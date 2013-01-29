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
	<div class="column clearfix">
		<h2><?php echo L('tools_category_index');?></h2>
		<div class="tool_index clearfix">
			<?php if(is_array($data_list)): foreach($data_list as $mod=>$data): ?><ul class="nav nav-list nav-stacked <?php echo ($mod); ?>">
					<li><strong><a href="#"><?php echo ($data["title"]); ?></a></strong></li>
					<li class="divider"></li>
					<?php if($data["data"] != ''): if(is_array($data["data"])): foreach($data["data"] as $key=>$val): ?><li>
								<a href="<?php echo u($mod.'/'.$val['act']);?>"><?php echo ($val["title"]); ?></a>
							</li><?php endforeach; endif; endif; ?>
				</ul><?php endforeach; endif; ?>
		</div>
	</div>
</div>
</body>
</html>