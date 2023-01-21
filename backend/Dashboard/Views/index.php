<div class="row" data-roleable="false" data-role="Bank-Read">
	<div class="col-12 col-lg-6 p-0">
		<div class="card shadow-sm rounded-3 m-7">
			<div class="card-body">
				<div class="d-flex justify-content-between mb-7">
					<h2 class="text-gray-700 fw-bold m-0"><i class="las la-cube fs-1 p-1 rounded-3 bg-light-primary" style="color: #1AA37A;"></i> Total Paket Pekerjaan</h2>
					<a href="#" class="align-self-center" onclick="onPaket()"><i class="las la-arrow-circle-right fs-1 text-gray-800"></i></a>
				</div>
				<div class="d-flex mb-1">
					<h1 class="mb-0 me-2 fs-1 text-gray-900" id="totalPekerjaan"></h1>
					<span class="text-gray-500 fs-7 align-self-end">Paket Pekerjaan</span>
				</div>
				<div class="d-flex fw-bold">
					<i class="las la-arrow-circle-up fs-1 align-self-center me-2" style="color: #1AA37A;"></i>
					<p class="mt-1 mb-0 align-self-center" style="color: #1AA37A;"> + <span id="totalPekerjaanOneLastWeek"></span> Paket Pekerjaan Dalam 7 Hari</p>
				</div>
			</div>
		</div>
		<div class="card shadow-sm rounded-3 m-7">
			<div class="card-body">
				<div class="d-flex justify-content-between mb-7">
					<h2 class="text-gray-700 fw-bold m-0"><i class="las la-cube fs-1 p-1 rounded-3 bg-light-primary" style="color: #1AA37A;"></i> Total Dokumen</h2>
					<a href="#" class="align-self-center" onclick="onDokumen()"><i class="las la-arrow-circle-right fs-1 text-gray-800"></i></a>
				</div>
				<div class="d-flex mb-1">
					<h1 class="mb-0 me-2 fs-1 text-gray-900" id="totalDokument"></h1>
					<span class="text-gray-500 fs-7 align-self-end">Dokumen</span>
				</div>
				<div class="d-flex fw-bold">
					<i class="las la-arrow-circle-up fs-1 align-self-center me-2" style="color: #1AA37A;"></i>
					<p class="mt-1 mb-0 align-self-center" style="color: #1AA37A;"> +<span id="totalDokumentOneLastWeek"></span> Paket Dokumen 7 Hari</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-6 p-0">
		<div class="card shadow-sm rounded-3 m-7 ">
			<div class="card-body">
				<h3>Persentase Dokumen</h3>
				<div id="kt_amcharts_3" style="height: 250px;"></div>
			</div>
		</div>
	</div>


</div>

<?= loadView('BackEnd/Dashboard/Views', ['javascript']) ?>