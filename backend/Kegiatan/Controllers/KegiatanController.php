<?php

namespace BackEnd\Kegiatan\Controllers;

use BackEnd\Kegiatan\Models\Kegiatan;
use BackEnd\Program\Models\Program;
use Exception;

class KegiatanController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Kegiatan(request()))->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Kegiatan())->find($data['id']);
		return $this->respondToCamel($operation, 'kegiatan');
	}

	public function store()
	{
		$data = getVar(null, 'kegiatan');
		$data['kegiatan_aktif'] = ((isset($data['kegiatan_aktif']) && $data['kegiatan_aktif'] == 1) ? 1 : 0);
		$data['kegiatan_created_at'] = date('Y-m-d H:i:s');
		$operation = (new Kegiatan())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'kegiatan');
		$data['kegiatan_aktif'] = ((isset($data['kegiatan_aktif']) && $data['kegiatan_aktif'] == 1) ? 1 : 0);
		$data['kegiatan_updated_at'] = date('Y-m-d H:i:s');
		$operation = (new Kegiatan())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new Kegiatan())->delete($data['id']);
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
		$program = (new Program())->where('program_aktif', 1)->orderBy('program_kode', 'ASC')->findAll();
		return $this->respond([
			'program' => $program
		]);
	}
}
