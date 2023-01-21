<script type="text/javascript">
	$(() => {

		HELPER.fields = ['id'];

		HELPER.api = {
			getRoleList: APP_URL + 'hak-access/getRoleList',
			getMenuList: APP_URL + 'hak-access/getMenuList',
			save: APP_URL + 'hak-access/save',
			destroy: APP_URL + 'hak-access/destroyRole',
			editRole: APP_URL + 'hak-access/editRole',
			saveRole: APP_URL + 'hak-access/saveRole',
		};

		index();
	});

	index = async () => {
		await getRoleList();
		await HELPER.unblock(200);
	}

	setTitleContent = () => {

	}

	getRoleList = () => {
		return new Promise((resolve) => {
			HELPER.ajax({
				url: HELPER.api.getRoleList,
				success: function(response) {
					let tbody = $("#role_container tbody");
					let html = [];
					if (response.success && response.total > 0) {
						$.each(response.data, (i, v) => {
							html.push([`
								<tr>
									<td class="text-center text-nowrap">${i+1}</td>
									<td title="Click to edit" data-role_id="${v.role_id}" onclick="editRow(this)" style="white-space:nowrap;cursor:pointer">${v.role_name}</td>
									<td style="white-space:nowrap; width: 40px;">
										<a href="javascript:;" data-role_id="${v.role_id}" onclick="deleteHA(this)" data-roleable="true" data-role="HakAccess-Destroy" class="btn btn-sm btn-clean btn-icon" title="Delete"> <i class="far fa-trash-alt fa-lg text-danger"></i></a>
										<a href="javascript:;" data-role_id="${v.role_id}" onclick="loadHakAkses(this)" data-roleable="true" data-role="HakAccess-Detail" class="btn btn-sm btn-clean btn-icon" title="Detail"> <i class="fa fa-arrow-right text-success"></i></a>
									</td>
								</tr>
							`]);
						})
					}
					tbody.html(html.join(''));
					resolve(true);
				}
			})
		})
	}

	initTree = (roleId) => {
		HELPER.block();
		HELPER.ajax({
			url: HELPER.api.getMenuList,
			data: {
				roleId: roleId
			},
			success: (response) => {
				$('#dataTree').jstree({
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

				$('#dataTree').on("changed.jstree", function(e, data) {
					if (typeof data.node != 'undefined') {
						if (data.selected.length == 0) {
							$("#btnSaveHA").addClass('d-none');
						} else {
							$("#btnSaveHA").removeClass('d-none');
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
					let tree = $("#dataTree").jstree(true);
					tree.search(this.value);
				});
				HELPER.unblock(200);
			}
		})
	}

	loadHakAkses = (el) => {
		let roleId = $(el).data('role_id');
		$.jstree.destroy();

		initTree(roleId);

		$("[name=role_id]").val(roleId)
		$("#btnSaveHA").addClass('d-none');
	}

	saveHA = (argument) => {
		HELPER.confirm({
			message: "Are you sure you want to save it?",
			callback: (result) => {
				if (result) {
					HELPER.block();
					HELPER.ajax({
						url: HELPER.api.save,
						data: {
							'role_id': $("[name=role_id]").val(),
							'roles': ((unique))
						},
						type: 'POST',
						success: (response) => {
							if (response['success']) {
								HELPER.showMessage({
									success: true,
									title: 'Information',
									message: 'Successfully saved data.'
								})
								if (response['reload']) {
									window.location.reload();
								}
							}
						},
						complete: (response) => {
							HELPER.unblock(200);
						}
					})
				}
			}
		});
	}

	deleteHA = (el) => {
		let role_id = $(el).data('role_id');
		HELPER.confirmDelete({
			url: HELPER.api.destroy,
			data: {
				role_id: role_id
			},
			callback: function(response) {
				if (response.success == true) {
					getRoleList();
					$.jstree.destroy();
					$("#btnSaveHA").addClass('d-none');
				}
			},
		});
	}

	addRow = (argument) => {
		if ($('[name=markerAdd]').val() == 0) {
			$('[name=markerAdd]').val(1);

			let html = `
				<tr>
					<td></td>
					<td>
						<input class="input-sm" type="text" name="input_group" value="" placeholder="">
					</td>
					<td>
						<a href="javascript:;" onclick="removeRow(this)" class="btn btn-sm btn-clean btn-icon" title="Delete"> 
							<i class="fa fa-trash"></i>
						</a>
						<a href="javascript:;" onclick="saveRow(this)" class="btn btn-sm btn-clean btn-icon" title="Delete">
							<i class="fa fa-check"></i>
						</a>
					</td>
				</tr>
			`;

			$('#role_container tbody').append(html);

			$('[name="input_group"]').on('keypress', function(e) {
				if (e.which == 13) {
					saveRow($(this).val(), true);
				}
			});
		}
	}

	removeRow = (el) => {
		$(el).parent().parent().remove();
		$('[name=markerAdd]').val(0);
	}

	saveRow = (el, isEnter = false) => {
		let text = (isEnter) ? el : $(el).parent().prev().children().val();
		if (text != '') {
			HELPER.block();
			HELPER.ajax({
				url: HELPER.api.saveRole,
				data: {
					role_name: text
				},
				success: (response) => {
					getRoleList();
					$('[name=markerAdd]').val(0);
				},
				complete: (response) => {
					HELPER.unblock(200);
				}
			})
		}
	}

	editRow = (el) => {
		let name = prompt('enter new permission name... ', $(el).html())
		if (name !== null) {
			HELPER.block();
			HELPER.ajax({
				url: HELPER.api.editRole,
				data: {
					role_name: name,
					'role_id': $(el).data('role_id')
				},
				success: (response) => {
					getRoleList();
					$('[name=markerAdd]').val(0);
				},
				complete: (response) => {
					HELPER.unblock(200);
				}
			})
		}
	}

</script>