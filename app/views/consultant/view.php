<?php echo View::make('header'); ?>

<div class="page-header">
	<h2 class="text-center">私募投顾注册</h2>
</div>

<h3>私募类型</h3>
<p><?=$consultant->type?></p>
<h3>全称</h3>
<p><?=$consultant->name?></p>
<h3>注册地</h3>
<p><?=$consultant->meta->注册地?></p>
<h3>基金经理介绍</h3>
<p><?=$consultant->meta->基金经理介绍?></p>
<h3>投资风格和策略</h3>
<p><?=$consultant->meta->投资风格和策略?></p>

<?php echo View::make('footer'); ?>
