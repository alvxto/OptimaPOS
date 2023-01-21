<div class="card shadow-sm">
	<div class="card-header d-flex justify-content-between py-10">
		<div>
			<h1 class="fw-bolder mb-3 namaPaket">Paket A</h1>
			<!-- <p class="fw-bold text-gray-500 m-0">Pembagunan saluran Drainase RT 29</p> -->
		</div>
		<div>
			<input type="hidden">
			<button type="button" onclick="HELPER.reloadPage()" class="btn btn-light btn-sm me-2">
				<i class="fas fa-angle-left"></i>
				Kembali
			</button>
			<button type="button" onclick="onEdit(this)" class="actEdit btn btn-warning btn-sm me-2">
				<i class="las la-edit fs-1"></i> Edit
			</button>
			<button type="button" onclick="onDestroy(this)" class="actEdit btn btn-danger btn-sm me-2">
				<i class="las la-trash fs-1"></i> Delete
			</button>
		</div>
	</div>
	<div class="card-body">
		<input type="hidden" name="id">

		<div class="row">
			<div class="col-12 mb-5">
				<h5 class="fw-bolder mb-5">Data Paket</h5>

				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Paket Pekerjaan</label>
					<div class="col-9 fw-bolder namaPaket">Paket A</div>
				</div>

				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Program</label>
					<div class="col-9 fw-bolder programNama" id="programNama">Paket A</div>
				</div>

				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Kegiatan</label>
					<div class="col-9 fw-bolder kegiatanNama" id="kegiatanNama">Paket A</div>
				</div>

				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Sub Kegiatan</label>
					<div class="col-9 fw-bolder kegiatanSubNama" id="kegiatanSubNama">Paket A</div>
				</div>

				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3 align-self-start m-0" style="vertical-align: top;">Uraian Pekerjaan</label>
					<div class="col-9">
						<table class="table table-row-bordered mt-5">
							<thead>
								<tr class="fw-bolder fs-6 text-gray-900 text-center">
									<th>No</th>
									<th>Nama</th>
									<th>Pagu</th>
									<th>Qty</th>
									<th>Harga</th>
									<th>Jumlah</th>
								</tr>
							</thead>
							<tbody id="detailUraianPekerjaan">
								<tr>
									<td>No</td>
									<td>Nama</td>
									<td>Pagu</td>
									<td>Qty</td>
									<td>Harga</td>
									<td>Jumlah</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Jenis PPH</label>
					<div class="jenisPph col-9 fw-bolder" id="jenisPph">Jenis 1</div>
				</div>

				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">PPN</label>
					<div class="ppn col-9 fw-bolder" id="ppn">ppn</div>
				</div>

				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Sumber Dana</label>
					<div class="sumberDanaNama col-9 fw-bolder" id="sumberDanaNama">Sumber Dana</div>
				</div>

				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Jenis Kontrak</label>
					<div class="jenisKontrak col-9 fw-bolder" id="jenisKontrak">Jenis Kontrak</div>
				</div>
				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Tahun Anggaran</label>
					<div class="tahunAnggaran col-9 fw-bolder" id="tahunAnggaran">Tahun Anggaran</div>
				</div>
				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">No Surat Undangan</label>
					<div class="suratUndanganNo col-9 fw-bolder" id="suratUndanganNo">No Surat Undangan</div>
				</div>
				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Tgl Surat Undangan</label>
					<div class="suratUndanganTgl col-9 fw-bolder" id="suratUndanganTgl">Tgl Surat Undangan</div>
				</div>
				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">No Surat Penunjukan</label>
					<div class="suratPenunjukanNo col-9 fw-bolder" id="suratPenunjukanNo">No Surat Penunjukan</div>
				</div>
				<div class="fv-row row mb-5">
					<label for="" class="form-label col-3">Tgl Surat Penunjukan</label>
					<div class="suratPenunjukanTgl col-9 fw-bolder" id="suratPenunjukanTgl">Tgl Surat Penunjukan</div>
				</div>
			</div>

			<div class="col-12">
				<div class="mb-10">
					<h5 class="fw-bolder mb-5">Pejabat Pembuat Kontrak</h5>

					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Nama</label>
						<div class="col-9 fw-bolder" id="user_name">Contoh Nama Pejabat</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">NIP</label>
						<div class="col-9 fw-bolder" id="user_code">Contoh NIP Pejabat</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Jabatan</label>
						<div class="col-9 fw-bolder" id="jabatan_name">Contoh Jabatan</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Alamat</label>
						<div class="col-9 fw-bolder" id="user_address">Contoh Alamat Pejabat</div>
					</div>
				</div>
				<div class="">
					<h5 class="fw-bolder mb-5">Data Rekanan</h5>

					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Nama</label>
						<div class="rekanan_nama col-9 fw-bolder" id="rekanan_nama">Contoh Nama</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Nama Perusahaan</label>
						<div class="rekanan_nama_perusahaan col-9 fw-bolder" id="rekanan_nama_perusahaan">Contoh Nama Perusahaan</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Alamat</label>
						<div class="rekanan_alamat col-9 fw-bolder" id="rekanan_alamat">Contoh Alamat</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Kota</label>
						<div class="rekanan_kota col-9 fw-bolder" id="rekanan_kota">Contoh Kota</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Jabatan</label>
						<div class="rekanan_jabatan col-9 fw-bolder" id="rekanan_jabatan">Contoh Jabatan</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">NPWP</label>
						<div class="rekanan_npwp col-9 fw-bolder" id="rekanan_npwp">Contoh NPWP</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Akte</label>
						<div class="rekanan_akte col-9 fw-bolder" id="rekanan_akte">Contoh Akte</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Tgl Akte</label>
						<div class="rekanan_tgl_akte col-9 fw-bolder" id="rekanan_tgl_akte">Contoh Tgl Akte</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Pembuat Akte</label>
						<div class="rekanan_pembuat_akte col-9 fw-bolder" id="rekanan_pembuat_akte">Contoh Pembuat Akte</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Telepon</label>
						<div class="rekanan_telepon col-9 fw-bolder" id="rekanan_telepon">Contoh Telepon</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Email</label>
						<div class="rekanan_email col-9 fw-bolder" id="rekanan_email">Contoh Email</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Bank</label>
						<div class="rekanan_bank col-9 fw-bolder" id="rekanan_bank">Contoh Bank</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label col-3">Rekening</label>
						<div class="rekanan_rekening col-9 fw-bolder" id="rekanan_rekening">Contoh Rekening</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card shadow-sm mt-10">
	<div class="card-header d-flex justify-content-between py-10">
		<h3 class="fw-bolder m-0 align-self-center">Daftar Dokumen Proyek</h3>
		<button type="button" class="btn btn-danger btn-sm align-self-center" data-bs-toggle="modal" data-bs-target="#addNewTermynModal">
			Tambah Termyn
		</button>
	</div>
	<div class="card-body p-0" id="detailDokumen">

	</div>
</div>


<div class="modal fade" tabindex="-1" id="addNewTermynModal">
	<div class="modal-dialog">
		<form class="modal-content" action="javascript:newTermyn()" method="post" id="formNewTermyn" name="formNewTermyn" autocomplete="off" enctype="multipart/form-data">
			<div class="modal-header">
				<h3 class="modal-title">Modal Tambah Termyn</h3>

				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
					<span class="svg-icon svg-icon-1"></span>
				</div>
			</div>

			<div class="modal-body">
				<div class="fv-row row mb-5">
					<label for="" class="required form-label">Jenis Termyn</label>
					<div class="col-12">
						<select name="newTermynJenisTermyn" id="newTermynJenisTermyn" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Pilih Jenis Termyn"></select>
					</div>
				</div>
				<div id="daftarTermynContainer">
					<label for="" class="m-0 form-label">Daftar Termyn</label><br>

				</div>
				<br>
				<div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label">Nominal Pembayaran (Rp <span id="nominalPembayaranLabel"></span>)</label>
						<div class="col-12">
							<input type="hidden" name="nominalPembayaranTotal" id="nominalPembayaranTotal" />
							<input type="number" min="0" onkeyup="calculatePembayaran(1)" name="nominalPembayaran" id="nominalPembayaran" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nominal Pembayaran" />
						</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="form-label">Persentase Pembayaran</label>
						<div class="col-12">
							<input type="number" min="0" onkeyup="calculatePembayaran(0)" max="100" id="persentasePembayaran" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Persentase Pembayaran" />
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-sm btn-danger">Tambah</button>
			</div>
		</form>
	</div>
</div>