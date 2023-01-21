<?php

namespace BackEnd\SumberDana\Controllers;

use BackEnd\SumberDana\Models\SumberDana;
use Exception;

class SumberDanaController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new SumberDana(request()))->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new SumberDana())->find($data['id']);
		return $this->respondToCamel($operation, 'sumber_dana');
	}

	public function store()
	{
		$data = getVar(null, 'sumber_dana');
		$data['sumber_dana_aktif'] = ((isset($data['sumber_dana_aktif']) && $data['sumber_dana_aktif'] == 1) ? 1 : 0);
		$data['sumber_dana_created_at'] = date('Y-m-d H:i:s');
		$operation = (new SumberDana())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'sumber_dana');
		$data['sumber_dana_aktif'] = ((isset($data['sumber_dana_aktif']) && $data['sumber_dana_aktif'] == 1) ? 1 : 0);
		$data['sumber_dana_updated_at'] = date('Y-m-d H:i:s');
		$operation = (new SumberDana())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new SumberDana())->delete($data['id']);
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
