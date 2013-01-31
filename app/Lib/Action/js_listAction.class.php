<?php
/**
 * js 相关类
 * @author Administrator
 *
 */
class js_listAction extends baseAction {
	
	private $path;
	
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
    					'java_home'=>C('yuicompressor.java_home'), //或自己指定 jdk 安装的 bin 目录 (绝对路径)
    					'jar_file' =>C('yuicompressor.jar_file'),
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
    					'java_home'=>C('yuicompressor.java_home'), //或自己指定 jdk 安装的 bin 目录 (绝对路径)
    					'jar_file' =>C('yuicompressor.jar_file'),
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
    	if ($this->isPost()) {
    		if (!empty($_FILES)) {
    			session('[start]');
    			session('id',time());
    			$this->path = './temp/js/'.session('id').'/';
    			$path_all = ROOT_PATH.'/temp/js/'.session('id').'_all/';
    			
    			
    			$file_info = $this->_upload();
    			
    			if($file_info){
    				$paths;
    				foreach ($file_info as $k => $t){
    					$paths[$k] = $t['savepath'].$t['savename'];
    				}
    				
    				import("@.ORG.miniJs.miniJsCss");
    				$miniJsCss = new miniJsCss();
    			 	$minjs = $miniJsCss -> show( join(',', $paths) );
    			 	$filename = 'all.js';
    			 	header('Pragma: public');
    			 	header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
    			 	header('Cache-Control: no-store, no-cache, must-revalidate');
    			 	header('Cache-Control: pre-check=0, post-check=0, max-age=0');
    			 	header('Content-Transfer-Encoding: binary');
    			 	header('Content-Encoding: none');
    			 	Header ( "Accept-Length: ".strlen($minjs));
    			 	header('Content-type: application/force-download');
    			 	header('Content-Disposition: attachment; filename="'.$filename.'"');
    			 	
    				echo $minjs;
    				//print_r($minjs);
    				die();
    				/* $filename = time();
    				foreach ($file_info as $k => $info){
    					//吧所有的js 合并在一个js
    					$path = $path_all.$filename."_all.js";
    					$fp = fopen($path,"a+");
    					
    					fwrite($fp,$content);
    					fclose($fp);
    				}
    				 */
    				import("@.Action.yui-compressor");
    				$yui = new yuicompressor(array(
    						'java_home'=>C('yuicompressor.java_home'), //或自己指定 jdk 安装的 bin 目录 (绝对路径)
    						'jar_file' =>C('yuicompressor.jar_file'),
    						'save_path'=> $path_all, //必须有可写权限
    						// -------- 全局设置 --------- //
    						'charset'=>'utf-8', //文件的编码
    						'line-break'=>$_POST['linebreak'] ? $_POST['linebreak'] : false, //在指定的列后插入一个 line-bread 符号
    						// -------- javascript 代码的配置选项 --------- //
    						'nomunge'=>$_POST['munge']? true:false,  //只是简单压缩，清除空行空格注释等。
    						'semi'=>false, //保留所有的分号
    						'optimizations'=>false, //禁止优化代码.
    				));
    				$resutlt = $yui->directory($this->path);
    				print_r($resutlt);
    			}
    			//print_r($file_info);
    			die();
    		}
    	}
    	$this->display();
    }
    
    
    // 文件上传
    protected function _upload() {
    	import('@.ORG.UploadFile');
    	//导入上传类
    	$upload = new UploadFile();
    	//设置上传文件大小
    	$upload->maxSize            = 3292200;
    	//设置上传文件类型
    	$upload->allowExts          = array('js');
    	//设置附件上传目录
    	$upload->savePath           = $this->path;
    	//设置需要生成缩略图，仅对图像文件有效
    	$upload->thumb              = false;
    	//设置上传文件规则
    	$upload->saveRule           = 'uniqid';
    	if (!$upload->upload()) {
    		//捕获上传异常
    		$this->error($upload->getErrorMsg());
    	} else {
    		//取得成功上传的文件信息
    		$uploadList = $upload->getUploadFileInfo();
    	}
    	return $uploadList;
    }
    //调试 
    function c_debug(){
    	$filename = "a.js";
		header('Pragma: public');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Encoding: none');
		header('Content-type: application/force-download');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		echo "nihao";
		die();
    }
}