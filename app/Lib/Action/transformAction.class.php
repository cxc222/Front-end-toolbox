<?php
/**
 * 加密 / 解密 处理类
 * @author Administrator
 *
 */
class transformAction extends baseAction {
	
	public function _initialize(){
		$title_name = '<div class="toolName">在线生成二维码(QR码)-采用<a href="http://www.oschina.net/p/zxing" id="zxing" data-original-title="">ZXing</a>与<a href="http://www.d-project.com/">d-project</a><a style="float:right;text-decoration:none;" href="#advice" data-toggle="modal"><span class="badge badge-important"><i class="icon-envelope icon-white"></i> Feedback</span></a></div>';
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
		
		if($this->isPost()){
			if($_POST['output'] && $_POST['error'] && $_POST['margin'] && $_POST['size'] && $_POST['data']){
				//纠错等级
				switch ($_POST['error']){
					case 'L':
						$level = 'QR_ECLEVEL_L';
						break;
					case 'M':
						$level = 'QR_ECLEVEL_M';
						break;
					case 'Q':
						$level = 'QR_ECLEVEL_Q';
						break;
					case 'H':
						$level = 'QR_ECLEVEL_H';
						break;
					default:
						$level = 'QR_ECLEVEL_L';
						break;
				}
				
				//大小
				if($_POST['size'] == 0){
					$size = '3';
				}else{
					$size = $_POST['size'];
				}
				
				//margin 留边
				$margin = $_POST['margin'];
				
				//内容
				$content = $_POST['data'];
			}
		}
		QRcode::png($content,false,$level,$size,$margin);
		die();
	}
	
}