<?php echo View::make('header'); ?>
<h1>私募客户登记</h1>
<form class="form-horizontal" role="form" method="post">
	<div class="form-group">
		<label class="control-label col-sm-2">名称</label>
		<div class="col-sm-10">
			<input name="name" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">类型</label>
		<div class="col-sm-10">
			<select id="account-type" name="type" class="form-control">
				<option value="单账户">单账户</option>
				<option value="伞形">伞形</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">开户券商营业部</label>
		<div class="col-sm-10">
			<input name="metas[开户券商营业部]" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">登陆账号</label>
		<div class="col-sm-10">
			<input name="metas[登陆账号]" class="form-control">
		</div>
	</div>
	<fieldset id="umbrella-account" style="display:none" disabled="disabled">
		<div class="form-group">
			<label class="control-label col-sm-2">总净值</label>
			<div class="col-sm-10">
				<input name="metas[总净值]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">杠杆配比</label>
			<div class="col-sm-10">
				<input name="metas[杠杆配比]" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">优先资金总成本</label>
			<div class="col-sm-10">
				<input name="metas[优先资金总成本]" class="form-control">
			</div>
		</div>
	</fieldset>
	<div class="form-group">
		<label class="control-label col-sm-2">备注</label>
		<div class="col-sm-10">
			<textarea name="comments" class="form-control"></textarea>
		</div>
	</div>
	<button type="submit" class="btn btn-primary">登记</button>
</form>
<script type="text/javascript">
	jQuery(function($){
		$('#account-type').on('change', function(){
			$(this).val() === '伞形' ? $('#umbrella-account').show().prop('disabled', false) : $('#umbrella-account').hide().prop('disabled', true);
		});
	});
</script>
<?php echo View::make('footer'); ?>
