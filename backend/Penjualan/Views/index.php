<div class="row" data-roleable="false" data-role="Penjualan-Read">
	<div class="col-xl-12 mb-3">
		<div class="card">
			<div class="card-body">
				Total
			</div>
		</div>
	</div>
	<div class="col-xl-4 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
						<div class="fv-row mb-5">
							<label for="" class="form-label">Operator</label>
							<input type="text" name="nama" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Operator" />
						</div>
					</div>
				</div>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
						<div class="fv-row mb-5">
							<label for="" class="form-label">Customer</label>
							<input type="text" name="nama" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Operator" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
						<div class="fv-row mb-5">
							<label for="" class="form-label">Produk</label>
							<input type="text" name="nama" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Operator" />
						</div>
					</div>
				</div>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
						<div class="fv-row mb-5">
							<label for="" class="form-label">Qty</label>
							<input type="text" name="nama" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Operator" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4 mb-3">
		<div class="card">
			<div class="card-body">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
						<div class="fv-row mb-5">
							<label for="" class="form-label">Harga</label>
							<input type="text" name="nama" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Operator" />
						</div>
					</div>
				</div>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
						<div class="fv-row mb-5">
							<label for="" class="form-label">Kembalian</label>
							<input type="text" name="nama" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Operator" />
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end py-0 px-0">
					<button type="submit" class="btn btn-primary btn-sm me-2 actCreate">
						<i class="las la-save fs-1"></i> Tambah
					</button>
				</div>
			</div>
		</div>
	</div>
	<div>
		<div class="col-xl-12">
			<div class="card card-bordered">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-row-bordered border align-middle rounded tdFirstCenter" id="tablePenjualan">
							<thead>
								<tr class="fw-bolder text-muted bg-light">
									<th class="ps-4" width="20">No</th>
									<th>Nama</th>
									<th>Stok</th>
									<th>Harga</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?= loadView('BackEnd/Penjualan/Views', ['javascript']) ?>