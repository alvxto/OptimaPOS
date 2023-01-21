<script type="text/javascript">
	var table = 'tableRekanan';
	var form = 'formRekanan';

	$(() => {
		HELPER.fields = ['id'];

		HELPER.api = {
			index: APP_URL + 'rekanan',
			store: APP_URL + 'rekanan/store',
			show: APP_URL + 'rekanan/show',
			update: APP_URL + 'rekanan/update',
			destroy: APP_URL + 'rekanan/destroy',
			getData: APP_URL + 'rekanan/getData',
		};

		HELPER.handleValidation({
			el: form,
			declarative: true
		});

		index();
		$("#tglAkte").daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			autoApply: true,
			minYear: 1901,
			maxYear: parseInt(moment().format("YYYY"), 10),
			locale: {
				format: "DD/MM/YYYY"
			}
		});
	});

	index = async () => {
		await initTable();
		await HELPER.unblock(100);
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
						HELPER.disableInput(`#${form}`);
						$(`.actCreate`).addClass('d-none');
						$(`.actEdit`).removeClass('d-none');
						onEdit(payload.rowData.id);
					}
				},
				columnDefs: [{
					targets: 0,
					render: function(data, type, full, meta) {
						return full.no;
					}
				}],
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
		$('#table_data').fadeOut()
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
				id: id
			},
			success: (response) => {
				onAdd()
				HELPER.populateForm($(`[id="${form}"]`), response);
				$(`[name="tglAkte"]`).val((response.tglAkte == null) ? moment().format('DD/MM/YYYY') : moment(response.tglAkte, 'YYYY-MM-DD').format('DD/MM/YYYY'))
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
	}

	onReset = () => {
		HELPER.resetForm(`#${form}`);
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
</script>