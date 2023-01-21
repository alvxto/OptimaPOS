<div class="row" data-roleable="false" data-role="Configuration-Read">
	<div class="col-xl-12 mb-5">
		<div class="card d-none" id="dataConfiguration">
			<div class="card-body pt-9 pb-0">
				<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
					<div class="me-7 mb-4">
						<div class="symbol symbol-90px symbol-lg-160px symbol-fixed position-relative">
							<img src="" id="logoApp" alt="Logo apps" class="w-125px h-125px" />
						</div>
					</div>
					<div class="flex-grow-1">
						<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
							<div class="d-flex flex-column">
								<div class="d-flex align-items-center mb-2">
									<a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">
										<span id="app.setTitle"></span>
									</a>
								</div>
								<div class="d-flex align-items-center mb-2">
									<div class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
										<span class="svg-icon svg-icon-4 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
												<path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
											</svg>
										</span>
										<span id="app.telp"></span>
									</div>
								</div>
								<div class="d-flex align-items-center mb-2">
									<div class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
										<span class="svg-icon svg-icon-4 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
												<path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
												<path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
											</svg>
										</span>
										<span id="app.address"></span>
									</div>
								</div>
								<div class="d-flex align-items-center mb-2">
									<div class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
										<span class="svg-icon svg-icon-4 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-justify-left" viewBox="0 0 16 16">
												<path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
											</svg>
										</span>
										<span id="app.description"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
					<li class="nav-item mt-2">
						<a class="nav-link text-active-primary ms-0 me-10 py-5 active tabConfig cp" data-group="app" onclick="showConfig(this)">Website</a>
					</li>
					<li class="nav-item mt-2">
						<a class="nav-link text-active-primary ms-0 me-10 py-5 active tabConfig cp" data-group="general" onclick="showConfig(this)">General</a>
					</li>
					<li class="nav-item mt-2">
						<a class="nav-link text-active-primary ms-0 me-10 py-5 tabConfig cp" data-group="email" onclick="showConfig(this)">Email</a>
					</li>
					<li class="nav-item mt-2">
						<a class="nav-link text-active-primary ms-0 me-10 py-5 tabConfig cp" data-group="google_recaptcha" onclick="showConfig(this)">Google Chaptcha</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-xl-12 mb-5">
		<div class="card mb-5 mb-xl-10">
			<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
				<div class="card-title m-0">
					<h3 class="fw-bolder m-0" id="configTitle">General</h3>
				</div>
			</div>
			<div id="kt_account_settings_profile_details" class="collapse show">
				<form action="javascript:save()" method="post" id="form_config" name="form_config" autocomplete="off" enctype="multipart/form-data">
					<div class="card-body border-top">
						<div class="" id="contentConfig"></div>
					</div>
					<div class="card-footer d-flex justify-content-end py-6 px-9">
						<button type="submit" class="btn btn-sm btn-primary" data-roleable="false" data-role="Configuration-Save"><i class="bi bi-save"></i> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?= loadView('BackEnd/Configuration/Views/javascript') ?>