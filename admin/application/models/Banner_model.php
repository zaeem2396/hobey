<?php

class Banner_model extends CI_Model
{



	private $_data = array();



	function __construct()
	{

		parent::__construct();
	}



	function add($content)

	{

		$L_strErrorMessage = '';



		$data['title'] = $content['title'];

		$data['title_2'] = $content['title_2'];

		//$data['activepage'] = $content['activepage'];

		$data['url'] = $content['url'];

		if ($content['image'] != '') {

			$data['image'] = $content['image'];
		}

		$this->_data = $data;

		if ($this->db->insert('banner', $this->_data)) {

			return true;
		} else {

			return false;
		}
	}

	function edit($id, $content)

	{

		$data['title'] = $content['title'];

		$data['title_2'] = $content['title_2'];

		//$data['activepage'] = $content['activepage'];

		$data['url'] = $content['url'];

		if ($content['image'] != '') {



			$data['image'] = $content['image'];
		}



		$this->_data = $data;



		$this->db->where('id', $id);



		if ($this->db->update('banner', $this->_data)) {



			return true;
		} else {



			return false;
		}
	}

	function lists($num, $offset, $content)



	{

		if ($offset == '') {

			$offset = '0';
		}



		$sql = "SELECT * FROM  banner where id <> 0 ";



		if ($content['name'] != '') {



			$sql .=	" AND  (title like '%" . $content['name'] . "%' ) ";
		}

		if ($num != '' || $offset != '') {



			$sql .=	"  order by id desc limit " . $offset . " , " . $num . " ";
		}

		$query = $this->db->query($sql);



		$sql_count = "SELECT * FROM banner  WHERE id <> 0";



		if ($content['name'] != '') {



			$sql_count .= " AND `title` like '" . $content['name'] . "%'";
		}



		$query1 = $this->db->query($sql_count);



		$ret['result'] = $query->result();



		$ret['count']  = $query1->num_rows();



		return $ret;
	}

	function deletes($id)

	{

		$this->db->where('id = ', $id);

		if ($this->db->delete('banner')) {



			return true;
		} else {



			return false;
		}
	}



	function allactivepages()
	{

		$query = $this->db->get('activepages');

		if ($query->num_rows() > 0) {

			$result = $query->result();

			return $result;
		} else {

			return false;
		}
	}



	function get_banner($id)
	{

		$this->db->where('id = ', $id);

		$query = $this->db->get('banner');

		if ($query->num_rows() > 0) {



			$result = $query->result();



			return $result;
		} else {



			return false;
		}
	}

	function is_already_exist_add($category)

	{

		$this->db->where('title', $category['title']);

		$query = $this->db->get('banner');

		if ($query->num_rows() > 0) {

			return true;
		} else {

			return false;
		}
	}

	function is_already_exist_edit($category, $id)

	{

		$this->db->where('id !=', $id);

		$this->db->where('title', $category['title']);

		$query = $this->db->get('banner');

		if ($query->num_rows() > 0) {

			return true;
		} else {

			return false;
		}
	}





	function updateorder($id, $val)
	{

		$content['set_order'] = $val;

		$this->db->where('id', $id);

		return $this->db->update('banner', $content);
	}
}
