<div class="row" data-roleable="false" data-role="Pejabat-Read">

	<div class="col-xl-5">
		<?= loadView('BackEnd/Pejabat/Views/form') ?>
	</div>

	<div class="col-xl-7">
		<div class="card card-bordered">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-row-bordered border align-middle rounded tdFirstCenter" id="tablePejabat">
						<thead>
							<tr class="fw-bolder text-muted bg-light">
								<th class="ps-4" width="20">No</th>
								<th width="50">Nip</th>
								<th>Nama</th>
								<th>Jabatan</th>
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

<?= loadView('BackEnd/Pejabat/Views', ['javascript']) ?>