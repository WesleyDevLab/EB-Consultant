<?php echo View::make('header'); ?>

<div class="page-header">
	<h2 class="text-center">私募产品列表</h2>
</div>

<?php if($mp !== 'news'){ ?>
<a href="<?=url('product/create')?>" class="btn btn-primary btn-block btn-lg">登记新产品</a>
<hr>
<?php } ?>
<table class="table table-striped">
	<?php foreach($products as $product){ ?>
	<tr role="presentation">
		<td>
			<h4><?=$product->name?> <span class="small"><?=$product->type?></span></h4>
		</td>
		<?php if($mp !== 'news'){ ?>
		<td>
			<a href="<?=url('product/' . $product->id)?>" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> 资料</a>
		</td>
		<?php } ?>
		<td>
			<a href="<?=url('product/' . $product->id . '/quote')?>" class="btn btn-default"><span class="glyphicon glyphicon-usd"></span> 查看净值</a>
		</td>
		<?php if(Input::get('action') === 'make-report' && $user instanceof Consultant){ ?>
		<td>
			<a href="<?=url('product/' . $product->id . '/quote/create')?>" class="btn btn-default"><span class="glyphicon glyphicon-usd"></span> 净值报告</a>
		</td>
		<?php } ?>
	</tr>
	<?php } ?>
</table>

<?php echo View::make('footer'); ?>
