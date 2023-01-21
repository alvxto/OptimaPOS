<script type="text/javascript">
	var table = 'tablePengaduan';
	var form = 'formPengaduan';
	var Rekanan = []
	var Satuan = []
	var DokumenMaster = []
	var formReset = [
	];

	$(() => {
		HELPER.fields = ['id'];

		HELPER.api = {
			index: APP_URL + 'pekerjaan',
			store: APP_URL + 'pekerjaan/store',
			show: APP_URL + 'pekerjaan/show',
			update: APP_URL + 'pekerjaan/update',
			destroy: APP_URL + 'pekerjaan/destroy',
			getData: APP_URL + 'pekerjaan/getData',
		};

		HELPER.handleValidation({
			el: form,
			declarative: true
		});

		index();
	});

	index = async () => {
		await initTable();
		await getData();
		await HELPER.unblock(100);
		$('#tanggalDokumen,[name="suratUndanganTgl"],[name="suratPenunjukanTgl"]').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			autoApply: true,
			minYear: 1901,
			maxYear: parseInt(moment().format("YYYY"), 10),
			locale: {
				format: "DD/MM/YYYY"
			}
		});
		$('[name="tahunAnggaran"]').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			autoApply: true,
			minYear: 1901,
			maxYear: parseInt(moment().format("YYYY"), 10),
			locale: {
				format: "YYYY"
			}
		});
		$("#tanggalSPMK").daterangepicker({
			showDropdowns: true,
			autoApply: true,
			minYear: 1901,
			maxYear: parseInt(moment().format("YYYY"), 10),
			locale: {
				format: "DD/MM/YYYY"
			}
		}, (start, end, label) => {
			$('#spmkDifDay').html(end.diff(start, 'days') + ' Hari')
		});
	}

	getData = () => {
		return new Promise((resolve, reject) => {
			HELPER.ajax({
				url: HELPER.api.getData,
				success: (response) => {
					resolve(true);
					$('#ppnView').val(response.ppn)
					Rekanan = response.rekanan
					Satuan = response.satuan
					DokumenMaster = response.dokumen
					HELPER.setDataMultipleCombo([{
							data: response.program,
							el: 'programId',
							valueField: 'program_id',
							displayField: 'program_nama',
							placeholder: 'Select Program',
							select2: true,
						},
						{
							data: response.sumberDana,
							el: 'sumberDanaId',
							valueField: 'sumber_dana_id',
							displayField: 'sumber_dana_nama',
							placeholder: 'Select sumber Dana',
							select2: true,
						},
						{
							data: response.JenisPPH,
							el: 'jenisPphId',
							valueField: 'jenis_pph_id',
							displayField: 'jenis_pph_presentase',
							displayField2: 'jenis_pph_nama',
							placeholder: 'Select Jenis PPH',
							grouped: true,
							select2: true,
						},
						{
							data: response.rekanan,
							el: 'rekananId',
							valueField: 'rekanan_id',
							displayField: 'rekanan_npwp',
							displayField2: 'rekanan_nama',
							placeholder: 'Select Rekanan',
							grouped: true,
							select2: true,
						},
						{
							data: response.JenisDokumen,
							el: 'newTermynJenisTermyn',
							valueField: 'jenis_dokumen_id',
							displayField: 'jenis_dokumen_nama',
							placeholder: 'Select Pembuat Komitmen',
							select2: true,
						},
						{
							data: response.penataUsahaKeuangan,
							el: 'penataUsahaKeuanganId',
							valueField: 'user_id',
							displayField: 'user_name',
							placeholder: 'Pilih Pejabat Penatausahaan Keuangan',
							select2: true,
						},
						{
							data: response.pembuatKomitmen,
							el: 'pembuatKomitmenId',
							valueField: 'user_id',
							displayField: 'user_name',
							placeholder: 'Pilih Pejabat Pembuat Komitmen',
							select2: true,
						},
						{
							data: response.pelaksanaTeknis,
							el: 'pelaksanaTeknisId',
							valueField: 'user_id',
							displayField: 'user_name',
							placeholder: 'Pilih Pejabat Pelaksana Teknis',
							select2: true,
						},
						{
							data: response.bendaharaPengeluaran,
							el: 'bendaharaPengeluaranId',
							valueField: 'user_id',
							displayField: 'user_name',
							placeholder: 'Pilih Bendahara Pengeluaran',
							select2: true,
						},
						{
							data: response.penggunaAnggaran,
							el: 'penggunaAnggaranId',
							valueField: 'user_id',
							displayField: 'user_name',
							placeholder: 'Pilih Pengguna Anggaran',
							select2: true,
						},
						{
							data: response.year,
							el: 'tahunAnggaran',
							valueField: 'year',
							displayField: 'year',
							placeholder: 'Pilih Tahun Anggaran',
							select2: true,
						},
					]);
					$("#tahunAnggaran").val('<?php echo date('Y') ?>').attr("selected", "selected").trigger("change");
				}
			});
		});
	}

	initTable = () => {
		return new Promise((resolve, reject) => {
			var initTable = HELPER.initTable({
				el: table,
				url: HELPER.api.index,
				clickAble: true,
				searchAble: true,
				destroyAble: true,
				responsive: false,
				rawClick: (payload) => {
					if (payload.selected) {
						onDetail(payload.rowData.id)
					}
				},
				columnDefs: [{
						targets: 0,
						render: function(data, type, full, meta) {
							return full.no;
						}
					},
					{
						targets: 2,
						render: function(data, type, full, meta) {
							return 'Pembuatan ' + data;
						}
					},
					{
						targets: 3,
						render: function(data, type, full, meta) {
							return moment(data, 'YYYY-MM-DD HH:mm:ss').format('DD MMMM YYYY HH:mm');
						}
					},
				],
				fnCreatedRow: function(nRow, aData, iDataIndex) {
					$(nRow).attr('id', aData[0]);
				},
				fnInitComplete: function(oSettings, data) {
					resolve(true)
				}
			});
		});
	}

	onAdd = () => {
		$('#table_data, #detail_data').fadeOut()
		$('#form_data').fadeIn()
	}

	onRefresh = () => {
		initTable()
	}

	onEdit = (id) => {
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.show,
			data: {
				id: $('#id').val()
			},
			success: (response) => {
				onAdd()
				HELPER.populateForm($(`[id="${form}"]`), response);
				$('#penataUsahaKeuanganId').val(response.penataUsahaKeuanganId).change()
				$('#pembuatKomitmenId').val(response.pembuatKomitmenId).change()
				$('#pelaksanaTeknisId').val(response.pelaksanaTeknisId).change()
				$('#bendaharaPengeluaranId').val(response.bendaharaPengeluaranId).change()
				$('#penggunaAnggaranId').val(response.penggunaAnggaranId).change()
				$(`[name="suratUndanganTgl"]`).val((response.suratUndanganTgl == null) ? moment().format('DD/MM/YYYY') : moment(dateIdtoEng(response.suratUndanganTgl), 'DD MMMM YYYY').format('DD/MM/YYYY'))
				$(`[name="suratPenunjukanTgl"]`).val((response.suratPenunjukanTgl == null) ? moment().format('DD/MM/YYYY') : moment(dateIdtoEng(response.suratPenunjukanTgl), 'DD MMMM YYYY').format('DD/MM/YYYY'))
				response.detail.map((v, i) => {
					addUraianPekerjaan(v)
				})
				calcTotalHarga()
				setKegiatan(response)
			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});
	}

	onDetail = (id) => {
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.show,
			data: {
				id: id
			},
			success: async (response) => {
				$('#id').val(id)
				$('#table_data, #form_data').fadeOut()
				$('#detail_data').fadeIn()

				let unset = [
					'paketPekerjaanId',
					'jenisPphId',
					'termynId',
					'sumberDanaId',
					'bankId',
					'penataUsahaKeuanganId',
					'pembuatKomitmenId',
					'pelaksanaTeknisId',
					'bendaharaPengeluaranId',
					'penggunaAnggaranId',
					'rekananId',
					'programId',
					'kegiatanId',
					'kegiatanSubId',
				]
				unset.map((v, i) => {
					delete response[v]
				})

				for (let key in response) {
					$("." + key).html(response[key])
				}

				if (response.ssk == null) {
					$("#kontrakSSkDownload").addClass('d-none')
				} else {
					$("#kontrakSSkDownload").removeClass('d-none')
					$(`#kontrakSSkDownload`).children('a').attr('href', APP_URL + `file/uploads-document-${response.ssk}`)
					$(`#kontrakSSkDownload`).children('a').attr('download', response.ssk)
				}
				if (response.ssuk == null) {
					$("#kontrakSSUkDownload").addClass('d-none')
				} else {
					$("#kontrakSSUkDownload").removeClass('d-none')
					$(`#kontrakSSUkDownload`).children('a').attr('href', APP_URL + `file/uploads-document-${response.ssuk}`)
					$(`#kontrakSSUkDownload`).children('a').attr('download', response.ssuk)
				}

				$(".namaPaket").html(response.name)
				$(".kodePaket").html(response.kode)

				let pembuatKomitmen = JSON.parse(response.pembuatKomitmenDetail)
				for (let key in pembuatKomitmen) {
					$("#" + key).html((pembuatKomitmen[key] == null || pembuatKomitmen[key] == '') ? '-' : pembuatKomitmen[key])
				}

				let rekanan = JSON.parse(response.rekananDetail)
				for (let key in rekanan) {
					$("." + key).html((rekanan[key] == null || rekanan[key] == '') ? '-' : rekanan[key])
				}

				let html = '';
				let total = 0
				response.detail.map((v, i) => {
					total += v.pekerjaan_uraian_qty * v.pekerjaan_uraian_harga;
					html += `
					<tr>
						<td align="center">${i+1}</td>
						<td>${v.pekerjaan_uraian_nama}</td>
						<td align="right">Rp ${HELPER.toRp(v.pekerjaan_uraian_pagu)}</td>
						<td align="center">${v.pekerjaan_uraian_qty} ${v.satuan_nama}</td>
						<td align="right">Rp ${HELPER.toRp(v.pekerjaan_uraian_harga)}</td>
						<td align="right">Rp ${HELPER.toRp(v.pekerjaan_uraian_qty * v.pekerjaan_uraian_harga)}</td>
					</tr>
					`;
				})
				html += `
					<tr class="fw-bold fs-6 text-gray-900">
						<td colspan="5" align="right">Total${(response.isIncludePpn == '1')? ` (Sudah Termasuk PPN Rp ${HELPER.toRp((100 / (100 + parseInt(response['ppn']))) * total * (response['ppn'] / 100))})`:''}</td>
						<td align="right">Rp ${HELPER.toRp(total)}</td>
					</tr>`;
				if (response.isIncludePpn != '1') {
					html += `
					<tr class="fw-bold fs-6 text-gray-900">
						<td colspan="5" align="right">PPN ${response['ppn']}%</td>
						<td align="right">Rp ${HELPER.toRp(total * response['ppn'] / 100)}</td>
					</tr>`;
					total += (total * response['ppn'] / 100);
				}

				html += `
					<tr class="fw-bolder fs-6 text-gray-900">
						<td colspan="5" align="right">Total + PPN</td>
						<td align="right">Rp ${HELPER.toRp(total)}</td>
					</tr>
				`;
				$('#nominalPembayaranLabel').html(HELPER.toRp(total))
				$('#nominalPembayaranTotal').val(total)
				$('#nominalPembayaran').attr('max', total)
				$('#nominalPembayaran').attr('step', total / 100)

				$('#detailUraianPekerjaan').html(html)

				await setDokumenLayout(response.jenisDokumen)
				await setDokumenData(response.dokumen)

			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});
	}

	setDokumenLayout = (data) => {
		$('#detailDokumen').html(``);
		$('#daftarTermynContainer').html(`<label for="" class="m-0 form-label">Daftar Termyn</label><br>`)
		data.map((vj, ij) => {
			html = '';
			DokumenMaster.map((v, i) => {
				if (v.dokumen_jenis_dokumen_id == vj.pekerjaan_jenis_dokumen_jenis_dokumen_id) {
					html += `
							<tr class="text-start fw-bold" valign="middle">
								<td>${1+i}</td>
								<td data-type="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" data-termynke="${ij}" class="docLabelName">${v.dokumen_nama.replaceAll('@termyn_ke',ij).toUpperCase()}</td>
								<td class="docType" data-type="${v.dokumen_tipe}">${v.dokumen_tipe.toUpperCase()}</td>
								<td data-type="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" data-termynke="${ij}" class="docCreatedDate">-</td>
								<td data-type="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" class="docNumber">-</td>
								<td>
									<form action="javascript:;" method="post" id="form_${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" name="form_${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" autocomplete="off" enctype="multipart/form-data">
										<input type="hidden" data-type="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" class="docId" name="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}Id">
										<input type="file" accept=".pdf" id="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" name="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" onchange="uploadDocuments('${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}')" class="d-none">
									</form>
									<button type="button" data-type="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" disabled class="generateBtn btn btn-sm btn-primary text-center fw-bolder ${(v.dokumen_tipe == 'pu')?'':'d-none'}" onclick="modalGenerate('${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}', '${btoa(JSON.stringify(v))}')"><i class="las la-plus"></i></button>
									<button type="button" data-type="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" disabled class="uploadBtn btn btn-sm btn-info text-center fw-bolder" onclick="$('#${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}').click()"><i class="las la-upload"></i></button>
									<a href="#" download="" data-type="${vj.pekerjaan_jenis_dokumen_id}_${v.dokumen_id}" class="d-none downloadBtn btn btn-sm btn-success text-center fw-bolder"><i class="las la-download"></i></a>
								</td>
							</tr>
						`;
				}
			})
			$('#detailDokumen').append(`
						<p class="bg-dark text-white px-10 py-5 fw-bold">${ij+1}. ${vj.jenis_dokumen_nama.toUpperCase()} ${(vj.pekerjaan_jenis_dokumen_pembayaran == null)?'':(vj.pekerjaan_jenis_dokumen_pembayaran/$('#nominalPembayaranTotal').val()*100) + '%'} (${moment(vj.pekerjaan_jenis_dokumen_created_at, 'YYYY-MM-DD HH:mm:ss').format('DD MMMM YYYY')})</p>
						<div class="px-10">
							<table class="table table-row-bordered mt-5 w-100">
								<thead>
									<tr class="fw-bolder fs-6 text-gray-900 text-start">
										<th>No</th>
										<th>Nama Dokumen</th>
										<th>Status</th>
										<th>Tanggal Dibuat</th>
										<th>Nomor Dokumen</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									${html}
								</tbody>
							</table>
						</div>
					`)
			$('#daftarTermynContainer').append(`<label class="form-label m-0 fs-7">${ij+1}. ${vj.jenis_dokumen_nama.toUpperCase()} ${(vj.pekerjaan_jenis_dokumen_pembayaran == null)?'':(vj.pekerjaan_jenis_dokumen_pembayaran/$('#nominalPembayaranTotal').val()*100) + '%'} (${moment(vj.pekerjaan_jenis_dokumen_created_at, 'YYYY-MM-DD HH:mm:ss').format('DD MMMM YYYY')})</label>`)
		})
	}

	setDokumenData = (data) => {
		if (data.length == 0) {
			if ($(`.generateBtn`).first().hasClass('d-none')) {
				$(`.uploadBtn`).first().removeAttr('disabled')
			} else {
				$(`.generateBtn`).first().removeAttr('disabled')
			}
		} else {
			data.map((v, i) => {
				$(`.generateBtn[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).removeAttr('disabled')
				$(`.uploadBtn[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).removeAttr('disabled')

				$(`.docCreatedDate[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).html(moment(v.pekerjaan_dokumen_created_at, 'YYYY-MM-DD HH:mm:ss').format('HH:mm DD MMMM YYYY'))
				$(`.docCreatedDate[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).removeAttr('data-all')
				$(`.docCreatedDate[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).attr('data-all', btoa(JSON.stringify(v)))

				$(`.docId[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).val(v.pekerjaan_dokumen_id)
				$(`.docNumber[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).html((v.pekerjaan_dokumen_no == null) ? '-' : v.pekerjaan_dokumen_no)
				if (v.pekerjaan_dokumen_file != null) {
					$(`.downloadBtn[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).removeClass('d-none')
					$(`.downloadBtn[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).attr('href', APP_URL + `file/uploads-document-${v.pekerjaan_dokumen_file}`)
					$(`.downloadBtn[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`).attr('download', v.pekerjaan_dokumen_file)
					let indexNow = parseInt($('.generateBtn').index($(`.generateBtn[data-type="${v.pekerjaan_dokumen_pekerjaan_jenis_dokumen_id}_${v.pekerjaan_dokumen_dokumen_id}"]`))) + 1
					if ($('.docType').eq(indexNow).attr('data-type') == 'pu') {
						$(`.generateBtn`).eq(indexNow).removeAttr('disabled')
					}
					if ($('.docType').eq(indexNow).attr('data-type') == 'rekanan') {
						$(`.uploadBtn`).eq(indexNow).removeAttr('disabled')
					}
				} else {
					if (v.dokumen_kode == 'DOC-002') {
						$(`.generateBtn`).eq(1).removeAttr('disabled')
					}
				}
			})
		}
	}

	onReset = () => {
		$.each(formReset, function(i, v) {
			$('#' + v).val('').change()
		});
		$('#uraianPekerjaanContainer').html('')
	}

	onSave = () => {
		HELPER.save({
			form: form,
			confirm: true,
			callback: (success, id, record, message) => {
				if (success === true) {
					HELPER.reloadPage({});
				}
			}
		});
	}

	onDestroy = (id = '') => {
		HELPER.confirmDelete({
			data: {
				id: $('[name="id"]').val()
			},
			callback: (response) => {
				if (response.success) {
					HELPER.reloadPage({});
				}
			},

		});
	}

	addUraianPekerjaan = (data = []) => {
		let id = (typeof data.pekerjaan_uraian_id == 'undefined') ? Date.now() : data.pekerjaan_uraian_id
		$('#uraianPekerjaanContainer').append(`
			<div class="row mb-3" id="row_${id}">
				<div class="col-3 align-self-center">
					<input required type="text" name="uraianPekerjaan[${id}][nama]" class="form-control form-control-sm form-control-solid" ${((typeof data.pekerjaan_uraian_nama == 'undefined')?'' :'value="'+data.pekerjaan_uraian_nama+'"')}placeholder="Nama Pekerjaan" />
				</div>
				<div class="col-2 align-self-center">
					<input required type="number" onchange="calcTotalHarga()" min="0" name="uraianPekerjaan[${id}][qty]" class="form-control form-control-sm form-control-solid" ${((typeof data.pekerjaan_uraian_qty == 'undefined')?'' :'value="'+data.pekerjaan_uraian_qty+'"')} placeholder="Qty" />
				</div>
				<div class="col-2 align-self-center">
					<select name="uraianPekerjaan[${id}][satuan]" id="satuan_${id}" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="false" placeholder="Satuan "></select>
				</div>
				<div class="col-2 align-self-center">
					<input required type="text" onchange="calcTotalHarga()" onkeyup="setRupiah(this)" min="0" name="uraianPekerjaan[${id}][harga]" class="form-control form-control-sm form-control-solid" ${((typeof data.pekerjaan_uraian_harga == 'undefined')?'' :'value="'+data.pekerjaan_uraian_harga+'"')} placeholder="Harga" />
				</div>
				<div class="col-2 align-self-center">
					<input required type="text" name="uraianPekerjaan[${id}][pagu]" onkeyup="setRupiah(this)" class="form-control form-control-sm form-control-solid" ${((typeof data.pekerjaan_uraian_pagu == 'undefined')?'' :'value="'+data.pekerjaan_uraian_pagu+'"')}placeholder="Pagu" />
				</div>
				<div class="col-1 align-self-center">
					<button type="button" onclick="$('#row_${id}').remove()" class="btn p-0 w-100 h-100"><i class="fas align-self-center fa-times"></i></button>
				</div>
			</div>
		`)

		HELPER.setChangeCombo({
			data: Satuan,
			el: `satuan_${id}`,
			valueField: 'satuan_id',
			displayField: 'satuan_nama',
			select2: true,
			withNull: false,
		});
		$(`[name="uraianPekerjaan[${id}][harga]"], [name="uraianPekerjaan[${id}][pagu]"]`).keyup()
		if (typeof data.pekerjaan_uraian_satuan_id != 'undefined') $(`#satuan_${id}`).val(data.pekerjaan_uraian_satuan_id).change();
	}
	$('#newTermynJenisTermyn').change(() => {
		if ($('#newTermynJenisTermyn').val() == 'vx259zxdx7g9t2jj') $('#persentasePembayaran').val(100).keyup()
		else $('#persentasePembayaran').val(null).keyup()
	})

	$('#rekananId').change(() => {
		$('#selectRekanan').removeClass('col-md-12');
		$('#selectRekanan').addClass('col-md-10');
		$('#addRekanan').show();

		Rekanan.map((v, i) => {
			if ($('#rekananId').val() == v.rekanan_id) {
				for (let key in v) {
					$(`[name="${key}"]`).val((v[key] == null) ? '-' : v[key])
				}
				return;
			}
		})
	})


	$('#addRekanan').click(function() {
		$('#rekananId').val('null').trigger('change');
		$('#addRekanan').hide();
		$('#selectRekanan').removeClass('col-md-10');
		$('#selectRekanan').addClass('col-md-12');
		$(`[name*="rekanan_"]`).val(null)
	})

	calcTotalHarga = () => {
		let total = 0;
		let id = '';
		$(`[id*="row_"]`).map((i, e) => {
			id = $(e).prop('id').split('_')[1]
			total += $(`[name="uraianPekerjaan[${id}][harga]"]`).val().replaceAll('.', '') * $(`[name="uraianPekerjaan[${id}][qty]"]`).val()
		})
		if ($('#isIncludePpn').prop('checked')) {
			total -= (100 / (100 + parseInt($('#ppnView').val()))) * total * ($('#ppnView').val() / 100)
		}

		$('#totalHargaAsli').val('Rp ' + HELPER.toRp(total))
		$('#totalHargaPPN').val('Rp ' + HELPER.toRp(total * $('#ppnView').val() / 100))

		if ($('#jenisPphId').val() != null) {
			$('#totalHargaPPH').val('Rp ' + HELPER.toRp(total * $('#jenisPphId').find(':selected').html().split(' - ')[1] / 100))
		}
		if ($('#jenisPphId').val() != null) {
			total += (total * $('#ppnView').val() / 100) + (total * $('#jenisPphId').find(':selected').html().split(' - ')[1] / 100);
			$('#totalHarga').val('Rp ' + HELPER.toRp(total))
		}
	}

	setRupiah = (e) => {
		$(e).val(HELPER.toRp($(e).val().replaceAll('.', '')))
	}

	setKegiatan = (data = []) => {
		data.programId = $('#programId').val()

		HELPER.ajax({
			url: HELPER.api.getData,
			data: {
				programId: data.programId
			},
			success: (response) => {
				HELPER.setChangeCombo({
					data: response.kegiatan,
					el: 'kegiatanId',
					valueField: 'kegiatan_id',
					displayField: 'kegiatan_nama',
					placeholder: 'Select kegiatan',
					select2: true,
				});
				if (typeof data.kegiatanId != 'undefined') {
					$('#kegiatanId').val(data.kegiatanId).change()
					setKegiatanSub(data)
				}
			}
		});
	}

	setKegiatanSub = (data = []) => {
		data.kegiatanId = $('#kegiatanId').val()

		HELPER.ajax({
			url: HELPER.api.getData,
			data: {
				kegiatanId: data.kegiatanId
			},
			success: (response) => {
				HELPER.setChangeCombo({
					data: response.kegiatanSub,
					el: 'kegiatanSubId',
					valueField: 'kegiatan_sub_id',
					displayField: 'kegiatan_sub_nama',
					placeholder: 'Select Sub Kegiatan',
					select2: true,
				});
				if (typeof data.kegiatanSubId != 'undefined') {
					$('#kegiatanSubId').val(data.kegiatanSubId).change()
				}
			}
		});
	}

	modalGenerate = (type, docData) => {
		$(`#modalDataTambahan`).modal('show')
		$(`#form_data_tambahan`).removeAttr('action')

		$(`#form_data_tambahan`).attr('action', `javascript:generateDocuments('${type}')`)
		let data = $(`.docCreatedDate[data-type="${type}"]`).attr('data-all')
		docData = JSON.parse(atob(docData))
		$(`#nomorDokumenLabel`).html('Nomor ' + $(`.docLabelName[data-type="${type}"]`).html().toLocaleLowerCase())
		$(`#tanggalDokumenLabel`).html('Tanggal ' + $(`.docLabelName[data-type="${type}"]`).html().toLocaleLowerCase())

		if (typeof data == 'undefined') {
			data = {};
		} else {
			data = JSON.parse(atob(data))
		}

		$('.spOnly').addClass('d-none')
		$('.spmkOnly').addClass('d-none')
		$(`[name="nomor"]`).val('')
		switch (docData.dokumen_kode) {
			case 'DOC-002':
				$('.spOnly').removeClass('d-none')
				break;
			case 'DOC-003':
				$('.spmkOnly').removeClass('d-none')

				$('#spmkDifDay').html('- Hari')
				if (data != []) {
					$('#tanggalSPMK').data('daterangepicker').setStartDate((data.pekerjaan_dokumen_tgl_mulai == null) ? moment().format('DD/MM/YYYY') : moment(dateIdtoEng(data.pekerjaan_dokumen_tgl_mulai), 'DD MMMM YYYY').format('DD/MM/YYYY'));
					$('#tanggalSPMK').data('daterangepicker').setEndDate((data.pekerjaan_dokumen_tgl_selesai == null) ? moment().format('DD/MM/YYYY') : moment(dateIdtoEng(data.pekerjaan_dokumen_tgl_selesai), 'DD MMMM YYYY').format('DD/MM/YYYY'));
					$('#spmkDifDay').html($('#tanggalSPMK').data('daterangepicker').endDate.diff($('#tanggalSPMK').data('daterangepicker').startDate, 'days') + ' Hari')
				}
				break;

			case 'DOC-007':
			case 'DOC-013':
			case 'DOC-020':
				$(`[name="nomor"]`).val(`                 /SPP-LS/			/${$('.tahunAnggaran').html()}`)
				break;
			default:
				break;
		}

		if (typeof data.pekerjaan_dokumen_no == 'undefined') {
			$(`[name="tanggal"]`).val(moment().format('DD/MM/YYYY'))
		} else {
			$(`[name="nomor"]`).val(data.pekerjaan_dokumen_no)
			$(`[name="tanggal"]`).val((data.pekerjaan_dokumen_tgl == null) ? moment().format('DD/MM/YYYY') : moment(dateIdtoEng(data.pekerjaan_dokumen_tgl), 'DD MMMM YYYY').format('DD/MM/YYYY'))
			calculatePembayaran(1, (data.pekerjaan_dokumen_pembayaran == null) ? 0 : data.pekerjaan_dokumen_pembayaran)
		}
	}

	dateIdtoEng = (date) => {
		let month = [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		];
		let bulan = [
			'Januari',
			'Febuari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		];
		bulan.map((v, i) => {
			date = date.replaceAll(v, month[i])
		})
		return date
	}

	generateDocuments = (type) => {
		$(`#modalDataTambahan`).modal('hide')
		var formData = new FormData($(`[name="form_data_tambahan"]`)[0]);
		formData.append('id', $('#id').val())
		formData.append('dataId', $(`.docId[data-type="${type}"]`).val())
		formData.append('type', type)
		formData.append('termyn_ke', $(`.docCreatedDate[data-type="${type}"]`).attr('data-termynke'))
		formData.append('diffSPMK', $('#tanggalSPMK').data('daterangepicker').endDate.diff($('#tanggalSPMK').data('daterangepicker').startDate, 'days'))

		HELPER.block()
		HELPER.save({
			data: formData,
			form: `form_data_tambahan`,
			processData: false,
			contentType: false,
			url: HELPER.api.generateDoc,
			success: async (response) => {
				await HELPER.showMessage({
					success: response.success,
					message: response.message,
					title: ((response.success) ? 'Success' : 'Failed')
				});
				await HELPER.unblock()
				if (response.success) {
					var link = document.createElement("a");
					link.download = response.data.pekerjaan_dokumen_file_name + '.pdf';
					link.href = APP_URL + `file/uploads-document-${response.data.pekerjaan_dokumen_file_name}.pdf`;
					document.body.appendChild(link);
					link.click();
					document.body.removeChild(link);
					delete link;
					setDokumenData([response.data])
				}
			}
		});
	}

	uploadDocuments = (type) => {
		var formData = new FormData($(`[name="form_${type}"]`)[0]);
		formData.append('type', type)
		formData.append('id', $('#id').val())
		HELPER.save({
			url: HELPER.api.uploadDoc,
			form: `form_${type}`,
			data: formData,
			contentType: false,
			processData: false,
			success: (response) => {
				HELPER.showMessage({
					success: response.success,
					message: response.message,
					title: ((response.success) ? 'Success' : 'Failed')
				});
				if (response.success) setDokumenData([response.data])
				HELPER.unblock()
			}
		});
	}

	calculatePembayaran = (type, nominal = null, persentase = null) => {
		if (nominal != null) $('#nominalPembayaran').val(nominal)
		if (persentase != null) $('#persentasePembayaran').val(persentase)
		if (type == 1) {
			$('#persentasePembayaran').val($('#nominalPembayaran').val() / $('#nominalPembayaranTotal').val() * 100)
		} else {
			$('#nominalPembayaran').val($('#nominalPembayaranTotal').val() * $('#persentasePembayaran').val() / 100)
		}
	}

	newTermyn = () => {
		$(`#addNewTermynModal`).modal('hide')

		HELPER.block()
		HELPER.ajax({
			url: HELPER.api.newTermyn,
			data: {
				id: $('#id').val(),
				jenisTermyn: $(`[name="newTermynJenisTermyn"]`).val(),
				pembayaran: $(`[name="nominalPembayaran"]`).val(),
			},
			success: async (response) => {
				await HELPER.showMessage({
					success: response.success,
					message: response.message,
					title: ((response.success) ? 'Success' : 'Failed')
				});
				await setDokumenLayout(response.jenisDokumen)
				await setDokumenData(response.dokumen)
				await HELPER.unblock(500);
			},
		});
	}
</script>