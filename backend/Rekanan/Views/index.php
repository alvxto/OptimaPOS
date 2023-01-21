<div class="row" data-roleable="false" data-role="Rekanan-Read">

	<div class="col-xl-12" style="display: none;" id="form_data">
		<?= loadView('BackEnd/Rekanan/Views/form') ?>
	</div>

	<div class="col-xl-12" id="table_data">
		<div class="card card-bordered">
			<div class="card-header d-flex justify-content-between">
				<div class="card-title m-0">
					<h3 class="fw-bolder m-0">Daftar Rekanan</h3>
				</div>
				<div class="card-toolbar">
					<button type="button" onclick="onAdd()" class="btn btn-primary font-weight-bolder btn-sm me-2"> <i class="fas fa-plus"></i> Tambah</button>
					<button type="button" onclick="onRefresh()" class="btn btn-light font-weight-bold btn-sm me-2"> <i class="fas fa-sync"></i> Refresh</button>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-row-bordered border align-middle rounded tdFirstCenter" id="tableRekanan">
						<thead>
							<tr class="fw-bolder text-muted bg-light">
								<th class="ps-4" width="20">No</th>
								<th>Perusahaan</th>
								<th>Nama</th>
								<th>Jabatan</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

				</div>
			</div>
		</div>
	</div>

</div>

<?= loadView('BackEnd/Rekanan/Views', ['javascript']) ?>