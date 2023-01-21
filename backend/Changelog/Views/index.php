<div class="row" data-roleable="false" data-role="Changelog-Read">
	<div class="col-xl-12 mb-5 dataIndex">
		<div class="card card-xl-stretch mb-xl-8">
			
			<div class="card-header border-0 pt-5">
				<div class="card-toolbar">
					<a href="javascript:;" onclick="onAdd(this)" class="btn btn-sm btn-primary" data-roleable="false" data-role="Changelog-Create">
						<i class="las la-plus fs-2"></i>
						Add Log
					</a>
				</div>
			</div>
			
			<div class="card-body">
				<div class="timeline" id="viewListLogs"></div>
			</div>
		</div>
	</div>
</div>

<?= 
	loadView('BackEnd/Changelog/Views',[
		'form',
		'detail',
		'javascript'
	]);
?>