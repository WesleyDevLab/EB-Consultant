<?php echo View::make('header'); ?>

<div class="page-header">
	<h2 class="text-center">私募<?php if($consultant->is_administrated){ ?><?=$consultant->name?>的<?php } ?>客户产品</h2>
</div>

<?php if(!$consultant->is_administrated){ ?>
<a href="<?=url('register-client')?>" class="btn btn-primary btn-block">登记新客户产品</a>
<hr>
<?php } ?>

<table class="table table-striped">
	<?php foreach($products as $product){ ?>
	<tr role="presentation">
		<td>
			<h4><?=$product->name?> <span class="small"><?=$product->type?></span></h4>
		</td>
		<td>
			<a href="<?=url('view-report/' . $product->id)?>" class="btn btn-default"><span class="glyphicon glyphicon-stats"></span> 报告</a>
		</td>
		<td>
			<a href="<?=url('view-client/' . $product->id)?>" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> 资料</a>
		</td>
	</tr>
	<?php } ?>
</table>

<?php echo View::make('footer'); ?>
