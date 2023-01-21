<script type="text/javascript">
    var table = 'tableBidangProgram';
    var form = 'formBidangProgram';

    $(() => {
        HELPER.fields = ['id'];

        HELPER.api = {
            index: APP_URL + 'bidangProgram',
            store: APP_URL + 'bidangProgram/store',
            show: APP_URL + 'bidangProgram/show',
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
                        $(`#btnSave`).removeClass('d-none');
                    } else {
                        $('#programContainer').html('')
                        $(`#btnSave`).addClass('d-none');
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
                        return full.position_code;

                    }
                }, {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return full.position_name;
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
        $.jstree.destroy();
        initTree(id);
        $("#btnSave").addClass('d-none');
    }

    initTree = (id) => {
        HELPER.block();
        HELPER.ajax({
            url: HELPER.api.show,
            data: {
                id: id
            },
            success: (response) => {
                $('[name="bidang_id"]').val(id)

                $('#programContainer').jstree({
                    'plugins': ["checkbox", "types", 'wholerow', "massload", "search"],
                    'core': {
                        'data': response['menu'],
                    },
                    "types": {
                        "default": {
                            "icon": "fa fa-folder text-success"
                        },
                        "file": {
                            "icon": "fa fa-file text-success"
                        }
                    },
                    "search": {
                        "case_sensitive": false,
                        "show_only_matches": true,
                        "delay": 100,
                    },
                });

                $('#programContainer').on("changed.jstree", function(e, data) {
                    if (typeof data.node != 'undefined') {
                        if (data.selected.length == 0) {
                            $("#btnSave").addClass('d-none');
                        } else {
                            $("#btnSave").removeClass('d-none');
                        }
                        unique = [];
                        let itemList = data.selected;
                        //adding all parent
                        $.each(itemList, function(i, el) {
                            if (data.instance.is_leaf(el)) {
                                $.each(data.instance.get_node(el).parents, function(i2, el2) {
                                    if ($.inArray(el2, itemList) == -1 && el2 != '#') itemList.push(el2);
                                });
                            }
                        });
                        unique = itemList;
                    }
                });
            },
            complete: (response) => {
                $('#search').keyup(function(event) {
                    let tree = $("#programContainer").jstree(true);
                    tree.search(this.value);
                });
                HELPER.unblock(200);
            }
        })
    }

    onSave = () => {
        HELPER.confirm({
            message: "Apakah anda yakin menyimpan data ini?",
            callback: (result) => {
                if (result) {
                    HELPER.block();
                    HELPER.ajax({
                        url: HELPER.api.store,
                        data: {
                            'bidang_id': $("[name=bidang_id]").val(),
                            'roles': ((unique))
                        },
                        type: 'POST',
                        success: (response) => {
                            HELPER.showMessage({
                                success: response['success'],
                                title: 'Information',
                                message: response['message']
                            })
                        },
                        complete: (response) => {
                            HELPER.unblock(200);
                        }
                    })
                }
            }
        });
    }
</script>