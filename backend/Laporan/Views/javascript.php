<script type="text/javascript">
	// var table = 'tableDokumen';
	var form = 'tableDokumen';
	var Rekanan = []
	var User = []

	$(() => {
		HELPER.fields = ['id'];

		HELPER.api = {
			index: APP_URL + 'laporan',
			show: APP_URL + 'laporan/show',
			getData: APP_URL + 'laporan/getData',
			getCombo: APP_URL + 'laporan/getCombo',
			getExcel: APP_URL + 'laporan/getExcel',
			// getExcel2: APP_URL + 'laporan/getExcel2',
		};

		// HELPER.handleValidation({
		// 	el: form,
		// 	declarative: true
		// });

		index();
	});

	index = async () => {
		// await initData();
		await getDataCombo();
		await HELPER.unblock(100);
	}

	getDataCombo = () => {
		return new Promise((resolve, reject) => {
			HELPER.ajax({
				url: HELPER.api.getCombo,
				success: (response) => {
					resolve(true);
					HELPER.setDataMultipleCombo([{
						data: response.program,
						el: 'navProgram',
						valueField: 'program_id',
						displayField: 'program_nama',
						placeholder: 'Program',
						withNull: true,
						select2: true
					}, ]);
					HELPER.setDataMultipleCombo([{
						data: response.kegiatan,
						el: 'navKegiatan',
						valueField: 'kegiatan_id',
						displayField: 'kegiatan_nama',
						placeholder: 'Kegiatan',
						withNull: true,
						select2: true
					}, ]);
					HELPER.setDataMultipleCombo([{
						data: response.kegiatanSub,
						el: 'navKegiatanSub',
						valueField: 'kegiatan_sub_id',
						displayField: 'kegiatan_sub_nama',
						placeholder: 'Kegiatan Sub',
						withNull: true,
						select2: true
					}, ]);
				}
			});
		});
	}
	onSearch = () => {
		HELPER.block();
		program = $('#navProgram').val();
		kegiatan = $('#navKegiatan').val();
		kegiatanSub = $('#navKegiatanSub').val();

		data = {
			'program': program,
			'kegiatan': kegiatan,
			'kegiatanSub': kegiatanSub
		}

		form_laporan = [];
		form_isi = [];
		form_uraian = [];
		form_head = [];

		HELPER.ajax({
			url: HELPER.api.getData,
			data: {
				data: data,
			},
			success: (response) => {
				form_laporan.push([`
					<div class="card shadow-sm">
						<div class="card-body">
						<div class="col-12 col-md-1 col-lg-1 mb-2">
							<button type="button" onclick="onExcel()" class="btn btn-sm btn-success" style="width:100px; !important"><i class="fa fa-file-excel me-1"></i>Export</button>
						</div>
							<div class="table-responsive">
								<table class="table table-row-bordered border align-middle rounded tdFirstCenter" style="white-space: nowrap;">
									<thead>
										<tr class="fw-bolder">
											<th width="25px" height="30px" style="vertical-align:center;">No</th>
											<th width="490px" style="vertical-align:center;">Program</th>
											<th width="430px" style="vertical-align:center;">Kegiatan</th>
											<th width="550px" style="vertical-align:center;">Sub_Keg</th>
											<th width="100px" style="vertical-align:center;">kap_pekerjaan</th>
											<th width="120px" style="vertical-align:center;">Rek_Giat</th>
											<th width="140px" style="vertical-align:center;">perusahaan</th>
											<th width="100px" style="vertical-align:center;">alamat</th>
											<th width="100px" style="vertical-align:center;">di</th>
											<th width="150px" style="vertical-align:center;">direktur</th>
											<th width="150px" style="vertical-align:center;">ketdir</th>
											<th width="100px" style="vertical-align:center;">npwp</th>
											<th width="100px" style="vertical-align:center;">akte_no</th>
											<th width="80px" style="vertical-align:center;">tgl_akte</th>
											<th width="80px" style="vertical-align:center;">akte_oleh</th>
											<th width="100px" style="vertical-align:center;">no. penw</th>
				`]);
				no = 1;
				uraian = [];
				$.each(response.laporan, (pi, pv) => {
					uraian.push(pv['uraian'].length);
					uraian2 = Math.max.apply(Math, uraian);
					if (pv['uraian'].length == uraian2) {
						$.each(pv['uraian'], (hi, hv) => {
							form_laporan.push([`
											<th width="130px" style="vertical-align:center;">ur${no++}</th>
											<th width="70px" style="vertical-align:center;">Vol/Sat</th>
											<th width="70px" style="vertical-align:center;">hrg/unt</th>
											<th width="120px" style="vertical-align:center;">d</th>
						`]);
						})
					}
				})
				form_laporan.push([`
											<th width="120px" style="vertical-align:center;">r1</th>
											<th width="120px" style="vertical-align:center;">r2</th>
											<th width="120px" style="vertical-align:center;">r3</th>
											<th width="120px" style="vertical-align:center;">r4</th>
											<th width="130px" style="vertical-align:center;">v</th>
											<th width="130px" style="vertical-align:center;">w</th>
											<th width="100px" style="vertical-align:center;">Sumber Dana</th>
											<th width="100px" style="vertical-align:center;">#####</th>
											<th width="120px" style="vertical-align:center;">harga</th>
											<th width="700px" style="vertical-align:center;">hrf_harga</th>
											<th width="120px" style="vertical-align:center;">pagu</th>
											<th width="700px" style="vertical-align:center;">hrf pagu</th>
											<th width="120px" style="vertical-align:center;">HPS</th>
											<th width="700px" style="vertical-align:center;">hrf_HPS</th>
											<th width="100px" style="vertical-align:center;">Lok1</th>
											<th width="100px" style="vertical-align:center;">Hrg_1</th>
											<th width="100px" style="vertical-align:center;">Lok2</th>
											<th width="100px" style="vertical-align:center;">Hrg_2</th>
											<th width="100px" style="vertical-align:center;">Lok3</th>
											<th width="100px" style="vertical-align:center;">Hrg_3</th>
											<th width="100px" style="vertical-align:center;">Lok4</th>
											<th width="100px" style="vertical-align:center;">Hrg_4</th>
											<th width="100px" style="vertical-align:center;">Lok5</th>
											<th width="100px" style="vertical-align:center;">Hrg_5</th>
											<th width="100px" style="vertical-align:center;">Lok6</th>
											<th width="100px" style="vertical-align:center;">Hrg_6</th>
											<th width="100px" style="vertical-align:center;">Lokasi</th>
											<th width="280px" style="vertical-align:center;">noundangan</th>
											<th width="120px" style="vertical-align:center;">tglundangan</th>
											<th width="80px" style="vertical-align:center;">Hari und</th>
											<th width="160px" style="vertical-align:center;">Hrf UND</th>
											<th width="90px" style="vertical-align:center;">Bln UND</th>
											<th width="260px" style="vertical-align:center;">No MASUK DOK</th>
											<th width="120px" style="vertical-align:center;">Tgl MASUK DOK</th>
											<th width="80px" style="vertical-align:center;">Hari MSK</th>
											<th width="120px" style="vertical-align:center;">Hrf MSK</th>
											<th width="90px" style="vertical-align:center;">Bln MSK</th>
											<th width="280px" style="vertical-align:center;">noaanwijzing</th>
											<th width="120px" style="vertical-align:center;">TGLaanwijzing</th>
											<th width="80px" style="vertical-align:center;">HARI aanwijzing</th>
											<th width="120px" style="vertical-align:center;">HRF aanwijzing</th>
											<th width="90px" style="vertical-align:center;">BLNaanwijzing dok</th>
											<th width="280px" style="vertical-align:center;">Nobuka dok</th>
											<th width="120px" style="vertical-align:center;">TGLbuka dok</th>
											<th width="80px" style="vertical-align:center;">HARI buka dok</th>
											<th width="120px" style="vertical-align:center;">HRF tglbukadok</th>
											<th width="90px" style="vertical-align:center;">BLNbuka dok</th>
											<th width="260px" style="vertical-align:center;">NOpenilaian dok</th>
											<th width="120px" style="vertical-align:center;">TGLpenilaian dok</th>
											<th width="80px" style="vertical-align:center;">HARIpenilaian dok</th>
											<th width="120px" style="vertical-align:center;">HRFtglpenilaian dok</th>
											<th width="90px" style="vertical-align:center;">BLNpenilaian dok</th>
											<th width="260px" style="vertical-align:center;">NOKlarifikasi</th>
											<th width="120px" style="vertical-align:center;">tglnegosiasi</th>
											<th width="80px" style="vertical-align:center;">harinego</th>
											<th width="120px" style="vertical-align:center;">hrftglnego</th>
											<th width="90px" style="vertical-align:center;">bulannego</th>
											<th width="120px" style="vertical-align:center;">NoTapLang</th>
											<th width="120px" style="vertical-align:center;">TglTapLang</th>
											<th width="260px" style="vertical-align:center;">HariTapLang</th>
											<th width="120px" style="vertical-align:center;">HRFtglTapLang</th>
											<th width="90px" style="vertical-align:center;">BlnTapLang</th>
											<th width="260px" style="vertical-align:center;">NoPenjLang</th>
											<th width="120px" style="vertical-align:center;">TGLPenjLang</th>
											<th width="80px" style="vertical-align:center;">HariTGLPenjLang</th>
											<th width="120px" style="vertical-align:center;">HrfTGLPenjLang</th>
											<th width="90px" style="vertical-align:center;">BlnPenjLang</th>
											<th width="260px" style="vertical-align:center;">NoPengum</th>
											<th width="120px" style="vertical-align:center;">TglPengum</th>
											<th width="260px" style="vertical-align:center;">NoPenunjukan</th>
											<th width="80px" style="vertical-align:center;">HRkeputusan</th>
											<th width="120px" style="vertical-align:center;">TGLkeputusan</th>
											<th width="260px" style="vertical-align:center;">no_spmk</th>
											<th width="120px" style="vertical-align:center;">tgl_spmk</th>
											<th width="260px" style="vertical-align:center;">no_kontrak</th>
											<th width="120px" style="vertical-align:center;">tgl_kontrak</th>
											<th width="120px" style="vertical-align:center;">tgl_huruf</th>
											<th width="80px" style="vertical-align:center;">hari</th>
											<th width="90px" style="vertical-align:center;">bulan</th>
											<th width="260px" style="vertical-align:center;">Add</th>
											<th width="120px" style="vertical-align:center;">tgl add</th>
											<th width="120px" style="vertical-align:center;">huruf add</th>
											<th width="80px" style="vertical-align:center;">hari add</th>
											<th width="90px" style="vertical-align:center;">bulan add</th>
											<th width="80px" style="vertical-align:center;">Ms Pel.</th>
											<th width="120px" style="vertical-align:center;">smp_dgn</th>
											<th width="250px" style="vertical-align:center;">PPK</th>
											<th width="370px" style="vertical-align:center;">Jabatan</th>
											<th width="190px" style="vertical-align:center;">NIP</th>
											<th width="130px" style="vertical-align:center;">Pangkat1</th>
											<th width="250px" style="vertical-align:center;">Nm Sekdin/PPK</th>
											<th width="120px" style="vertical-align:center;">Pangkat</th>
											<th width="280px" style="vertical-align:center;">Jabatan</th>
											<th width="180px" style="vertical-align:center;">Nip</th>
											<th width="300px" style="vertical-align:center;">No. DIPA</th>
											<th width="120px" style="vertical-align:center;">Tgl DPA</th>
											<th width="220px" style="vertical-align:center;">PPtk</th>
											<th width="260px" style="vertical-align:center;">Jabatan</th>
											<th width="120px" style="vertical-align:center;">Pangkat</th>
											<th width="200px" style="vertical-align:center;">Nip</th>
											<th width="220px" style="vertical-align:center;">SK PPKOM</th>
											<th width="120px" style="vertical-align:center;">kosong</th>
											<th width="250px" style="vertical-align:center;">PERMOHONAN PEMERIKSAAN</th>
											<th width="70px" style="vertical-align:center;">BAPB</th>
											<th width="120px" style="vertical-align:center;">TGL-PERIKSA</th>
											<th width="80px" style="vertical-align:center;">HR-PERIKSA</th>
											<th width="120px" style="vertical-align:center;">TGL-PERIKSA</th>
											<th width="90px" style="vertical-align:center;">BLN-PERIKSA</th>
											<th width="50px" style="vertical-align:center;">BAST</th>
											<th width="120px" style="vertical-align:center;">TGL_SERAH</th>
											<th width="120px" style="vertical-align:center;">HRF_SERAH</th>
											<th width="120px" style="vertical-align:center;">TGL_HRF_SERAH</th>
											<th width="120px" style="vertical-align:center;">BLN_HRF_SERAH</th>
											<th width="120px" style="vertical-align:center;">TGL_MHN</th>
											<th width="50px" style="vertical-align:center;">BYR</th>
											<th width="50px" style="vertical-align:center;">PAB100</th>
											<th width="120px" style="vertical-align:center;">Tgl100%</th>
											<th width="80px" style="vertical-align:center;">hr100%</th>
											<th width="120px" style="vertical-align:center;">tgl 100%</th>
											<th width="120px" style="vertical-align:center;">bln 100%</th>
											<th width="50px" style="vertical-align:center;">PKP</th>
											<th width="120px" style="vertical-align:center;">TGL_PKP</th>
											<th width="80px" style="vertical-align:center;">Hari_HRF_PKP</th>
											<th width="120px" style="vertical-align:center;">TGL_HRF_PKP</th>
											<th width="90px" style="vertical-align:center;">BLN_HRF_PKP</th>
											<th width="120px" style="vertical-align:center;">PPHP</th>
											<th width="120px" style="vertical-align:center;">TGL_PPHP</th>
											<th width="80px" style="vertical-align:center;">Hari_HRF_PPHP</th>
											<th width="120px" style="vertical-align:center;">TGL_HRF_PPHP</th>
											<th width="120px" style="vertical-align:center;">BLN_HRF_PPHP</th>
											<th width="300px" style="vertical-align:center;">Bank</th>
											<th width="150px" style="vertical-align:center;">No_Rek</th>
											<th width="120px" style="vertical-align:center;">Nilai Fisik</th>
											<th width="120px" style="vertical-align:center;">PPN</th>
											<th width="650px" style="vertical-align:center;">PPN_HRF</th>
											<th width="120px" style="vertical-align:center;">PPH</th>
											<th width="650px" style="vertical-align:center;">PPH_HRF</th>
											<th width="120px" style="vertical-align:center;">Total</th>
											<th width="120px" style="vertical-align:center;">Pengawas</th>
											<th width="120px" style="vertical-align:center;">Dir_xxx</th>
											<th width="120px" style="vertical-align:center;">DIR_PWS</th>
											<th width="120px" style="vertical-align:center;">ALAMAT_PWS</th>
											<th width="120px" style="vertical-align:center;">BA_FHO</th>
											<th width="120px" style="vertical-align:center;">TGL_FHO</th>
											<th width="80px" style="vertical-align:center;">HR_FHO</th>
											<th width="120px" style="vertical-align:center;">TGL_HRF_FHO</th>
											<th width="90px" style="vertical-align:center;">BLN_FHO</th>
											<th width="120px" style="vertical-align:center;">TAHUN_FHO</th>
											<th width="120px" style="vertical-align:center;">TGL PERIKSA PELIHARA</th>
											<th width="80px" style="vertical-align:center;">HR_MHN</th>
											<th width="120px" style="vertical-align:center;">TGL_MHN</th>
											<th width="90px" style="vertical-align:center;">BL_MHN</th>
										</tr>
									</thead>
									<tbody>
						`]);
				no2 = 1;
				isi = [];
				$.each(response.laporan, (lpi, lpv) => {
					json = lpv.pekerjaan_rekanan_detail;
					obj = JSON.parse(json);
					values = Object.keys(obj).map(function(key) {
						return obj[key];
					});
					console.log(values[9])
					if (values[9] == null) {
						var tgl = values[9] = '-';
					} else {
						var slash = values[9].replace("-", "/");
						var tgl = slash.replace("-", "/");
					}
					form_laporan.push([`
										<tr>
											<td>${no2++}</td>
											<td>${lpv.program_nama}</td>
											<td>${lpv.kegiatan_nama}</td>
											<td>${lpv.kegiatan_sub_nama}</td>
											<td>${lpv.pekerjaan_name}</td>
											<td>${values[15]}</td>
											<td>${values[3]}</td>
											<td>${values[4]}</td>
											<td>${values[5]}</td>
											<td>${values[2]}</td>
											<td>${values[6]}</td>
											<td>${values[7]}</td>
											<td>${values[8]}</td>
											<td>${tgl}</td>
											<td>${values[10]}</td>
											<td></td>
						`]);
					var col_v = 0;
					$.each(lpv['uraian'], (ui, uv) => {
						col_v += uv['pekerjaan_uraian_harga'] * uv['pekerjaan_uraian_qty'];
						form_laporan.push([`
											<td>${uv['pekerjaan_uraian_nama']}</td>
											<td>${uv['pekerjaan_uraian_qty']} ${uv['satuan_nama']}</td>
											<td>${uv['pekerjaan_uraian_harga']}</td>
											<td>${uv['pekerjaan_uraian_harga'] * uv['pekerjaan_uraian_qty']}</td>
							`]);
					});

					isi.push(lpv['uraian'].length);
					isi2 = Math.max.apply(Math, isi);
					if (lpv['uraian'].length < isi2) {
						isi3 = isi2 - lpv['uraian'].length;
						for (var i = 0; i < isi3; i++) {
							form_laporan.push([`
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
							`]);
						}
					}
					form_laporan.push([`
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>${col_v}</td>
											<td></td>
											<td>${lpv.sumber_dana_nama}</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>${values[14]}</td>
											<td>${values[15]}</td>
											<td></td>
											<td>${lpv.pekerjaan_ppn}</td>
											<td></td>
											<td>${lpv.jenis_pph_presentase}</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											
					`])
					form_laporan.push(['</tr>'])
				});
				form_laporan.push([`
										</tbody>
										</table>
									</div>
								</div>
							</div>
					`]);
				$('#viewLaporan').html(form_laporan.join(''));
			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});


	}

	// onExcel = () => {
	// 	html = $('#viewLaporan').html()
	// 	HELPER.ajax({
	// 		url: HELPER.api.getExcel,
	// 		data: {
	// 			html: html,
	// 		},
	// 		success: (response) => {
	// 			var obj = JSON.parse(response);
	// 			var link = document.createElement("a");
	// 			link.href = obj.url;
	// 			document.body.appendChild(link);
	// 			link.click();
	// 			link.remove();
	// 		},
	// 		complete: (response) => {
	// 			HELPER.unblock(500);
	// 		}
	// 	});
	// }

	onExcel = () => {
		program = $('#navProgram').val();
		kegiatan = $('#navKegiatan').val();
		kegiatanSub = $('#navKegiatanSub').val();

		data = {
			'program': program,
			'kegiatan': kegiatan,
			'kegiatanSub': kegiatanSub
		}
		HELPER.ajax({
			url: HELPER.api.getExcel,
			data: {
				data: data,
			},
			success: (response) => {
				var obj = response;
				var link = document.createElement("a");
				link.href = obj.url;
				document.body.appendChild(link);
				link.click();
				link.remove();
			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});
	}

	onRefresh = () => {
		initData()
	}
</script>