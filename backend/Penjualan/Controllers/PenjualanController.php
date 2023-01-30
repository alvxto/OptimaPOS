<?php

namespace BackEnd\Penjualan\Controllers;

use BackEnd\Penjualan\Models\Penjualan;
use BackEnd\Kategori\Models\Kategori;
use BackEnd\Satuan\Models\Satuan;
use Exception;

class PenjualanController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Penjualan(request()))->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Penjualan())->find($data['id']);
		return $this->respondToCamel($operation, 'penjualan');
	}

	public function store()
	{
		$data = getVar(null, 'penjualan');
		$data['penjualan_aktif'] = ((isset($data['penjualan_aktif']) && $data['penjualan_aktif'] == 1) ? 1 : 0);
		$data['penjualan_created_at'] = date('Y-m-d H:i:s');
		$data['penjualan_user_id'] = session()->UserId;
		$operation = (new Penjualan())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'penjualan');
		$data['penjualan_aktif'] = ((isset($data['penjualan_aktif']) && $data['penjualan_aktif'] == 1) ? 1 : 0);
		$data['penjualan_updated_at'] = date('Y-m-d H:i:s');
		$operation = (new Penjualan())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new Penjualan())->delete($data['id']);
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

	public function getData()
	{
		$kategori = (new Kategori())->findAll();
		$satuan = (new Satuan())->findAll();
		return $this->respond([
			'kategori' => $kategori,
			'satuan' => $satuan,
		]);
	}
}
