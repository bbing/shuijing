<?php 
class Shuijing extends CI_Controller
{
	public function __construct()
	{
		$this->load->model('mod_index', 'shuijing');
	}
	
	public function index()
	{
		$this->shuijing->saveData();
	}
}