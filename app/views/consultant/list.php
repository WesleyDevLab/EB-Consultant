<?php echo View::make('header'); ?>

<div class="page-header">
	<h2 class="text-center">私募投顾列表</h2>
</div>
<a href="<?=url('register-client')?>" class="btn btn-primary btn-block">登记新投顾</a>
<hr>
<ul class="nav nav-pills nav-stacked">
	<?php foreach($consultants as $consultant){ ?>
	<li role="presentation"><a href="<?=url('view-consultant/' . $consultant->id)?>"><?=$consultant->name?>, <?=$consultant->type?></li>
	<?php } ?>
</ul>

<?php echo View::make('footer'); ?>
