<?php

namespace BackEnd\Barang\Controllers;

use BackEnd\Barang\Models\Barang;
use Exception;

class BarangController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Barang(request()))->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Barang())->find($data['id']);
		return $this->respondToCamel($operation, 'barang');
	}

	public function store()
	{
		$data = getVar(null, 'barang');
		$data['barang_aktif'] = ((isset($data['barang_aktif']) && $data['barang_aktif'] == 1) ? 1 : 0);
		$data['barang_created_at'] = date('Y-m-d H:i:s');
		$data['barang_created_by'] = session()->UserId;
		$operation = (new Barang())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'barang');
		$data['barang_aktif'] = ((isset($data['barang_aktif']) && $data['barang_aktif'] == 1) ? 1 : 0);
		$data['barang_updated_at'] = date('Y-m-d H:i:s');
		$operation = (new Barang())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new Barang())->delete($data['id']);
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
