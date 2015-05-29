<?php echo View::make('header'); ?>

<div class="page-header">
	<h2 class="text-center">私募产品登记</h2>
</div>
<form class="form-horizontal" role="form" method="post" action="<?=url(isset($product) ? 'product/' . $product->id : 'product')?>">
	<?php if(isset($product)){ ?><input type="hidden" name="_method" value="PUT"><?php } ?>
	<div class="form-group">
		<label class="control-label col-sm-2">名称*</label>
		<div class="col-sm-10">
			<input type="text" name="name" value="<?=@$product->name?>" required class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">类型*</label>
		<div class="col-sm-offset-2 col-sm-10">
			<div class="btn-group btn-block" data-toggle="buttons">
				<label class="btn btn-default col-xs-6<?php if(@$product->type === '单账户'){ ?> active<?php } ?>">
					<?=Form::radio('type', '单账户', @$product->type === '单账户', array('required'))?>
					单账户
				</label>
				<label class="btn btn-default col-xs-6<?php if(@$product->type === '伞型'){ ?> active<?php } ?>">
					<?=Form::radio('type', '伞型', @$product->type === '伞型', array('required'))?>
					伞型
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">投顾分成比例*</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="number" name="meta[投顾分成比例]" value="<?=@$product->meta->投顾分成比例?>" min="0" max="100" step="0.1" required class="form-control">
				<div class="input-group-addon">%</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">产品成立日期*</label>
		<div class="col-sm-10">
			<input type="date" name="start_date" value="<?=isset($product) ? $product->start_date->toDateString() : ''?>" required class="form-control">
		</div>
	</div>
	<fieldset id="single"<?php if(@$product->type !== '单账户'){ ?> style="display:none"<?php } ?>>
		<div class="form-group">
			<label class="control-label col-sm-2">起始资金规模*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" step="0.01" min="0" name="meta[起始资金规模]" value="<?=@$product->meta->起始资金规模?>" required class="form-control">
					<div class="input-group-addon">元</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">平仓线*</label>
			<div class="col-sm-10">
				<input type="number" step="0.0001" name="meta[平仓线]" value="<?=@$product->meta->平仓线?>" required class="form-control">
			</div>
		</div>
	</fieldset>
	<fieldset id="umbrella-account"<?php if(@$product->type !== '伞型'){ ?> style="display:none"<?php } ?>>
		<div class="form-group">
			<label class="control-label col-sm-2">劣后资金规模*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" step="0.01" min="0" name="meta[劣后资金规模]" value="<?=@$product->meta->劣后资金规模?>" required class="form-control">
					<div class="input-group-addon">元</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">预警线*</label>
			<div class="col-sm-10">
				<input type="number" step="0.0001" name="meta[预警线]" value="<?=@$product->meta->预警线?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">平仓线*</label>
			<div class="col-sm-10">
				<input type="number" step="0.0001" name="meta[平仓线]" value="<?=@$product->meta->平仓线?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">信托公司名称*</label>
			<div class="col-sm-10">
				<input name="meta[信托公司名称]" value="<?=@$product->meta->信托公司名称?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">信托通道费率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" step="0.01" name="meta[信托通道费率]" value="<?=@$product->meta->信托通道费率?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">银行托管费率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" step="0.01" name="meta[银行托管费率]" value="<?=@$product->meta->银行托管费率?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">杠杆配比*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">1 : </div>
					<input type="number" step="1" name="meta[杠杆配比]" value="<?=@$product->meta->杠杆配比?>" required class="form-control">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">优先资金成本*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" step="0.01" name="meta[优先资金成本]" value="<?=@$product->meta->优先资金成本?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
	</fieldset>
	<div class="form-group">
		<label class="control-label col-sm-2">开户券商营业部*</label>
		<div class="col-sm-10">
			<input name="meta[开户券商营业部]" value="<?=@$product->meta->开户券商营业部?>" required class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">登陆账号*</label>
		<div class="col-sm-10">
			<input name="meta[登陆账号]" value="<?=@$product->meta->登陆账号?>" required class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">备注</label>
		<div class="col-sm-10">
			<textarea name="comments" class="form-control"><?=@$product->comments?></textarea>
		</div>
	</div>
	<?php if(!isset($product)){ ?>
	<button type="submit" class="btn btn-primary btn-lg btn-block">登记</button>
	<?php }else{ ?>
	<?php if($weixin->account !== 'news'){ ?>
	<button type="submit" class="btn btn-primary btn-lg">更新</button>
	<button type="submit" name="action" value="remove" class="btn btn-danger btn-lg">删除</button>
	<?php } ?>
	<a href="<?=url('product/' . $product->id . '/quote')?>" class="btn btn-info btn-lg">查看报告</a>
	<?php } ?>
</form>

<script type="text/javascript">
	jQuery(function($){
		
		$('[name="type"]').on('change', function(){
			if($(this).val() === '伞型'){
				$('#umbrella-account').trigger('enable');
				$('#single').trigger('disable');
			}
			else{
				$('#umbrella-account').trigger('disable');
				$('#single').trigger('enable');
			}
		});
		
		if($('[name="type"]:checked').length === 0){
			$('[name="type"]:first').prop('checked', true);
		}
		
		$('[name="type"]:checked').trigger('change').parent('label').addClass('active');
		
		$('[name="action"]').on('click', function(){
			if($(this).val() === 'remove'){
				return confirm('即将删除这个客户及其所有产品');
			}
		});
		
	});
</script>
<?php echo View::make('footer'); ?>
