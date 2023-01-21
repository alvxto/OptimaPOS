<?php

namespace BackEnd\Changelog\Controllers;

use BackEnd\Changelog\Models\Changelog;
use Exception;

class ChangelogController extends \App\Core\BaseController
{
    public function index()
    {
        $operation = (new Changelog(request()))->draw(false, false);
        return $this->respond($operation);
    }

    public function getData()
    {
        $changelog = (new Changelog())->setView('v_changelogs')->orderBy('changelog_code', 'DESC')->findAll();
        foreach ($changelog as $key => $value) {
            $changelog[$key]['time_since'] = timeSince($value['changelog_created_at']);
            $changelog[$key]['created_at'] = date('d/m/Y', strtotime($value['changelog_created_at']));
            $changelog[$key]['inisial_name'] = $value['user_name'][0] ?? null;
        }
        return $this->respond([
            'changelog' => $changelog
        ]);
    }

    public function show()
    {
        $data = getPost();
        $operation = (new Changelog())->find($data['id']);
        return $this->respond($operation);
    }

    public function store()
    {
        $data = getPost();
        $data['changelog_active'] = 1;
        $data['changelog_created_at'] = date('Y-m-d H:i:s');
        $data['changelog_created_by'] = session()->UserId;
        $operation = (new Changelog())->insert($data);
        return $this->respondCreated($operation);
    }

    public function update()
    {
        $data = getPost();
        $data['changelog_updated_at'] = date('Y-m-d H:i:s');
        $operation = (new Changelog())->update($data['changelog_id'], $data);
        return $this->respondUpdated($operation);
    }

    public function destroy()
    {
        $data = getPost();
        try {
            $operation = (new Changelog())->delete($data['id']);
            if ($operation['success'] == false) throw new Exception($operation['errors'], $operation['code']);
            return $this->respondDeleted($operation);
        } catch (\Throwable $th) {
            if ($th->getCode() == '1451') {
                return $this->respondDeleted([
                    'success' => false,
                    'message' => "Gagal menghapus Data, Data sudah digunakan",
                ]);
            } else {
                return $this->respondDeleted([
                    'success' => false,
                    'message' => "Gagal menghapus Data",
                ]);
            }
        }
    }
}
