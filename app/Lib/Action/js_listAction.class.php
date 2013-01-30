<?php
/**
 * js 相关类
 * @author Administrator
 *
 */
class js_listAction extends baseAction {
	
	public function _initialize(){
		$title_name = '在线JS/CSS/HTML压缩(采用<a id="YUI" href="#####" data-original-title="">YUI Compressor</a>实现)';
		//定义动作 
		$action = array(
				'jscompress' => L('js_css_compression'),
				'html'	=> L('html_compression'),
				'much_js_compression'	=> L('much_js_compression')
		);
		$this->assign('title_name', $title_name);
		$this->assign('action', $action);
	}
	
    public function index(){
    	$datalist = C('data_list');
    	$this->assign('data_list', $datalist);
    	$this->display();
    }
    
    //压缩js 或者 css代码
    //注意 java的jdk路径
    public function jscompress(){
    	if ($this->isPost()) {
    		ini_set('memory_limit','-1');
    		$data = array('status' => 0, 'data'=>null, 'info'=> null);
    		
    		if($_POST['js']){
    			$filename = time();
    			$path = ROOT_PATH."/temp/js/".$filename.".js";
    			$fp = fopen($path,"w+");
    			$content = $_POST['js'];
    			fwrite($fp,$content);
    			fclose($fp);
    			
    			import("@.Action.yui-compressor");
    			$yui = new yuicompressor(array(
    					'java_home'=>ROOT_PATH.'/jar/jdk1.7.0_09/bin/java', //或自己指定 jdk 安装的 bin 目录 (绝对路径)
    					'jar_file' =>ROOT_PATH.'/jar/yuicompressor-2.4.7.jar',
    					'save_path'=> ROOT_PATH."/temp/js/", //必须有可写权限
    					// -------- 全局设置 --------- //
    					'charset'=>'utf-8', //文件的编码
    					'line-break'=>$_POST['linebreak'] ? $_POST['linebreak'] : false, //在指定的列后插入一个 line-bread 符号
    					// -------- javascript 代码的配置选项 --------- //
    					'nomunge'=>$_POST['munge']? true:false,  //只是简单压缩，清除空行空格注释等。
    					'semi'=>false, //保留所有的分号
    					'optimizations'=>false, //禁止优化代码.
    			));
    			
    			$resutlt = $yui->compress($path);
    			if($resutlt['status'] == 0 && $resutlt['success']){
    				$file = file_get_contents($resutlt['success']);
    				$file = strip_tags($file);
    				$data['status'] = 1;
    				$data['data'] = $file;
    			}
    			@unlink($path);
    			@unlink($resutlt['success']);
    			$this->ajaxReturn($data);
    		}elseif($_POST['css']){
    			$filename = time();
    			$path = ROOT_PATH."/temp/css/".$filename.".css";
    			$fp = fopen($path,"w+");
    			$content = $_POST['css'];
    			fwrite($fp,$content);
    			fclose($fp);
    			
    			import("@.Action.yui-compressor");
    			$yui = new yuicompressor(array(
    					'java_home'=>ROOT_PATH.'/jar/jdk1.7.0_09/bin/java', //或自己指定 jdk 安装的 bin 目录 (绝对路径)
    					'jar_file' =>ROOT_PATH.'/jar/yuicompressor-2.4.7.jar',
    					'save_path'=> ROOT_PATH."/temp/css/", //必须有可写权限
    					// -------- 全局设置 --------- //
    					'charset'=>'utf-8', //文件的编码
    					'line-break'=>$_POST['linebreak'] ? $_POST['linebreak'] : false, //在指定的列后插入一个 line-bread 符号
    					// -------- javascript 代码的配置选项 --------- //
    					'nomunge'=>false,  //只是简单压缩，清除空行空格注释等。
    					'semi'=>false, //保留所有的分号
    					'optimizations'=>false, //禁止优化代码.
    			));
    			
    			$resutlt = $yui->compress($path);
    			if($resutlt['status'] == 0 && $resutlt['success']){
    				$file = file_get_contents($resutlt['success']);
    				$file = strip_tags($file);
    				$data['status'] = 1;
    				$data['data'] = $file;
    			}
    			@unlink($path);
    			@unlink($resutlt['success']);
    			$this->ajaxReturn($data);
    		}
    		
    	}
    	$this->display();
    }
    
    //压缩html
    function html(){
    	$this->display();
    }
    
    //多个js压缩
    function much_js_compression(){
    	$this->display();
    }
    //调试 
    function c_debug(){
    	$de = "D:/xampp/htdocs/Front-end-toolbox/jar/jdk1.7.0_09/bin/java.exe -jar D:/xampp/htdocs/Front-end-toolbox/jar/yuicompressor-2.4.7.jar --type js --charset utf-8 D:/xampp/htdocs/Front-end-toolbox/temp/js/1359516817.js > D:/xampp/htdocs/Front-end-toolbox/temp/js/1359516817.min.js";
    	$a = exec($de.' 2>&1',$out, $status);
    	
    	print_r($a);
    	print_r($out);
    	print_r($status);
    	die();
    }
}