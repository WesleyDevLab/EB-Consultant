<?php echo View::make('header'); ?>
<?php if(!$consultant){ ?>
<h1 class="text-center">私募投顾注册</h1>
<form class="form-horizontal" role="form" method="post">
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<label class="radio-inline">
				<input type="radio" name="type" value="机构">
				机构
			</label>
			<label class="radio-inline">
				<input type="radio" name="type" value="个人" checked="checked">
				个人
			</label>
		</div>
	</div>
	<fieldset id="entity" style="display:none" disabled="disabled">
		<div class="form-group">
			<label class="control-label col-sm-2">公司全称</label>
			<div class="col-sm-10">
				<input type="text" name="name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">注册地</label>
			<div class="col-sm-10">
				<input type="text" name="meta[注册地]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">投研团队人数</label>
			<div class="col-sm-10">
				<input type="text" name="meta[投研团队人数]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">管理资金规模</label>
			<div class="col-sm-10">
				<input type="text" name="meta[管理资金规模]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">管理的产品与专户数量</label>
			<div class="col-sm-10">
				<input type="text" name="meta[管理的产品与专户数量]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年平均收益率</label>
			<div class="col-sm-10">
				<input type="text" name="meta[近三年平均收益率]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年最大回撤</label>
			<div class="col-sm-10">
				<input type="text" name="meta[近三年最大回撤]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">最优的三个产品名称、规模、累计净值</label>
			<div class="col-sm-10">
				<input type="text" name="meta[最优的三个产品名称、规模、累计净值]" class="form-control">
			</div>
		</div>
	</fieldset>
	<fieldset id="personal">
		<div class="form-group">
			<label class="control-label col-sm-2">投顾名字</label>
			<div class="col-sm-10">
				<input type="text" name="name" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">证券投资经验</label>
			<div class="col-sm-10">
				<input type="text" name="meta[证券投资经验]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">管理专户数量和规模</label>
			<div class="col-sm-10">
				<input type="text" name="meta[管理专户数量和规模]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年平均收益率</label>
			<div class="col-sm-10">
				<input type="text" name="meta[近三年平均收益率]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年最大回撤</label>
			<div class="col-sm-10">
				<input type="text" name="meta[近三年最大回撤]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">最优和最差的专户收益率和最大回撤</label>
			<div class="col-sm-10">
				<input type="text" name="meta[最优和最差的专户收益率和最大回撤]" class="form-control">
			</div>
		</div>
	</fieldset>
	<button type="submit" class="btn btn-primary btn-block btn-lg">注册</button>
</form>
<?php }else{ ?>
<div class="alert alert-info">您已经注册为 <?=$consultant->name?></div>
<?php } ?>
<script type="text/javascript">
	jQuery(function($){
		$('[name="type"]').on('change', function(){
			if($(this).val() === '机构'){
				$('#entity').prop('disabled', false).show();
				$('#personal').prop('disabled', true).hide();
			}else{
				$('#entity').prop('disabled', true).hide();
				$('#personal').prop('disabled', false).show();
			}
		});
	});
</script>
<?php echo View::make('footer'); ?>
