<?php

namespace BackEnd\Rekanan\Controllers;

use BackEnd\Rekanan\Models\Rekanan;
use BackEnd\Role\Models\Role;
use BackEnd\Bank\Models\Bank;
use BackEnd\Position\Models\Position;

use App\Libraries\Utils;
use App\Libraries\DB;
use Exception;

class RekananController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Rekanan(request()))->setView('v_rekanan')->setMode('datatable')->draw(false);
		foreach ($operation['data'] as $key => $value) {
			$operation['data'][$key]->no = ($key + 1);
		}
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Rekanan())->find($data['id']);
		return $this->respondToCamel($operation, 'rekanan');
	}

	public function store()
	{
		$data = getVar(null, 'rekanan');
		$data['rekanan_tgl_akte'] = convertSlashDate($data['rekanan_tgl_akte']);
		$operation = (new Rekanan())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'rekanan');
		$data['rekanan_tgl_akte'] = convertSlashDate($data['rekanan_tgl_akte']);
		$operation = (new Rekanan())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new Rekanan())->delete($data['id']);
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

	// public function getData()
	// {
	// 	$bank = (new Bank())->orderBy('bank_kode', 'ASC')->findAll();
	// 	return $this->respond([
	// 		'bank' => $bank,
	// 	]);
	// }
}
