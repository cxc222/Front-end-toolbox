<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link href="__ROOT__/resources/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="__ROOT__/resources/css/style.css" rel="stylesheet" type="text/css"/>

<script language="javascript" type="text/javascript" src="__ROOT__/resources/js/jquery/jquery-1.9.0.min.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/resources/js/bootstrap.min.js"></script>
<script language="javascript">
var URL = '__URL__';
var ROOT_PATH = '__ROOT__';
var APP	 =	 '__APP__';
</script>
<title><?php echo L('site_name');?></title>
</head>
<body>
<div id="header">
	<div class="wrapper">
		<div id="logo" class="texthidden" onclick="javascript:location.href='/'">
			<h1><?php echo L('site_name');?></h1>
		</div>
	</div>
</div>
<div id="mainContent" class="wrapper">
	<div class="toolName">
		在线JS/CSS/HTML压缩(采用<a id="YUI" href="http://www.oschina.net/p/yui+compressor" data-original-title="">YUI Compressor</a>实现)
	</div>
	<div class="toolUsing clearfix">
		<div class="toolsTab clearfix">
			<ul class="nav nav-tabs">
				<li class="active">
					<a onclick="javascript:location.href='/jscompress'"><?php echo L('js_css_compression');?></a>
				</li>
				<li>
					<a onclick="javascript:location.href='/jscompress'"><?php echo L('html_compression');?></a>
				</li>
				<li>
					<a onclick="javascript:location.href='/jscompress'"><?php echo L('much_js_compression');?></a>
				</li>
			</ul>
		</div>
		<link href="__ROOT__/resources/js/codemirror/codemirror.css" rel="stylesheet" type="text/css"/>
		<script language="javascript" type="text/javascript" src="__ROOT__/resources/js/codemirror/codemirror.js"></script>
		<script language="javascript" type="text/javascript" src="__ROOT__/resources/js/codemirror/mode/javascript/javascript.js"></script>
		<style>
			#error_msg {border:1px dashed #C00; padding:5px; color:#C00;margin:10px 2px;display:none;}
			.toolUsing textarea{min-height:610px;font-size:12px;}
			.Code{border:1px solid #ccc;width:420px;height:610px;overflow-x: hidden;}
			.CodeMirror {width:420px;min-height:610px;}
			.CodeMirror-scroll {height: auto;overflow-y: hidden;overflow-x: hidden;}
			#common_js{margin:20px 0 10px 0;}
			#common_js ul{margin-top:10px;}
			#common_js li{width:150px;height:35px;display:inline-block;}
		</style>
		<div class="leftBar">
			<div class="Code">
<textarea id="source" name="less">/*示例代码*/
				
function echo(stringA,stringB){ 

	var hello="你好"; 
	
	alert("hello world"); 
	
}

/*示例代码*/</textarea>
			</div>
		</div>
		<div class="operateLR">
			<form style="padding:20px 0 20px 0;" class="well">
				<div class="input-append">
					<input type="text" value="5000" class="span1" size="5" id="linebreak" name="linebreak"><span class="add-on">字节换行</span>
				</div>
				<div style="padding:8px 8px 8px 8px;margin:10px 10px 10px 10px;" class="alert alert-info">
					<strong>Note:</strong><p>若将此置空则将默认不换行</p>
	            </div>
				<label class="checkbox inline"><input type="checkbox" id="munge" name="munge">JS标识符混淆</label>
				<button style="margin:0 0 10px 0;" onclick="js_compress();" value=" JS压缩 " type="button" class="btn btn-primary" data-loading-text="正在压缩..." id="js_com">JS压缩<i class="icon-chevron-right icon-white"></i></button>
				<button onclick="css_compress();" value=" CSS压缩 " type="button" class="btn btn-primary" data-loading-text="正在压缩..." id="css_com">CSS压缩<i class="icon-chevron-right icon-white"></i></button>
			</form>
		</div>
		<div class="rightBar">
			<div class="Result">
				<textarea id="result" name="css"></textarea>
			</div>
		</div>
	</div>
	<script>
	var editor = CodeMirror.fromTextArea(document.getElementById("source"), {
	  mode: "javascript",
	  lineNumbers: true,
	  lineWrapping: true
	});

	function js_compress(){
		$("#js_com").button("loading");
		var js = editor.getValue();
		var munge=0;
		if("checked"==$("#munge").attr("checked"))
			munge=1;
		var linebreakpos=$("#linebreak").val();
		ajax_post("/action/jscompress/js_compress"+"?munge="+munge+"&amp;linebreakpos="+linebreakpos,js,function(html){
		$("#js_com").button("reset");
		var json = eval('(' + html + ')');
			if(json.msg){
				$('#error_msg').html(json.msg);
				$('#error_msg').show();
			}
			else if(json.result)
				$('#error_msg').hide();
				$("#result").val(json.result);
		});
	}
	function css_compress(){
		$("#css_com").button("loading");
		var css = editor.getValue();
		var linebreakpos=$("#linebreak").val();
		ajax_post("/action/jscompress/css_compress"+"?linebreakpos="+linebreakpos,css,function(html){
		$("#css_com").button("reset");
		var json = eval('(' + html + ')');
			if(json.msg){
				$('#error_msg').html(json.msg);
				$('#error_msg').show();
			}
			else if(json.result)
				$('#error_msg').hide();
				$("#result").val(json.result);
		});
	}
	</script>
</div>
</body>
</html>