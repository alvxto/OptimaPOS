<?php

namespace BackEnd\Jabatan\Controllers;

use BackEnd\Jabatan\Models\Jabatan;
use Exception;

class JabatanController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Jabatan(request()))->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Jabatan())->find($data['id']);
		return $this->respondToCamel($operation, 'jabatan');
	}

	public function store()
	{
		$data = getVar(null, 'jabatan');
		$data['jabatan_active'] = ((isset($data['jabatan_active']) && $data['jabatan_active'] == 1) ? 1 : 0);
		$data['jabatan_created_at'] = date('Y-m-d H:i:s');
		$data['jabatan_created_by'] = session()->UserId;
		$operation = (new Jabatan())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'jabatan');
		$data['jabatan_active'] = ((isset($data['jabatan_active']) && $data['jabatan_active'] == 1) ? 1 : 0);
		$data['jabatan_updated_at'] = date('Y-m-d H:i:s');
		$operation = (new Jabatan())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new Jabatan())->delete($data['id']);
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
