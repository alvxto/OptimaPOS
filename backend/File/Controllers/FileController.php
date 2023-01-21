<?php

namespace BackEnd\File\Controllers;

use CodeIgniter\Files\File;
use BackEnd\Configuration\Models\Configuration;

class FileController extends \App\Core\BaseController
{
    /**
     * example
     * www.domain.com/file/uploads-logos-thumbs-fileimage.png
     * */

    public function index($path = '')
    {
        $this->createFile($path);
    }

    public function logo()
    {
        $fileName = (new Configuration())->where(['config_code' => 'app.logo'])->first()['config_value'];
        $this->createFile("uploads/logos/thumbs/{$fileName}");
    }

    public function background()
    {
        $fileName = (new Configuration())->where(['config_code' => 'app.background'])->first()['config_value'];
        $this->createFile("uploads/logos/origins/{$fileName}");
    }

    public function createFile($path)
    {
        $path = explode('-', $path);
        $newPath = '';
        if (count($path) > 0) {
            foreach ($path as $key => $value) {
                $newPath .= "$value/";
            }
        }

        $newPath = substr($newPath, 0, -1);
        $filePath = (file_exists(WRITEPATH . $newPath) && $newPath != '') ?
            WRITEPATH . $newPath :
            WRITEPATH . "uploads/users/thumbs/blank.png";

        $file = new File($filePath);
        return $this->response->setContentType($file->getMimeType())->setBody(file_get_contents($filePath))->send();
    }
}
