<?php

namespace BackEnd\Laporan\Controllers;

use BackEnd\Laporan\Models\Laporan;
use BackEnd\Program\Models\Program;
use BackEnd\Kegiatan\Models\Kegiatan;
use BackEnd\KegiatanSub\Models\KegiatanSub;
use BackEnd\Pekerjaan\Models\PekerjaanUraian;

use App\Libraries\Excel;


class LaporanController extends \App\Core\BaseController
{
	public function index()
	{
		$operation = (new Laporan(request()))->draw(false);
		return $this->respond($operation);
	}

	public function getData($post = [])
	{
		$data = (!empty($post)) ? $post : getPost();
		$where = [];
		if ($data['data']['program']) {
			$where['pekerjaan_program_id'] = $data['data']['program'];
		};
		if ($data['data']['kegiatan']) {
			$where['pekerjaan_kegiatan_id'] = $data['data']['kegiatan'];
		};
		if ($data['data']['kegiatanSub']) {
			$where['pekerjaan_kegiatan_sub_id'] = $data['data']['kegiatanSub'];
		};
		$laporan = (new Laporan())->setView('v_laporan')->where($where)->findAll();

		foreach ($laporan as $lpi => $lpv) {
			$uraian = (new PekerjaanUraian())->setView('v_pekerjaan_uraian_all')->where('pekerjaan_uraian_pekerjaan_id', $lpv['pekerjaan_id'])->findAll();
			// print_r($uraian);
			$laporan[$lpi]['uraian'] = $uraian;
			// foreach($uraian as $ui => $uv){
			// 	$laporan[$lpi]['banyak_uraian'] = $uv;
			// }
		}

		if (!empty($post)) {
			return [
				'laporan' => $laporan
			];
		} else {
			return $this->respond([
				'laporan' => $laporan,
				// 'uraian' => $uraian,
			]);
		}
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

	// public function getExcel()
	// {
	// 	$operation = (new Excel())->htmlToExcel([$_POST['html']], 'laporan');
	// 	echo json_encode($operation);
	// }
	public function getExcel()
	{
		$data = getPost();
		$where = [];
		if ($data['data']['program']) {
			$where['pekerjaan_program_id'] = $data['data']['program'];
		};
		if ($data['data']['kegiatan']) {
			$where['pekerjaan_kegiatan_id'] = $data['data']['kegiatan'];
		};
		if ($data['data']['kegiatanSub']) {
			$where['pekerjaan_kegiatan_sub_id'] = $data['data']['kegiatanSub'];
		};
		$laporan = (new Laporan())->setView('v_laporan')->where($where)->findAll();

		foreach ($laporan as $lpi => $lpv) {
			$uraian = (new PekerjaanUraian())->setView('v_pekerjaan_uraian_all')->where('pekerjaan_uraian_pekerjaan_id', $lpv['pekerjaan_id'])->findAll();
			// print_r($uraian);
			$laporan[$lpi]['uraian'] = $uraian;
			// foreach($uraian as $ui => $uv){
			// 	$laporan[$lpi]['banyak_uraian'] = $uv;
			// }
		}

		$excel = new Excel();
		$col = 1;

		$headerCol1 = [
			"No",
			"Program",
			"Kegiatan",
			"Sub_Keg",
			"kap_pekerjaan",
			"Rek_Giat",
			"perusahaan",
			"alamat",
			"di",
			"direktur",
			"ketdir",
			"npwp",
			"akte_no",
			"tgl_akte",
			"akte_oleh",
			"no. penw",
		];
		foreach ($headerCol1 as $key => $value) {
			$excel->setDataCells([
				[
					'cell' => $excel->siConvert($col++) . '1',
					'value' => $value,
					'style' => '{height:20;vertical-align:center;}'
				],
			]);
		}
		$array = [];
		foreach ($laporan as $key => $value) {
			$array[] = count($value['uraian']);
			$maxArray = max($array);
			if (count($value['uraian']) === $maxArray) {
				foreach ($value['uraian'] as $key2 => $ur) {
					// print_r($ur);
					$excel->setDataCells([
						[
							'cell' => $excel->siConvert($col++) . '1',
							'value' => 'ur' . ($key2 + 1)
						],
						[
							'cell' => $excel->siConvert($col++) . '1',
							'value' => 'Vol/Sat'
						],
						[
							'cell' => $excel->siConvert($col++) . '1',
							'value' => 'hrg/unt'
						],
						[
							'cell' => $excel->siConvert($col++) . '1',
							'value' => 'd'
						],
					]);
				}
			}
		};
		$headerCol2 = [
			"r1",
			"r2",
			"r3",
			"r4",
			"v",
			"w",
			"Sumber Dana",
			"#####",
			"harga",
			"hrf_harga",
			"pagu",
			"hrf pagu",
			"HPS",
			"hrf_HPS",
			"Lok1",
			"Hrg_1",
			"Lok2",
			"Hrg_2",
			"Lok3",
			"Hrg_3",
			"Lok4",
			"Hrg_4",
			"Lok5",
			"Hrg_5",
			"Lok6",
			"Hrg_6",
			"Lokasi",
			"noundangan",
			"tglundangan",
			"Hari und",
			"Hrf UND",
			"Bln UND",
			"No MASUK DOK",
			"Tgl MASUK DOK",
			"Hari MSK",
			"Hrf MSK",
			"Bln MSK",
			"noaanwijzing",
			"TGLaanwijzing",
			"HARI aanwijzing",
			"HRF aanwijzing",
			"BLNaanwijzing dok",
			"Nobuka dok",
			"TGLbuka dok",
			"HARI buka dok",
			"HRF tglbukadok",
			"BLNbuka dok",
			"NOpenilaian dok",
			"TGLpenilaian dok",
			"HARIpenilaian dok",
			"HRFtglpenilaian dok",
			"BLNpenilaian dok",
			"NOKlarifikasi",
			"tglnegosiasi",
			"harinego",
			"hrftglnego",
			"bulannego",
			"NoTapLang",
			"TglTapLang",
			"HariTapLang",
			"HRFtglTapLang",
			"BlnTapLang",
			"NoPenjLang",
			"TGLPenjLang",
			"HariTGLPenjLang",
			"HrfTGLPenjLang",
			"BlnPenjLang",
			"NoPengum",
			"TglPengum",
			"NoPenunjukan",
			"HRkeputusan",
			"TGLkeputusan",
			"no_spmk",
			"tgl_spmk",
			"no_kontrak",
			"tgl_kontrak",
			"tgl_huruf",
			"hari",
			"bulan",
			"Add",
			"tgl add",
			"huruf add",
			"hari add",
			"bulan add",
			"Ms Pel.",
			"smp_dgn",
			"PPK",
			"Jabatan",
			"NIP",
			"Pangkat1",
			"Nm Sekdin/PPK",
			"Pangkat",
			"Jabatan",
			"Nip",
			"No. DIPA",
			"Tgl DPA",
			"PPtk",
			"Jabatan",
			"Pangkat",
			"Nip",
			"SK PPKOM",
			"kosong",
			"PERMOHONAN PEMERIKSAAN",
			"BAPB",
			"TGL-PERIKSA",
			"HR-PERIKSA",
			"TGL-PERIKSA",
			"BLN-PERIKSA",
			"BAST",
			"TGL_SERAH",
			"HRF_SERAH",
			"TGL_HRF_SERAH",
			"BLN_HRF_SERAH",
			"TGL_MHN",
			"BYR",
			"PAB100",
			"Tgl100%",
			"hr100%",
			"tgl 100%",
			"bln 100%",
			"PKP",
			"TGL_PKP",
			"Hari_HRF_PKP",
			"TGL_HRF_PKP",
			"BLN_HRF_PKP",
			"PPHP",
			"TGL_PPHP",
			"Hari_HRF_PPHP",
			"TGL_HRF_PPHP",
			"BLN_HRF_PPHP",
			"Bank",
			"No_Rek",
			"Nilai Fisik",
			"PPN",
			"PPN_HRF",
			"PPH",
			"PPH_HRF",
			"Total",
			"Pengawas",
			"Dir_xxx",
			"DIR_PWS",
			"ALAMAT_PWS",
			"BA_FHO",
			"TGL_FHO",
			"HR_FHO",
			"TGL_HRF_FHO",
			"BLN_FHO",
			"TAHUN_FHO",
			"TGL PERIKSA PELIHARA",
			"HR_MHN",
			"TGL_MHN",
			"BL_MHN",
		];
		foreach ($headerCol2 as $key => $value) {
			$excel->setDataCells([
				[
					'cell' => $excel->siConvert($col++) . '1',
					'value' => $value
				],
			]);
		}
		$array2 = [];
		foreach ($laporan as $lpi => $lpv) {
			$rekanan = json_decode($lpv['pekerjaan_rekanan_detail'], true);
			$excel->setDataCells([
				[
					'cell' => 'A' . ($lpi + 2),
					'value' => $lpi + 1,
					'style' => '{text-align:left;width:4}'
				],
				[
					'cell' => 'B' . ($lpi + 2),
					'value' => $lpv['program_nama'],
					'style' => '{text-align:left;width:70}'
				],
				[
					'cell' => 'C' . ($lpi + 2),
					'value' => $lpv['kegiatan_nama'],
					'style' => '{text-align:left;width:62}'
				],
				[
					'cell' => 'D' . ($lpi + 2),
					'value' => $lpv['kegiatan_sub_nama'],
					'style' => '{text-align:left;width:79}'
				],
				[
					'cell' => 'E' . ($lpi + 2),
					'value' => $lpv['pekerjaan_name'],
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => 'F' . ($lpi + 2),
					'value' => $rekanan['rekanan_rekening'],
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => 'G' . ($lpi + 2),
					'value' => $rekanan['rekanan_nama_perusahaan'],
					'style' => '{text-align:left;width:20}'
				],
				[
					'cell' => 'H' . ($lpi + 2),
					'value' => $rekanan['rekanan_alamat'],
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => 'I' . ($lpi + 2),
					'value' => $rekanan['rekanan_kota'],
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => 'J' . ($lpi + 2),
					'value' => $rekanan['rekanan_nama'],
					'style' => '{text-align:left;width:22}'
				],
				[
					'cell' => 'K' . ($lpi + 2),
					'value' => $rekanan['rekanan_jabatan'],
					'style' => '{text-align:left;width:22}'
				],
				[
					'cell' => 'L' . ($lpi + 2),
					'value' => $rekanan['rekanan_npwp'],
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => 'M' . ($lpi + 2),
					'value' => $rekanan['rekanan_akte'],
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => 'N' . ($lpi + 2),
					'value' => $rekanan['rekanan_tgl_akte'],
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => 'O' . ($lpi + 2),
					'value' => $rekanan['rekanan_pembuat_akte'],
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => 'P' . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
			]);
			$col2 = 17;
			$style = [
				"{width:130}",
				"{width:130}",
			];
			$valueV = [];
			foreach ($lpv['uraian'] as $ui => $uv) {
				$valueV[] = $uv['pekerjaan_uraian_harga'] * $uv['pekerjaan_uraian_qty'];
				$excel->setDataCells([
					[
						'cell' => $excel->siConvert($col2++) . ($lpi + 2),
						'value' => $uv['pekerjaan_uraian_nama'],
						'style' => '{text-align:left;width:19}'
					],
					[
						'cell' => $excel->siConvert($col2++) . ($lpi + 2),
						'value' => $uv['pekerjaan_uraian_qty'] . $uv['satuan_nama'],
						'style' => '{text-align:left;width:10}'
					],
					[
						'cell' => $excel->siConvert($col2++) . ($lpi + 2),
						'value' => $uv['pekerjaan_uraian_harga'],
						'style' => '{text-align:left;width:10}'
					],
					[
						'cell' => $excel->siConvert($col2++) . ($lpi + 2),
						'value' => $uv['pekerjaan_uraian_harga'] * $uv['pekerjaan_uraian_qty'],
						'style' => '{text-align:left;width:18}'
					],
				]);
			}
			$array2[] = count($lpv['uraian']);
			$maxArray = max($array);
			if (count($lpv['uraian']) < $maxArray) {
				$valueNull = $maxArray - count($lpv['uraian']);
				for ($i = 0; $i < $valueNull; $i++) {
					$excel->setDataCells([
						[
							'cell' => $excel->siConvert($col2++) . ($lpi + 2),
							'value' => '-',
							'style' => '{width:19}'
						],
						[
							'cell' => $excel->siConvert($col2++) . ($lpi + 2),
							'value' => '-',
							'style' => '{width:10}'
						],
						[
							'cell' => $excel->siConvert($col2++) . ($lpi + 2),
							'value' => '-',
							'style' => '{width:10}'
						],
						[
							'cell' => $excel->siConvert($col2++) . ($lpi + 2),
							'value' => '-',
							'style' => '{width:18}'
						],
					]);
				}
			}
			$excel->setDataCells([
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => array_sum($valueV),
					'style' => '{text-align:left;width:19}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:19}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => $lpv['sumber_dana_nama'],
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:100}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:100}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:100}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:15}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:40}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:23}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:40}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:40}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:36}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:53}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:28}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:19}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:36}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:40}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:26}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:43}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:32}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:38}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:29}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:32}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:36}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:10}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:8}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:8}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:8}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:8}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'value' => $rekanan['rekanan_bank'],
					'style' => '{text-align:left;width:43}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:22}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => $lpv['pekerjaan_ppn'],
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:93}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi+2),
					'value' => $lpv['jenis_pph_presentase'],
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:93}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:12}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:18}'
				],
				[
					'cell' => $excel->siConvert($col2++) . ($lpi + 2),
					'value' => '',
					'style' => '{text-align:left;width:13}'
				],
			]);
		}
		$operation = $excel->export('Laporan');
		return $this->respond($operation);
	}
}