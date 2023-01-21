<script type="text/javascript">
	var table = 'tableProfile';
	var form = 'formProfile';

	KTPasswordMeter.createInstances();
	var options = {
		minLength: 8,
		checkUppercase: true,
		checkLowercase: true,
		checkDigit: true,
		scoreHighlightClass: "active"
	};
	var passwordMeterElement = document.querySelector("#kt_password_meter_control");
	var passwordMeter = KTPasswordMeter.getInstance(passwordMeterElement);

	$(() => {
		HELPER.fields = ['user_id'];

		HELPER.api = {
			index: APP_URL + 'profile',
			show: APP_URL + 'profile/show',
			showChangeLog: APP_URL + 'profile/showChangeLog',
			changePassword: APP_URL + 'profile/changePassword',
			update: APP_URL + 'profile/update',
		};

		// HELPER.handleValidation({
		// 	el: form,
		// 	declarative: true
		// });

		HELPER.toggleForm({
			tohide: 'dataLogActivity',
			toshow: 'dataForm'
		});

		index();
	});

	index = async () => {
		await onEdit();
		await HELPER.unblock(100);
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

	onEdit = () => {
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.show,
			success: (response) => {
				console.log(response)
				HELPER.populateForm($(`[id="${form}"]`), response.detail);
				$('#photoPreview').removeAttr('style')
				$('#photoPreview').attr('style', `background-image: url(${response.profile})`)
				$('#profileDownload').removeAttr('href')
				$('#profileDownload').attr('href', response.profile)
				$('#profileDownload').removeAttr('download')
				$('#profileDownload').attr('download', (response.detail.user_photo == null) ? 'blank' : response.detail.user_photo)
				$('#previewUsername').html(response.detail.user_name)
				$('#previewJabatan').html(response.role_name)
			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});
	}

	onChangeLogActivity = () => {
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.showChangeLog,
			success: (response) => {
				HELPER.populateForm($(`[id="${form}"]`), response);
			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});
	}

	onSelectMenu = (type, el) => {
		$('.profileMenu').removeClass('btn-danger')
		$('.profileMenu').addClass('text-gray-900')
		$(el).removeClass('text-gray-900')
		$(el).addClass('btn-danger')
		if (type == "ubah profile") {
			$("#ubahProfile-tab").click();
			onEdit()
		} else if (type == "ubah password") {
			$("#ubahPassword-tab").click();
			onEdit()
		} else {
			$("#logActivity-tab").click();
			onChangeLogActivity()
		}
	}



	comparePass = () => {
		if ($('[name="newPass"]').val() != $('[name="renewPass"]').val()) {
			$('[name="renewPass"]').addClass('is-invalid');
		} else {
			$('[name="renewPass"]').removeClass('is-invalid');
		}
	}

	onChangePassword = () => {
		HELPER.block();
		try {
			if ($('[name="newPass"]').val() != $('[name="renewPass"]').val()) throw "Password isn't match!"
			if (passwordMeter.getScore() != 100) throw "New Password Not Enough Strong!"

			HELPER.ajax({
				url: HELPER.api.changePassword,
				data: {
					'newPass': $('[name="newPass"]').val(),
					'oldPass': $('[name="oldPass"]').val(),
				},
				success: async (response) => {
					await HELPER.showMessage({
						message: response.message,
						title: response.title,
						success: response.success,
					});
					if (response.success) {
						await $('#formPassword').trigger("reset");
					}
				},
				complete: (response) => {
					HELPER.unblock(500);
				}
			});
		} catch (error) {
			HELPER.showMessage({
				message: error,
				title: 'Failed',
				success: false,
				type: 'red',
				btnClass: 'btn-danger',
			});
			HELPER.unblock()
		}
	}
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