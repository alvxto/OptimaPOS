<script type="text/javascript">
	$(() => {
		HELPER.fields = ['id'];
		HELPER.api = {
			getConfig: APP_URL + 'config/getConfig',
			save: APP_URL + 'config/save',
			uploadFile: APP_URL + 'config/uploadFile',
			deleteFile: APP_URL + 'config/deleteFile',
		};
		index();
	});

	index = async () => {
		await showConfig('app', true);
		await HELPER.unblock(500);
	}

	/**
	 * create input
	 * @param string
	 * */
	showConfig = (group = '', init = false) => {
		var group = (init) ? group : $(group).data('group');

		$(`.tabConfig`).removeClass('active');
		$(`[data-group="${group}"]`).addClass('active');
		$(`#configTitle`).html($(`[data-group="${group}"]`).html());

		return new Promise((resolve) => {
			HELPER.block();
			HELPER.ajax({
				url: HELPER.api.getConfig,
				data: {
					group: group
				},
				success: (response) => {
					resolve(true)
					var html = [];
					$.each(response.config, (i, v) => {
						html.push(createTemplates(v));
					});
					$('#contentConfig').html('').html(html.join(''));
				},
				complete: (response) => {
					$.each(response.config, (i, v) => {
						if (v.config_type == 'file') {
							uploadFileOnChange(v.config_id);
							// set logo
							if (v.config_code == 'app.logo') {
								$('#logoApp').attr('src', APP_URL + 'config/getImage/' + v.config_value);
							}
						}
						$(`[id="${v.config_code}"]`).text(v.config_value);
					});

					$('#dataConfiguration').removeClass('d-none');
					HELPER.unblock(500);
				}
			})
		});
	}

	save = () => {
		var formData = new FormData($(`[name="form_config"]`)[0]);
		HELPER.save({
			form: 'form_config',
			data: formData,
			url: HELPER.api.save,
			contentType: false,
			processData: false,
			confirm: true,
			callback: (success, id, record, message) => {

			}
		});
	}

	createTemplates = (value) => {

		switch (value.config_type) {
			case 'text':
				return createTypeText(value);
				break;
			case 'file':
				return createTypeFile(value);
				break;
			case 'textarea':
				return createTypeTextarea(value);
				break;
			case 'password':
				return createTypePassword(value);
				break;
			default:
				return '';
				break;
		}
	}

	/**
	 * create template type input
	 * @param array|object
	 * */
	createTypeText = (value) => {
		return `
			<div class="row mb-6">
				<label class="col-lg-3 col-form-label fw-bold fs-6">${value.config_title}</label>
				<div class="col-lg-9 fv-row">
					<input type="text" name="${value.config_id}" class="form-control form-control-sm" placeholder="${HELPER.nullConverter(value.config_info, '')}" value="${HELPER.nullConverter(value.config_value, '')}" />
				</div>
			</div>
		`;
	}

	/**
	 * create template type input
	 * @param array|object
	 * */
	createTypePassword = (value) => {
		return `
			<div class="row mb-6">
				<label class="col-lg-3 col-form-label fw-bold fs-6">${value.config_title}</label>
				<div class="col-lg-9 fv-row">
					<input type="password" name="${value.config_id}" class="form-control form-control-sm" placeholder="${HELPER.nullConverter(value.config_info, '')}" value="${HELPER.nullConverter(value.config_value, '')}" />
				</div>
			</div>
		`;
	}

	/**
	 * create template input type file
	 * @params array|object
	 * @params boolean
	 * */
	createTypeFile = (value, isImage = true) => {
		if (isImage) {
			let img = APP_URL + 'config/getImage/' + value.config_value;
			let html = `
				<div class="row mb-6">
					<label class="col-lg-3 col-form-label fw-bold fs-6">${value.config_title}</label>
					<div class="col-lg-9">

						<div class="image-input image-input-circle dataFile${value.config_id}" id="${value.config_id}" data-kt-image-input="true" style="background-image: url(${img})">
						<div class="image-input-wrapper w-125px h-125px dataFile${value.config_id}" style="background-image: url(${img})"></div>

						<label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
							data-kt-image-input-action="change"
							data-bs-toggle="tooltip"
							data-bs-dismiss="click"
							title="Change File">
								<i class="bi bi-pencil-fill fs-7"></i>

								<input type="file" name="${value.config_id}" accept=".png, .jpg, .jpeg" />
								<input type="hidden" name="hide_${value.config_id}" />
						</label>	

						<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow d-none"
							data-action-remove="${value.config_id}"
							data-kt-image-input-action="remove"
							data-bs-toggle="tooltip"
							data-bs-dismiss="click"
							title="Remove File">
								<i class="bi bi-x fs-2 text-danger"></i>
						</span>
					</div>	
				</div>
			`;
			return html;
		}

	}

	uploadFileOnChange = (id) => {
		window['var_' + id] = new KTImageInput(document.querySelector(`#${id}`));
		window['var_' + id].on('kt.imageinput.change', function(imageInput) {
			var fd = new FormData();
			var files = $(`[name="${id}"]`)[0].files[0];

			fd.append('logo', files);
			fd.append('id', id);

			HELPER.block();
			HELPER.ajax({
				url: HELPER.api.uploadFile,
				data: fd,
				type: "POST",
				contentType: false,
				processData: false,
				success: function(response) {

					if (response.success) {
						$(`[data-action-remove="${id}"]`).removeClass('d-none').css('display', 'block');
					} else {
						HELPER.showMessage({
							success: false,
							title: 'Gagal',
							message: response.message
						})
						$(`[data-action-remove="${id}"]`).addClass('d-none').css('display', 'none');
					}

				},
				complete: function(response) {
					HELPER.unblock();
				}
			});
		});
		window['var_' + id].on('kt.imageinput.remove', function(imageInput) {
			let idLogo = $(imageInput.element).attr('id');
			HELPER.confirm({
				message: 'Are you sure you want to delete the data?',
				callback: (result) => {
					if (result) {
						HELPER.ajax({
							url: HELPER.api.deleteFile,
							data: {
								id: idLogo,
							},
							success: (response) => {
								$(`.dataFile${idLogo}`).css({
									'background-image': 'url(' + APP_URL + 'config/getImage/' + idLogo + ')'
								});
							}
						});
					}
				}
			});
		});
	}

	/**
	 * create template textarea
	 * @param array|object
	 * @param boolean
	 * */
	createTypeTextarea = (value, withysiwyg = false) => {
		if (!withysiwyg) {
			return `
				<div class="row mb-6">
					<label class="col-lg-3 col-form-label fw-bold fs-6">${value.config_title}</label>
					<div class="col-lg-9 fv-row">
						<textarea class="form-control form-control-sm" name="${value.config_id}" data-kt-autosize="true">${HELPER.nullConverter(value.config_value, '')}</textarea>
					</div>
				</div>
			`;
		}
	}
</script>