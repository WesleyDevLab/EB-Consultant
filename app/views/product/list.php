<?php echo View::make('header'); ?>

<div class="page-header">
	<h2 class="text-center">私募<?=Input::query('type') === 'account' ? '专户' : '产品'?>列表</h2>
</div>

<?php if($weixin->account !== 'news'){ ?>
<a href="<?=url('product/create?type=' . Input::query('type'))?>" class="btn btn-primary btn-block btn-lg">登记新<?=Input::query('type') === 'account' ? '专户' : '产品'?></a>
<hr>
<?php } ?>
<table class="table table-striped">
	<?php foreach($products as $product){ ?>
	<tr role="presentation">
		<td>
			<h4><?=$product->name?> <span class="small"><?=$product->type?>
			<?php if($user && ($user->id === $product->consultant_id || $user->is_admin) && in_array($product->type, array('单账户', '伞型'))){?> <?=$product->clients->first()->name?><?php } ?></span></h4>
		</td>
		<?php if($weixin->account !== 'news'){ ?>
		<td>
			<a href="<?=url('product/' . $product->id)?>" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> 资料</a>
		</td>
		<?php } ?>
		<?php if(Input::get('action') !== 'make-report'){ ?>
		<td>
			<a href="<?=url('product/' . $product->id . '/quote')?>" class="btn btn-default">查看净值 <?=$product->quotes->last()->value?></a>
		</td>
		<?php } ?>
		<?php if(Input::get('action') === 'make-report' && ($user instanceof Consultant || $user->is_admin)){ ?>
		<td>
			<a href="<?=url('product/' . $product->id . '/quote/create')?>" class="btn btn-default"><span class="glyphicon glyphicon-usd"></span> 净值报告</a>
		</td>
		<?php } ?>
	</tr>
	<?php } ?>
</table>

<?php echo View::make('footer'); ?>
