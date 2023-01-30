<form action="javascript:onSave()" method="post" id="formBarang" name="formBarang" autocomplete="off" enctype="multipart/form-data">
	<div class="card card-bordered">
		<div class="card-body">
			<input type="hidden" name="id">

			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="tabGeneral" role="tabpanel">
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Kode</label>
						<input type="text" name="kode" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Kode Barang" required />
					</div>
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Nama</label>
						<input type="text" name="nama" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama Barang" required />
					</div>
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Stok</label>
						<input type="text" name="stok" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama Barang" required />
					</div>
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Harga</label>
						<input type="text" name="harga" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama Barang" required />
					</div>
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Kategori</label>
						<select name="kategoriId" id="kategoriId" class="form-select form-select-sm form-select-solid" aria-label="Kegiatan" required></select>
					</div>
					<div class="fv-row mb-5">
						<label for="" class="required form-label">Satuan</label>
						<select name="satuanId" id="satuanId" class="form-select form-select-sm form-select-solid" aria-label="Kegiatan" required></select>
					</div>
					<div class="fv-row mb-5">
						<label for="" class="form-label">Status</label>
						<div class="form-check form-check-custom form-check-solid">
							<input name="aktif" class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" checked="checked" />
							<label class="form-check-label" for="flexCheckChecked">
								Active
							</label>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="card-footer d-flex justify-content-end py-6 px-9">
			<button type="button" onclick="$('.selectedRow').click()" class="btn btn-sm btn-light btn-active-light-primary me-2 d-none actBack">
				<i class="las la-times fs-1"></i> Batal
			</button>
			<button type="button" onclick="onReset(this)" class="btn btn-sm btn-light btn-active-light-primary me-2 actCreate">
				<i class="las la-redo-alt fs-1"></i> Reset
			</button>
			<button type="submit" class="btn btn-primary btn-sm me-2 actCreate">
				<i class="las la-save fs-1"></i> Save
			</button>
			<button type="button" onclick="onDisplayEdit(this)" class="btn btn-warning btn-sm me-2 d-none actEdit">
				<i class="las la-edit fs-1"></i> Edit
			</button>
			<button type="button" onclick="onDestroy(this)" class="btn btn-danger btn-sm me-2 d-none actEdit">
				<i class="las la-trash fs-1"></i> Delete
			</button>
		</div>
	</div>
</form>