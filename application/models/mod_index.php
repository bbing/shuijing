<?php 
class mod_index extends CI_Model
{

    public function getTree()
    {
        $res = $this->db->query("select id,name as text from category where fid=0 order by id asc")->result_array();
        foreach($res as $key=>$val) {
            $children = $this->getChild($val['id']);
            if (!$children) {
                $res[$key]['isLeaf'] = 1;
            } else {
                $res[$key]['children'] = $children;
            }
        }
        return $res;
    }

    public function getList($id)
    {
        $delId = $this->getChildId($id);
        $delId .= $id;
        $query = $this->db->query("select a.*,b.name as catename from product a left join category b on a.cateid=b.id where cateid in ({$delId}) order by a.ctime desc");

        return array('total'=>$query->num_rows,'rows'=>$query->result_array());
    }

    public function delCate($id)
    {
        $delId = $this->getChildId($id);
        $delId .= $id;
        $this->db->query("delete from category where id in ({$delId})");
        return array('errorcode'=>0, 'message'=>'删除成功!');
    }

    public function delPro($id)
    {
        $this->db->query("delete from product where id in ({$id})");
        return array('errorcode'=>0, 'message'=>'删除成功!');
    }
	public function saveCate($id,$fid,$name)
    {
        if ($id) {
            $this->db->where('id', $id)->update('category', array( 'name'=>$name));
            return array('errorcode'=>0, 'message'=>'修改成功!');
        } else {
            $this->db->insert('category',array('fid'=>$fid, 'name'=>$name));
            return array('errorcode'=>0, 'message'=>'添加成功!');
        }
    }

    public function savePro($id,$name,$cateid,$aprice,$bprice,$image)
    {
        if ($id) {
            if ($image) {
                $this->db->where('id', $id)->update('product', array('cateid'=>$cateid, 'name'=>$name, 'aprice'=>$aprice,'bprice'=>$bprice, 'image'=>$image));
            } else {
                $this->db->where('id', $id)->update('product', array('cateid'=>$cateid, 'name'=>$name, 'aprice'=>$aprice,'bprice'=>$bprice));
            }
            return array('errorcode'=>0, 'message'=>'修改成功!');
        } else {
            $this->db->insert('product',array('cateid'=>$cateid, 'name'=>$name, 'aprice'=>$aprice, 'bprice'=>$bprice,'image'=>$image));
            return array('errorcode'=>0, 'message'=>'添加成功!');
        }
    }

    private function getChild($fid)
    {
        $res = $this->db->query("select id,name as text from category where fid='{$fid}' order by id asc")->result_array();
        if (!$res) return false;
        foreach ($res as $key=>$val) {
            $children = $this->getChild($val['id']);
            if (!$children) {
                $res[$key]['isLeaf'] = 1;
            } else {
                $res[$key]['children'] = $children;
            }
        }
        return $res;
    }
    private function getChildId($fid)
    {
        $id = '';
        $res = $this->db->query("select id,name as text from category where fid='{$fid}' order by id asc")->result_array();
        if (!$res) return false;
        foreach ($res as $key=>$val) {
            $id .= $val['id'] . ',';
            $id .= $this->getChildId($val['id']);

        }
        return $id;
    }

    public function login($user, $pass, $ip)
    {
        $map = array('username'=>$user,'password'=>md5($pass));
        $query = $this->db->where($map)->get('user');
        if($query->num_rows()>0) {
            $row = $query->row();
            $this->db->login_time = time();
            $this->db->login_ip   = ip2long($ip);
            $logincount = $row->logincount+1;
            $data = array('login_time'=> time(),'login_ip' => ip2long($ip),'logincount' => $logincount );
            $this->db->where(array('account_id'=>$row->account_id))->update('user', $data);
            return $row;
        } else {
            return false;
        }
    }

}
