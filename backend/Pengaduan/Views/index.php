<div class="row" data-roleable="false" data-role="Pekerjaan-Read">

	<div class="col-xl-12" id="form_data" style="display: none;">
		<?= loadView('BackEnd/Pekerjaan/Views/form') ?>
	</div>

	<div class="col-xl-12" id="detail_data" style="display: none;">
		<?= loadView('BackEnd/Pekerjaan/Views/detail') ?>
	</div>

	<div class="col-xl-12" id="table_data">
		<!-- <div class="card  shadow-sm mb-10">
			<div class="card-body">
				<h3 class="fw-bold text-primary mb-3">List Paket Pekerjaan</h3>
				<div class="row">
					<div class="col-12 col-md-8 col-lg-10">
						<input type="text" class="form-control form-control-sm w-100 form-control-solid px-5" placeholder="Search">
					</div>
					<div class="col-12 col-md-4 col-lg-2">
						<button type="button" onclick="onAdd()" class="btn btn-sm btn-warning w-100"> <i class="fas fa-plus"></i> Tambah Paket</button>
					</div>
				</div>
			</div>
		</div> -->
		<div class="card shadow-sm">
			<div class="card-header d-flex justify-content-between">
				<div class="card-title m-0">
					<h3 class="fw-bolder m-0">Daftar Paket Pekerjaan</h3>
				</div>
				<div class="card-toolbar">
					<button type="button" onclick="onAdd()" class="btn btn-primary font-weight-bolder btn-sm me-2"> <i class="fas fa-plus"></i> Tambah</button>
					<button type="button" onclick="onRefresh()" class="btn btn-light font-weight-bold btn-sm me-2"> <i class="fas fa-sync"></i> Refresh</button>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-row-bordered border align-middle rounded tdFirstCenter" id="tablePekerjaan">
						<thead>
							<tr class="fw-bolder text-muted bg-light">
								<th class="ps-4" width="20">No</th>
								<th>Nama Paket</th>
								<th>Status Paket</th>
								<th>Tgl. Dibuat</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

				</div>
			</div>
		</div>
	</div>

</div>

<?= loadView('BackEnd/Pekerjaan/Views', ['javascript', 'modalGenerateDokumen']) ?>