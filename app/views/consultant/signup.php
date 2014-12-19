<?php echo View::make('header'); ?>
<h1>私募投顾注册</h1>
<form class="form-horizontal" role="form" method="post">
	<div class="form-group">
		<label class="control-label col-sm-2">名称</label>
		<div class="col-sm-10">
			<input name="name" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">简介</label>
		<div class="col-sm-10">
			<textarea name="description" class="form-control"></textarea>
		</div>
	</div>
	<button type="submit" class="btn btn-primary">注册</button>
</form>
<?php echo View::make('footer'); ?>
