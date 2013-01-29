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
    		import("@.Action.yui-compressor");
    		$yui = new yuicompressor(array(
    				'java_home'=>'C:\Program Files\Java\jdk1.7.0_09\bin\java.exe', //或自己指定 jdk 安装的 bin 目录 (绝对路径)
    				'jar_file'=>'D:\xampp\htdocs\Front-end-toolbox\jar\yuicompressor-2.4.7.jar',
    				'save_path'=>'D:\xampp\htdocs\Front-end-toolbox\temp', //必须有可写权限
    				// -------- 全局设置 --------- //
    				'charset'=>'utf-8', //文件的编码
    				'line-break'=>false, //在指定的列后插入一个 line-bread 符号
    				// -------- javascript 代码的配置选项 --------- //
    				'nomunge'=>false,  //只是简单压缩，清除空行空格注释等。
    				'semi'=>false, //保留所有的分号
    				'optimizations'=>false, //禁止优化代码.
    		));
    	}
    	$this->display();
    }
    
}