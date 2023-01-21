	<div class="row" data-roleable="false" data-role="Dokumen-Read">
		<div class="col-xl-12" id="table_data">
			<div class="card  shadow-sm mb-10">
				<div class="card-body">
					<h3 class="fw-bolder text-dark mb-3">Daftar Dokumen</h3>
					<div class="row">
						<div class="col-12 col-md-8 col-lg-10">
							<input type="text" class="form-control form-control-sm w-100 form-control-solid px-5" id="SearchDoc" placeholder="Search">
						</div>
						<div class="col-12 col-md-4 col-lg-2">
							<button type="button" onclick="onSearch()" class="btn btn-sm btn-warning w-100"> <i class="fas fa-search"></i> Cari</button>
						</div>
					</div>
					<div>
						<div class="row">
							<nav class="nav mt-3">
								<li class="nav-item col-12 col-md-1 ">
									<a class="nav-link disabled me-3" href="#" aria-disabled="true">Filter</a>
								</li>
								<div class="col-12 col-md-2 mx-2">
									<select name="navProgram" id="navProgram" class="form-select form-select-sm" aria-label="Kegiatan" data-placeholder="Program" onchange="onFilter()"></select>
								</div>
								<div class="col-12 col-md-2 mx-2">
									<select name="navKegiatan" id="navKegiatan" class="form-select form-select-sm" aria-label="Kegiatan" data-placeholder="Kegiatan" onchange="onFilter()"></select>
								</div>
								<div class="col-12 col-md-2 mx-2">
									<select name="navKegiatanSub" id="navKegiatanSub" class="form-select form-select-sm" aria-label="Kegiatan" data-placeholder="Kegiatan Sub" onchange="onFilter()"></select>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<div class="row col-md-12 document" id="viewDocument"></div>
		</div>

	</div>

	<?= loadView('BackEnd/Dokumen/Views', ['javascript']) ?>