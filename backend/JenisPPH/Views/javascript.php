<script type="text/javascript">
    var table = 'tableJenisPPH';
    var form = 'formJenisPPH';

    $(() => {
        HELPER.fields = ['id'];

        HELPER.api = {
            index: APP_URL + 'jenispph',
            store: APP_URL + 'jenispph/store',
            show: APP_URL + 'jenispph/show',
            update: APP_URL + 'jenispph/update',
            destroy: APP_URL + 'jenispph/destroy',
        };

        HELPER.handleValidation({
            el: form,
            declarative: true
        });

        index();
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
                        return full.jenis_pph_kode;

                    }
                }, {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return full.jenis_pph_nama;
                    }
                }, {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        return full.jenis_pph_presentase;
                    }
                }, {
                    targets: -1,
                    render: function(data, type, full, meta) {
                        return full.jenis_pph_keterangan;
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