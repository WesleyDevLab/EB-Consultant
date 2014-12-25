<?php echo View::make('header'); ?>
<div class="page-header">
	<h2 class="text-center">私募客户登记</h2>
</div>
<form class="form-horizontal" role="form" method="post">
	<div class="form-group">
		<label class="control-label col-sm-2">名称*</label>
		<div class="col-sm-10">
			<input type="text" name="name" required class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">类型*</label>
		<div class="col-sm-offset-2 col-sm-10 row">
			<div class="btn-group col-xs-12" data-toggle="buttons">
				<label class="btn btn-default col-xs-6 active">
					<input type="radio" name="type" value="单账户" checked="checked" required>
					单账户
				</label>
				<label class="btn btn-default col-xs-6">
					<input type="radio" name="type" value="伞型" required>
					伞型
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">投顾分成比例*</label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="number" name="meta[投顾分成比例]" min="0" max="100" step="1" required class="form-control">
				<div class="input-group-addon">%</div>
			</div>
		</div>
	</div>
	<fieldset id="single">
		<div class="form-group">
			<label class="control-label col-sm-2">起始资金规模*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" step="0.01" min="0" name="meta[起始资金规模]" required class="form-control">
					<div class="input-group-addon">元</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">平仓线*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">-</div>
					<input type="number" step="0.1" min="0" max="100" name="meta[平仓线]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset id="umbrella-account" style="display:none">
		<div class="form-group">
			<label class="control-label col-sm-2">劣后资金规模*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">人民币</div>
					<input type="number" step="0.01" min="0" name="meta[劣后资金规模]" required class="form-control">
					<div class="input-group-addon">元</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">预警线*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">-</div>
					<input type="number" step="0.1" min="0" max="100" name="meta[预警线]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">平仓线*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">-</div>
					<input type="number" step="0.1" min="0" max="100" name="meta[平仓线]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">信托公司名称*</label>
			<div class="col-sm-10">
				<input name="meta[信托公司名称]" required class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">信托通道费率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[信托通道费率]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">银行托管费率*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[银行托管费率]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">杠杆配比*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<div class="input-group-addon">1 : </div>
					<input type="number" name="meta[杠杆配比]" required class="form-control">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">优先资金成本*</label>
			<div class="col-sm-10">
				<div class="input-group">
					<input type="number" name="meta[优先资金成本]" required class="form-control">
					<div class="input-group-addon">%</div>
				</div>
			</div>
		</div>
	</fieldset>
	<div class="form-group">
		<label class="control-label col-sm-2">开户券商营业部*</label>
		<div class="col-sm-10">
			<input name="meta[开户券商营业部]" required class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">登陆账号*</label>
		<div class="col-sm-10">
			<input name="meta[登陆账号]" required class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">备注</label>
		<div class="col-sm-10">
			<textarea name="comments" class="form-control"></textarea>
		</div>
	</div>
	<button type="submit" class="btn btn-primary btn-lg btn-block">登记</button>
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
		
		$('[name="type"]:checked').trigger('change');
		
	});
</script>
<?php echo View::make('footer'); ?>
