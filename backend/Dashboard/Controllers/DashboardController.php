<?php

namespace BackEnd\Dashboard\Controllers;

use App\Libraries\Parser;
use BackEnd\Pekerjaan\Models\Pekerjaan;
use BackEnd\Pekerjaan\Models\PekerjaanDokumen;

class DashboardController extends \App\Core\BaseController
{
	public function getData()
	{
		$oneLastDate = date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d'))));
		$pekerjaan = new Pekerjaan();
		$totalPekerjaan = $pekerjaan->countAllResults();
		$totalPekerjaanOneLastWeek = $pekerjaan->where(['pekerjaan_created_at >= "' . $oneLastDate . '" ' => null])->countAllResults();

		$dokument = new PekerjaanDokumen();
		$totalDokument = 0;
		$totalDokumentOneLastWeek = $this->getCountDocThisWeek($oneLastDate);

		$chartDokument = $this->getChartDokument();
		foreach ($chartDokument as $key => $value) {
			$totalDokument += $value['value'];
		}

		return $this->respond([
			'totalPekerjaan' => $totalPekerjaan,
			'totalPekerjaanOneLastWeek' => $totalPekerjaanOneLastWeek,
			'totalDokument' => $totalDokument,
			'totalDokumentOneLastWeek' => $totalDokumentOneLastWeek,
			'chartDokument' => $chartDokument
		]);
	}

	public function getChartDokument()
	{
		$operation = $this->db->query("
			SELECT 
				(SELECT COUNT('*') FROM pekerjaan_dokumen WHERE pekerjaan_dokumen_dokumen_id = 'n5j9qg55y8fc0yks' AND pekerjaan_dokumen_file is not null)+(SELECT COUNT('*') FROM pekerjaan_dokumen WHERE pekerjaan_dokumen_dokumen_id = 'n5j9qg55y8fc0yks' AND pekerjaan_dokumen_file_name is not null) AS Kontrak,
				(SELECT COUNT('*') FROM pekerjaan_dokumen WHERE pekerjaan_dokumen_dokumen_id = 'i2b2wrizvq4gvynh' AND pekerjaan_dokumen_file is not null)+(SELECT COUNT('*') FROM pekerjaan_dokumen WHERE pekerjaan_dokumen_dokumen_id = 'i2b2wrizvq4gvynh' AND pekerjaan_dokumen_file_name is not null) AS SPMK,
				(SELECT COUNT('*') FROM pekerjaan_dokumen WHERE pekerjaan_dokumen_dokumen_id NOT IN('n5j9qg55y8fc0yks','i2b2wrizvq4gvynh') AND pekerjaan_dokumen_file is not null)+(SELECT COUNT('*') FROM pekerjaan_dokumen WHERE pekerjaan_dokumen_dokumen_id NOT IN('n5j9qg55y8fc0yks','i2b2wrizvq4gvynh') AND pekerjaan_dokumen_file_name is not null) AS Termin
		")->getResultArray()[0];

		return [
			['category' => 'Kontrak', 'value' => $operation['Kontrak']],
			['category' => 'SPMK', 'value' => $operation['SPMK']],
			['category' => 'Termin', 'value' => $operation['Termin']],
		];
	}

	public function getCountDocThisWeek($oneLastDate)
	{
		$operation = $this->db->query("
			SELECT
				(SELECT COUNT('*') FROM pekerjaan_dokumen WHERE pekerjaan_dokumen_created_at >= '" . $oneLastDate . "' AND pekerjaan_dokumen_file is not null)+(SELECT COUNT('*') FROM pekerjaan_dokumen WHERE pekerjaan_dokumen_created_at >= '" . $oneLastDate . "' AND pekerjaan_dokumen_file_name is not null) AS Total
		")->getResultArray()[0];

		return $operation['Total'];
	}
}
