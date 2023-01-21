<script type="text/javascript">
    var table = 'tableDokumenMaster';
    var form = 'formDokumenMaster';
    var editor2 = '';

    $(() => {
        HELPER.fields = ['id'];

        HELPER.api = {
            index: APP_URL + 'dokumenMaster',
            store: APP_URL + 'dokumenMaster/store',
            show: APP_URL + 'dokumenMaster/show',
            getData: APP_URL + 'dokumenMaster/getData',
            update: APP_URL + 'dokumenMaster/update',
            destroy: APP_URL + 'dokumenMaster/destroy',
        };

        HELPER.handleValidation({
            el: form,
            declarative: true
        });

        CKEDITOR.DecoupledEditor.create(document.getElementById("editor"), {
            toolbar: {
                items: [
                    'exportPDF', 'exportWord', '|',
                    'findAndReplace', 'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'insertImage', 'blockQuote', 'insertTable', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|','sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            },
            placeholder: 'Welcome to CKEditor 5!',
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            htmlSupport: {
                allow: [{
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }]
            },
            htmlEmbed: {
                showPreviews: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            mention: {
                feeds: [{
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }]
            },
            removePlugins: [
                // 'ExportPdf',
                // 'ExportWord',
                'CKBox',
                'CKFinder',
                'EasyImage',
                // 'Base64UploadAdapter',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                'MathType'
            ]
        }).then(editor => {
            const toolbarContainer = document.querySelector('#toolbarEditor');
            toolbarContainer.appendChild(editor.ui.view.toolbar.element);
            // editor.enableReadOnlyMode( '#editor' );

            window.editor = editor;
        })

        var legendList = [{}]

        index();
    });

    index = async () => {
        await initTable();
        // await getData();
        HELPER.setChangeCombo({
            data: [{
                    val: 'pu'
                },
                {
                    val: 'rekanan'
                }
            ],
            el: `tipe`,
            valueField: 'val',
            displayField: 'val',
            select2: true,
            withNull: false,

        });
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
                    } else {
                        onReset();
                        HELPER.enableInput(`#${form}`);
                        $(`.actCreate`).removeClass('d-none');
                        $(`.actEdit`).addClass('d-none');
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
									<div class="d-flex justify-content-start flex-column">
										<span class="text-dark text-hover-primary fs-6">${full.dokumen_kode}</span>
									</div>
								</div>
							`;

                    }
                }, {
                    targets: 2,
                    render: function(data, type, full, meta) {
                        return full.dokumen_nama;
                    }
                }, {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        return full.dokumen_tipe;
                    }
                }, {
                    targets: -1,
                    render: function(data, type, full, meta) {
                        var status = 'active';
                        var bg = 'success';
                        if (full.dokumen_aktif != 1) {
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

    getData = () => {
        return new Promise((resolve, reject) => {
            HELPER.ajax({
                url: HELPER.api.getData,
                success: (response) => {
                    resolve(true);
                    HELPER.setChangeCombo({
                        data: response.jenisDokumen,
                        el: 'jenisDokumenId',
                        valueField: 'jenis_dokumen_id',
                        displayField: 'jenis_dokumen_nama',
                        placeholder: 'Pilih Jenis Dokumen',
                        select2: true,
                    });
                }
            });
        });
    }

    setLegend = (data) => {
        data.map((v, i) => {
            $('#legendContainer').append(`
                <div class="accordion-item">
                    <h6 class="accordion-header" id="kt_accordion_1_header_${i}">
                        <button class="accordion-button collapsed fs-7 p-3 fw-semibold" aria-expanded="false" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_${i}" aria-controls="kt_accordion_1_body_${i}">
                            ${v.name}
                        </button>
                    </h6>
                    <div id="kt_accordion_1_body_${i}" class="accordion-collapse collapse collapsed" aria-labelledby="kt_accordion_1_header_${i}" data-bs-parent="#kt_accordion_1">
                        <div class="accordion-body p-3 fs-7">
                            <p>\$\{${v.data.join('}</p><p>${')}}</p>
                        </div>
                    </div>
                </div>
            `)
        })
    }

    toggleForm = () => {
        $('#' + form).fadeToggle()
        $('#tableDokumenMasterContainer').fadeToggle()
    }

    onEdit = (id) => {
        toggleForm()
        HELPER.block();
        HELPER.ajax({
            url: HELPER.api.show,
            data: {
                id: id
            },
            success: (response) => {
                HELPER.populateForm($(`[id="${form}"]`), response);
                $('#editor').attr('contenteditable','false');
                if (response.template != null) {
                    window.editor.setData(response.template)
                }
                setLegend(response.legend)
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
        $('#editor').attr('contenteditable','true');
        $('#ckeditor').removeAttr('style');
    }

    onReset = () => {
        HELPER.resetForm(`#${form}`);
        $('#tipe').val('null').trigger('change')
    }

    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);
        formData.append('template', window.editor.getData())
        HELPER.save({
            form: form,
            data: formData,
            issanitize: false,
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

    $('#tipe').change(() => {
        if ($('#tipe').val() == 'pu') {
            $('#docTemplateContainer').removeClass('d-none')
        } else {
            $('#docTemplateContainer').addClass('d-none')
        }
    })
</script>