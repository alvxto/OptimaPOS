<form action="javascript:onSave()" style="display: none;" method="post" id="formDokumenMaster" name="formDokumenMaster" autocomplete="off" enctype="multipart/form-data">
	<div class="card card-bordered">
		<div class="card-body">
			<input type="hidden" name="id">

			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Kode</label>
						<input type="text" name="kode" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Kode Jenis Dokumen" readonly />
					</div>
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Nama</label>
						<input type="text" name="nama" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama Jenis Dokumen" required />
					</div>
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Tipe</label>
						<select name="tipe" id="tipe" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="false" data-placeholder="Tipe">

						</select>
					</div>

					<!-- <div class="fv-row mb-5">
						<label for="" class="required form-label">Jenis Dokumen</label>
						<select name="jenisDokumenId" id="jenisDokumenId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="false" placeholder="Tipe">

						</select>
					</div> -->

					<div class="fv-row mb-5">
						<label for="" class="form-label">Status</label>
						<div class="form-check form-check-custom form-check-solid">
							<input name="aktif" class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" checked="checked" />
							<label class="form-check-label" for="flexCheckChecked">
								Active
							</label>
						</div>
					</div>
				</div>

				<div id="docTemplateContainer">
					<div class="row">
						<div class="col-12 col-xl-12" id="ckeditor" style="pointer-events:none;">
							<h5>Template Dokumen</h5>
							<div id="toolbarEditor"></div>
							<div id="container" class="w-100 p-5 d-flex justify-content-center overflow-scroll" style="background: #f5f8fa;height: 400px;">
								<div id="editor" class="overflow-visible" style="height: fit-content;background: white;outline:none;border: none;border-radius: 0!important; width: 21cm;padding:2.54cm;">
								</div>
							</div>
						</div>
						<div class="col-12 col-xl-12">
							<h3>Legenda</h3>
							<div class="accordion" id="legendContainer">

							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="card-footer d-flex justify-content-end py-6 px-9">
			<button type="button" onclick="HELPER.reloadPage()" class="btn btn-light btn-sm me-2">
				<i class="fas fa-angle-left"></i>
				Kembali
			</button>
			<button type="button" onclick="onReset(this)" class="btn btn-sm btn-light btn-active-light-primary me-2 actCreate">
				<i class="las la-redo-alt fs-1"></i> Reset
			</button>
			<button type="submit" class="btn btn-primary btn-sm me-2 actCreate">
				<i class="las la-save fs-1"></i> Save
			</button>
			<button type="button" onclick="onDisplayEdit(this)" class="btn btn-warning btn-sm me-2 d-none actEdit">
				<i class="las la-edit fs-1"></i> Edit
			</button>
			<!-- <button type="button" onclick="onDestroy(this)" class="btn btn-danger btn-sm me-2 d-none actEdit">
				<i class="las la-trash fs-1"></i> Delete
			</button> -->
		</div>
	</div>

	<style>
		.ck-editor__editable[role="textbox"] {
			/* editing area */
			min-height: 200px;
		}

		.ck-content .image {
			/* block images */
			max-width: 80%;
			margin: 20px auto;
		}
	</style>
</form>