<?php
/**
 * 加密 / 解密 处理类
 * @author Administrator
 *
 */
class transformAction extends baseAction {
	
	public function _initialize(){
		$title_name = '<div class="toolName">在线生成二维码(QR码)-采用<a href="http://www.oschina.net/p/zxing" id="zxing" data-original-title="">phpqrcode</a><a style="float:right;text-decoration:none;" href="#advice" data-toggle="modal"><span class="badge badge-important"><i class="icon-envelope icon-white"></i> Feedback</span></a></div>';
		//定义动作
		$action = array(
				'generate_qrcode' => L('generate_qrcode')
		);
		$this->assign('title_name', $title_name);
		$this->assign('action', $action);
	}
	//生成二维码 界面
	public function generate_qrcode(){
		$this->display();
	}
	
	//生成处理
	public function generate(){
		
		import("@.ORG.phpqrcode.qrlib");
		$level = 'QR_ECLEVEL_L';
		$size = '3';
		$margin = '4';
		
		$content = 'http://tool.qdzff.com/';
		
		if($_GET['output'] && $_GET['error'] && $_GET['size'] && $_GET['data']){
			//纠错等级
			switch ($_GET['error']){
				case 'L':
					$level = 0;
					break;
				case 'M':
					$level = 1;
					break;
				case 'Q':
					$level = 2;
					break;
				case 'H':
					$level = 3;
					break;
				default:
					$level = 0;
					break;
			}
			
			//大小
			if($_GET['size'] == 0){
				$size = '3';
			}else{
				$size = $_GET['size'];
			}
			
			//margin 留边
			$margin = $_GET['margin'];
			
			//内容
			$content = $_GET['data'];
		}
		QRcode::png($content,false,$level,$size,$margin);
		die();
	}
	
}