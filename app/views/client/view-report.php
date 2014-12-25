<?php echo View::make('header'); ?>
<div class="page-header">
	<h2 class="text-center">净值报告</h2>
</div>
<ul class="list-unstyled">
	<?php foreach($products as $product){ ?>
	<li>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>日期</th>
					<th>本账户</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($product->quotes()->dateAscending()->get() as $quote){ ?>
				<tr>
					<td><?=$quote->date->toDateString()?></td>
					<td><?=$quote->value?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</li>
	<?php } ?>
</ul>
<div id="chart"></div>
<script type="text/javascript" src="<?=url()?>/packages/highstock-release/highstock.js"></script>
<script type="text/javascript">
	jQuery(function($){
		$('#chart').highcharts('StockChart', {
			 
			series: [{
				name: '本账户',
				data: <?=json_encode($chartData[$products[0]->id])?>,
				tooltip: {
					valueDecimals: 2
				}
			},{
				name: '沪深300指数',
				data: <?=json_encode($chartData['sh300'])?>,
				tooltip: {
					valueDecimals: 2
				}
			}],
		
			rangeSelector: {
				selected: 1
			},

			yAxis: {
				labels: {
					formatter: function () {
						return (this.value > 0 ? ' + ' : '') + this.value + '%';
					}
				},
				plotLines: [{
					value: 0,
					width: 2,
					color: 'silver'
				}]
			},

			plotOptions: {
				series: {
					compare: 'percent'
				}
			},
			tooltip: {
				pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
				valueDecimals: 2
			}
		});
	});
</script>
<?php echo View::make('footer'); ?>
