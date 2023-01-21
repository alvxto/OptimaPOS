<script type="text/javascript">
	// var table = 'tableDokumen';
	var form = 'formDokumen';
	var Rekanan = []
	var User = []

	$(() => {
		HELPER.fields = ['id'];

		HELPER.api = {
			index: APP_URL + 'dokumen',
			store: APP_URL + 'dokumen/store',
			show: APP_URL + 'dokumen/show',
			update: APP_URL + 'dokumen/update',
			destroy: APP_URL + 'dokumen/destroy',
			getData: APP_URL + 'dokumen/getData',
			getCombo: APP_URL + 'dokumen/getCombo',
			filter: APP_URL + 'dokumen/getFilter',
		};

		// HELPER.handleValidation({
		// 	el: form,
		// 	declarative: true
		// });

		index();
	});

	index = async () => {
		await initData();
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

	initData = () => {
		return new Promise((resolve) => {
			HELPER.ajax({
				url: HELPER.api.getData,
				success: (response) => {
					generateDoc(response.document)
					resolve(true);
				}
			});
		})

	}
	generateDoc = (data) => {
		let doc = [];
		$.each(data, (i, v) => {
			if (v.pekerjaan_dokumen_file_name != null && v.pekerjaan_dokumen_file_name != '') {
				doc.push([`
				<div class="col-md-4 mb-5 document-head">
					<div class="card shadow-sm">
						<div class="card-body" style="height:58vh;">
							<div class="document-image">
								<img class="card-img-top mb-3" height="225px" width="100%" style="object-fit:cover ;" src="https://img2.pngdownload.id/20180319/eeq/kisspng-adobe-acrobat-portable-document-format-computer-ic-png-file-pdf-icon-5ab050ebc8a806.8725653815215044918219.jpg" alt="doc">
							</div>
							<div class="col-md-12">
								<div class="document-content row col-md-12 mt-3">
									<div class="col-md-3">
										<span class="badge badge-light-primary d-inline-flex align-items-center justify-content-start" style="height:30px;">sistem</span>
									</div>
									<div class="col-md-8">
										<p class="card-text" style="overflow:hidden;line-height: 1.3rem;max-height: 2.6rem;-webkit-box-orient: vertical;display: block;display: -webkit-box;overflow: hidden !important;text-overflow: ellipsis;-webkit-line-clamp: 2;" data-toggle="tooltip" data-placement="bottom" title="${v.dokumen_nama}">${v.dokumen_nama}</p>
									</div>
									<div class="col-md-1">
										<div class="dropdown col-md-12">
											<i class="fa fa-ellipsis-v" style="position:absolute;right:0px;cursor: pointer;" aria-hidden="true" id="dropdownMenuButton1" data-bs-toggle="dropdown"></i>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
												<li><a class="dropdown-item" href="javascript:;" onclick="onPreview('${v.pekerjaan_dokumen_id}','1')"><i class="fa fa-eye me-2"></i>Preview</a></li>
												<li><a class="dropdown-item" href="javascript:;" onclick="onDownload('${v.pekerjaan_dokumen_id}','1')"><i class="fa fa-download me-2"></i>Download</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-12">
										<p class="card-text m-0" style="overflow:hidden;line-height: 1.5rem;max-height: 3rem;-webkit-box-orient: vertical;display: block;display: -webkit-box;overflow: hidden !important;text-overflow: ellipsis;-webkit-line-clamp: 2;"><strong>${v.pekerjaan_name}</strong></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-12">
										<p class="card-text" style="overflow:hidden;line-height: 1.5rem;max-height: 3rem;-webkit-box-orient: vertical;display: block;display: -webkit-box;overflow: hidden !important;text-overflow: ellipsis;-webkit-line-clamp: 2;">${v.pekerjaan_dokumen_file}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	
				<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">${v.pekerjaan_dokumen_file}</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<embed id="docPreview" width="750px" height="750px"A src="<?= base_url() ?>"/>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
					`]);
			}
			if (v.pekerjaan_dokumen_file != null && v.pekerjaan_dokumen_file != '') {
				doc.push([`
				<div class="col-md-4 mb-5 document-head">
					<div class="card shadow-sm">
						<div class="card-body" style="height:58vh;">
							<div class="document-image">
								<img class="card-img-top mb-3" height="225px" width="100%" style="object-fit:cover ;" src="https://img2.pngdownload.id/20180319/eeq/kisspng-adobe-acrobat-portable-document-format-computer-ic-png-file-pdf-icon-5ab050ebc8a806.8725653815215044918219.jpg" alt="doc">
							</div>
							<div class="col-md-12">
								<div class="document-content row col-md-12 mt-3">
									<div class="col-md-3">
										<span class="badge badge-light-success d-inline-flex align-items-center justify-content-start" style="height:30px;">upload</span>
									</div>
									<div class="col-md-8">
										<p class="card-text" style="overflow:hidden;line-height: 1.3rem;max-height: 2.6rem;-webkit-box-orient: vertical;display: block;display: -webkit-box;overflow: hidden !important;text-overflow: ellipsis;-webkit-line-clamp: 2;" data-toggle="tooltip" data-placement="bottom" title="${v.dokumen_nama}">${v.dokumen_nama}</p>
									</div>
									<div class="col-md-1">
										<div class="dropdown col-md-12">
											<i class="fa fa-ellipsis-v" style="position:absolute;right:0px;cursor: pointer;" aria-hidden="true" id="dropdownMenuButton1" data-bs-toggle="dropdown"></i>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
												<li><a class="dropdown-item" href="javascript:;" onclick="onPreview('${v.pekerjaan_dokumen_id}','1')"><i class="fa fa-eye me-2"></i>Preview</a></li>
												<li><a class="dropdown-item" href="javascript:;" onclick="onDownload('${v.pekerjaan_dokumen_id}','1')"><i class="fa fa-download me-2"></i>Download</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-12">
										<p class="card-text m-0" style="overflow:hidden;line-height: 1.5rem;max-height: 3rem;-webkit-box-orient: vertical;display: block;display: -webkit-box;overflow: hidden !important;text-overflow: ellipsis;-webkit-line-clamp: 2;"><strong>${v.pekerjaan_name}</strong></p>
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-12">
										<p class="card-text" style="overflow:hidden;line-height: 1.5rem;max-height: 3rem;-webkit-box-orient: vertical;display: block;display: -webkit-box;overflow: hidden !important;text-overflow: ellipsis;-webkit-line-clamp: 2;">${v.pekerjaan_dokumen_file}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	
				<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">${v.pekerjaan_dokumen_file}</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<embed id="docPreview" width="750px" height="750px"A src="<?= base_url() ?>"/>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
					`]);
			}
		});
		$('#viewDocument').html(doc.join(''));
	}

	onPreview = (id, type) => {
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.show,
			data: {
				id,
				type,
			},
			success: (response) => {
				$('#docPreview').removeAttr('src');
				$('#docPreview').attr('src', `${response.doc}`);
			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});
		$('#previewModal').modal('show');
	}

	onSearch = () => {
		HELPER.block();
		var input, filter, cards, cardContainer, title, i;
		input = document.getElementById("SearchDoc");
		filter = input.value.toUpperCase();
		cardContainer = document.getElementById("viewDocument");
		cards = cardContainer.getElementsByClassName("document-head");
		for (i = 0; i < cards.length; i++) {
			title = cards[i].querySelector(".card-body");
			if (title.innerText.toUpperCase().indexOf(filter) > -1) {
				HELPER.unblock(500);
				cards[i].style.display = "";
			} else {
				HELPER.unblock(500);
				cards[i].style.display = "none";
			}
		}
	}

	onDownload = (id, type) => {
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.show,
			data: {
				id,
				type,
			},
			success: (response) => {
				var link = document.createElement("a");
				link.setAttribute('download', response.docName);
				link.href = response.doc;
				document.body.appendChild(link);
				link.click();
				link.remove();
				// (response.doc).save(response.pekerjaanDokumenFile);
			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});
	}

	onFilter = () => {
		idp = $('#navProgram').val();
		idk = $('#navKegiatan').val();
		idks = $('#navKegiatanSub').val();
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.filter,
			data: {
				idp: idp,
				idk: idk,
				idks: idks,
			},
			success: (response) => {
				generateDoc(response.document)
				HELPER.unblock(500);
			}
		});
	}



	onRefresh = () => {
		initData()
	}
</script>