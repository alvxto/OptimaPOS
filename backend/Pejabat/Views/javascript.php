<script type="text/javascript">
    var table = 'tablePejabat';
    var form = 'formPejabat';

    $(() => {
        HELPER.fields = ['id'];

        HELPER.api = {
            index: APP_URL + 'pejabat',
            store: APP_URL + 'pejabat/store',
            show: APP_URL + 'pejabat/show',
            update: APP_URL + 'pejabat/update',
            destroy: APP_URL + 'pejabat/destroy',
            getData: APP_URL + 'pejabat/getData',
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
        $("#tglDpp,#tglDppa").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            minYear: 1901,
            maxYear: parseInt(moment().format("YYYY"), 10),
            locale: {
                format: "DD/MM/YYYY"
            }
        });
    }

    getData = () => {
        return new Promise((resolve, reject) => {
            HELPER.ajax({
                url: HELPER.api.getData,
                success: (response) => {
                    resolve(true);
                    HELPER.setDataMultipleCombo([{
                        data: response.jabatan,
                        el: 'positionId',
                        valueField: 'jabatan_id',
                        displayField: 'jabatan_name',
                        placeholder: 'Pilih Jabatan'
                    }, ]);
                    HELPER.setDataMultipleCombo([{
                        data: response.position,
                        el: 'bidangId',
                        valueField: 'position_id',
                        displayField: 'position_name',
                        placeholder: 'Pilih Bidang'
                    }, ]);
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
                        return `
						<small>${full.no}</small>
					`;
                    }
                }, {
                    targets: 1,
                    render: function(data, type, full, meta) {
                        return full.user_code;

                    }
                }, {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return full.user_name;
                    }
                }, {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        return full.jabatan_name;
                    }
                }, {
                    targets: -1,
                    render: function(data, type, full, meta) {
                        var status = 'active';
                        var bg = 'success';
                        if (full.user_active != 1) {
                            status = 'not active';
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
                $(`[name="tglDpp"]`).val((response.tglDpp == null) ? moment().format('DD/MM/YYYY') : moment(response.tglDpp, 'DD MMMM YYYY').format('DD/MM/YYYY'))
                $(`[name="tglDppa"]`).val((response.tglDppa == null) ? moment().format('DD/MM/YYYY') : moment(response.tglDppa, 'DD MMMM YYYY').format('DD/MM/YYYY'))
                $(`[name="nip"]`).val(response.code)
                $(`[name="nama"]`).val(response.name)
                $(`[name="Bidang"]`).val(response.bidangId)
                $(`[name="Jabatan"]`).val(response.positionId)
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
        HELPER.enableInput(`#${form}`);
        $(`.actCreate`).removeClass('d-none');
        $(`.actEdit`).addClass('d-none');
        $(`.actBack`).addClass('d-none');
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