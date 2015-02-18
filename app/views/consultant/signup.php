<?php echo View::make('header'); ?>

<div class="page-header">
	<h2 class="text-center">私募投顾注册</h2>
</div>
<form class="form-horizontal" role="form" method="post">
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<div class="btn-group btn-block" data-toggle="buttons">
				<label class="btn btn-default col-xs-6<?php if($consultant->type === '机构'){ ?> active<?php } ?>">
					<?=Form::radio('type', '机构', @$consultant->type === '机构', array('required'))?>
					机构
				</label>
				<label class="btn btn-default col-xs-6<?php if($consultant->type === '个人'){ ?> active<?php } ?>">
					<?=Form::radio('type', '个人', @$consultant->type === '个人', array('required'))?>
					个人
				</label>
			</div>
		</div>
	</div>
	<fieldset id="entity"<?php if($consultant->type !== '机构'){ ?> style="display:none"<?php } ?>>
		<div class="form-group">
			<label class="control-label col-sm-2">公司全称*</label>
			<div class="col-sm-10">
				<input type="text" name="name" value="<?=@$consultant->name?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">注册地*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[注册地]" value="<?=@$consultant->meta->注册地?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">投研团队人数*</label>
			<div class="col-sm-10">
				<input type="number" step="1" name="meta[投研团队人数]" value="<?=@$consultant->meta->投研团队人数?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">管理资金规模*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[管理资金规模]" value="<?=@$consultant->meta->管理资金规模?>" required class="form-control">
					<div class="input-group-addon">万元</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">管理的产品与专户数量*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" step="1" name="meta[管理的产品与专户数量]" value="<?=@$consultant->meta->管理的产品与专户数量?>" required class="form-control">
					<div class="input-group-addon">个</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年平均收益率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[近三年平均收益率]" value="<?=@$consultant->meta->近三年平均收益率?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年最大回撤*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">-</div>
					<input type="number" name="meta[近三年最大回撤]" value="<?=@$consultant->meta->近三年最大回撤?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">最优的三个产品名称、规模、累计净值*</label>
			<div class="col-sm-10">
				<p><input type="text" name="meta[最优的三个产品][0][名称]" value="<?=@$consultant->meta->最优的三个产品[0]->名称?>" placeholder="名称" required class="form-control"></p>
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[最优的三个产品][0][规模]" value="<?=@$consultant->meta->最优的三个产品[0]->规模?>" placeholder="规模" required class="form-control">
					<div class="input-group-addon">万元</div>
					<input type="number" name="meta[最优的三个产品][0][累计净值]" value="<?=@$consultant->meta->最优的三个产品[0]->累计净值?>" placeholder="累计净值" required class="form-control">
				</div>
				<br>
				<p><input type="text" name="meta[最优的三个产品][1][名称]" value="<?=@$consultant->meta->最优的三个产品[1]->名称?>" placeholder="名称" required class="form-control"></p>
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[最优的三个产品][1][规模]" value="<?=@$consultant->meta->最优的三个产品[1]->规模?>" placeholder="规模" required class="form-control">
					<div class="input-group-addon">万元</div>
					<input type="number" name="meta[最优的三个产品][1][累计净值]" value="<?=@$consultant->meta->最优的三个产品[1]->累计净值?>" placeholder="累计净值" required class="form-control">
				</div>
				<br>
				<p><input type="text" name="meta[最优的三个产品][2][名称]" value="<?=@$consultant->meta->最优的三个产品[2]->名称?>" placeholder="名称" required class="form-control"></p>
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[最优的三个产品][2][规模]" value="<?=@$consultant->meta->最优的三个产品[2]->规模?>" placeholder="规模" required class="form-control">
					<div class="input-group-addon">万元</div>
					<input type="number" name="meta[最优的三个产品][2][累计净值]" value="<?=@$consultant->meta->最优的三个产品[2]->累计净值?>" placeholder="累计净值" required class="form-control">
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset id="personal"<?php if($consultant->type !== '个人'){ ?> style="display:none"<?php } ?>>
		<div class="form-group">
			<label class="control-label col-sm-2">投顾名字*</label>
			<div class="col-sm-10">
				<input type="text" name="name" value="<?=@$consultant->name?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">证券投资经验*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" step="1" name="meta[证券投资经验]" value="<?=@$consultant->meta->证券投资经验?>" required class="form-control">
					<div class="input-group-addon">年</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">管理专户数量和规模*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" step="1" name="meta[管理专户数量]" value="<?=@$consultant->meta->管理专户数量?>" required class="form-control">
					<div class="input-group-addon">个</div>
				</div>
				<br>
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" name="meta[管理专户规模]" value="<?=@$consultant->meta->管理专户规模?>" required class="form-control">
					<div class="input-group-addon">万元</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年平均收益率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[近三年平均收益率]" value="<?=@$consultant->meta->近三年平均收益率?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">近三年最大回撤*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">-</div>
					<input type="number" name="meta[近三年最大回撤]" value="<?=@$consultant->meta->近三年最大回撤?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">最优专户收益率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[最优专户收益率]" value="<?=@$consultant->meta->最优专户收益率?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">最差专户收益率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[最差专户收益率]" value="<?=@$consultant->meta->最差专户收益率?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
	</fieldset>
	<div class="form-group">
		<label class="control-label col-sm-2">投资风格和策略*</label>
		<div class="col-sm-10">
			<textarea name="meta[投资风格和策略]" required class="form-control"><?=@$consultant->meta->投资风格和策略?></textarea>
		</div>
	</div>
	<?php if(Route::getCurrentRoute()->getPath() === 'signup'){ ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<label class="checkbox-inline">
				<input type="checkbox" id="agreement" required>
				本人/本公司承诺将主动推送相关信息用于“翊弼-私募产品统计平台”的展示，并就所提供信息的真实性、有效性和自愿性负责。
			</label>
		</div>
	</div>
	<?php }elseif($consultant){ ?>
	<a href="<?=url()?>/view-client?consultant_id=<?=$consultant->id?>" class="btn btn-info btn-block btn-lg">查看客户产品</a>
	<?php } ?>
	<hr>
	<button type="submit" class="btn btn-primary btn-block btn-lg"><?=empty($consultant) ? '注册' : '更新'?></button>
</form>

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
		
		if($('[name="type"]:checked').length === 0){
			$('[name="type"]:first').prop('checked', true);
		}
		
		$('[name="type"]:checked').trigger('change').parent('label').addClass('active');
		
		$('form').on('submit', function(){
			if($('#agreement').length && !$('#agreement').is(':checked')){
				return false;
			}
		});
		
	});
</script>
<?php echo View::make('footer'); ?>
