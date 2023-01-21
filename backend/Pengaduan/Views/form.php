<form action="javascript:onSave()" method="post" id="formPekerjaan" name="formPekerjaan" autocomplete="off" enctype="multipart/form-data">
	<div class="card shadow-sm">
		<div class="card-body">
			<input type="hidden" name="id" id="id">

			<div class="row">
				<div class="col-12 col-lg-12">
					<h3 class="fw-bolder mb-5">Data Paket</h3>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Nama Paket</label>
						<div class="col-12">
							<input type="text" name="name" id="name" aliases="Nama Paket" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Name Paket" required />
						</div>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Program</label>
						<select name="programId" id="programId" aliases="Program" onchange="setKegiatan()" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Select Program"></select>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Kegiatan</label>
						<select name="kegiatanId" id="kegiatanId" onchange="setKegiatanSub()" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Select Kegiatan"></select>
					</div>

					<div class="fv-row mb-5">
						<label for="" class="form-label">Sub Kegiatan</label>
						<select name="kegiatanSubId" id="kegiatanSubId" aliases="kegiatan sub" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Select Sub Kegiatan"></select>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="form-label">PPN</label>
						<div class="col-12">
							<input type="number" value="11" readonly id="ppnView" class="form-control form-control-sm form-control-solid" />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Jenis PPH</label>
						<div class="col-12">
							<select name="jenisPphId" id="jenisPphId" aliases="Jenis PPH" onchange="calcTotalHarga()" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Select Jenis PPH" required></select>
						</div>
					</div>

					<div class="fv-row row mb-10">
						<label for="" class="form-label col-12">
							Detail Uraian Pekerjaan
						</label>

						<label class="col-3 px-6 py-3 fw-bold">Nama Pekerjaan</label>
						<label class="col-2 px-6 py-3 fw-bold">Qty</label>
						<label class="col-2 px-6 py-3 fw-bold">Satuan</label>
						<label class="col-2 px-6 py-3 fw-bold">Harga</label>
						<label class="col-2 px-6 py-3 fw-bold">Pagu</label>
						<div class="col-12" id="uraianPekerjaanContainer">

						</div>

						<button type="button" onclick="addUraianPekerjaan()" class="btn btn-sm btn-primary col-3 ms-3 mt-3 fs-9">Tambah Pekerjaan</button>
						<div class="col-12 px-3 py-3 form-check form-check-sm form-check-custom form-check-solid">
							<input class="form-check-input" type="checkbox" disabled="disabled" value="1" name="isIncludePpn" id="isIncludePpn" onchange="calcTotalHarga()" checked="checked" />
							<label class="form-check-label" for="isIncludePpn">
								Sudah termasuk PPN
							</label>
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="form-label">Nilai Kontrak</label>
						<div class="col-12">
							<input type="text" readonly id="totalHargaAsli" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Total Harga Asli" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="form-label">PPN</label>
						<div class="col-12">
							<input type="text" readonly id="totalHargaPPN" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Total Harga" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="form-label">PPH</label>
						<div class="col-12">
							<input type="text" readonly id="totalHargaPPH" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Total Harga" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="form-label">+PPN, +PPH</label>
						<div class="col-12">
							<input type="text" readonly id="totalHarga" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Total Harga" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Sumber Dana</label>
						<div class="col-12">
							<select name="sumberDanaId" id="sumberDanaId" aliases="Sumber Dana" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Select Sumber Dana " required></select>
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Tahun Anggaran</label>
						<div class="col-12">
							<select name="tahunAnggaran" id="tahunAnggaran" aliases="Tahun Anggaran" class="form-select form-select-sm form-select-solid" data-placeholder="Select Tahun Anggaran " required></select>
							<!-- <input type="text" name="tahunAnggaran" id="tahunAnggaran" class="form-control form-control-sm form-control-solid" placeholder="Masukkan tahun anggaran" required /> -->
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Lokasi</label>
						<div class="col-12">
							<input type="text" name="lokasi" id="lokasi" aliases="Lokasi" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Lokasi" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Jenis Kontrak</label>
						<div class="col-12">
							<input type="text" name="jenisKontrak" id="jenisKontrak" aliases="Jenis Kontrak" class="form-control form-control-sm form-control-solid" placeholder="Masukkan jenis kontrak" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">No Surat Undangan</label>
						<div class="col-12">
							<input type="text" name="suratUndanganNo" id="suratUndanganNo" aliases="No Surat Undangan" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No Surat Undangan" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Tgl. Surat Undangan</label>
						<div class="col-12">
							<input type="text" name="suratUndanganTgl" id="suratUndanganTgl" class="form-control form-control-solid form-control-sm" placeholder="Masukkan Tgl. Surat Undangan" />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">No Surat Penunjukan</label>
						<div class="col-12">
							<input type="text" name="suratPenunjukanNo" id="suratPenunjukanNo" aliases="No Surat Penunjukan" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No Surat Penunjukan" required />
						</div>
					</div>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Tgl. Surat Penunjukan</label>
						<div class="col-12">
							<input type="text" name="suratPenunjukanTgl" id="suratPenunjukanTgl" class="form-control form-control-solid form-control-sm" placeholder="Tgl. Surat Penunjukan" />
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-12">
					<h3 class="fw-bolder mb-5">Data Pejabat</h3>

					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Pengguna Anggaran</label>
						<div class="col-12">
							<select name="pejabat[penggunaAnggaranId]" id="penggunaAnggaranId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Pilih Pengguna Anggaran" ></select>
						</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Pejabat Penatausahaan Keuangan</label>
						<div class="col-12">
							<select name="pejabat[penataUsahaKeuanganId]" id="penataUsahaKeuanganId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Pilih Pejabat Penatausahaan Keuangan" ></select>
						</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Pejabat Pembuat Komitmen</label>
						<div class="col-12">
							<select name="pejabat[pembuatKomitmenId]" id="pembuatKomitmenId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Pilih Pejabat Pembuat Komitmen" ></select>
						</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Pejabat Pelaksana Teknis</label>
						<div class="col-12">
							<select name="pejabat[pelaksanaTeknisId]" id="pelaksanaTeknisId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Pilih Pejabat Pelaksana Teknis" ></select>
						</div>
					</div>
					<div class="fv-row row mb-5">
						<label for="" class="required form-label">Bendahara Pengeluaran</label>
						<div class="col-12">
							<select name="pejabat[bendaharaPengeluaranId]" id="bendaharaPengeluaranId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Pilih Bendahara Pengeluaran" ></select>
						</div>
					</div>


					<h3 class="fw-bolder mb-5 mt-10">Data Rekanan</h3>
					<div class="row">
						<div id="selectRekanan" class="fv-row row mb-5 col-md-12">
							<label for="" class="form-label">Nama Rekanan</label>
							<div class="col-12">
								<select name="rekananId" id="rekananId" class="form-select form-select-sm form-select-solid" data-control="select2" data-allow-clear="true" data-placeholder="Select Rekanan">
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<button type="button" id="addRekanan" class="btn btn-warning btn-sm mt-8" style="display: none;">
								<i class="fas fa-plus"></i>
								tambah Baru
							</button>
						</div>
						<!-- <div id="addRekanan" class="fv-row row mb-5 col-md-1" style="display: none;">
							<label for="" class="form-label"></label>
							<div class="form-check form-check-custom form-check-solid">
								<input name="aktif" class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" />
								<label class="form-check-label" for="flexCheckChecked">
									Update Rekanan
								</label>
							</div>
						</div> -->
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-lg-6 pe-lg-10">
						<h3 class="fw-bolder mb-5">Profile Pemilik</h3>
						<input type="hidden" name="rekanan_id">

						<div class="fv-row mb-5">
							<label for="" class="required form-label">Nama</label>
							<div class="col-12">
								<input type="text" name="rekanan_nama" id="rekanan_nama" aliases="Nama Rekanan" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama" required />
							</div>
						</div>

						<div class="fv-row mb-5">
							<label for="" class="required form-label">Jabatan</label>
							<div class="col-12">
								<input type="text" name="rekanan_jabatan" id="rekanan_jabatan" aliases="Jabatan" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Jabatan" required />
							</div>
						</div>

						<div class="fv-row mb-5">
							<label for="" class="required form-label">No. NPWP</label>
							<div class="col-12">
								<input type="text" name="rekanan_npwp" id="rekanan_npwp" aliases="No. NPWP" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No. NPWP" required />
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
								<input type="text" name="rekanan_telepon" id="rekanan_telepon" aliases="Rekanan telepon" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No. Telepon" />
							</div>
						</div>

						<div class="fv-row mb-5">
							<label for="" class="form-label">Email</label>
							<div class="col-12">
								<input type="text" name="rekanan_email" id="rekanan_email" aliases="Rekanan email" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Email" />
							</div>
						</div>

						<div class="fv-row mb-5">
							<label for="" class="required form-label">No. Rekening</label>
							<div class="col-12">
								<input type="text" name="rekanan_rekening" id="rekanan_rekening" aliases="No Rekening" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No. Rekening" required />
							</div>
						</div>

						<div class="fv-row mb-5">
							<label for="" class="required form-label">Nama Bank</label>
							<div class="col-12">
								<input type="text" name="rekanan_bank" id="rekanan_bank" aliases="Nama Bank" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama Bank" required />
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-6 ps-lg-10" style="border-left: 1px solid #DEDEDE;">
						<section>

							<h3 class="fw-bolder mb-5">Profile Perusahaan</h3>

							<div class="fv-row mb-5">
								<label for="" class="required form-label">Nama Perusahaan</label>
								<div class="col-12">
									<input type="text" name="rekanan_nama_perusahaan" id="rekanan_nama_perusahaan" aliases="Nama Perusahaan" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nama Perusahaan" required />
								</div>
							</div>

							<div class="fv-row mb-5">
								<label for="" class="required form-label">Alamat</label>
								<div class="col-12">
									<textarea name="rekanan_alamat" id="rekanan_alamat" aliases="Alamat" cols="30" rows="2" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Alamat" required></textarea>
								</div>
							</div>

							<div class="fv-row mb-5">
								<label for="" class="required form-label">Kota/Kab</label>
								<div class="col-12">
									<input type="text" name="rekanan_kota" id="rekanan_kota" aliases="Kota/Kab" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Kota atau Kabupaten" required />
								</div>
							</div>
						</section>
						<section>
							<h3 class="fw-bolder mb-5 mt-10">Informasi Akte</h3>

							<div class="fv-row mb-5">
								<label for="" class="required form-label">No. Akte</label>
								<div class="col-12">
									<input type="text" name="rekanan_akte" id="rekanan_akte" aliases="No Akte" class="form-control form-control-sm form-control-solid" placeholder="Masukkan No. Akte" required />
								</div>
							</div>

							<div class="fv-row mb-5">
								<label for="" class="required form-label">Tgl Akte</label>
								<div class="col-12 input-group date" data-target-input="nearest">
									<input type=" text" class="form-control form-control-solid form-control-sm datetimepicker-input" placeholder="Tanggal Mulai" data-target="#rekanan_tgl_akte" name="rekanan_tgl_akte" id="rekanan_tgl_akte" aliases="Rekanan tgl_akte" value="<?= date('d/m/Y'); ?>" />
								</div>
							</div>

							<div class="fv-row mb-5">
								<label for="" class="required form-label">Pembuat Akte</label>
								<div class="col-12">
									<input type="text" name="rekanan_pembuat_akte" id="rekanan_pembuat_akte" aliases="Pembuat Akte" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Pembuat Akte" required />
								</div>
							</div>
						</section>
					</div>
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