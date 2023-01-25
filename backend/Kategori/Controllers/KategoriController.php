<?php

namespace BackEnd\Kategori\Controllers;

use BackEnd\Kategori\Models\Kategori;
use Exception;

class KategoriController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Kategori(request()))->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Kategori())->find($data['id']);
		return $this->respondToCamel($operation, 'kategori');
	}

	public function store()
	{
		$data = getVar(null, 'kategori');
		$data['kategori_aktif'] = ((isset($data['kategori_aktif']) && $data['kategori_aktif'] == 1) ? 1 : 0);
		$data['kategori_created_at'] = date('Y-m-d H:i:s');
		$data['kategori_created_by'] = session()->UserId;
		$operation = (new Kategori())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'kategori');
		$data['kategori_aktif'] = ((isset($data['kategori_aktif']) && $data['kategori_aktif'] == 1) ? 1 : 0);
		$data['kategori_updated_at'] = date('Y-m-d H:i:s');
		$operation = (new Kategori())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new Kategori())->delete($data['id']);
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
