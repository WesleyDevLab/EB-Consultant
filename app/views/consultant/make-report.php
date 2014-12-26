<?php echo View::make('header'); ?>
<div class="page-header">
	<h2 class="text-center">净值报告</h2>
</div>
<?php if(isset($product)){ ?>
<form class="form-horizontal" role="form" method="post">
	<div class="form-group">
		<label class="control-label col-sm-2">日期</label>
		<div class="col-sm-10">
			<input type="date" name="date" value="<?=date('Y-m-d')?>" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">市值</label>
		<div class="col-sm-10">
			<div class="input-group">
				<div class="input-group-addon">人民币</div>
				<input type="number" step="0.01" min="0" name="cap" class="form-control">
				<div class="input-group-addon">元</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">备注</label>
		<div class="col-sm-10">
			<textarea name="comments" class="form-control"></textarea>
		</div>
	</div>
	<button type="submit" class="btn btn-primary btn-lg btn-block">提交</button>
</form>
<?php } else{ ?>
<ul class="nav nav-pills nav-stacked">
	<?php foreach($products as $product){ ?>
	<li role="presentation"><a href="<?=url('make-report/' . $product->id)?>"><?=$product->name?>, <?=$product->type?></li>
	<?php } ?>
</ul>
<?php } ?>
<?php echo View::make('footer'); ?>
