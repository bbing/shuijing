<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 首页
 * @zhangbing
 */
class Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mod_index', 'model');
    }
    public function index()
    {
        $this->load->view('tem_index');
    }

    public function gettree()
    {
        echo json_encode($this->model->getTree());
    }

    public function getlist($id='')
    {
        echo json_encode($this->model->getList($id));
    }

    public function delcate($id = '')
    {
        if ($id) {
            echo json_encode($this->model->delCate($id));
        } else {
            echo json_encode(array('errorcode'=>1, 'message'=>'参数不完整'));
        }
    }

    public function delPro($id='')
    {
        if ($id) {
            echo json_encode($this->model->delPro($id));
        } else {
            echo json_encode(array('errorcode'=>1, 'message'=>'参数不完整'));
        }
    }

    public function savecate($id='')
    {
        if(!$this->input->get_post('name')) {
            echo json_encode(array('errorcode'=>1, 'message'=>'参数不完整'));
        } else {
            echo json_encode($this->model->saveCate($id,$this->input->get_post('fid'),$this->input->get_post('name')));
        }
    }

    public  function savePro($id='')
    {
        if(!$this->input->get_post('name')) {
            echo json_encode(array('errorcode'=>1, 'message'=>'参数不完整'));
        } else {
            echo json_encode($this->model->savePro($id, $this->input->get_post('name'), $this->input->get_post('cateid'), $this->input->get_post('aprice'),$this->input->get_post('bprice'), $this->input->get_post('relimage')));
        }
    }

    public function saveImage()
    {
        if (isset($_FILES["image"]["tmp_name"])) {
            move_uploaded_file($_FILES["image"]["tmp_name"], dirname(BASEPATH) . '/upload/' .  time()  . '_' . $_FILES["image"]["name"]);
            echo json_encode(array('errorcode' => 0, 'message' => 'upload/' .  time() . '_'  . $_FILES["image"]["name"]));
        } else {
            echo json_encode(array('errorcode' => 1, 'message' => '发生错误'));
        }
    }
}
