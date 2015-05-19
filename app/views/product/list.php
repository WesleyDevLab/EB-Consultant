<?php echo View::make('header'); ?>

<div class="page-header">
	<h2 class="text-center">私募产品列表</h2>
</div>

<table class="table table-striped">
	<?php foreach($products as $product){ ?>
	<tr role="presentation">
		<td>
			<h4><?=$product->name?> <span class="small"><?=$product->type?></span></h4>
		</td>
		<td>
			<a href="<?=url('view-product/' . $product->id)?>" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> 资料</a>
		</td>
		<td>
			<a href="<?=url('view-report/' . $product->id)?>" class="btn btn-default"><span class="glyphicon glyphicon-usd"></span> 报告</a>
		</td>
	</tr>
	<?php } ?>
</table>

<?php echo View::make('footer'); ?>
