<script type="text/javascript">
	$(() => {
		HELPER.fields = ['id'];
		HELPER.api = {
			getData: APP_URL + 'dashboard/getData',
		};
		index();
	});

	index = async () => {
		await getData();
		await HELPER.unblock(100);
	}

	getData = () => {
		return new Promise((resolve) => {
			HELPER.ajax({
				url: HELPER.api.getData,
				success: (response) => {
					$.each(response, (i,v) => {
						$('#'+i).html(v);
					});
					createChartDokument(response.chartDokument);
					resolve(true);
				}
			})
		});
	}

	createChartDokument = (dataXY) => {
		am5.ready(function() {
			var root = am5.Root.new("kt_amcharts_3");
			root.setThemes([
				am5themes_Animated.new(root)
			]);

			var chart = root.container.children.push(
				am5percent.PieChart.new(root, {
					endAngle: 270
				})
			);

			var series = chart.series.push(
				am5percent.PieSeries.new(root, {
					valueField: "value",
					categoryField: "category",
					endAngle: 270
				})
			);

			series.states.create("hidden", {
				endAngle: 0
			});

			series.data.setAll(dataXY);

			series.appear(1000, 100);

		});
	}
	onPaket = () => {
		$('[data-con="mms9mjrsvdbcucg6"]').trigger('click')
	}

	onDokumen = () => {
		$('[data-con="edre61plejjxhyjz"]').trigger('click')
	}
</script>