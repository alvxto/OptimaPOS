<?php namespace BackEnd\Configuration\Controllers;

use BackEnd\Configuration\Models\Configuration;

use CodeIgniter\Files\File;
use App\Libraries\DB;

class ConfigurationController extends \App\Core\BaseController
{

    /**
     * get data configuration by group config
     * */
    public function getConfig()
    {
        $data = getPost();
        $operation = (new Configuration())->where('config_group', $data['group'])->orderBy('config_order','ASC')->findAll();
        return $this->respond([
            'config' => $operation,
        ]);
    }

    /**
     * 
     * */
    public function getImage($fileName = '')
    {
        $filePath = (file_exists(WRITEPATH."uploads/logos/thumbs/{$fileName}") && $fileName != '') ? 
            WRITEPATH."uploads/logos/thumbs/{$fileName}" : 
            WRITEPATH."uploads/logos/not-found.png";

        $file = new File($filePath);
        $this->response->setContentType($file->getMimeType())->setBody(file_get_contents($filePath))->send();
    }

    /**
     * update resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function save()
    {
        $data = getPost();
        $operation = DB::transaction(function() use($data){
            $dataSave = [];
            foreach ($data as $key => $value) {
                if (count(explode('_', $key)) == 1) {
                    array_push($dataSave,[
                        'config_id' => $key,
                        'config_value' => $value
                    ]);
                }
            }
            $operation = (new Configuration())->updateBatch($dataSave, 'config_id');
        });
        return $this->respondUpdated($operation);
    }

    public function uploadFile()
    {
        $data = getPost();
        $validationRule = [
            'logo' => [
                'label' => 'Image File',
                'rules' => 'uploaded[logo]'
                    . '|is_image[logo]'
                    . '|mime_in[logo,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[logo,1000]'
                    . '|max_dims[logo,2000,2000]',
            ],
        ];

        $operation = [];
        if (! $this->validate($validationRule)) {
            $operation = [
                'success' => false,
                'message' => $this->validator->getErrors()
            ];
        }else{
            $file = $this->request->getFile('logo');
            if (! $file->hasMoved()) {

                $operation = DB::transaction(function() use($data, $file) {
                    $dataFile = (new Configuration())->find($data['id']);

                    if (!empty($dataFile) && $dataFile['config_value'] != '') {
                        if(file_exists(WRITEPATH .'uploads/logos/origins/'. $dataFile['config_value'])){
                            unlink(WRITEPATH .'uploads/logos/origins/'. $dataFile['config_value']);
                            unlink(WRITEPATH .'uploads/logos/thumbs/'. $dataFile['config_value']);
                        }
                    }

                    $newName = $file->getRandomName();
                    $image = \Config\Services::image()
                        ->withFile($file)
                        ->resize(100, 100, true, 'height')
                        ->save(WRITEPATH .'uploads/logos/thumbs/'. $newName);

                    $file->move(WRITEPATH . 'uploads/logos/origins/', $newName);

                    (new Configuration())->update($data['id'],['config_value'=>$newName]);
                });

            }
        }
        return $this->respond($operation);
    }

    public function deleteFile()
    {
        $data = getPost();
        $dataFile = (new Configuration())->find($data['id']);
        if (!empty($dataFile) && $dataFile['config_value'] != '') {
            if(file_exists(WRITEPATH .'uploads/logos/origins/'. $dataFile['config_value'])){
                unlink(WRITEPATH .'uploads/logos/origins/'. $dataFile['config_value']);
                unlink(WRITEPATH .'uploads/logos/thumbs/'. $dataFile['config_value']);
            }
        }
        return $this->respond(['success'=>true]);
    }
}
