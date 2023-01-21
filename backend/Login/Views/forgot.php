<!DOCTYPE html>
<html lang="en">

<head>
    <title>E-Kontrak - Forgot Password</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{url}/uploads/logos/thumbs/logo.svg" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{url}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{url}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-auto w-lg-500px w-xl-600px positon-xl-relative" style="background-image: url({url}/uploads/login/bg.png);background-size: cover; background-repeat: no-repeat;background-origin: content-box, padding-box;margin:10px;border-radius: 1em;">
            </div>
            <div class="d-flex flex-column flex-lg-row-fluid p-0">
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <div class="w-lg-400px mx-auto mb-20">
                        <div class="mb-15">
                            <div class="d-flex align-items-center">
                                <img src="<?= base_url() ?>/uploads/logos/thumbs/logo.svg" alt="E-kontrak Logo" />
                                <h1 class="text-primary fw-bolder align-self-center m-0" style="font-size: 3em;">E-Kontrak</h1>
                            </div>
                            <h3 class="text-primary">Forgot Password Form</h3>
                        </div>
                        <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" action="#">
                            <p class="fw-bold text-gray-600 mb-5">Please enter your email.<br> We will send a link to change your password via that email</p>
                            <div class="fv-row mb-5">
                                <label class="form-label fs-7 fw-bolder text-dark">Email</label>
                                <input class="form-control form-control-sm form-control" type="text" name="Email" value="appstarter@gmail.com" autocomplete="off" />
                            </div>
                            <div class="text-center mt-15">
                                <button type="submit" id="kt_password_reset_submit" class="btn btn-sm btn-warning rounded-pill w-100 mb-5">
                                    <span class="indicator-label">Continue</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>

                                <a href="/app-login" class="link-primary fs-8 fw-bolder align-self-center">
                                    Back to Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script type="text/javascript">
        var APP_URL = "{url}/";
    </script>

    <script src="{url}/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{url}/assets/js/scripts.bundle.js"></script>
    <script src="{url}/assets/js/custom/authentication/password-reset/password-reset.js"></script>

</body>

</html>