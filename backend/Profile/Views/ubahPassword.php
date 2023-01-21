<form class="card card-xl-stretch mb-xl-8" action="javascript:onChangePassword()" method="post" id="formPassword" name="formPassword" autocomplete="off" enctype="multipart/form-data">
    <div class="card-body">
        <h3>Ubah Password</h3>
        <div class="fv-row row mb-6">
            <label class="col-form-label required">Password Lama</label>
            <div class="col-lg-12">
                <input type="password" name="oldPass" class="form-control form-control-sm" placeholder="Password Lama" required />
            </div>
        </div>

        <div class="fv-row row">
            <div class="fv-row" data-kt-password-meter="true" id="kt_password_meter_control">
                <div class="mb-1">
                    <label class="col-form-label required">
                        Password Baru
                    </label>
                    <div class="position-relative mb-3">
                        <input class="form-control form-control-sm" type="password" onkeyup="comparePass()" placeholder="" name="newPass" autocomplete="off" />
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                            <i class="bi bi-eye-slash fs-2"></i>

                            <i class="bi bi-eye fs-2 d-none"></i>
                        </span>
                    </div>

                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div>
                </div>

                <div class="text-muted">
                    Gunakan 8 karakter atau lebih dengan campuran huruf, angka & simbol.
                </div>
            </div>
        </div>

        <div class="fv-row row mb-6">
            <div class="input-group has-validation mb-5">
                <label class="col-form-label required">Tulis Ulang Password Baru</label>
                <div class="col-lg-12">
                    <input type="password" onkeyup="comparePass()" name="renewPass" class="form-control form-control-sm" placeholder="Tulis Ulang Password Baru" required />
                    <div id="validationServerrenewPassFeedback" class="invalid-feedback">Password tidak cocok.</div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-block btn-warning" style="width:100%">
            <i class="las la-save fs-16"></i> Ubah Password
        </button>
    </div>
</form>