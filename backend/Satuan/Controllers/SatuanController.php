<?php

namespace BackEnd\Satuan\Controllers;

use BackEnd\Satuan\Models\Satuan;
use Exception;

class SatuanController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Satuan(request()))->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Satuan())->find($data['id']);
		return $this->respondToCamel($operation, 'satuan');
	}

	public function store()
	{
		$data = getVar(null, 'satuan');
		// $data['satuan_created_at'] = date('Y-m-d H:i:s');
		$data['satuan_user_id'] = session()->UserId;
		$operation = (new Satuan())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'satuan');
		$data['satuan_aktif'] = ((isset($data['satuan_aktif']) && $data['satuan_aktif'] == 1) ? 1 : 0);
		$data['satuan_updated_at'] = date('Y-m-d H:i:s');
		$operation = (new Satuan())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new Satuan())->delete($data['id']);
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
