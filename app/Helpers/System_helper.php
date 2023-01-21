<?php

use Mpdf\Mpdf;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

if (!function_exists('addJobToRabbit')) {

    function addJobToRabbit($tube = null, $payload = null)
    {
        if (!$tube) return;
        $tube = $tube . $_SERVER['APP_STATUS'];
        $connection = new AMQPStreamConnection($_SERVER['RABBIT_HOST'], $_SERVER['RABBIT_PORT'], $_SERVER['RABBIT_USER'], $_SERVER['RABBIT_PASSWORD']);
        $channel = $connection->channel();
        $channel->queue_declare($tube, false, true, false, false);
        $msg = new AMQPMessage(json_encode($payload), array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($msg, '', $tube);
        $channel->close();
        $connection->close();
    }
}


if (!function_exists("getSegment")) {
    function getSegment($value = '')
    {
        return service('uri')->getSegment($value);
    }
}

/**
 * @return boolean
 * */
if (!function_exists("isAjax")) {
    function isAjax()
    {
        $request = \Config\Services::request();
        if (!$request->isAJAX()) {
            die('The action you have requested is not allowed.');
        };
    }
}

if (!function_exists("menuActive")) {
    function menuActive($url = '')
    {
        return (explode('/', uri_string())[0] == $url) ? true : false;
    }
}

/**
 * @param array|array|null
 * @param string
 * jika data isinya boolean maka dianggap snakeTocammel
 * 
 * */
if (!function_exists("getPost")) {
    function getPost($data = null, $prefix = null)
    {
        $request = \Config\Services::request();
        if (!is_null($prefix)) {
            return \App\Libraries\Utils::camelToSnake($request->getPost(null, FILTER_SANITIZE_STRING), $prefix);
        } else {
            return $request->getPost($data, FILTER_SANITIZE_STRING);
        }
    }
}

/**
 * @param array|array|null
 * @param string
 * jika data isinya boolean maka dianggap snakeTocammel
 * 
 * */
if (!function_exists("getVar")) {
    function getVar($data = null, $prefix = null)
    {
        $request = \Config\Services::request();
        if (!is_null($prefix)) {
            return \App\Libraries\Utils::camelToSnake($request->getVar(null, FILTER_SANITIZE_STRING), $prefix);
        } else {
            return $request->getVar($data, FILTER_SANITIZE_STRING);
        }
    }
}

if (!function_exists("request")) {
    function request($data = null)
    {
        return \Config\Services::request($data);
    }
}

/**
 *  Used to generate password
 * @param string
 * */
if (!function_exists("generatePassword")) {
    function generatePassword($value = null)
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }
}

/**
 * @param string
 * @param array
 * 
 * */
if (!function_exists('loadView')) {
    function loadView($path, $files = null)
    {
        if (is_array($path)) {
            foreach ($path as $key => $value) {
                $newPath = str_replace(array('/', '\\'), '\\', $value);
                echo view($newPath);
            }
        } else {
            $path = str_replace(array('/', '\\'), '\\', $path);
            if (!is_null($files)) {
                foreach ($files as $key => $value) {
                    echo view($path . '\\' . $value);
                }
            } else {
                echo view($path);
            }
        }
    }
}

if (!function_exists('dateId')) {
    function dateId($date, $format = 'Y-m-d H:i:s')
    {
        $newDate = date_format($date, $format);

        if (strpos($format, 'l') != null || strpos($format, 'l') == 0) {
            $day = [
                'Sunday',
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
            ];
            $hari = [
                'Minggu',
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
            ];
            $newDate = str_replace($day[(int)date_format($date, 'w')], $hari[(int)date_format($date, 'w')], $newDate);
        }
        if (strpos($format, 'F') != null || strpos($format, 'F') == 0) {
            $month = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];
            $bulan = [
                'Januari',
                'Febuari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ];
            $newDate = str_replace($month[(int)date_format($date, 'm') - 1], $bulan[(int)date_format($date, 'm') - 1], $newDate);
        }

        return $newDate;
    }
}

if (!function_exists('monthEngtoId')) {
    function monthEngtoId($data)
    {
        $month = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
        $bulan = [
            'Januari',
            'Febuari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        foreach ($month as $key => $value) {
            $data = str_replace($value, $bulan[$key], $data);
        }

        return $data;
    }
}

/**
 * @param date
 * @param boolean
 * 
 * */

if (!function_exists('timeSince')) {

    function timeSince($timestamp, $ID = false)
    {
        $time_ago = strtotime($timestamp);
        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        $minutes      = round($seconds / 60);        // value 60 is seconds  
        $hours        = round($seconds / 3600);       //value 3600 is 60 minutes * 60 sec  
        $days         = round($seconds / 86400);      //86400 = 24 * 60 * 60;  
        $weeks        = round($seconds / 604800);     // 7*24*60*60;  
        $months       = round($seconds / 2629440);    //((365+365+365+365+366)/5/12)*24*60*60  
        $years        = round($seconds / 31553280);   //(365+365+365+365+366)/5 * 24 * 60 * 60  

        if ($seconds <= 60) {
            return ($ID) ? "sekarang" : "Just Now";
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return (($ID) ? "satu menit yang lalu" : "one minute ago");
            } else {
                return "$minutes " . (($ID) ? "menit yang lalu" : "minutes ago");
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return (($ID) ? "satu jam yang lalu" : "an hour ago");
            } else {
                return "$hours " . (($ID) ? "jam yang lalu" : "hrs ago");
            }
        } else if ($days <= 7) {
            if ($days == 1) {
                return (($ID) ? "kemarin" : "yesterday");
            } else {
                return "$days " . (($ID) ? "hari yang lalu" : "days ago");
            }
        } else if ($weeks <= 4.3) {  //4.3 == 52/12
            if ($weeks == 1) {
                return (($ID) ? "seminggu yang lalu" : "a week ago");
            } else {
                return "$weeks " . (($ID) ? "minggu yang lalu" : "weeks ago");
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return (($ID) ? "sebulan yang lalu" : "a month ago");
            } else {
                return "$months " . (($ID) ? "bulan yang lalu" : "months ago");
            }
        } else {
            if ($years == 1) {
                return (($ID) ? "satu tahun yang lalu" : "one year ago");
            } else {
                return "$years " . (($ID) ? "tahun yang lalu" : "years ago");
            }
        }
    }
}

/**
 * Search data array
 * @param array
 * @param array
 * @return array
 */

if (!function_exists('findWhere')) {
    function findWhere($_array, $_matching)
    {
        $return = array();
        foreach ($_array as $item) {
            $is_match = true;
            foreach ($_matching as $key => $value) {

                if (is_object($item)) {
                    if (!isset($item->$key)) {
                        $is_match = false;
                        break;
                    }
                } else {
                    if (!isset($item[$key])) {
                        $is_match = false;
                        break;
                    }
                }

                if (is_object($item)) {
                    if ($item->$key != $value) {
                        $is_match = false;
                        break;
                    }
                } else {
                    if ($item[$key] != $value) {
                        $is_match = false;
                        break;
                    }
                }
            }

            if ($is_match) {
                array_push($return, $item);
            }
        }
        return $return;
    }
}

/**
 * Search data array
 * @param {Array}
 * @param {Array}
 */
if (!function_exists('findRead')) {
    function findRead($_array, $_matching)
    {
        foreach ($_array as $item) {
            $is_match = true;
            foreach ($_matching as $key => $value) {

                if (is_object($item)) {
                    if (!isset($item->$key)) {
                        $is_match = false;
                        break;
                    }
                } else {
                    if (!isset($item[$key])) {
                        $is_match = false;
                        break;
                    }
                }

                if (is_object($item)) {
                    if ($item->$key != $value) {
                        $is_match = false;
                        break;
                    }
                } else {
                    if ($item[$key] != $value) {
                        $is_match = false;
                        break;
                    }
                }
            }

            if ($is_match) {
                return $item;
            }
        }
        return false;
    }
}

if (!function_exists('convertSlashDate')) {
    function convertSlashDate($val)
    {
        if (strpos($val, '/') > 0) {
            $a   = explode('/', $val);
            $val = $a[2] . '-' . $a[1] . '-' . $a[0];
        }
        return date('Y-m-d', strtotime($val));
    }
}

if (!function_exists('toRp')) {
    function toRp($val)
    {
        return number_format($val, 2, ',', '.');
    }
}

if (!function_exists('numToSpell')) {
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    function numToSpell($val)
    {
        if ($val < 0) {
            $hasil = "minus " . trim(penyebut($val));
        } else {
            $hasil = trim(penyebut($val));
        }
        return $hasil;
    }
}

if (!function_exists('convertSlashDateTime')) {
    /* Ex Params: 14/12/2021 17:24 */
    function convertSlashDateTime($val)
    {
        $date = explode(" ", $val)[0];
        $time = explode(" ", $val)[1];
        if (strpos($date, '/') > 0) {
            $a   = explode('/', $date);
            $val = $a[2] . '-' . $a[1] . '-' . $a[0] . " " . $time . ":00";
        }

        return date('Y-m-d H:i:s', strtotime($val));
    }
}

if (!function_exists('keyAddPrefix')) {
    function keyAddPrefix($obj, $prefix)
    {
        if ($obj == []) return [];
        return array_combine(
            array_map(function ($k) use ($prefix) {
                return $prefix . $k;
            }, array_keys($obj)),
            $obj
        );
    }
}

if (!function_exists('createPdf')) {
    function createPdf($data = array())
    {
        $config = array();
        if (is_array($data)) {
            $config = array(
                'data'          => (!empty($data['data']))           ? $data['data']         : '',
                'paper_size'    => (!empty($data['paper_size']))     ? $data['paper_size']   : '',
                'file_name'     => (!empty($data['file_name']))      ? $data['file_name']    : '',
                'margin'        => (!empty($data['margin']))         ? $data['margin']       : '',
                'stylesheet'    => (!empty($data['stylesheet']))     ? $data['stylesheet']   : '',
                'font_face'     => (!empty($data['font_face']))      ? $data['font_face']    : '',
                'font_size'     => (!empty($data['font_size']))      ? $data['font_size']    : '',
                'orientation'   => (!empty($data['orientation']))    ? $data['orientation']  : '',
                'margin_hf'     => (!empty($data['margin_hf']))      ? $data['margin_hf']    : '',
                'download'      => (!empty($data['download'])       && $data['download'] == true)    ? true : false,
                'title'         => (!empty($data['title']))          ? $data['title']        : '',
                'header'        => (!empty($data['header']))         ? $data['header']       : '',
                'footer'        => (!empty($data['footer']))         ? $data['footer']       : '',
                'json'          => (!empty($data['json'])           && $data['json'] == true)     ? true : false,
                'kwt'           => (!empty($data['kwt'])            && $data['kwt'] == true)      ? true : false,
                'save'          => (!empty($data['save'])           && $data['save'] == true)     ? true : false,
            );
        }

        $explode     = explode(' ', $config['margin']);
        $explode_hf  = explode(' ', $config['margin_hf']);
        $orientation = ($config['orientation'] == '') ? 'P' : $config['orientation'];
        $font_face   = ($config['font_face'] != '') ? $config['font_face'] : '';
        $font_size   = ($config['font_size'] != '') ? $config['font_size'] : '';
        $file_name   = ($config['file_name'] != '') ? $config['file_name'] : 'Laporan' . date('dMY');
        $title       = ($config['title'] != '')     ? $config['title']     : 'Laporan';
        $header      = ($config['header'] != '')    ? $config['header']    : '';
        $footer      = ($config['footer'] != '')    ? $config['footer']    : '';
        $json        = ($config['json'] != '')      ? true                 : false;

        ob_clean();
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => $config['paper_size'],
            'orientation' => $orientation,
            'default_font_size' => $font_size,
            'default_font' => $font_face,
            'margin-left' => (isset($explode[3]) != '') ? $explode[3] : '',
            'margin-right' => (isset($explode[1]) != '') ? $explode[1] : '',
            'margin-top' => (isset($explode[0]) != '') ? $explode[0] : '',
            'margin-bottom' => (isset($explode[2]) != '') ? $explode[2] : '',
            'margin-header' => (isset($explode_hf[0]) != '') ? $explode_hf[0] : '',
            'margin-footer' => (isset($explode_hf[1]) != '') ? $explode_hf[1] : '',
        ]);
        // $pdf->use_kwt = $config['kwt'];
        $xstylesheet = '';
        // if (is_array($config['stylesheet'])) {
        //     for ($i = 0; $i < count($config['stylesheet']); $i++) {
        //         $xstylesheet .= file_get_contents($config['stylesheet'][$i]);
        //     }
        // } else {
        //     $xstylesheet = file_get_contents($config['stylesheet']);
        // }
        // $pdf->use_kwt = true;

        // $pdf->WriteHTML($xstylesheet, 1);
        $pdf->SetTitle($title);
        $pdf->shrink_tables_to_fit = '0';

        // $pdf->SetHTMLHeader($header, '', TRUE);
        // $pdf->SetHTMLFooter($footer);

        // $pdf->setFooter('{PAGENO} / {nb}');

        $pdf->WriteHTML($config['data']);

        ob_end_clean();
        if ($config['save'] == true) {
            $pdf->Output($file_name . '.pdf', 'F');
        } else {
            if ($json == true) {
                $pdfString = $pdf->Output('', 'S');
                $response =  array(
                    'success' => true,
                    'id' => $file_name,
                    'message' => 'Berhasil',
                    'record' => "data:application/pdf;base64," . base64_encode($pdfString)
                );
                die(json_encode($response));
            } else {
                if ($config['download'] == true) {
                    $pdf->Output($file_name . '.pdf', 'D');
                } else {
                    $pdf->Output($file_name . '.pdf', 'I');
                }
            }
        }
    }
}
