<?php

namespace BackEnd\Pejabat\Controllers;

use App\Libraries\Gen;
use BackEnd\User\Models\User;
use BackEnd\Jabatan\Models\Jabatan;
use BackEnd\Position\Models\Position;
use Exception;

class PejabatController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new User(request()))->setView('v_user_all')->setMode('snapshoot')->draw(['user_is_pejabat' => 1], true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new User())->find($data['id']);
		return $this->respondToCamel($operation, 'user');
	}

	public function store()
	{
		$data = getVar(null, 'user');
		$data['user_aktif'] = ((isset($data['user_aktif']) && $data['user_aktif'] == 1) ? 1 : 0);
		$data['user_created_at'] = date('Y-m-d H:i:s');
		$data['user_created_by'] = session()->UserId;
		$data['user_is_pejabat'] = '1';
		$data['user_tgl_dpp'] = date_format(date_create(convertSlashDate($data['user_tgl_dpp'])), "d F Y");
		$data['user_tgl_dppa'] = date_format(date_create(convertSlashDate($data['user_tgl_dppa'])), "d F Y");
		$data['user_code'] = $data['user_nip'];
		$data['user_name'] = $data['user_nama'];
		$data['user_bidang_id'] = $data['user_bidang'];
		$data['user_position_id'] = $data['user_jabatan'];
		$operation = (new User())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'user');
		$data['user_aktif'] = ((isset($data['user_aktif']) && $data['user_aktif'] == 1) ? 1 : 0);
		$data['user_updated_at'] = date('Y-m-d H:i:s');
		$data['user_tgl_dpp'] = date_format(date_create(convertSlashDate($data['user_tgl_dpp'])), "d F Y");
		$data['user_tgl_dppa'] = date_format(date_create(convertSlashDate($data['user_tgl_dppa'])), "d F Y");
		$data['user_code'] = $data['user_nip'];
		$data['user_name'] = $data['user_nama'];
		$data['user_bidang_id'] = $data['user_bidang'];
		$data['user_position_id'] = $data['user_jabatan'];
		$operation = (new User())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new User())->delete($data['id']);
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
		$jabatan = (new Jabatan())->orderBy('jabatan_code', 'ASC')->findAll();
		$position = (new Position())->where('position_active', '1')->orderBy('position_code', 'ASC')->findAll();
		return $this->respond([
			'jabatan' => $jabatan,
			'position' => $position,
		]);
	}
}
