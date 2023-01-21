<form action="javascript:onSave()" class="dataForm" method="post" id="formProfile" name="formProfile" autocomplete="off" enctype="multipart/form-data">
    <div class="card card-xl-stretch mb-xl-8">
        <div class="card-body">
            <input type="hidden" name="user_id">
            <div class="d-flex mb-10">
            <div class="image-input image-input-circle" id="kt_image_input_profile" data-kt-image-input="false" style="background-image: url(<?= base_url() ?>/assets/media/avatars/blank.png)">
                <div class="image-input-wrapper w-100px h-100px" id="photoPreview" style="background-image: url(<?= base_url() ?>/assets/media/avatars/blank.png)"></div>

                <label class="editProfile btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change avatar">
                    <i class="bi bi-pencil-fill fs-7"></i>

                    <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="user_isremoved" />
                </label>

                <a href="#" id="profileDownload" style="margin-right: 65px;" class="editProfile btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Download Profile">
                    <i class="bi bi-arrow-down fs-2"></i>
                </a>

                <span class="editProfile btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel Profile">
                    <i class="bi bi-x fs-2"></i>
                </span>

                <span class="editProfile btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove Profile">
                    <i class="bi bi-x fs-2"></i>
                </span>

                </div>
                <!-- <img src="<?= base_url() ?>/assets/media/avatars/blank.png" id="photoProfile" class="img-thumbnail rounded-circle" alt="asset" style="width:100px;height:100px !important;"> -->
                <div class="align-middle p-6">
                    <h2 id="previewUsername">User Name</h2>
                    <h4 id="previewJabatan" class="fw-normal">Position</h4>
                </div>
            </div>
            <h4>Profile Detail</h4>
            <div class="fv-row row mb-6">
                <label class="col-form-label required">Username</label>
                <div class="col-lg-12">
                    <input type="text" name="user_username" class="form-control form-control-sm" placeholder="Username" required />
                </div>
            </div>

            <div class="fv-row row mb-6">
                <label class="col-form-label required">Nama</label>
                <div class="col-lg-12">
                    <input type="text" name="user_name" class="form-control form-control-sm" placeholder="Nama" required />
                </div>
            </div>

            <div class="fv-row row mb-6">
                <label class="col-form-label required">Email</label>
                <div class="col-lg-12">
                    <input type="email" name="user_email" class="form-control form-control-sm" placeholder="Email" required />
                </div>
            </div>

            <h4 class="mt-10">User Detail</h4>
            <div class="fv-row row mb-6">
                <label class="col-form-label">Tempat Lahir</label>
                <div class="col-lg-12">
                    <input type="text" name="user_tempat_lahir" class="form-control form-control-sm" placeholder="Tempat Lahir"/>
                </div>
            </div>

            <div class="fv-row row mb-6">
                <div class="col-lg-6">
                    <label class="col-form-label">Tanggal Lahir</label>
                    <input type="date" name="user_tanggal_lahir" id="" class="form-control form-control-sm"/>
                </div>

                <div class="col-lg-6">
                    <label class="col-form-label required">No. Telp</label>
                    <input type="text" name="user_telp" id="" class="form-control form-control-sm" required />
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-warning" style="width:100%">
                <i class="las la-save fs-16"></i> Save
            </button>
        </div>
    </div>
</form>