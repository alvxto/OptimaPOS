	<div class="row" data-roleable="false" data-role="Laporan-Read">

		<div class="col-xl-12" id="table_data">
			<div class="card  shadow-sm mb-10">
				<div class="card-body">
					<div>
						<h3 class="fw-bolder text-dark mb-3">Daftar Laporan</h3>
						<div class="row">
							<nav class="nav mt-3">
								<div class="col-12 col-md-3 mx-2">
									<select name="navProgram" id="navProgram" class="form-select form-select-sm" aria-label="Program" data-placeholder="Program"></select>
								</div>
								<div class="col-12 col-md-3 mx-2">
									<select name="navKegiatan" id="navKegiatan" class="form-select form-select-sm" aria-label="Kegiatan" data-placeholder="Kegiatan"></select>
								</div>
								<div class="col-12 col-md-3 mx-2">
									<select name="navKegiatanSub" id="navKegiatanSub" class="form-select form-select-sm" aria-label="Kegiatan Sub" data-placeholder="Kegiatan Sub"></select>
								</div>
								<div class="col-12 col-md-2 col-lg-2">
									<button type="button" onclick="onSearch()" class="btn btn-sm btn-warning w-100"> <i class="fas fa-search"></i> Filter</button>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<div style="overflow-x:scroll; max-width: 100%;">
				<div class="row col-md-12 laporan" id="viewLaporan"></div>
			</div>
		</div>

	</div>

	<?= loadView('BackEnd/Laporan/Views', ['javascript']) ?>