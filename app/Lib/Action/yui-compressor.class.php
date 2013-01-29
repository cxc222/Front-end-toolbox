<?php
/*
 * PHP YUICompressor Class (Dual licensed under the MIT)
 * 风吟 (http://fengyin.name/guestbook.php)
 * DEMO http://sweet.fengyin.name/ (yui online compressor)
 ----------------------------------------------------------
 要求: dk 1.4+  php exec() 
 作用: 使用 yuicompressor 批量压缩一个目录的 js 或者 css 文件.也可以对单个文件进行压缩
 ----------------------------------------------------------
 
 //Windows 调用方式:
 

  $yui = new yuicompressor(array(
 'java_home'=>'java', //或自己指定 jdk 安装的 bin 目录 (绝对路径)
 'jar_file'=>'D:\www\htdocs\yuicompressor.jar', 
 'save_path'=>'D:\www\htdocs\results\\', //必须有可写权限
 // -------- 全局设置 --------- //
 'charset'=>'utf-8', //文件的编码
 'line-break'=>false, //在指定的列后插入一个 line-bread 符号
 // -------- javascript 代码的配置选项 --------- //
 'nomunge'=>false,  //只是简单压缩，清除空行空格注释等。
 'semi'=>false, //保留所有的分号
 'optimizations'=>false, //禁止优化代码.
 ));
 
 //对单个文件压缩
 $resutlt = $yui->compress('D:\www\htdocs\swfobject_src.js');
 print_r ($resutlt);
 
 //对目录文件压缩
 $resutlt = $yui->directory('D:\www\htdocs\\');
 print_r($resutlt);
 
 ----------------------------------------------------------
 
 //Linux  调用方式:
 
 $yui = new yuicompressor(array(
 'java_home'=>'java', //或自己指定 jdk 安装的 bin 目录 (绝对路径)
 'jar_file'=>'/home/admin/yuicompressor-2.4.2.jar', 
 'save_path'=>'/home/admin/results/', //必须有可写权限
 // -------- 全局设置 --------- //
 'charset'=>'utf-8', //文件的编码
 'line-break'=>false, //在指定的列后插入一个 line-bread 符号
 // -------- javascript 代码的配置选项 --------- //
 'nomunge'=>false,  //只是简单压缩，清除空行空格注释等。
 'semi'=>false, //保留所有的分号
 'optimizations'=>false, //禁止优化代码.
 ));
 
 //对单个文件压缩
 $resutlt = $yui->compress('/home/admin/style.css');
 print_r ($resutlt);
 
 //对目录文件压缩
 $resutlt = $yui->directory('/home/admin/');
 print_r($resutlt);
 
 */

 class yuicompressor {
        function __construct($options = array()) {
            $this->options = $options;
        }
        function args($o) {
            $o['line-break'] && ($line_break = ' --line-break ' . $o['line-break'] . ' ');
            $o['charset'] && ($charset = ' --charset ' . $o['charset'] . ' ');
            $o['nomunge'] && ($jsargs .= ' --nomunge ');
            $o['semi'] && ($jsargs .= ' --preserve-semi ');
            $o['optimizations'] && ($jsargs .= ' --disable-optimizations ');
            $exten = $this->getExtension($o['file']);
            $cmd = array();
            $newfile = $o['save_path'] . $this->replace($o['file']);
			$cmd['file'] = $newfile;
            $cmd['shell'] = $o['java_home'] . ' -jar ' . $o['jar_file'] . ' --type ' . $exten['extension'] . $charset . $line_break . $jsargs . $o['file']. ' > ' . $newfile;
            return $cmd;
        }
        function getExtension($fn) {
            return pathinfo(strtolower($fn));
        }
        function replace($fn) {
            $exten = $this->getExtension($fn);
            return str_replace('.'.$exten['extension'], '.min.' . $exten['extension'], $exten['basename']);
        }
        function exec($cmd) {
			exec($cmd['shell'].' 2>&1',$out, $status);
            return array(
            'shell' => $cmd['shell'],
                'out' => implode("\n",$out),
                'status' => $status,
                'success' => $cmd['file']
           );
        }
        function ls($dir) {
            !($dh = opendir($dir)) && exit('open directory error');
            while (($file = readdir($dh)) !== false) {
                $exten = $this->getExtension($file);
                if ($exten['extension'] == 'js' || $exten['extension'] == 'css') {
                    $files[] = $dir . $file;
                }
            }
            closedir($dh);
            return $files;
        }
        function directory($dir) {
            !is_dir($dir) && exit('directory error');
            foreach ($this->ls($dir) as $file) {
                $fn[] = $this->compress($file);
            }
            return $fn;
        }
        function compress($file) {
            $this->options['file'] = $file;
            return $this->exec($this->args($this->options));
        }
    }
?>