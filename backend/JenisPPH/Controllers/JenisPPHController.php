<?php

namespace BackEnd\JenisPPH\Controllers;

use BackEnd\JenisPPH\Models\JenisPPH;
use Exception;

class JenisPPHController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new JenisPPH(request()))->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new JenisPPH())->find($data['id']);
		return $this->respondToCamel($operation, 'jenis_pph');
	}

	public function store()
	{
		$data = getVar(null, 'jenis_pph');
		$data['jenis_pph_aktif'] = ((isset($data['jenis_pph_aktif']) && $data['jenis_pph_aktif'] == 1) ? 1 : 0);
		$operation = (new JenisPPH())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'jenis_pph');
		$data['jenis_pph_aktif'] = ((isset($data['jenis_pph_aktif']) && $data['jenis_pph_aktif'] == 1) ? 1 : 0);
		$operation = (new JenisPPH())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new JenisPPH())->delete($data['id']);
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
