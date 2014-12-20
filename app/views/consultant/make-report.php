<?php echo View::make('header'); ?>
<h1>净值报告</h1>
<?php if(isset($product)){ ?>
<form class="form-horizontal" role="form" method="post">
	<div class="form-group">
		<label class="control-label col-sm-2">日期</label>
		<div class="col-sm-10">
			<input type="date" name="date" value="<?=date('Y-m-d')?>" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">净值</label>
		<div class="col-sm-10">
			<input type="number" step="0.01" name="value" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">备注</label>
		<div class="col-sm-10">
			<textarea name="comments" class="form-control"></textarea>
		</div>
	</div>
	<button type="submit" class="btn btn-primary">提交</button>
</form>
<?php } else{ ?>
<ul class="nav nav-pills nav-stacked">
	<?php foreach($products as $product){ ?>
	<li role="presentation"><a href="<?=url('make-report/' . $product->id)?>"><?=$product->name?>, <?=$product->type?></li>
	<?php } ?>
</ul>
<?php } ?>
<?php echo View::make('footer'); ?>
