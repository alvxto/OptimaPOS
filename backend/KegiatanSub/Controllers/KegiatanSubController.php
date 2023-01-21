<?php

namespace BackEnd\KegiatanSub\Controllers;

use BackEnd\KegiatanSub\Models\KegiatanSub;
use BackEnd\Kegiatan\Models\Kegiatan;
use App\Libraries\Gen;
use Exception;

class KegiatanSubController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new KegiatanSub(request()))->setView('v_kegiatan_sub')->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new KegiatanSub())->find($data['id']);
		return $this->respondToCamel($operation, 'kegiatan_sub');
	}

	public function store()
	{
		$data = getPost();
		$dataS = [
			'kegiatan_sub_id' => Gen::key(16),
			'kegiatan_sub_kode' => $data['kode'],
			'kegiatan_sub_nama' => $data['nama'],
			'kegiatan_sub_keterangan' => $data['keterangan'],
			'kegiatan_sub_kegiatan_id' => $data['kegiatan'],
			'kegiatan_sub_aktif' => ((isset($data['aktif']) && $data['aktif'] == 1) ? 1 : 0),
			'kegiatan_sub_created_at' => date('Y-m-d H:i:s'),
		];
		$operation = (new KegiatanSub())->insert($dataS);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getPost();
		$dataU = [
			'kegiatan_sub_id' => $data['id'],
			'kegiatan_sub_kode' => $data['kode'],
			'kegiatan_sub_nama' => $data['nama'],
			'kegiatan_sub_keterangan' => $data['keterangan'],
			'kegiatan_sub_kegiatan_id' => $data['kegiatan'],
			'kegiatan_sub_aktif' => ((isset($data['aktif']) && $data['aktif'] == 1) ? 1 : 0),
			'kegiatan_sub_created_at' => date('Y-m-d H:i:s'),
		];
		$operation = (new KegiatanSub())->update($dataU);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new KegiatanSub())->delete($data['id']);
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
		$kegiatan = (new Kegiatan())->orderBy('kegiatan_kode', 'ASC')->findAll();
		return $this->respond([
			'kegiatan' => $kegiatan,
		]);
	}
}
