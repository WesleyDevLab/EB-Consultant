<?php echo View::make('header'); ?>
<?php if(!$consultant){ ?>
<div class="page-header">
	<h2 class="text-center">私募投顾注册</h2>
</div>
<form class="form-horizontal" role="form" method="post">
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10 row">
			<div class="btn-group col-xs-12" data-toggle="buttons">
				<label class="btn btn-default col-xs-6">
					<input type="radio" name="type" value="机构" required>
					机构
				</label>
				<label class="btn btn-default col-xs-6 active">
					<input type="radio" name="type" value="个人" checked="checked" required>
					个人
				</label>
			</div>
		</div>
	</div>
	<fieldset id="entity" style="display:none">
		<div class="form-group">
			<label class="control-label col-sm-2">公司全称*</label>
			<div class="col-sm-10">
				<input type="text" name="name" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">注册地*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[注册地]" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">投研团队人数*</label>
			<div class="col-sm-10">
				<input type="number" step="1" name="meta[投研团队人数]" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">管理资金规模*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[管理资金规模]" required class="form-control">
					<div class="input-group-addon">万元</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">管理的产品与专户数量*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" step="1" name="meta[管理的产品与专户数量]" required class="form-control">
					<div class="input-group-addon">个</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年平均收益率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[近三年平均收益率]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年最大回撤*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">-</div>
					<input type="number" name="meta[近三年最大回撤]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">最优的三个产品名称、规模、累计净值*</label>
			<div class="col-sm-10">
				<p><input type="text" name="meta[最优的三个产品][0][名称]" placeholder="名称" required class="form-control"></p>
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[最优的三个产品][0][规模]" placeholder="规模" required class="form-control">
					<div class="input-group-addon">万元</div>
					<input type="number" name="meta[最优的三个产品][0][累计净值]" placeholder="累计净值" required class="form-control">
				</div>
				<br>
				<p><input type="text" name="meta[最优的三个产品][1][名称]" placeholder="名称" required class="form-control"></p>
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[最优的三个产品][1][规模]" placeholder="规模" required class="form-control">
					<div class="input-group-addon">万元</div>
					<input type="number" name="meta[最优的三个产品][1][累计净值]" placeholder="累计净值" required class="form-control">
				</div>
				<br>
				<p><input type="text" name="meta[最优的三个产品][2][名称]" placeholder="名称" required class="form-control"></p>
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[最优的三个产品][2][规模]" placeholder="规模" required class="form-control">
					<div class="input-group-addon">万元</div>
					<input type="number" name="meta[最优的三个产品][2][累计净值]" placeholder="累计净值" required class="form-control">
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset id="personal">
		<div class="form-group">
			<label class="control-label col-sm-2">投顾名字*</label>
			<div class="col-sm-10">
				<input type="text" name="name" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">证券投资经验*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" step="1" name="meta[证券投资经验]" required class="form-control">
					<div class="input-group-addon">年</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">管理专户数量和规模*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" step="1" name="meta[管理专户数量]" required class="form-control">
					<div class="input-group-addon">个</div>
				</div>
				<br>
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[管理专户规模]" required class="form-control">
					<div class="input-group-addon">万元</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年平均收益率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[近三年平均收益率]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年最大回撤*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">-</div>
					<input type="number" name="meta[近三年最大回撤]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">最优专户收益率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[最优专户收益率]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">最差专户收益率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[最差专户收益率]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
	</fieldset>
	<div class="form-group">
		<label class="control-label col-sm-2">投资风格和策略*</label>
		<div class="col-sm-10">
			<textarea name="meta[投资风格和策略]" required class="form-control"></textarea>
		</div>
	</div>
	<button type="submit" class="btn btn-primary btn-block btn-lg">注册</button>
</form>
<?php }else{ ?>
<div class="alert alert-info">您已经注册为 <?=$consultant->name?></div>
<?php } ?>
<script type="text/javascript">
	jQuery(function($){
		
		$('[name="type"]').on('change', function(){
			if($(this).val() === '机构'){
				$('#entity').trigger('enable');
				$('#personal').trigger('disable');
			}else{
				$('#entity').trigger('disable');
				$('#personal').trigger('enable');
			}
		});
		
		$('[name="type"]:checked').trigger('change');
		
	});
</script>
<?php echo View::make('footer'); ?>
