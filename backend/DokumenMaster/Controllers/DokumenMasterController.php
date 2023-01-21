<?php

namespace BackEnd\DokumenMaster\Controllers;

use BackEnd\DokumenMaster\Models\DokumenMaster;
use BackEnd\DokumenMaster\Models\JenisDokumen;
use Exception;

class DokumenMasterController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new DokumenMaster(request()))->setView('v_dokumen_master')->setMode('datatable')->draw(true);
		return $this->respond($operation);
	}

	public function show()
	{
		$data = getPost();
		$operation = (new DokumenMaster())->find($data['id']);
		$operation['dokumen_template'] = base64_decode($operation['dokumen_template']);
		$operation['legend'] =  [
			[
				'name' => 'Dokumen',
				'data' => [
					'dokumen_no',
					'dokumen_tgl',
					'dokumen_type',
					'tanggal_hari',
					'tanggal_hari_huruf',
					'tanggal_nama_hari',
					'tanggal_bulan',
					'tanggal_nama_bulan',
					'tanggal_tahun',
					'tanggal_tahun_huruf'
				]
			],

			[
				'name' => 'Paket Pekerjaan',
				'data' => [
					'pekerjaan_name',
					'pekerjaan_lokasi',
					'program_nama',
					'kegiatan_nama',
					'kegiatan_sub_nama',
					'termyn_ke',
					'sumber_dana_nama',
					'pekerjaan_ppn',
					'jenis_pph_presentase',
					'pembayaran',
					'pembayaran_huruf',
					'pembayaran_prosentase',
					'pembayaran_prosentase_huruf',
					'nilai_ppn',
					'nilai_pph',
					'nilai_kontrak',
					'nilai_kontrak_huruf',
					'uraian_pekerjaan',
					'pekerjaan_jenis_kontrak',
					'pekerjaan_tahun_anggaran',
					'pekerjaan_surat_undangan_no',
					'pekerjaan_surat_undangan_tgl',
					'pekerjaan_surat_penunjukan_no',
					'pekerjaan_surat_penunjukan_tgl',
					'pekerjaan_surat_penunjukan_tgl_tanggal',
					'pekerjaan_surat_penunjukan_tgl_bulan',
					'pekerjaan_surat_penunjukan_tgl_tahun',
				]
			],

			[
				'name' => 'Rekanan',
				'data' => [
					'rekanan_nama',
					'rekanan_nama_perusahaan',
					'rekanan_alamat',
					'rekanan_kota',
					'rekanan_jabatan',
					'rekanan_npwp',
					'rekanan_akte',
					'rekanan_tgl_akte',
					'rekanan_pembuat_akte',
					'rekanan_kop_surat',
					'rekanan_telepon',
					'rekanan_email',
					'rekanan_bank',
					'rekanan_rekening'
				]
			],

			[
				'name' => 'Penatausahaan Keuangan (Pkeuangan)',
				'data' => [
					'Pkeuangan_user_name',
					'Pkeuangan_user_email',
					'Pkeuangan_user_telp',
					'Pkeuangan_user_address',
					'Pkeuangan_user_code',
					'Pkeuangan_jabatan_name',
					'Pkeuangan_user_pangkat',
					'Pkeuangan_user_no_dpp',
					'Pkeuangan_user_tgl_dpp',
					'Pkeuangan_user_no_dppa',
					'Pkeuangan_user_tgl_dppa',
					'Pkeuangan_user_no_skpa',
					'Pkeuangan_user_no_skppkom_pptk_ppk',
				]
			],

			[
				'name' => 'Pembuat Komitmen (PK)',
				'data' => [
					'PK_user_name',
					'PK_user_email',
					'PK_user_telp',
					'PK_user_address',
					'PK_user_code',
					'PK_jabatan_name',
					'PK_user_pangkat',
					'PK_user_no_dpp',
					'PK_user_tgl_dpp',
					'PK_user_no_dppa',
					'PK_user_tgl_dppa',
					'PK_user_no_skpa',
					'PK_user_no_skppkom_pptk_ppk',
				]
			],

			[
				'name' => 'Pelaksana Teknis (Pteknis)',
				'data' => [
					'Pteknis_user_name',
					'Pteknis_user_email',
					'Pteknis_user_telp',
					'Pteknis_user_address',
					'Pteknis_user_code',
					'Pteknis_jabatan_name',
					'Pteknis_user_pangkat',
					'Pteknis_user_no_dpp',
					'Pteknis_user_tgl_dpp',
					'Pteknis_user_no_dppa',
					'Pteknis_user_tgl_dppa',
					'Pteknis_user_no_skpa',
					'Pteknis_user_no_skppkom_pptk_ppk',
				]
			],

			[
				'name' => 'Pejabat Bendahara (Pbendahara)',
				'data' => [
					'Pbendahara_user_name',
					'Pbendahara_user_email',
					'Pbendahara_user_telp',
					'Pbendahara_user_address',
					'Pbendahara_user_code',
					'Pbendahara_jabatan_name',
					'Pbendahara_user_pangkat',
					'Pbendahara_user_no_dpp',
					'Pbendahara_user_tgl_dpp',
					'Pbendahara_user_no_dppa',
					'Pbendahara_user_tgl_dppa',
					'Pbendahara_user_no_skpa',
					'Pbendahara_user_no_skppkom_pptk_ppk',
				]
			],

			[
				'name' => 'Pengguna Anggaran (PA)',
				'data' => [
					'PA_user_name',
					'PA_user_email',
					'PA_user_telp',
					'PA_user_address',
					'PA_user_code',
					'PA_jabatan_name',
					'PA_user_pangkat',
					'PA_user_no_dpp',
					'PA_user_tgl_dpp',
					'PA_user_no_dppa',
					'PA_user_tgl_dppa',
					'PA_user_no_skpa',
					'PA_user_no_skppkom_pptk_ppk',
				]
			],
		];
		switch ($operation['dokumen_kode']) {
			case 'DOC-003':
				$operation['legend'][] = [
					'name' => 'Khusus Dokumen Ini',
					'data' => [
						'pekerjaan_dokumen_tgl_mulai',
						'pekerjaan_dokumen_tgl_selesai',
						'pekerjaan_dokumen_durasi_pekerjaan',
					]
				];
				break;

			case 'DOC-006':
			case 'DOC-007':
			case 'DOC-009':
			case 'DOC-012':
			case 'DOC-013':
			case 'DOC-015':
			case 'DOC-019':
			case 'DOC-020':
				$operation['legend'][] = [
					'name' => 'Khusus Dokumen Ini',
					'data' => [
						'SP_pekerjaan_dokumen_no',
						'SP_pekerjaan_dokumen_tgl',
						'SPK_pekerjaan_dokumen_tgl_mulai',
						'SPK_pekerjaan_dokumen_tgl_selesai',
					]
				];
				break;

			case 'DOC-016':
				$operation['legend'][] = [
					'name' => 'Khusus Dokumen Ini',
					'data' => [
						'SP_pekerjaan_dokumen_no',
						'SP_pekerjaan_dokumen_tgl',
						'SPK_pekerjaan_dokumen_no',
						'SPK_pekerjaan_dokumen_tgl',
						'SPK_pekerjaan_dokumen_tgl_mulai',
						'SPK_pekerjaan_dokumen_tgl_selesai',
						'PemeriksaanPekerjaan_pekerjaan_dokumen_no',
						'PemeriksaanPekerjaan_pekerjaan_dokumen_tgl',
					]
				];
				break;

			case 'DOC-005':
			case 'DOC-011':
				$operation['legend'][] = [
					'name' => 'Khusus Dokumen Ini',
					'data' => [
						'SP_pekerjaan_dokumen_no',
						'SP_pekerjaan_dokumen_tgl',
						'SPK_pekerjaan_dokumen_no',
						'SPK_pekerjaan_dokumen_tgl',
					]
				];
				break;

			case 'DOC-018':
				$operation['legend'][] = [
					'name' => 'Khusus Dokumen Ini',
					'data' => [
						'SP_pekerjaan_dokumen_no',
						'SP_pekerjaan_dokumen_tgl',
						'SPK_pekerjaan_dokumen_no',
						'SPK_pekerjaan_dokumen_tgl',
						'SerahTerima_pekerjaan_dokumen_no',
						'SerahTerima_pekerjaan_dokumen_tgl',
					]
				];
				break;
		}

		return $this->respondToCamel($operation, 'dokumen');
	}

	public function store()
	{
		$data = getVar(null, 'dokumen');
		$data['dokumen_aktif'] = ((isset($data['dokumen_aktif']) && $data['dokumen_aktif'] == 1) ? 1 : 0);
		$data['dokumen_template'] = base64_encode($data['dokumen_template']);
		$operation = (new DokumenMaster())->insert($data);
		return $this->respondCreated($operation);
	}

	public function update()
	{
		$data = getVar(null, 'dokumen');
		$data['dokumen_aktif'] = ((isset($data['dokumen_aktif']) && $data['dokumen_aktif'] == 1) ? 1 : 0);
		unset($data['dokumen_kode']);
		$data['dokumen_template'] = base64_encode($_POST['template']);
		$operation = (new DokumenMaster())->update($data);
		return $this->respondCreated($operation);
	}

	public function destroy()
	{
		$data = getPost();
		try {
			$operation = (new DokumenMaster())->delete($data['id']);
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
		return $this->respond([
			'jenisDokumen' => (new JenisDokumen())->where('jenis_dokumen_aktif', '1')->orderBy('jenis_dokumen_kode', 'ASC')->findAll()
		]);
	}
}
