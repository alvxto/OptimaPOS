<div class="col-xl-12 mb-5 dataForm d-none">
	<form action="javascript:save()" method="post" id="formChangelog" name="formChangelog" autocomplete="off" enctype="multipart/form-data">
		<div class="card card-xl-stretch mb-xl-8">

			<div class="card-header border-0 pt-5">
				<div class="card-title align-items-start flex-column"></div>
				<div class="card-toolbar align-items-end flex-column">
					<a href="javascript:;" onclick="HELPER.reloadPage({})" class="btn btn-sm btn-light">
						Back
					</a>
				</div>
			</div>

			<div class="card-body">
				<input type="hidden" name="changelog_id">
				<div class="fv-row row mb-6">
					<label class="col-lg-2 col-form-label required">Version Code</label>
					<div class="col-lg-10">
						<input type="text" name="changelog_code" class="form-control form-control-sm" placeholder="input version code" required />
					</div>
				</div>

				<div class="fv-row row mb-6">
					<label class="col-lg-2 col-form-label required">Version Title</label>
					<div class="col-lg-10">
						<input type="text" name="changelog_title" class="form-control form-control-sm" placeholder="input vesrsion title" required />
					</div>
				</div>

				<div class="fv-row row mb-6">
					<label class="col-lg-2 col-form-label required">List Update</label>
					<div class="col-lg-10">
						<div id="toolbarEditor"></div>
						<div id="listLogs" style="border: 1px solid #e4e6ef; min-height:150px;" class="form-control"></div>
					</div>
				</div>

			</div>

			<div class="card-footer d-flex justify-content-end py-6 px-9">
				<button type="reset" class="btn btn-sm btn-light me-2">
					<i class="las la-redo-alt fs-12"></i> Reset
				</button>
				<button type="submit" class="btn btn-primary btn-sm">
					<i class="las la-save fs-12"></i> Save
				</button>
			</div>

		</div>
	</form>
</div>