<script type="text/javascript">
    var table = 'tableBarang';
    var form = 'formBarang';

    $(() => {
        HELPER.fields = ['id'];

        HELPER.api = {
            index: APP_URL + 'barang',
            store: APP_URL + 'barang/store',
            show: APP_URL + 'barang/show',
            update: APP_URL + 'barang/update',
            destroy: APP_URL + 'barang/destroy',
            getData: APP_URL + 'barang/getData',
        };

        // HELPER.handleValidation({
        //     el: form,
        //     declarative: true
        // });

        index();
    });

    index = async () => {
        // await initTable();
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
                        data: response.kategori,
                        el: 'kategoriId',
                        valueField: 'kategori_id',
                        displayField: 'kategori_nama',
                        placeholder: 'Pilih Kategori'
                    }, ]);
                    HELPER.setDataMultipleCombo([{
                        data: response.satuan,
                        el: 'satuanId',
                        valueField: 'satuan_id',
                        displayField: 'satuan_nama',
                        placeholder: 'Pilih Satuan'
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
                            return full.barang_kode;

                        }
                    }, {
                        targets: 2,
                        render: function(data, type, full, meta) {
                            return full.barang_nama;
                        }
                    }, {
                        targets: 3,
                        render: function(data, type, full, meta) {
                            return full.barang_stok;
                        }
                    }, {
                        targets: 4,
                        render: function(data, type, full, meta) {
                            return full.barang_harga;
                        }
                    }, {
                        targets: -1,
                        render: function(data, type, full, meta) {
                            var status = 'active';
                            var bg = 'success';
                            if (full.barang_aktif != 1) {
                                status = 'not active';
                                bg = 'danger';
                            }

                            return `<span class="badge px-2 badge-light-${bg}">${status}</span>`;
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