<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
	<div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
		<strong>{!fullname!}</strong>
		<img src="{!photoProfile!}" alt="user" class="rounded-circle" style="margin-left:10px;object-fit:cover;" />
	</div>
	<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-danger fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
		<div class="menu-item px-3">
			<div class="menu-content d-flex align-items-center px-3">
				<div class="symbol symbol-50px me-5">
					<img alt="Logo" src="{!photoProfile!}" class="rounded-circle" style="object-fit:cover;" />
				</div>
				<div class="d-flex flex-column">
					<!-- <div class="fw-bolder d-flex align-items-center fs-5">{!fullname!}
						<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span>
					</div> -->
					<a href="#" class="fw-bold text-muted text-hover-danger fs-7">{!email!}</a>
				</div>
			</div>
		</div>
		<div class="separator my-2"></div>
		<div class="menu-item px-5">
			<a href="javascript:;" data-con="j93ck5d81mt44dlw" onclick="HELPER.loadPage(this)" class="menu-link px-5">Profile</a>
		</div>
		<div class="separator my-2"></div>
		<!-- <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
			<a href="#" class="menu-link px-5">
				<span class="menu-title position-relative">Language
					<span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">Indonesia
						<img class="w-15px h-15px rounded-1 ms-2" src="{url}/assets/media/flags/indonesia.svg" alt="" /></span></span>
			</a>
			<div class="menu-sub menu-sub-dropdown w-175px py-4">
				<div class="menu-item px-3">
					<a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5 active">
						<span class="symbol symbol-20px me-4">
							<img class="rounded-1" src="{url}/assets/media/flags/united-states.svg" alt="" />
						</span>English</a>
				</div>
				<div class="menu-item px-3">
					<a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5">
						<span class="symbol symbol-20px me-4">
							<img class="rounded-1" src="{url}/assets/media/flags/russia.svg" alt="" />
						</span>Rusia</a>
				</div>
			</div>
		</div>
		<div class="menu-item px-5 my-1">
			<a href="" class="menu-link px-5">Account Settings</a>
		</div> -->
		<div class="menu-item px-5">
			<a href="#" class="menu-link px-5" onclick="HELPER.logout()">Keluar</a>
		</div>
	</div>
</div>