<?php

namespace BackEnd\Profile\Controllers;

use BackEnd\User\Models\User;
use BackEnd\ChangeLog\Models\ChangeLog;

use App\Libraries\Utils;
use App\Libraries\DB;
use CodeIgniter\Files\File;
use Exception;

class ProfileController extends \App\Core\BaseController
{
	public function index()
	{
	}

	public function show()
	{
		$operation = (new User())->setView('v_user_roles')->setMode('datatable')->find(session()->UserId);
		$operation['profile'] = base_url() . '/manages/file/uploads-users-' . $operation['user_id'] . '.jpg?' . date('YmdHis');
		$operation['detail'] = (new User())->find(session()->UserId);
		return $this->respondToCamel($operation, 'user');
		// return $this->respond($operation);
	}

	public function showChangeLog()
	{
		$operation = (new Changelog(request()))->draw(true);
		return $this->respond($operation);
	}

	public function update()
	{
		$data = getPost();
		try {
			if ($_FILES['photo']['name'] != null && $data['user_isremoved'] != 1) {
				$validationRule = [
					'photo' => [
						'label' => 'Image File',
						'rules' => 'uploaded[photo]'
							. '|is_image[photo]'
							. '|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
							. '|max_size[photo,1000]'
							. '|max_dims[photo,1024,768]',
					],
				];
				if (!$this->validate($validationRule)) {
					new Exception($this->validator->getErrors()['photo']);
				}

				$img = $this->request->getFile('photo');
				if (!$img->hasMoved()) {
					if (file_exists(WRITEPATH . 'uploads/users/' . $data['user_id'] . '.jpg')) {
						unlink(WRITEPATH . 'uploads/users/' . $data['user_id'] . '.jpg');
						unlink(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg');
					}

					$operation = \Config\Services::image()
						->withFile($img)
						->resize(100, 100, true, 'height')
						->save(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg');

					$operation = $img->move(WRITEPATH . 'uploads/users/', $data['user_id'] . '.jpg');

					$data['user_photo'] = $img->getClientName();
				} else {
					new Exception("Failed to save Photo Profile");
				}
			} else {
				if ($data['user_isremoved'] == 1) {
					if (file_exists(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg')) {
						unlink(WRITEPATH . 'uploads/users/' . $data['user_id'] . '.jpg');
						unlink(WRITEPATH . 'uploads/users/thumbs/' . $data['user_id'] . '.jpg');
						$data['user_photo'] = NULL;
					}
					unset($data['user_isremoved']);
				}
			}

			$data['user_updated_at'] = date("Y-m-d H:i:s");
			$operation = (new User())->update($data['user_id'], $data);
		} catch (\Throwable $th) {
			$operation = [
				'success' => false,
				'message' => $th->getMessage(),
				'title' => 'Error'
			];
		}
		return $this->respondCreated($operation);
	}

	public function changePassword()
	{
		$data = getPost();
		$user = (new User())->find(session()->UserId);
		if (password_verify($data['oldPass'], $user['user_password'])) {
			$operation =  (new User())->update(session()->UserId, [
				'user_password' => generatePassword($data['newPass'])
			]);
			return $this->respondCreated($operation);
		} else {
			return $this->respond([
				'title' => 'Failed',
				'success' => false,
				'message' => 'Old Password is Wrong'
			]);
		}
	}
}
