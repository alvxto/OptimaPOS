<form action="javascript:onSave()" method="post" id="formRekanan" name="formRekanan" autocomplete="off" enctype="multipart/form-data">
	<div class="card card-bordered">
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-lg-6 pe-lg-10">
					<h3 class="fw-bolder mb-5">Profile Pemilik</h3>
					<input type="hidden" name="id">

					<div class="fv-row mb-5">
						<label for="" class="required form-label">Nama</label>
						<div class="col-12">
							<input type="text" name="nama" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama" required />
						</div>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="required form-label">Jabatan</label>
						<div class="col-12">
							<input type="text" name="jabatan" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Jabatan" required />
						</div>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="required form-label">No. NPWP</label>
						<div class="col-12">
							<input type="text" name="npwp" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No. NPWP" required />
						</div>
					</div>

					<!-- <div class="fv-row mb-5">
						<label for="" class="required form-label">Kop Surat</label>
						<div class="col-12">
							<input type="text" name="kopSurat" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Kop Surat" required />
						</div>
					</div> -->

					<div class="fv-row mb-5">
						<label for="" class="form-label">No. Telepon</label>
						<div class="col-12">
							<input type="number" pattern="\d\d\d\d\d\d\d\d\d\d\d" name="telepon" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No. Telepon" />
						</div>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Email</label>
						<div class="col-12">
							<input type="email" name="email" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Email" />
						</div>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="required form-label">No. Rekening</label>
						<div class="col-12">
							<input type="text" name="rekening" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No. Rekening" required />
						</div>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="required form-label">Nama Bank</label>
						<div class="col-12">
							<input type="text" name="bank" id="bank" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama Bank" required />
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-6 ps-lg-10" style="border-left: 1px solid #DEDEDE;">
					<section>

						<h3 class="fw-bolder mb-5">Profile Perusahaan</h3>

						<div class="fv-row mb-5">
							<label for="" class="required form-label">Nama Perusahaan</label>
							<div class="col-12">
								<input type="text" name="namaPerusahaan" aliases="Nama Perusahaan" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama Perusahaan" required />
							</div>
						</div>

						<div class="fv-row mb-5">
							<label for="" class="required form-label">Alamat</label>
							<div class="col-12">
								<textarea name="alamat" cols="30" rows="2" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Alamat" required></textarea>
							</div>
						</div>

						<div class="fv-row mb-5">
							<label for="" class="required form-label">Kota/Kab</label>
							<div class="col-12">
								<input type="text" name="kota" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Kota atau Kabupaten" required />
							</div>
						</div>
					</section>
					<section>
						<h3 class="fw-bolder mb-5 mt-10">Informasi Akte</h3>

						<div class="fv-row mb-5">
							<label for="" class="required form-label">No. Akte</label>
							<div class="col-12">
								<input type="text" name="akte" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No. Akte" required />
							</div>
						</div>

						<div class="fv-row row mb-5">
							<label for="" class="required form-label">Tgl Akte</label>
							<div class="col-12">
								<input type="text" id="tglAkte" name="tglAkte" aliases="Tgl Akte"  class="form-control form-control-solid form-control-sm" placeholder="Masukkan Tgl. Akter" />
							</div>
						</div>

						<div class="fv-row mb-5">
							<label for="" class="required form-label">Pembuat Akte</label>
							<div class="col-12">
								<input type="text" name="pembuatAkte" aliases="Pembuat Akte" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Pembuat Akte" required />
							</div>
						</div>
					</section>
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
	</div>
</form>
<style>
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		/* display: none; <- Crashes Chrome on hover */
		-webkit-appearance: none;
		margin: 0;
		/* <-- Apparently some margin are still there even though it's hidden */
	}

	input[type=number] {
		-moz-appearance: textfield;
		/* Firefox */
	}
</style>