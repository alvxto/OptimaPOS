<script type="text/javascript">
	var listLogs;
	var ck;
	var form = 'formChangelog';

	$(() => {

		HELPER.fields = ['changelog_id'];
		HELPER.api = {
			index: APP_URL + 'changelog',
			store: APP_URL + 'changelog/store',
			show: APP_URL + 'changelog/show',
			update: APP_URL + 'changelog/update',
			destroy: APP_URL + 'changelog/destroy',
			getData: APP_URL + 'changelog/getData',
		};

		HELPER.handleValidation({
			el: form,
			declarative: true
		});

		index();

		// CKEDITOR.BalloonEditor
		// 	.create(document.querySelector('#listLogs'), {
		// 		placeholder: 'make a log list here!'
		// 	})
		// 	.then(editor => {
		// 		listLogs = editor;
		// 	})
		// 	.catch(error => {});
		CKEDITOR.DecoupledEditor.create(document.getElementById("listLogs"), {
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
					'specialCharacters', 'horizontalLine', 'pageBreak', '|',
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
			placeholder: 'Input Daftar Perubahan',
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
	})

	index = async () => {
		// $('#titleContent').html(setTitleContent());
		await initData();
		await HELPER.unblock();
	}

	/*setTitleContent = () => {
		return `<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Changelog
			<span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
			<small class="text-muted fs-7 fw-bold my-1 ms-1">+4 release</small>
		</h1>`;
	}*/

	initData = () => {
		return new Promise((resolve) => {
			HELPER.ajax({
				url: HELPER.api.getData,
				success: (response) => {
					let logs = [];
					$.each(response.changelog, (i, v) => {
						logs.push([`
							<div class="timeline-item">
								<div class="timeline-line w-40px"></div>
								<div class="timeline-icon symbol symbol-circle symbol-40px me-4">
									<div class="symbol-label bg-light">
										${v.changelog_code}
									</div>
								</div>
								<div class="timeline-content mt-n1" style="overflow:unset">
									<div class="pe-3 mb-5">
										<div class="fs-5 fw-bold mb-2">E-Kontrak ${v.changelog_code} (${v.created_at})</div>
										<div class="d-flex align-items-center mt-1 fs-6">
											<div class="text-muted me-2 fs-7">Added at ${v.time_since} by</div>
											<div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="${v.user_name}">
												<div class="symbol-label fs-8 fw-bold bg-primary text-inverse-primary">${v.inisial_name}</div>
											</div>
										</div>
									</div>
									<div class="pb-5">
										<div class="d-flex flex-stack flex-wrap border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
											<div class="d-flex align-items-center">
												<p class="fs-6 fw-bold w-375px min-w-200px">${v.changelog_title}</p>
											</div>
											<div class="d-flex align-items-center py-2">
												<li class="nav-item dropdown d-flex">
								                    <a class="btn btn-sm btn-outline-primary btn-active-light-dark nav-link dropdown-toggle px-4 me-2" 
								                    	href="#" id="configAction" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
								                    	<i class="las la-ellipsis-v fs-1"></i> Action 
								                    </a>
								                    <ul class="dropdown-menu" aria-labelledby="configAction">
								                    	<li>
								                            <a class="dropdown-item" data-roleable="true" data-role="Changelog-Detail" href="javascript:;" onclick="onDetail('${v.changelog_id}')">Detail</a>
								                        </li>
								                        <li>
								                            <a class="dropdown-item" data-roleable="true" data-role="Changelog-Update" href="javascript:;" onclick="onEdit('${v.changelog_id}')">Edit</a>
								                        </li>
								                        <li>
								                            <a class="dropdown-item" data-roleable="true" data-role="Changelog-Destroy" href="javascript:;" onclick="onDestroy('${v.changelog_id}')">Delete</a>
								                        </li>
								                    </ul>
								                </li>
											</div>
										</div>
									</div>
								</div>
							</div>
						`]);
					});
					$('#viewListLogs').html(logs.join(''));
					resolve(true);
				}
			});
		})
	}

	onAdd = () => {
		HELPER.toggleForm({
			tohide: 'dataIndex',
			toshow: 'dataForm',
		});
	}

	save = () => {
		var formData = new FormData($(`[name="${form}"]`)[0]);
		formData.append('changelog_description', btoa(window.editor.getData()));
		HELPER.save({
			form: form,
			data: formData,
			contentType: false,
			processData: false,
			confirm: true,
			callback: (success, id, record, message) => {
				if (success) {
					HELPER.reloadPage({});
				}
			}
		});
	}


	onDetail = (id) => {
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.show,
			data: {
				id: id,
			},
			success: (response) => {
				// title 
				$('.childTitle').html('Detail Logs');
				HELPER.toggleForm({
					tohide: 'dataIndex',
					toshow: 'dataDetail'
				});
			},
			complete: (response) => {
				$.each(response, (i, v) => {
					$(`#detail_${i}`).html((i == 'changelog_description') ? atob(v) : v);
				});
				HELPER.unblock(500);
			}
		});
	}

	onEdit = (id) => {
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.show,
			data: {
				id: id,
			},
			success: (response) => {
				$('.childTitle').html('Form Update Logs');
				onAdd();
				HELPER.populateForm($(`[id="${form}"]`), response);
				if (response.changelog_description != null) {
					window.editor.setData(atob(response.changelog_description));
				}
			},
			complete: (response) => {
				HELPER.unblock(500);
			}
		});
	}

	onDestroy = (id) => {
		HELPER.confirmDelete({
			data: {
				id: id
			},
			callback: (response) => {
				if (response.success) {
					HELPER.reloadPage({});
				}
			},

		});
	}
</script>