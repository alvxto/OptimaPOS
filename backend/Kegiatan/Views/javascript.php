<script type="text/javascript">
    var table = 'tableKegiatan';
    var form = 'formKegiatan';

    $(() => {
        HELPER.fields = ['id'];

        HELPER.api = {
            index: APP_URL + 'kegiatan',
            store: APP_URL + 'kegiatan/store',
            show: APP_URL + 'kegiatan/show',
            update: APP_URL + 'kegiatan/update',
            destroy: APP_URL + 'kegiatan/destroy',
            getData: APP_URL + 'kegiatan/getData',
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
        return new Promise((resolve) => {
            HELPER.ajax({
                url: HELPER.api.getData,
                success: (response) => {
                    HELPER.setDataMultipleCombo([{
                        data: response.program,
                        el: 'programId',
                        valueField: 'program_id',
                        displayField: 'program_nama',
                        displayField2: 'program_kode',
                        placeholder: 'Select Program',
                        grouped: true,
                        select2: true,
                    }]);
                    resolve(true)
                }
            });
        })
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
                        return full.kegiatan_kode;

                    }
                }, {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return full.kegiatan_nama;
                    }
                }, {
                    targets: -1,
                    render: function(data, type, full, meta) {
                        var status = 'active';
                        var bg = 'success';
                        if (full.kegiatan_aktif != 1) {
                            status = 'not active';
                            bg = 'danger';
                        }

                        return `<span class="badge px-2 badge-light-${bg}">${status}</span>`;
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
        $('#programId').val('null').trigger('change')
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
    //     onReset();
    //     initTable();
    //     HELPER.enableInput(`#${form}`);
    //     $('#programId').val('null').trigger('change')
    //     $(`.actCreate`).removeClass('d-none');
    //     $(`.actEdit`).addClass('d-none');
    //     $(`.actBack`).addClass('d-none');
    // }
</script>