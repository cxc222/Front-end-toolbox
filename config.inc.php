<?php
/**数据列表**/
return array (
		'data_list'	=> array(
				//js 相关的工具
				'js_list' => array(
						'title'	=> 'html|js|css工具',
						'data'	=> array(
								//js列表
								array('act'=>'jscompress', 'title'=>'JS代码压缩'),
								array('act'=>'jscompress', 'title'=>'CSS代码压缩'),
							),
						
					),
				'transform'	=> array(
						'title'	=> '加密/转码工具',
						'data'	=> array(
								array('act'	=> 'generate_qrcode', 'title'	=> '生成QrCode'),
								//array('act' => 'decryption_qrcode', 'title'	=> '解密QrCode')
							),
					),
		)
	);