<div class="modal fade" tabindex="-1" id="modalDataTambahan">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <form class="modal-content" action="javascript:;" method="post" id="form_data_tambahan" name="form_data_tambahan" autocomplete="off" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Form Data Tambahan</h5>

                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
            </div>

            <div class="modal-body">
                <div class="fv-row row mb-5">
                    <label for="" class="required form-label text-capitalize" id="nomorDokumenLabel">Nomor Dokumen</label>
                    <div class="col-12">
                        <input type="text" name="nomor" class="form-control form-control-sm form-control-solid" placeholder="Masukkan Nomor Dokumen" required />
                    </div>
                </div>
                <div class="fv-row row mb-5">
                    <label for="" class="required form-label text-capitalize" id="tanggalDokumenLabel">Tanggal Dokumen</label>
                    <div class="col-12">
                        <input class="form-control form-control-solid form-control-sm" placeholder="Tanggal Dokumen" id="tanggalDokumen" name="tanggal" />
                    </div>
                </div>
                <div class="fv-row row mb-5 d-none spmkOnly">
                    <label for="" class="form-label">Tanggal SPMK (<span id="spmkDifDay"> - Hari</span>) </label>
                    <div class="col-12">
                        <input class="form-control form-control-solid form-control-sm" placeholder="Tanggal SPMK" id="tanggalSPMK" name="tanggalSPMK" />
                    </div>
                </div>
                <div class="fv-row row mb-5 d-none spOnly">
                    <label for="" class="form-label">Dokumen SSK</label>
                    <div class="col">
                        <input type="file" class="form-control form-control-solid form-control-sm" placeholder="Dokumen SSK" id="kontrakSSk" name="kontrakSSk" />
                    </div>
                    <div class="col-1 d-none" id="kontrakSSkDownload">
                        <a href="#" download="" class="btn btn-sm btn-success text-center fw-bolder"><i class="las la-download"></i></a>
                    </div>
                </div>
                <div class="fv-row row mb-5 d-none spOnly">
                    <label for="" class="form-label">Dokumen SSUK</label>
                    <div class="col">
                        <input type="file" class="form-control form-control-solid form-control-sm" placeholder="Dokumen SSUK" id="kontrakSSUk" name="kontrakSSUk" />
                    </div>
                    <div class="col-1 d-none" id="kontrakSSUkDownload">
                        <a href="#" download="" class="btn btn-sm btn-success text-center fw-bolder"><i class="las la-download"></i></a>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Buat Dokumen</button>
            </div>
        </form>
    </div>
</div>