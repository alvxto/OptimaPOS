<!DOCTYPE html>
<html lang="en">

<head>
	<title>E-Kontrak - Login App</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="shortcut icon" href="{url}/file/logo" />

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<link href="{url}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="{url}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

</head>

<body id="kt_body" class="bg-body">
	<div class="d-flex flex-column flex-root">
		<div class="d-flex flex-column flex-lg-row flex-column-fluid">
			<div class="d-flex flex-column flex-lg-row-fluid py-10">
				<div class="d-flex flex-center flex-column flex-column-fluid">
					<div class="w-lg-450px w-300px mx-auto">
						<div class="mb-5">
							<div class="d-flex justify-content-between">
								<div class="d-flex align-items-end">
									<img src="{url}/file/logo" alt="E-kontrak Logo" style="width: clamp(50px,4vw,100px);" />
									<h1 class="text-gray-900 fw-bolder m-0" style="font-size: 2em;font-weight: 800!important;">E-Kontrak</h1>
								</div>
								<img src="malangMakmur.png" alt="E-kontrak Logo" class="align-self-end" />
							</div>
							<br>
							<h5 class="text-gray-600 fw-bold">
								Selamat datang di Aplikasi E-Kontrak
							</h5>
							<br>
						</div>
						<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
							<div class="fv-row mb-5">
								<label class="form-label fs-7 fw-bolder text-dark">Username</label>
								<input class="form-control form-control-sm form-control" type="text" name="Username" value="appstarter@gmail.com" placeholder="Masukkan Username" autocomplete="off" />
							</div>
							<div class="fv-row mb-10">
								<div class="d-flex justify-content-between mb-1">
									<label class="form-label fw-bolder text-dark fs-7">Password</label>
									<!-- <a href="/app-login/forgot" class="link-danger fs-8 fw-bolder align-self-center">
										Forgot Password ?
									</a> -->
								</div>
								<i id="mata" onclick="showPassword()" style="position:absolute;right:20px;bottom:11px;" class="fa fa-eye"></i>
								<input class="form-control mb-5 form-control-sm form-control" type="password" name="Password" id="Password" value="@appstarter12345" placeholder="Masukkan Password" autocomplete="off" />
							</div>
							<div class="fv-row mb-10">
								<div class="g-recaptcha" id="captcha" data-sitekey="{siteKey}"></div>
							</div>
							<div class="text-center">
								<button type="submit" id="kt_sign_in_submit" class="btn btn-sm btn-warning rounded-pill text-dark w-100 mb-5">
									<span class="indicator-label">Login</span>
									<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<!-- <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
								<a href="#" class="btn btn-flex flex-center rounded-pill btn-light btn-sm w-100 mb-5">
									<img alt="Logo" src="{url}/assets/media/svg/brand-logos/google-icon.svg" class="h-20px me-3" />
									Continue with Google
								</a> -->
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="d-flex flex-column flex-lg-row-auto w-lg-500px w-xl-600px positon-xl-relative" style="background-image: url({url}/file/background);background-size: cover; background-repeat: no-repeat;background-origin: content-box,">
			</div>

		</div>
	</div>

	<script type="text/javascript">
		var APP_URL = "{url}/";
	</script>
	<script>
		function showPassword() {
				var x = document.getElementById("Password");
				var mata = document.getElementById("mata");
				if (x.type === "password") {
					x.type = "text";
					mata.classList.remove('fa-eye')
					mata.classList.add('fa-eye-slash')
				} else {
					x.type = "password";
					mata.classList.add('fa-eye')
					mata.classList.remove('fa-eye-slash')
				}
			}
	</script>

	<script src="{url}/assets/plugins/global/plugins.bundle.js"></script>
	<script src="{url}/assets/js/scripts.bundle.js"></script>
	<script src="{url}/assets/js/custom/authentication/sign-in/general.js"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>

</body>

</html>