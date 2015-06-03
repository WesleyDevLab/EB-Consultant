<?php echo View::make('header'); ?>

<div class="page-header">
	<h2 class="text-center">私募<?=$product->category === 'account' ? '专户' : '产品'?>登记</h2>
</div>
<form class="form-horizontal" role="form" method="post" action="<?=url($product->exists ? 'product/' . $product->id : 'product')?>">
	<?php if($product->exists){ ?><input type="hidden" name="_method" value="PUT"><?php } ?>
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
				<?php if($product->category === 'account'){ ?>
				<label class="btn btn-default col-xs-6<?php if(@$product->type === '单账户'){ ?> active<?php } ?>">
					<?=Form::radio('type', '单账户', @$product->type === '单账户', array('required'))?>
					单账户
				</label>
				<label class="btn btn-default col-xs-6<?php if(@$product->type === '伞型'){ ?> active<?php } ?>">
					<?=Form::radio('type', '伞型', @$product->type === '伞型', array('required'))?>
					伞型账户
				</label>
				<?php }else{ ?>
				<label class="btn btn-default col-xs-6<?php if(@$product->type === '管理型'){ ?> active<?php } ?>">
					<?=Form::radio('type', '管理型', @$product->type === '管理型', array('required'))?>
					管理型产品
				</label>
				<label class="btn btn-default col-xs-6<?php if(@$product->type === '结构化'){ ?> active<?php } ?>">
					<?=Form::radio('type', '结构化', @$product->type === '结构化', array('required'))?>
					结构化产品
				</label>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php if($product->category === 'account'){ ?>
	<div class="form-group">
		<label class="control-label col-sm-2">投顾分成比例*</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="number" min="0" max="100" step="0.01" name="meta[投顾分成比例]" value="<?=@$product->meta->投顾分成比例?>" required class="form-control">
				<div class="input-group-addon">%</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="form-group">
		<label class="control-label col-sm-2">产品成立日期*</label>
		<div class="col-sm-10">
			<input type="date" name="start_date" value="<?=$product->exists ? $product->start_date->toDateString() : ''?>" required class="form-control">
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
					<input type="number" min="0" max="100" step="0.01" name="meta[信托通道费率]" value="<?=@$product->meta->信托通道费率?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">银行托管费率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[银行托管费率]" value="<?=@$product->meta->银行托管费率?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">杠杆配比*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">1 : </div>
					<input type="number" step="0.5" name="meta[杠杆配比]" value="<?=@$product->meta->杠杆配比?>" required class="form-control">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">优先资金成本*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[优先资金成本]" value="<?=@$product->meta->优先资金成本?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset id="management"<?php if(@$product->type !== '管理型'){ ?> style="display:none"<?php } ?>>
		<div class="form-group">
			<label class="control-label col-sm-2">基金管理人*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[基金管理人]" value="<?=@$product->meta->基金管理人?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">投资顾问*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[投资顾问]" value="<?=@$product->meta->投资顾问?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">基金管理费*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[基金管理费]" value="<?=@$product->meta->基金管理费?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">投顾管理费*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[投顾管理费]" value="<?=@$product->meta->投顾管理费?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">托管费*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[托管费]" value="<?=@$product->meta->托管费?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">业绩提成*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[业绩提成]" value="<?=@$product->meta->业绩提成?>" required class="form-control">
					<div class="input-group-addon">%</div>
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
			<label class="control-label col-sm-2">安全垫比率（无则留空）</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[安全垫比率]" value="<?=@$product->meta->安全垫比率?>" class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">托管机构*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[托管机构]" value="<?=@$product->meta->托管机构?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">经纪券商*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[经纪券商]" value="<?=@$product->meta->经纪券商?>" required class="form-control">
			</div>
		</div>
	</fieldset>
	<fieldset id="structured"<?php if(@$product->type !== '结构化'){ ?> style="display:none"<?php } ?>>
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
			<label class="control-label col-sm-2">杠杆配比*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">1 : </div>
					<input type="number" step="0.5" name="meta[杠杆配比]" value="<?=@$product->meta->杠杆配比?>" required class="form-control">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">产品管理人*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[基金管理人]" value="<?=@$product->meta->基金管理人?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">投资顾问*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[投资顾问]" value="<?=@$product->meta->投资顾问?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">优先资金成本*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[优先资金成本]" value="<?=@$product->meta->优先资金成本?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">产品管理费*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[产品管理费]" value="<?=@$product->meta->产品管理费?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">投顾管理费*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[投顾管理费]" value="<?=@$product->meta->投顾管理费?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">托管费*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[托管费]" value="<?=@$product->meta->托管费?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">业绩提成*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[业绩提成]" value="<?=@$product->meta->业绩提成?>" required class="form-control">
					<div class="input-group-addon">%</div>
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
			<label class="control-label col-sm-2">个股比例*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[个股比例]" value="<?=@$product->meta->个股比例?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">单个创业板比例*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[单个创业板比例]" value="<?=@$product->meta->单个创业板比例?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">创业板总比例*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" min="0" max="100" step="0.01" name="meta[创业板总比例]" value="<?=@$product->meta->创业板总比例?>" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">托管机构*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[托管机构]" value="<?=@$product->meta->托管机构?>" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">经纪券商*</label>
			<div class="col-sm-10">
				<input type="text" name="meta[经纪券商]" value="<?=@$product->meta->经纪券商?>" required class="form-control">
			</div>
		</div>
	</fieldset>
	<?php if($product->category === 'account'){ ?>
	<div class="form-group">
		<label class="control-label col-sm-2">开户券商营业部*</label>
		<div class="col-sm-10">
			<input name="meta[开户券商营业部]" value="<?=@$product->meta->开户券商营业部?>" required class="form-control">
		</div>
	</div>
	<?php } ?>
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
	<?php if(!$product->exists){ ?>
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
				$('fieldset:not(#umbrella-account)').trigger('disable');
			}
			else if($(this).val() === '单账户'){
				$('#single').trigger('enable');
				$('fieldset:not(#single)').trigger('disable');
			}
			else if($(this).val() === '管理型'){
				$('#management').trigger('enable');
				$('fieldset:not(#management)').trigger('disable');
			}
			else if($(this).val() === '结构化'){
				$('#structured').trigger('enable');
				$('fieldset:not(#structured)').trigger('disable');
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
