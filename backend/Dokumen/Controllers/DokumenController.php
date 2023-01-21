<?php

namespace BackEnd\Dokumen\Controllers;

use BackEnd\Dokumen\Models\Dokumen;
use BackEnd\Program\Models\Program;
use BackEnd\Kegiatan\Models\Kegiatan;
use BackEnd\KegiatanSub\Models\KegiatanSub;


class DokumenController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Dokumen(request()))->draw(false);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new Dokumen())->find($data['id']);
		if ($data['type'] == '0') {
			$operation['doc'] = base_url() . '/manages/file/uploads-document-' . $operation['pekerjaan_dokumen_file_name'] . '.pdf?' . date('YmdHis');
			$operation['docName'] = $operation['pekerjaan_dokumen_file_name'] . '.pdf';
		}
		if ($data['type'] == '1') {
			$operation['doc'] = base_url() . '/manages/file/uploads-document-' . $operation['pekerjaan_dokumen_file'] . '?' . date('YmdHis');
			$operation['docName'] = $operation['pekerjaan_dokumen_file'];
		}
		return $this->respondToCamel($operation, 'document');
	}

	public function getData()
	{
		$document = (new Dokumen())->setView('v_dokumen')->orderBy('pekerjaan_dokumen_no', 'ASC')->findAll();
		return $this->respond([
			'document' => $document,
		]);
	}

	public function getFilter()
	{
		$data = getPost();
		$where = [];
		if ($data['idp']) {
			$where['pekerjaan_program_id'] = $data['idp'];
		};
		if ($data['idk']) {
			$where['pekerjaan_kegiatan_id'] = $data['idk'];
		};
		if ($data['idks']) {
			$where['pekerjaan_kegiatan_sub_id'] = $data['idks'];
		};
		$document = (new Dokumen())->setView('v_dokumen')->where($where)->findAll();
		return $this->respond([
			'document' => $document,
		]);
	}

	public function getCombo()
	{
		$program = (new Program())->orderBy('program_kode', 'ASC')->findAll();
		$kegiatan = (new Kegiatan())->orderBy('kegiatan_kode', 'ASC')->findAll();
		$kegiatanSub = (new KegiatanSub())->setView('v_kegiatan_sub')->orderBy('kegiatan_sub_kode', 'ASC')->findAll();
		return $this->respond([
			'program' => $program,
			'kegiatan' => $kegiatan,
			'kegiatanSub' => $kegiatanSub,
		]);
	}
}
