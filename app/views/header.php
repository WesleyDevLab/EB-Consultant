<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>EB投顾报告平台</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="format-detection"content="telephone=no, email=no" />
		<!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->
		<meta name="HandheldFriendly" content="true">
		<!-- uc强制竖屏 -->
		<meta name="screen-orientation" content="portrait">
		<!-- QQ强制竖屏 -->
		<meta name="x5-orientation" content="portrait">
		<!-- UC强制全屏 -->
		<meta name="full-screen" content="yes">
		<!-- QQ强制全屏 -->
		<meta name="x5-fullscreen" content="true">
		<!-- UC应用模式 -->
		<meta name="browsermode" content="application">
		<!-- QQ应用模式 -->
		<meta name="x5-page-mode" content="app">
		<!-- windows phone 点击无高光 -->
		<meta name="msapplication-tap-highlight" content="no">
		
		<link rel="stylesheet" type="text/css" href="<?=url()?>/packages/bootstrap/dist/css/bootstrap.min.css">
<!--		<link rel="stylesheet" type="text/css" href="<?=url()?>/packages/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=url()?>/style.css">-->
		<style type="text/css">
			header { padding: 1px; height: 1px; background: #A700D5; }
			footer { padding: 10px; }
			.page-header { margin-top: 30px; }
		</style>
		
		<script type="text/javascript" src="<?=url()?>/packages/jquery/dist/jquery.min.js"></script>
		<script type="text/javascript" src="<?=url()?>/packages/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			jQuery(function($){
				// enable child inputs along with fieldsets
				$('fieldset')
					.on('enable', function(){
						$(this).prop('disabled', false).removeAttr('disabled')
							.find(':input').prop('disabled', false).removeAttr('disabled')
						.end().show();
					})
					.on('disable', function(){
						$(this).prop('disabled', true).attr('disabled', 'disabled')
							.find(':input').prop('disabled', true).attr('disabled', 'disabled')
						.end().hide();
					});
					
				$('form').on('submit', function(){

					var submit = true,
						focused = false;

					$(':input:enabled[required]').each(function(index, object){

						if($(object).val() === ''){

							submit = false;

							$(object).parents('.form-group:first').addClass('has-warning');

							// focus the first blank required input
							!focused && $(object).focus() && alert('请填写带*号的必填项');
							focused = true;

						}
					});

					return submit;
				});

				$('.form-group').on('change', function(){
					$(this).removeClass('has-warning');
				});

			});
		</script>
	</head>
	<body>
		<header></header>
		<div class="container">
