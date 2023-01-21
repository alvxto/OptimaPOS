<!DOCTYPE html>
<html lang="en">

<head>
    <title>E-Kontrak - Login App</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{url}/uploads/logos/thumbs/logo.svg" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{url}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{url}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

</head>

<body id="kt_body" class="bg-body">
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="w-400px card shadow-sm">
            <form class="form w-100" novalidate="novalidate" id="kt_new_password_form" action="#">
                <div class="card-body">
                    <h3>Change Password</h3>
                    <div class="fv-row row">
                        <div class="fv-row" data-kt-password-meter="true" id="kt_password_meter_control">
                            <div class="mb-1">
                                <label class="col-form-label required">
                                    New Password
                                </label>
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-sm" type="password" name="password" autocomplete="off" />
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
                                Use 8 or more characters with a mix of letters, numbers & symbols.
                            </div>
                        </div>
                    </div>

                    <div class="fv-row row mb-6">
                        <div class="input-group has-validation mb-5">
                            <label class="col-form-label required">Retype New Password</label>
                            <div class="col-lg-12">
                                <input type="password" name="confirm-password" class="form-control form-control-sm" placeholder="Retype New Password" required />
                                <div id="validationServerrenewPassFeedback" class="invalid-feedback">Password isn't match.</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="kt_new_password_submit" class="btn btn-sm btn-warning rounded-pill w-100 mb-5">
                        <span class="indicator-label">Change Password</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <input type="hidden" name="id" value="<?= $id ?>" />
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        var APP_URL = "{url}/";
    </script>

    <script src="{url}/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{url}/assets/js/scripts.bundle.js"></script>
    <script src="{url}/assets/js/custom/authentication/password-reset/new-password.js"></script>

</body>

</html>