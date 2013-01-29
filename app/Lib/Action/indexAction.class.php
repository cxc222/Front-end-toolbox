<?php
class indexAction extends baseAction {
	
    public function index(){
    	$datalist = C('data_list');
    	$this->assign('data_list', $datalist);
    	$this->display();
    }
}