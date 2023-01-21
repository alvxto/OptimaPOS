<div class="row" data-roleable="false" data-role="DokumenMaster-Read">


	<div class="col-xl-12">
		<div class="card card-bordered">
			<div class="card-body">
				<?= loadView('BackEnd/DokumenMaster/Views/form') ?>

				<div class="table-responsive" id="tableDokumenMasterContainer">
					<table class="table table-striped table-row-bordered border align-middle rounded tdFirstCenter" id="tableDokumenMaster">
						<thead>
							<tr class="fw-bolder text-muted bg-light">
								<th class="ps-4" width="20">No</th>
								<th width="50">Kode</th>
								<th>Nama</th>
								<th>Tipe</th>
								<th>status</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

				</div>
			</div>
		</div>
	</div>

</div>

<?= loadView('BackEnd/DokumenMaster/Views', ['javascript']) ?>