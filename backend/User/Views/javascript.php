<script type="text/javascript">
	var table = 'tableUser';
	var form = 'formUser';

	$(() => {
		HELPER.fields = ['id'];

		HELPER.api = {
			index: APP_URL + 'user',
			store: APP_URL + 'user/store',
			show: APP_URL + 'user/show',
			update: APP_URL + 'user/update',
			destroy: APP_URL + 'user/destroy',
			getData: APP_URL + 'user/getData',
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
	}

	getData = () => {
		return new Promise((resolve, reject) => {
			HELPER.ajax({
				url: HELPER.api.getData,
				success: (response) => {
					resolve(true);
					HELPER.setDataMultipleCombo([{
							data: response.role,
							el: 'roleId',
							valueField: 'role_id',
							displayField: 'role_name',
							placeholder: 'Pilih Role'
						},
						{
							data: response.position,
							el: 'bidangId',
							valueField: 'position_id',
							displayField: 'position_name',
							placeholder: 'Pilih Bidang'
						}
					]);
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
						onEdit(payload.rowData.id);
					} else {
						onReset();
					}
				},
				columnDefs: [{
					orderable: false,
					targets: [0, -1]
				}, {
					targets: 0,
					render: function(data, type, full, meta) {
						return full.no;
					}
				}, {
					targets: 1,
					render: function(data, type, full, meta) {
						return `
								<div class="d-flex align-items-center">
									<div class="symbol symbol-45px me-5">
										<img src="${full.profile}" alt="" style="object-fit:cover;"/>
									</div>
									<div class="d-flex justify-content-start flex-column">
										<span class="text-dark fw-bolder text-hover-primary fs-6">${full.user_name}</span>
										<span class="text-muted text-muted d-block fs-7">${full.user_email}</span>
									</div>
								</div>
							`;

					}
				},{
					targets: 2,
					render: function(data, type, full, meta) {
						return full.role_name;
					}
				}, {
					targets: -1,
					render: function(data, type, full, meta) {
						var status = 'aktif';
						var bg = 'success';
						if (full.user_active != 1) {
							status = 'tidak aktif';
							bg = 'danger';
						}

						return `<span class="badge px-2 badge-light-${bg}">${status}</span>`;

					}
				}, ],

				fnCreatedRow: function(nRow, aData, iDataIndex) {
					$(nRow).attr('id', aData[0]);
				},
				fnInitComplete: function(oSettings, data) {
					resolve(true)
				}
			});
		});
	}

	onEdit = (id) => {
		HELPER.disableInput(`#${form}`);
		$(`.actCreate`).addClass('d-none');
		$(`.actEdit`).removeClass('d-none');
		$(`.actBack`).removeClass('d-none');

		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.show,
			data: {
				id: id
			},
			success: (response) => {
				HELPER.populateForm($(`[id="${form}"]`), response);
				$('#photoPreview').removeAttr('style')
				$('#photoPreview').attr('style', `background-image: url(${response.profile})`)
				$('#profileDownload').removeAttr('href')
				$('#profileDownload').attr('href', response.profile)
				$('#profileDownload').removeAttr('download')
				$('#profileDownload').attr('download', (response.photo == null) ? 'blank' : response.photo)
				$(`.editProfile`).addClass('d-none');
			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});
	}

	onDisplayEdit = () => {
		HELPER.enableInput(`#${form}`);
		$(`.actEdit`).addClass('d-none');
		$(`.actCreate`).removeClass('d-none');
		$(`.editProfile`).removeClass('d-none');
	}

	onReset = () => {
		HELPER.resetForm(`#${form}`);
		HELPER.enableInput(`#${form}`);
		$(`.actCreate`).removeClass('d-none');
		$(`.actEdit`).addClass('d-none');
		$(`.actBack`).addClass('d-none');
		$('#photoPreview').removeAttr('style')
		$('#photoPreview').attr('style', `background-image: url(${APP_URL}/file/uploads-user-blank)`)
	}

	onSave = () => {
		var formData = new FormData($(`[name="${form}"]`)[0]);
		HELPER.save({
			form: form,
			data: formData,
			contentType: false,
			processData: false,
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

	// onBack = () => {
	// 	onReset();
	// 	initTable();
	// 	HELPER.enableInput(`#${form}`);
	// 	$('#bidangId').val('null').trigger('change')
	//     $('#roleId').val('null').trigger('change')
	// 	$(`.actCreate`).removeClass('d-none');
	// 	$(`.actEdit`).addClass('d-none');
	// 	$(`.actBack`).addClass('d-none');
	// }

	KTImageInput.createInstances();
	var imageInputElement = document.querySelector("#kt_image_input_profile");
	var imageInput = KTImageInput.getInstance(imageInputElement);
	imageInput.on("kt.imageinput.change", function() {
		$('#isremoved').removeAttr('value')
	});

	imageInput.on("kt.imageinput.remove", function() {
		$('#profileDownload').removeAttr('href')
		$('#profileDownload').attr('href', '#')
		$('#profileDownload').removeAttr('download')
		$('#isremoved').val(1)
	});
	imageInput.on("kt.imageinput.cancel", function() {
		$('#profileDownload').removeAttr('href')
		$('#profileDownload').attr('href', '#')
		$('#profileDownload').removeAttr('download')
		$('#isremoved').val(1)
	});
</script>