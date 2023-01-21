<form action="javascript:onSave()" method="post" id="formLaporan" name="formLaporan" autocomplete="off" enctype="multipart/form-data">
	<div class="card shadow-sm">
		<div class="card-body">
			<input type="hidden" name="id">

			<div class="row">
				<div class="col-12 col-lg-7 pe-lg-10">
					<h3 class="fw-bolder mb-5">Data Paket</h3>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Kode Paket</label>
						<div class="col-12">
							<input type="text" name="kode" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Kode Paket" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Paket Dokumen</label>
						<div class="col-12">
							<select name="paketDokumenId" id="paketDokumenId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" placeholder="Pilih Paket"></select>
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="form-label">PPN</label>
						<div class="col-12">
							<input type="number" value="11" readonly id="ppn" class="form-control form-control-sm form-control-solid" />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Jenis PPH</label>
						<div class="col-12">
							<select name="jenisPphId" id="jenisPphId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" placeholder="Pilih Jenis Pph"></select>
						</div>
					</div>

					<div class="fv-row row mb-10">
						<label for="" class="required form-label">Detail Uraian Dokumen</label>
						<div class="col-12" id="uraianDokumenContainer">

						</div>
						<button type="button" onclick="addUraianDokumen()" class="btn btn-sm btn-primary col-3 ms-3 mt-3 fs-9">Tambah Dokumen</button>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Total Harga</label>
						<div class="col-12">
							<input type="number" step="1000" min="0" readonly id="totalHarga" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Total Harga" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Jenis Termyn</label>
						<div class="col-12">
							<select name="termynId" id="termynId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" placeholder="Pilih Jenis Termyn "></select>
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Sumber Dana</label>
						<div class="col-12">
							<select name="sumberDanaId" id="sumberDanaId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" placeholder="Pilih Sumber Dana "></select>
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Jenis Bank</label>
						<div class="col-12">
							<select name="bankId" id="bankId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" placeholder="Pilih Jenis Bank"></select>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-5 ps-lg-10" style="border-left: 1px solid #DEDEDE;">
					<section>
						<h3 class="fw-bolder mb-5">Data Pembuat Kontrak</h3>

						<div class="fv-row row mb-5">
							<label for="" class="required form-label">Nama Pejabat</label>
							<div class="col-12">
								<select name="pembuatKomitmenId" id="pembuatKomitmenId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" placeholder="Pilih Program"></select>
							</div>
						</div>

						<div class="fv-row row mb-5">
							<label for="" class="required form-label">NIP Pejabat</label>
							<div class="col-12">
								<input type="text" readonly id="pembuatKomitmenNip" class="form-control form-control-sm form-control-solid" />
							</div>
						</div>

						<div class="fv-row row mb-5">
							<label for="" class="required form-label">Jabatan</label>
							<div class="col-12">
								<input type="text" readonly id="pembuatKomitmenJabatan" class="form-control form-control-sm form-control-solid" />
							</div>
						</div>

						<div class="fv-row row mb-5">
							<label for="" class="required form-label">Alamat Pejabat</label>
							<div class="col-12">
								<input type="text" readonly id="pembuatKomitmenAlamat" class="form-control form-control-sm form-control-solid" />
							</div>
						</div>
					</section>
					<section>
						<h3 class="fw-bolder mb-5">Data Rekanan</h3>

						<div class="fv-row row mb-5">
							<label for="" class="required form-label">Nama Rekanan</label>
							<div class="col-12">
								<select name="rekananId" id="rekananId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" placeholder="Pilih Program"></select>
							</div>
						</div>

						<div class="fv-row row mb-5">
							<label for="" class="required form-label">Jabatan rekanan</label>
							<div class="col-12">
								<input type="text" readonly id="jabatanRekanan" class="form-control form-control-sm form-control-solid" />
							</div>
						</div>

						<div class="fv-row row mb-5">
							<label for="" class="required form-label">Alamat Rekanan</label>
							<div class="col-12">
								<input type="text" readonly id="alamatRekanan" class="form-control form-control-sm form-control-solid" />
							</div>
						</div>
					</section>
				</div>
			</div>

		</div>
		<div class="card-footer d-flex justify-content-end py-6 px-9">
			<button type="button" onclick="HELPER.reloadPage()" class="btn btn-light btn-sm me-2">
				<i class="fas fa-angle-left"></i>
				Kembali
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