<?php

namespace BackEnd\Login\Controllers;

use BackEnd\Configuration\Models\Configuration;
use BackEnd\User\Models\User;

use App\Libraries\Parser;
use App\Libraries\Collection;
use Exception;

class LoginController extends \App\Core\BaseController
{
    /**
     * @return view page login
     * */
    public function index()
    {
        $configRecatcha = (new Configuration())->where(['config_group' => 'google_recaptcha'])->find();
        $collect        = new Collection($configRecatcha);
        $data = [
            'secretKey' => $collect->where('config_code', 'captcha.secretKey')->find()['config_value'],
            'siteKey'   => $collect->where('config_code', 'captcha.siteKey')->find()['config_value'],
        ];
        Parser::view('BackEnd\Login\Views\view_login', $data);
    }

    /**
     * @param array
     * @return response
     * */
    static function validateCaptcha($data)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $captcha = [
            'secret' => $data['secret'],
            'response' => $data['Captcha'],
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($captcha)
            ]
        ];

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }

    /**
     * action login
     * set session
     * @return array
     * */
    public function login()
    {
        $data = getPost();
        $validateForm = [
            'Username'  => 'required',
            'Password'  => 'required',
            'Captcha'   => 'required',
        ];

        if ($this->validate($validateForm)) {

            $dataConfig = (new Configuration())->whereIn('config_code', ['captcha.secretKey', 'app.logo', 'app.setTitle'])->findAll();
            $collect    = new Collection($dataConfig);

            $data['secret']  =  $collect->where('config_code', 'captcha.secretKey')->first()['config_value'];
            $validateCaptcha = self::validateCaptcha($data);
            
            if ($validateCaptcha['success']) {
                
                $user = (new User())->where([
                    "user_username = BINARY '" . $data['Username'] . "'" => null,
                    'user_active'  => 1
                ])->first();
                if($user != ''){
                    if (password_verify($data['Password'], $user['user_password'])) {
                        session()->set([
                            'UserId'    => $user['user_id'],
                            'Fullname'  => $user['user_name'],
                            'Email'     => $user['user_email'],
                            'TypeModul' => 2,
                            'IsLogin'   => true,
                            'RoleId'    => $user['user_role_id'],
                            'BidangId'    => $user['user_bidang_id'],
                            'Gender'    => ($user['user_gender'] == '1') ? 'Male' : 'Woman',
                            'Rules'     => $this->getRoles($user['user_id']),
                            'googleToken' => null,
                            'logo'      => '', //$collect->where('config_code','app.logo')->first()['config_value'],
                            'titleApp'  => '', //$collect->where('config_code','app.setTitle')->first()['config_value'],
                        ]);
                        $response = [
                            'success'   => true,
                            'message'   => 'login successfully',
                            'redirectTo' => 'main'
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'title' => 'Failed',
                            'message' => 'Wrong username or password.'
                        ];
                    }
                }else{
                    $response = [
                        'success' => false,
                        'title' => 'Failed',
                        'message' => 'Wrong username or password.'
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'title' => 'Failed',
                    'message' => 'Captcha timeout or duplicate, Please reload your browser!'
                ];
            }
        } else {
            $response = [
                'success' => false,
                'title' => 'Failed',
                'message' => $this->validator->getErrors()
            ];
        }
        return $this->respond($response);
    }

    public function getRoles($userId)
    {
        $operation = (new User())->setView('v_role_menus')->setMode('roles')->where([
            'user_id' => $userId,
            'menu_code IS NOT NULL' => null,
        ])->findAll();

        return $operation;
    }

    public function logout()
    {
        session()->destroy();
        return $this->respond([
            'success' => true,
            'url' => base_url('app-login')
        ]);
    }
    public function forgot()
    {
        Parser::view('BackEnd\Login\Views\forgot');
    }

    public function sendForgot()
    {
        $data = getPost();
        try {
            $user = (new User())->where([
                "user_email = BINARY '" . $data['Email'] . "'" => null,
                'user_active'  => 1
            ])->first();
            if ($user == null) throw new Exception("User not found");

            $email = \Config\Services::email();
            $email->setTo($data['Email']);
            $email->setSubject('Password Reset E=Kontrak');

            date_default_timezone_set("Asia/Jakarta");
            $data = base64_encode(base64_encode(base64_encode(json_encode(['id' => $user['user_id'], 'time' => date("Y-m-d H:i:s")]))));
            $msg = "
                <table>
                    <tr>
                        <td valign=\"center\">
                            <img src=\"http://localhost:8080/uploads/logos/thumbs/logo.svg\" alt=\"E-kontrak Logo\" />
                        </td>
                        <td valign=\"center\">
                            <span style=\"font-weight:700;font-size: 3em;\">E-Kontrak</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=\"2\">Reset Password</td>
                    </tr>
                    <tr>
                        <td colspan=\"2\">To change your password, please press the button below</td>
                    </tr>
                    <tr>
                        <a href=\"http://localhost:8080/app-login/changePassword/{$data}\">Reset Password</a>
                    </tr>
                </table>
            ";
            $email->setMessage($msg);

            if (!$email->send()) throw new Exception("Failed to send email");

            return $this->respond([
                'success' => true,
                'title' => 'Success',
                'message' => 'Change password link has been successfully sent to your email'
            ]);
        } catch (\Throwable $th) {
            return $this->respond([
                'success' => false,
                'title' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function change($data)
    {
        $data = json_decode(base64_decode(base64_decode(base64_decode($data))));
        Parser::view('BackEnd\Login\Views\changePassword', ['id' => $data->id]);
    }
    public function changePassword()
    {
        $data = getPost('', 'user');
        $data['user_password'] = password_hash($data['user_password'], PASSWORD_BCRYPT);
        try {
            if ((new User())->update($data['user_id'], $data) != 1) throw new Exception("Failed to update password");
            // $user = (new User())->update($data['id'], ['user_password' => $data['password']]);
            return $this->respond([
                'success' => true,
                'title' => 'Success',
                'message' => 'Password changed successfully'
            ]);
        } catch (\Throwable $th) {
            return $this->respond([
                'success' => false,
                'title' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
