<form action="javascript:onSave()" method="post" id="formUser" name="formUser" autocomplete="off" enctype="multipart/form-data">
	<div class="card card-bordered">
		<div class="card-body">
			<input type="hidden" name="id">

			<ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
				<li class="nav-item">
					<a class="nav-link active" data-bs-toggle="tab" href="#tabGeneral">
						<i class="las la-bars fs-2"></i>
						Umum
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="tab" href="#tabAccount">
						<i class="las la-user-cog fs-2"></i>
						Akun
					</a>
				</li>
			</ul>

			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
					<div class="fv-row mb-5">
						<div class="image-input image-input-circle" id="kt_image_input_profile" data-kt-image-input="false" style="background-image: url(<?= base_url() ?>/assets/media/avatars/blank.png)">
							<div class="image-input-wrapper w-125px h-125px" id="photoPreview" style="background-image: url(<?= base_url() ?>/assets/media/avatars/blank.png)"></div>

							<label class="editProfile btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change avatar">
								<i class="bi bi-pencil-fill fs-7"></i>

								<input type="file" name="photo" accept=".png, .jpg, .jpeg" />
								<input type="hidden" name="isremoved" />
							</label>

							<a href="#" id="profileDownload" style="margin-right: 90px;" class="editProfile btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Download Profile">
								<i class="bi bi-arrow-down fs-2"></i>
							</a>

							<span class="editProfile btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel Profile">
								<i class="bi bi-x fs-2"></i>
							</span>

							<span class="editProfile btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove Profile">
								<i class="bi bi-x fs-2"></i>
							</span>

						</div>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="required form-label">Nama Lengkap</label>
						<input type="text" name="name" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama Lengkap" required />
					</div>

					<div class="fv-row mb-5">
						<label for="" class="required form-label">Kode</label>
						<input type="text" name="code" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Kode" required />
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Bidang / UPT</label>
						<select name="bidangId" id="bidangId" class="form-select form-select-sm form-select-solid" aria-label="Positions"></select>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Role</label>
						<select name="roleId" id="roleId" class="form-select form-select-sm form-select-solid" aria-label="Categories"></select>
					</div>

					<div class="fv-row">
						<label for="" class="form-label">Jenis Kelamin</label>
						<div class="mt-2">
							<div class="form-check form-check-inline">
								<input class="form-check-input h-20px w-20px" type="radio" name="gender" id="inlineRadio1" value="1">
								<label class="form-check-label" for="inlineRadio1">Laki-laki</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input h-20px w-20px" type="radio" name="gender" id="inlineRadio2" value="0">
								<label class="form-check-label" for="inlineRadio2">Perempuan</label>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="tabAccount" role="tabpanel">
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Username</label>
						<input type="text" name="username" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Username" required />
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Password</label>
						<input type="password" name="password" autocomplete="on" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Password" />
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Email</label>
						<input type="email" name="email" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Email Aktif" />
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Telepon</label>
						<input type="number" pattern="\d\d\d\d\d\d\d\d\d\d\d" name="telp" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nomor Telepon" />
					</div>
					<div class="fv-row mb-5">
						<label for="" class="form-label">Status</label>
						<div class="form-check form-check-custom form-check-solid">
							<input name="active" class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" checked="checked" />
							<label class="form-check-label" for="flexCheckChecked">
								Aktif
							</label>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="card-footer d-flex justify-content-end py-6 px-9">
			<button type="button" onclick="$('.selectedRow').click()" class="btn btn-sm btn-light btn-active-light-primary me-2 d-none actBack">
				<i class="las la-times fs-1"></i> Batal
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
			<button type="button" onclick="onDestroy(this)" class="btn btn-danger btn-sm me-2 d-none actEdit">
				<i class="las la-trash fs-1"></i> Delete
			</button>
		</div>
	</div>
</form>
<style>
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		/* display: none; <- Crashes Chrome on hover */
		-webkit-appearance: none;
		margin: 0;
		/* <-- Apparently some margin are still there even though it's hidden */
	}

	input[type=number] {
		-moz-appearance: textfield;
		/* Firefox */
	}
</style>