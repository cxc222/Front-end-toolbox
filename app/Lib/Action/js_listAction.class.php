<?php
/**
 * js 相关类
 * @author Administrator
 *
 */
class js_listAction extends baseAction {
	
    public function index(){
    	$datalist = C('data_list');
    	$this->assign('data_list', $datalist);
    	$this->display();
    }
    
    //压缩js 或者 css代码
    public function jscompress(){
    	if ($this->isPost()) {
    		if($_POST['js']){
    			$data = array('status'=>0, 'data'=>null, 'info'=> null);
    			ini_set('memory_limit','-1');
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
    					'line-break'=>false, //在指定的列后插入一个 line-bread 符号
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
}