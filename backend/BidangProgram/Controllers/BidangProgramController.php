<?php

namespace BackEnd\BidangProgram\Controllers;

use App\Libraries\DB;
use App\Libraries\Gen;
use BackEnd\BidangProgram\Models\BidangKegiatan;
use BackEnd\BidangProgram\Models\BidangKegiatanSub;
use BackEnd\Position\Models\Position;
use BackEnd\BidangProgram\Models\BidangProgram;

class BidangProgramController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Position(request()))->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$id = getPost('id');
		$program = $this->db->query("SELECT	* FROM program WHERE program_aktif = '1' ")->getResultArray();
		$kegiatan = $this->db->query("SELECT * FROM kegiatan WHERE kegiatan_aktif = '1'")->getResultArray();
		$kegiatansub = $this->db->query("SELECT *,
						( SELECT count(*) FROM position_kegiatan_subs 
							WHERE position_kegiatan_sub_kegiatan_sub_id = kegiatan_sub.kegiatan_sub_id AND kegiatan_sub_aktif = '1' AND position_kegiatan_sub_bidang_id = '{$id}') AS is_selected 
					FROM
						kegiatan_sub")->getResultArray();

		$menu_list = [];
		foreach ($program as $key => $value) {
			array_push($menu_list, array(
				'id' => $value['program_id'] . '_program',
				'parent' => '#',
				'icon' => "las la-cogs",
				'text' => $value['program_nama'],
				'state' => array(
					"selected" => false,
					"opened" => false
				)
			));
		}
		foreach ($kegiatan as $key => $value) {
			array_push($menu_list, array(
				'id' => $value['kegiatan_id'] . '_kegiatan',
				'parent' => $value['kegiatan_program_id'] . '_program',
				'icon' => "las la-tools",
				'text' => $value['kegiatan_nama'],
				'state' => array(
					"selected" => false,
					"opened" => false
				)
			));
		}
		foreach ($kegiatansub as $key => $value) {
			array_push($menu_list, array(
				'id' => $value['kegiatan_sub_id'] . '_kegiatanSub',
				'parent' => $value['kegiatan_sub_kegiatan_id'] . '_kegiatan',
				'icon' => "las la-wrench",
				'text' => $value['kegiatan_sub_nama'],
				'state' => array(
					"selected" => ($value['is_selected'] == 0) ? false : true,
					"opened" => false
				)
			));
		}
		return $this->respond([
			'menu' => $menu_list,
		]);
	}

	public function store()
	{
		$data = getPost();

		$operation = DB::transaction(function () use ($data) {
			(new BidangProgram())->where('position_program_bidang_id', $data['bidang_id'])->delete();
			(new BidangKegiatan())->where('position_kegiatan_bidang_id', $data['bidang_id'])->delete();
			(new BidangKegiatanSub())->where('position_kegiatan_sub_bidang_id', $data['bidang_id'])->delete();
			$program = [];
			$kegiatan = [];
			$kegiatanSub = [];
			foreach ($data['roles'] as $key => $value) {
				switch (explode('_', $value)[1]) {
					case 'program':
						$program[] = [
							'position_program_id' => Gen::key(),
							'position_program_program_id' => explode('_', $value)[0],
							'position_program_bidang_id' => $data['bidang_id'],
						];
						break;
					case 'kegiatan':
						$kegiatan[] = [
							'position_kegiatan_id' => Gen::key(),
							'position_kegiatan_kegiatan_id' => explode('_', $value)[0],
							'position_kegiatan_bidang_id' => $data['bidang_id'],
						];
						break;
					case 'kegiatanSub':
						$kegiatanSub[] = [
							'position_kegiatan_sub_id' => Gen::key(),
							'position_kegiatan_sub_kegiatan_sub_id' => explode('_', $value)[0],
							'position_kegiatan_sub_bidang_id' => $data['bidang_id'],
						];
						break;
				}
			}

			if ($program != []) (new BidangProgram())->insertBatch($program);
			if ($kegiatan != []) (new BidangKegiatan())->insertBatch($kegiatan);
			if ($kegiatanSub != []) (new BidangKegiatanSub())->insertBatch($kegiatanSub);
		});

		return $this->respond($operation);
	}
}
