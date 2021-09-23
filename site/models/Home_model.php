<?php
class Home_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function checkLogin($data)
	{
		$sql = "select * from users where (email = '" . $data['email'] . "') AND password = '" . $data['password'] . "' AND user_vendor != 0  ";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return "0";
		}
	}

	public function checkLogin_active($data)
	{
		$sql = "select * from users where (email = '" . addslashes($data['email']) . "') AND password = '" . addslashes($data['password']) . "' AND user_vendor != 0";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return false;
		}
	}

	public function checkLogin_active_new($data)
	{
		$sql = "select * from users where (email = '" . addslashes($data['email']) . "') AND password = '" . addslashes($data['password']) . "' AND user_vendor != 0 ";
		$result = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return false;
		}
	}

	function userlogin($arrContent)
	{

		$sql = "select * from users where (email = '" . addslashes($arrContent['email']) . "' ) AND password = '" . addslashes($arrContent['password']) . "' AND user_vendor != 0";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function show_subcategory($cate_id)
	{
		$this->db->where('state_id', $cate_id);
		$query = $this->db->get('city');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function show_area($city_id)
	{
		$this->db->where('city_id', $city_id);
		$query = $this->db->get('area');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	function show_pincode_change($pincode_id)
	{
		$this->db->where('city_id', $pincode_id);
		$query = $this->db->get('pincode');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function show_pincode($pincode_id)
	{
		$this->db->where('area_id', $pincode_id);
		$query = $this->db->get('pincode');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function check_review($p_id)
	{
		$this->db->where('productid', $p_id);
		$this->db->where('userid', $this->session->userdata('userid'));
		$query = $this->db->get('reviews');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}


	/*function pincode_check($id)
	{
		$sql = "SELECT e.* FROM product e where e.page_url = '".$id."'  ";
		
 		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}*/

	function pincode_check($id)
	{
		if ($id != "") {
			$sql = "SELECT GROUP_CONCAT(id SEPARATOR ',') as id FROM pincode where name IN ($id)";
			$result = $this->db->query($sql);
			if ($result->num_rows() > 0) {
				return $result->row()->id;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function allproduct($pg_num, $offset, $content)
	{
		$state_id = $this->session->userdata('state_id');
		$city_id = $this->session->userdata('city_id');
		$pincode = $this->session->userdata('pincode');
		//echo  $pincode; die;
		$pincode_name = $this->pincode_check($pincode);
		if ($pincode_name == '') {
			$pincode_name = '0';
		}
		//print_r($pincode_name); die;	
		if ($offset == '') {

			$offset = '0';
		}

		$sql = "SELECT p.*,p.user_id,stock.inventory FROM product p 
		LEFT JOIN product_stock_details as stock ON stock.pro_id = p.id 
		LEFT JOIN users as users ON users.id = p.user_id
		where p.id <> 0 and p.is_deleted = 0 and p.status = 0 and users.status = 0
		and ( stock.state_id IN (" . $state_id . ") OR stock.city_id IN (" . $city_id . ")  OR FIND_IN_SET(stock.pincode_id, '" . $pincode_name . "') ) ";

		if (!empty($content['category_serarch'])) {
			$sql .= " and p.category_id =" . $content['category_serarch'] . " ";
		}

		if ($content['search'] != '') {
			$sql .= " and ( p.name Like '%" . $content['search'] . "%' OR p.product_code Like '%" . $content['search'] . "%') ";
		}

		if (!empty($content['subcateid'])) {
			$sql .= " and p.subcatefory_id =" . $content['subcateid'] . " ";
		}

		if (!empty($content['brand'])) {
			$categorys = explode(',', $content['brand']);
			if ($categorys != '') {
				$sql .= " AND (";
				for ($i = '0'; $i < count($categorys); $i++) {
					$sql .= "  find_in_set( '" . $categorys[$i] . "', p.brand_id ) ";
					if ($i != count($categorys) - 1) {
						$sql .= " OR ";
					}
				}
				$sql .= ") ";
			}
		}

		/*if($content['sort_by'] !="")
				{
					if($content['sort_by'] == 'lowtohigh'){
						$sql .=  "  Group by p.id order by `minprice` asc LIMIT ".$offset.",".$pg_num;
					}
					if($content['sort_by'] == 'hightolow'){
						$sql .=  "  Group by p.id order by `minprice` desc LIMIT ".$offset.",".$pg_num;
					}
					
					if($content['sort_by'] == 'instock'){
						$sql .=  " and pa.qty != 0  Group by p.id order by p.id desc LIMIT ".$offset.",".$pg_num;
					}
					
			}
			else
			{
					$sql .=  " Group by p.id ORDER BY p.id desc LIMIT ".$offset.",".$pg_num;
			}*/

		if ($content['sort_by'] != "") {
			if ($content['sort_by'] == 'lowtohigh') {
				$sql .=  " GROUP BY p.id order by p.billing_price asc LIMIT " . $offset . "," . $pg_num;
			}
			if ($content['sort_by'] == 'hightolow') {
				$sql .=  " GROUP BY p.id order by p.billing_price desc LIMIT " . $offset . "," . $pg_num;
			}

			if ($content['sort_by'] == 'atoz') {
				$sql .=  " GROUP BY p.id order by p.material_name asc LIMIT " . $offset . "," . $pg_num;
			}
		} else {
			$sql .=  " GROUP BY p.id ORDER BY p.id desc LIMIT " . $offset . "," . $pg_num;
		}


		$query = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		/*$sql_couint = "SELECT p.*,stock.inventory FROM product p LEFT JOIN product_stock_details as stock ON stock.pro_id = p.id where p.id <> 0 and is_deleted = 0 and status = 0 and stock.state_id IN (".$state_id.") ";*/
		/*$sql_couint = "SELECT p.*,stock.inventory FROM product p LEFT JOIN product_stock_details as stock ON stock.pro_id = p.id where p.id <> 0 and is_deleted = 0 and status = 0 and ( stock.state_id IN (".$state_id.") OR stock.city_id IN (".$city_id.")  OR stock.pincode_id IN (".$pincode_name[0].") ) ";*/

		$sql_couint = "SELECT p.*,stock.inventory FROM product p LEFT JOIN product_stock_details as stock ON stock.pro_id = p.id where p.id <> 0 and is_deleted = 0 and status = 0 and ( stock.state_id IN (" . $state_id . ") OR stock.city_id IN (" . $city_id . ")  OR FIND_IN_SET(stock.pincode_id, '" . $pincode_name . "') ) ";

		if (!empty($content['category_serarch'])) {
			$sql_couint .= " and p.category_id =" . $content['category_serarch'] . " ";
		}

		if ($content['search'] != '') {
			$sql_couint .= " and ( p.name Like '%" . $content['search'] . "%' OR p.product_code Like '%" . $content['search'] . "%') ";
		}

		if (!empty($content['brand'])) {
			$categorys = explode(',', $content['brand']);
			if ($categorys != '') {
				$sql_couint .= " AND (";
				for ($i = '0'; $i < count($categorys); $i++) {
					$sql_couint .= "  find_in_set( '" . $categorys[$i] . "', p.brand_id ) ";
					if ($i != count($categorys) - 1) {
						$sql_couint .= " OR ";
					}
				}
				$sql_couint .= ") ";
			}
		}

		if (!empty($content['subcateid'])) {
			$sql_couint .= " and p.subcatefory_id =" . $content['subcateid'] . " ";
		}

		$sql_couint .=  " Group by p.id ORDER BY p.id desc ";


		$query1 = $this->db->query($sql_couint);
		//$results = $query->result();
		if ($query->num_rows() > 0) {
			$ret['result'] = $query->result();
			$ret['count']  = $query1->num_rows();
			return $ret;
		} else {
			return false;
		}
	}

	function get_product_detail($id)
	{
		$sql = "SELECT e.* FROM product e where e.page_url='" . $id . "' and is_deleted = 0 ";

		// $sql = "SELECT p.*,item.user_info_id FROM product p 
		// INNER JOIN ci_order_item item ON item.product_id  = p.id
		// LEFT JOIN users as users ON users.id = item.user_info_id 
		// where page_url='".$id."' and p.is_deleted = 0";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function get_category($id)
	{
		$this->db->where('id = ', $id);
		$query = $this->db->get('material');
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function relatedproduct_cat($id, $cid)
	{
		$sql = "SELECT p.* FROM product p where  p.id!='" . $id . "' and  p.is_deleted = 0 ";

		if (!empty($cid)) {
			$categorys = explode(',', $cid);
			if ($categorys != '') {
				$sql .= " AND (";
				for ($i = '0'; $i < count($categorys); $i++) {
					$sql .= "  find_in_set( '" . $categorys[$i] . "',  p.material_type ) ";
					if ($i != count($categorys) - 1) {
						$sql .= " OR ";
					}
				}
				$sql .= ") ";
			}
		}

		$sql .=	" order by rand() limit 4";
		//echo $sql; die;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return 0;
		}
	}
	/* ============================== */
	function subscribeemail($email)
	{
		$this->db->select('subscribe.email');
		$this->db->where(array('email' => $email));
		$query = $this->db->get('subscribe');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			$data['email'] = $email;
			$this->_data = $data;
			if ($this->db->insert('subscribe', $this->_data)) { }
			return '5';
		}
	}

	function unsubscribe($email)
	{
		$content['is_sub']  = '1';
		$this->db->where('email', $email);
		if ($this->db->update('subscribe', $content)) {
			return true;
		} else {
			return false;
		}
	}

	function checkemail($email)
	{
		$this->db->select('users.id,users.email');

		$this->db->where(array('email' => $email, 'user_vendor' => 0));
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}


	function checkemail_vendor($email)
	{
		$this->db->select('*');

		$this->db->where(array('email' => $email, 'user_vendor' => 1));
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	function checkpincode($pincode)
	{
		$this->db->select('pincode.id,pincode.pincode');
		$this->db->where(array('pincode' => $pincode));
		$query = $this->db->get('pincode');
		if ($query->num_rows() > 0) {
			return $query->row()->pincode;
		} else {
			return false;
		}
	}

	function sellername($id)
	{
		$this->db->select('company_name');
		$this->db->where(array('id' => $id));
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return $query->row()->company_name;
		} else {
			return false;
		}
	}

	function sellernamedetails($id)
	{
		$this->db->select('*');
		$this->db->where(array('id' => $id));
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	function checkvalidemail1($content)
	{
		$this->db->select('users.id,users.email');
		$this->db->where(array('email' => $content['email']));
		$this->db->where(array('user_vendor' => '0'));

		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}




	function add($content)
	{
		$data['fname'] = $content['fname'];
		$data['lname'] = $content['lname'];
		$data['email'] = $content['email'];
		$data['password'] = $content['password'];
		$data['mobile'] = $content['mobile'];
		/*	$data['address'] = $content['address'];
				$data['country'] = $content['country'];
				$data['state'] = $content['state'];
				$data['city'] = $content['city'];
				$data['pincode'] = $content['pincode']; */
		$data['added_date'] = date('Y-m-d');
		$data['user_vendor'] = '0';


		$this->_data = $data;
		if ($this->db->insert('users', $this->_data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}



	public function vendor_checkLogin($data)
	{
		$sql = "select * from users where (email = '" . $data['email'] . "') AND password = '" . $data['password'] . "' AND user_vendor=1 ";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return "0";
		}
	}


	public function checkLogin1($data)
	{
		$sql = "select * from users where (email = '" . addslashes($data['email']) . "') AND password = '" . addslashes($data['password']) . "' and status = '0' ";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return "1";
		}
	}



	public function vendor_checkLogin_active($data)
	{
		$sql = "select * from users where (email = '" . addslashes($data['email']) . "') AND password = '" . addslashes($data['password']) . "' AND user_vendor=1";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return false;
		}
	}


	function userbyemail($id, $is_vendor)
	{
		$sql = "select * from users where email = '" . $id . "' AND user_vendor=$is_vendor";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	function vendor_registration_step2($content)
	{
		$data['fname'] = $content['fname'];
		$data['email']        = $content['email'];
		$data['mobile']       = $content['mobile'];
		$data['password']     = $content['password'];
		$data['user_vendor'] = 1;
		$data['added_date'] = date("Y-m-d");
		$data['status'] = 1;
		$this->_data = $data;
		if ($this->db->insert('users', $this->_data)) { }
	}

	function travelenquriy($content)
	{
		$data['txtName']     = $content['txtName'];
		$data['txtMobile']   = $content['txtMobile'];
		$data['txtEmail']    = $content['txtEmail'];
		$data['txtMessage']  = $content['txtMessage'];
		$data['serviceId']   = $content['serviceId'];
		$data['added_date']  = date("Y-m-d");
		$this->_data = $data;
		if ($this->db->insert('travelenquriy', $this->_data)) { }
	}

	function serviceenquriy($content)
	{
		$data['txtName']     = $content['txtName'];
		$data['txtMobile']   = $content['txtMobile'];
		$data['txtEmail']    = $content['txtEmail'];
		$data['txtMessage']  = $content['txtMessage'];
		$data['serviceId']   = $content['serviceId'];
		$data['added_date']  = date("Y-m-d");
		$this->_data = $data;
		if ($this->db->insert('serviceinquiry', $this->_data)) { }
	}

	function notifymeenquriy($content)
	{
		$data['txtName']     = $content['txtName'];
		$data['txtMobile']   = $content['txtMobile'];
		$data['txtEmail']    = $content['txtEmail'];
		$data['txtMessage']  = $content['txtMessage'];
		$data['serviceId']   = $content['serviceId'];
		$data['added_date']  = date("Y-m-d");
		$this->_data = $data;
		if ($this->db->insert('notifymeenquriy', $this->_data)) { }
	}

	function farchisenquriy($content)
	{
		$data['txtName']     = $content['txtName'];
		$data['txtMobile']   = $content['txtMobile'];
		$data['txtEmail']    = $content['txtEmail'];
		$data['txtMessage']  = $content['txtMessage'];
		$data['txtCity']  = $content['txtCity'];
		$data['serviceId']   = $content['serviceId'];
		$data['added_date']  = date("Y-m-d");
		$this->_data = $data;
		if ($this->db->insert('farchisenquriy', $this->_data)) { }
	}

	function contactenquriy($content)
	{
		$data['txtName']     = $content['txtName'];
		$data['txtMobile']   = $content['txtMobile'];
		$data['txtEmail']    = $content['txtEmail'];
		$data['txtMessage']  = $content['txtMessage'];
		$data['added_date']  = date("Y-m-d");
		$this->_data = $data;
		if ($this->db->insert('contactenquriy', $this->_data)) { }
	}


	function vendor_registration($content)
	{
		$data['company_name'] = $content['company_name'];
		$data['register_address'] = $content['register_address'];
		$data['email'] = $content['email_id'];
		$data['address'] = $content['address'];
		$data['mobile'] = $content['tel_no'];
		$data['tel_no_a'] = $content['tel_no_a'];
		$data['website'] = $content['website'];
		$data['service_tax_no'] = $content['service_tax_no'];
		$data['pancardnumber'] = $content['pancardnumber'];
		$data['excise_reg_no'] = $content['excise_reg_no'];
		$data['gumasta_lisence_no'] = $content['gumasta_lisence_no'];
		$data['contact_Person1'] = $content['contact_Person1'];
		$data['contact_person2'] = $content['contact_person2'];
		$data['distributor_wholeseller'] = $content['distributor_wholeseller'];
		$data['business_area'] = $content['business_area'];
		$data['bank_name'] = $content['bank_name'];
		$data['account_holder_name'] = $content['account_holder_name'];
		$data['account_no'] = $content['account_no'];
		$data['ifsc_code'] = $content['ifsc_code'];
		$data['no_of_years_in_business'] = $content['no_of_years_in_business'];
		$data['list_of_customers'] = $content['list_of_customers'];
		$data['user_vendor'] = 1;
		$data['added_date'] = date("Y-m-d");
		$data['status'] = 1;

		$this->_data = $data;
		if ($this->db->insert('users', $this->_data)) { }
	}
	function update_password($data, $id)
	{
		$content['password']  = $data['new_password'];

		$this->db->where('id', $id);
		if ($this->db->update('users', $content)) {
			return true;
		} else {
			return false;
		}
	}

	function faceuserlogin($arrContent)
	{
		$sql = "select * from users where (email = '" . addslashes($arrContent['email']) . "' ) AND user_vendor=0";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function userfacebook($data)
	{
		$content['fname']       = $data['name'];
		$content['lname']       = $data['lname'];
		$content['email']       = $data['email'];
		$content['password']    = time();
		$content['added_date']  = date('Y-m-d');
		$content['user_vendor'] = '0';
		$content['registerfrom'] = $data['registerfrom'];
		$this->db->insert('users', $content);
		return $this->db->insert_id();
	}


	function vendor_userlogin($arrContent)
	{

		$sql = "select * from users where (email = '" . addslashes($arrContent['email']) . "' ) AND password = '" . addslashes($arrContent['password']) . "'  AND user_vendor=1";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}


	function userdata($id)
	{
		$this->db->select('*');
		$this->db->where(array('id' => $id));
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}



	function add_vendor_detail($content)

	{
		$L_strErrorMessage = '';
		$data['address'] = $content['address'];
		$data['mobile'] = $content['tel_no'];
		$data['email'] = $content['email_id'];
		$data['password'] = $content['password'];

		$data['company_name'] = $content['company_name'];
		$data['register_address'] = $content['register_address'];
		$data['tel_no_a'] = $content['tel_no_a'];
		$data['website'] = $content['website'];
		$data['service_tax_no'] = $content['service_tax_no'];
		$data['pancardnumber'] = $content['pancardnumber'];
		$data['excise_reg_no'] = $content['excise_reg_no'];

		$data['gumasta_lisence_no'] = $content['gumasta_lisence_no'];
		$data['contact_Person1'] = $content['contact_Person1'];
		$data['contact_person2'] = $content['contact_person2'];
		$data['distributor_wholeseller'] = $content['distributor_wholeseller'];
		$data['business_area'] = $content['business_area'];

		$data['bank_name'] = $content['bank_name'];
		$data['account_holder_name'] = $content['account_holder_name'];
		$data['account_no'] = $content['account_no'];
		$data['ifsc_code'] = $content['ifsc_code'];
		$data['no_of_years_in_business'] = $content['no_of_years_in_business'];
		$data['list_of_customers'] = $content['list_of_customers'];
		$data['subcategory_id'] = $content['subcetagorysss'];
		$data['category_id'] = $content['select_cate_id'];

		$data['user_vendor'] = '1';

		$data['added_date'] = date('Y-m-d');

		$this->_data = $data;
		if ($this->db->insert('users', $this->_data)) {
			$id = $this->db->insert_id();

			if (count($_POST['pincode']) > 0 && $_POST['pincode'] != '') {
				for ($i = 0; $i < count($_POST['pincode']); $i++) {
					if ($_POST['pincode'][$i] != '') {
						$content['p_id']   = $id;
						$content['pincode']   = $_POST['pincode'][$i];
						$content['pin_address'] = $_POST['pin_address'][$i];
						$content['pin_city']  = $_POST['pin_city'][$i];
						$content['pin_state']  = $_POST['pin_state'][$i];
						$this->insert_attribute($content);
					}
				}
			}
			return $id;
		} else {
			return false;
		}
	}


	function insert_attribute($content)
	{

		$data['user_id'] = $content['p_id'];
		$data['pincode']  = $content['pincode'];
		$data['pin_address']  = $content['pin_address'];
		$data['pin_city'] = $content['pin_city'];
		$data['pin_state'] = $content['pin_state'];

		$this->_data = $data;
		if ($this->db->insert('add_vendor_pincode', $this->_data)) {
			return true;
		} else {
			return false;
		}
	}

	function getuserdata($uid)
	{
		$sql = "SELECT * from users where id='" . $uid . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}
	function allcategory_select()
	{
		$sql = "SELECT * from category";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function select_cate($id)
	{
		$sql = "SELECT * from subcategory where id IN(" . $id . ") group by category_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}
	function allsubcategory_select($id)
	{
		$sql = "SELECT * from subcategory where  category_id IN('" . $id . "') order by id desc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function allsubcategory_id()
	{
		$sql = "SELECT * from subcategory order by id desc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function addition_item($id)
	{
		$this->db->where('user_id = ', $id);
		$query = $this->db->get('add_vendor_pincode');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function get_vendor_product($id, $status)
	{
		$this->db->select('p.*');
		$this->db->where('p.vendor_id = ', $id);
		$this->db->where('p.is_deleted = ', '0');

		if ($status == '0') {
			$this->db->where('p.status = ', '0');
		}
		if ($status == '1') {
			$this->db->where('p.status = ', '1');
		}
		if ($status == '2') {
			$this->db->where('pa.qty= ', '0');
		}
		if ($status == '3') {
			//$this->db->where('pa.qty <=','5');
			$this->db->join('product_attribute pa', 'pa.pid = p.id and pa.qty <= 5', 'inner');
		} else {
			$this->db->join('product_attribute pa', 'pa.pid = p.id', 'left');
		}
		if ($status == '4') {
			$this->db->where('p.is_blocked =', '1');
		}
		$this->db->group_by('p.id');
		$this->db->order_by("p.id", "desc");

		$query = $this->db->get('product p');

		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function productstatus($id)
	{
		$return = array();
		/*$this->db->where('vendor_id = ',$id);
		$this->db->where('is_deleted = ','0');
		$this->db->order_by("id","desc");
		$this->db->group_by('id');
		$query = $this->db->get('product');*/

		$sql = "select p.* from product p
	            left join product_attribute pa ON pa.pid = p.id
	            where p.vendor_id ='" . $id . "' and p.is_deleted =0 group by p.id";
		$query = $this->db->query($sql);
		$return['total_products'] = $query->num_rows();


		$sql = "select p.* from product p
	            left join product_attribute pa ON pa.pid = p.id
	            where p.vendor_id ='" . $id . "' and p.is_deleted =0 AND status = '0' group by p.id";
		$query = $this->db->query($sql);
		$return['activeproducts'] = $query->num_rows();

		$sql = "select p.* from product p
	            left join product_attribute pa ON pa.pid = p.id
	            where p.vendor_id ='" . $id . "' and p.is_deleted =0 AND status = '1' group by p.id";
		$query = $this->db->query($sql);
		$return['deactiveproducts'] = $query->num_rows();

		/*$this->db->where('vendor_id = ',$id);
		$this->db->where('is_deleted = ','0');
 		$this->db->where('status = ','0');
		$this->db->order_by("id","desc");
		$this->db->group_by('id');
		$query5 = $this->db->get('product');
	    $return['activeproducts'] = $query5->num_rows();


	    $this->db->where('vendor_id = ',$id);
		$this->db->where('is_deleted = ','0');
 		$this->db->where('status = ','1');
		$this->db->order_by("id","desc");
		$this->db->group_by('id');
		$query1 = $this->db->get('product');
	    $return['deactiveproducts'] = $query1->num_rows();*/


		$sql4 = "select p.* from product p
	            inner join product_attribute pa ON pa.pid = p.id AND pa.qty = 0
	            where p.vendor_id ='" . $id . "' and p.is_deleted = 0 group by p.id";
		$query2 = $this->db->query($sql4);
		$return['outofstock'] = $query2->num_rows();

		$sql = "select p.* from product p
	            inner join product_attribute pa ON pa.pid = p.id AND pa.qty <= 5
	            where p.vendor_id ='" . $id . "' and p.is_deleted =0 group by p.id";
		$query3 = $this->db->query($sql);
		$return['lowstock'] = $query3->num_rows();

		$this->db->where('vendor_id = ', $id);
		$this->db->where('is_blocked = ', '1');
		$this->db->where('is_deleted = ', '0');
		$this->db->order_by("id", "desc");
		$query4 = $this->db->get('product');
		$return['blockedproducts'] = $query4->num_rows();


		//print_r($return); die;
		return $return;
	}

	function productstatusinventory($id)
	{
		$return = array();

		$sql = "select pa.* from product_attribute pa
	            left join product p ON pa.pid = p.id
	            where p.vendor_id ='" . $id . "' and p.is_deleted =0 ";
		$query2 = $this->db->query($sql);
		$return['total_products'] = $query2->num_rows();

		$sql1 = "select pa.* from product_attribute pa
	            left join product p ON pa.pid = p.id AND pa.qty = '0'
	            where p.vendor_id ='" . $id . "' and p.is_deleted =0 ";
		$query2 = $this->db->query($sql1);
		$return['outofstock'] = $query2->num_rows();

		$sql2 = "select pa.* from product_attribute pa
	            left join product p ON pa.pid = p.id AND pa.qty <= 5
	            where p.vendor_id ='" . $id . "' and p.is_deleted =0 ";
		$query3 = $this->db->query($sql2);
		$return['lowstock'] = $query3->num_rows();

		//print_r($return); die;
		return $return;
	}

	function productorder($id)
	{
		$return = array();
		$this->db->where('vendor_id = ', $id);
		$this->db->where('DATE(cdate)', date("Y-m-d"));
		$this->db->group_by("order_id");
		$query = $this->db->get('ci_order_item');
		$return['new_orders'] = $query->num_rows();

		return $return;
	}



	function prdattrarray($pid)
	{

		$this->db->where('pid = ', $pid);
		$this->db->order_by('price', 'asc');
		$this->db->limit(1);
		$query = $this->db->get('product_attribute');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}



	function get($id)
	{
		$this->db->where('id = ', $id);
		$query = $this->db->get('product');
		if ($query->num_rows() > 0) {
			$result = $query->result();

			$product_filter = array();
			$this->db->where('product_id', $id);
			$query = $this->db->get('product_filter');
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $filter) {
					$product_filter[] = $filter->filter_id;
				}
			}
			$result[0]->product_filter = $product_filter;

			return $result;
		} else {
			return false;
		}
	}


	function get_cate_name($id)
	{
		if ($id != "") {
			$sql = "SELECT GROUP_CONCAT(name SEPARATOR ', ') as name FROM category where id IN ($id)";
			$result = $this->db->query($sql);
			if ($result->num_rows() > 0) {
				return $result->row()->name;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}



	function get_subcate_name($id)
	{
		if ($id != "") {
			$sql = "SELECT GROUP_CONCAT(name SEPARATOR ', ') as name FROM subcategory where id IN ($id)";
			$result = $this->db->query($sql);
			if ($result->num_rows() > 0) {
				return $result->row()->name;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function alldata($table_name)
	{
		$query = $this->db->get($table_name);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function subcategory()
	{

		$query = $this->db->get('subcategory');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function subcategory_bycat($id)
	{
		//$this->db->where('category_id = ',$id);
		//$query = $this->db->get('subcategory');
		if ($id != '') {
			$sql = "SELECT * from subcategory where category_id IN($id) ";
			$query = $this->db->query($sql);

			if ($query->num_rows() > 0) {
				$result = $query->result();
				return $result;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function subcategory_byname($id)
	{
		//$this->db->where('category_id = ',$id);
		//$query = $this->db->get('subcategory');
		if ($id != '') {
			$sql = "SELECT s.* from subcategory s
 		        left join category c ON c.id = s.category_id
 		        where c.name = '" . $id . "'";
			$query = $this->db->query($sql);

			if ($query->num_rows() > 0) {
				$result = $query->result();
				return $result;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function update_profile($id, $content)
	{
		$data['address'] = $content['address'];
		$data['mobile'] = $content['tel_no'];
		$data['company_name'] = $content['company_name'];
		$data['register_address'] = $content['register_address'];
		$data['tel_no_a'] = $content['tel_no_a'];
		$data['website'] = $content['website'];
		$data['service_tax_no'] = $content['service_tax_no'];
		$data['pancardnumber'] = $content['pancardnumber'];
		$data['excise_reg_no'] = $content['excise_reg_no'];
		$data['gumasta_lisence_no'] = $content['gumasta_lisence_no'];
		$data['contact_Person1'] = $content['contact_Person1'];
		$data['contact_person2'] = $content['contact_person2'];
		$data['distributor_wholeseller'] = $content['distributor_wholeseller'];
		$data['business_area'] = $content['business_area'];
		$data['bank_name'] = $content['bank_name'];
		$data['account_holder_name'] = $content['account_holder_name'];
		$data['account_no'] = $content['account_no'];
		$data['ifsc_code'] = $content['ifsc_code'];
		$data['no_of_years_in_business'] = $content['no_of_years_in_business'];
		$data['list_of_customers'] = $content['list_of_customers'];

		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('users', $this->_data)) {
			if ($_POST['pincode1'] != '' && count($_POST['pincode1']) > 0) {
				for ($i = 0; $i < count($_POST['pincode1']); $i++) {

					if ($_POST['pincode1'][$i] != '') {
						$content2['p_id']   = $id;
						$content2['pin_address']   = $_POST['pin_address1'][$i];
						$content2['pin_city'] = $_POST['pin_city1'][$i];
						$content2['pincode'] = $_POST['pincode1'][$i];
						$content2['pin_state'] = $_POST['pin_state1'][$i];

						$this->insert_attribute($content2);
					}
				}
			}
			if (count($_POST['pincodeu']) > 0 && $_POST['pincodeu'] != '') {
				for ($i = 0; $i < count($_POST['pincodeu']); $i++) {
					$content1['p_id']   = $id;
					$content1['pincodeu']   = $_POST['pincodeu'][$i];
					$content1['pin_addressu']   = $_POST['pin_addressu'][$i];
					$content1['pin_cityu'] = $_POST['pin_cityu'][$i];
					$content1['pin_stateu'] = $_POST['pin_stateu'][$i];

					$content1['updateid1xxx'] = $_POST['updateid1xxx'][$i];
					$this->update_attribute($content1);
				}
			}
			return true;
		} else {
			return false;
		}
	}

	function removeattriute($product_id, $id)
	{
		$this->db->where('user_id = ', $product_id);
		$this->db->where('id = ', $id);
		if ($this->db->delete('add_vendor_pincode')) {
			return true;
		} else {
			return false;
		}
	}
	function removeattriuteprice($product_id, $id)
	{
		$this->db->where('pid = ', $product_id);
		$this->db->where('id = ', $id);
		if ($this->db->delete('product_attribute')) {
			return true;
		} else {
			return false;
		}
	}


	function product_attr($id)
	{

		$this->db->where('pid = ', $id);
		$query = $this->db->get('product_attribute');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function update_attribute($content)
	{
		$data1['user_id'] = $content['p_id'];
		$data1['pincode']  = $content['pincodeu'];
		$data1['pin_address']  = $content['pin_addressu'];
		$data1['pin_city'] = $content['pin_cityu'];
		$data1['pin_state'] = $content['pin_stateu'];


		$this->db->where('id =', $content['updateid1xxx']);

		if ($this->db->update('add_vendor_pincode', $data1)) {
			return true;
		} else {
			return false;
		}
	}

	function update_bankdeatial($data)
	{
		$content['bank_name'] = $data['bank_name'];
		$content['account_holder_name'] = $data['account_holder_name'];
		$content['account_no'] = $data['account_no'];
		$content['ifsc_code'] = $data['ifsc_code'];
		$content['id']  = $data['id'];
		$content['kyc_document']  = $data['kyc_documents'];


		$this->db->where('id =', $content['id']);

		if ($this->db->update('users', $content)) {
			return true;
		} else {
			return false;
		}
	}

	function update_storedeatial($data)
	{


		$content['website'] = $data['website'];
		$content['service_tax_no'] = $data['gstin'];
		$content['pancardnumber'] = $data['pancard'];
		$content['excise_reg_no'] = $data['exciseno'];
		$content['gumasta_lisence_no'] = $data['lisenceno'];
		$content['distributor_wholeseller'] = $data['distributor_wholeseller'];
		$content['business_area'] = $data['business_area'];
		$content['id']  = $data['id'];



		$this->db->where('id =', $content['id']);

		if ($this->db->update('users', $content)) {
			return true;
		} else {
			return false;
		}
	}

	function update_presoneldeatial($data)
	{

		$content['company_name'] = $data['company_name'];
		$content['email'] = $data['email'];
		$content['tel_no_a'] = $data['tel_no_a'];
		$content['mobile'] = $data['mobile'];
		$content['register_address'] = $data['register_address'];
		$content['address'] = $data['address'];

		$content['id']  = $data['id'];

		$this->db->where('id =', $content['id']);

		if ($this->db->update('users', $content)) {
			return true;
		} else {
			return false;
		}
	}


	function updatecategory_sub($data)
	{
		$content['subcategory_id'] = $data['subcetagory_cate'];
		$content['category_id'] = $data['select_cate_id'];


		$this->db->where('id =', $data['userid']);

		if ($this->db->update('users', $content)) {
			return true;
		} else {
			return false;
		}
	}




	function add_product($content)
	{

		$L_strErrorMessage = '';
		/*$data['name'] = $content['name'];
		$data['page_url']  	  =  strtolower(str_replace(' ', '-',preg_replace('/[^A-Za-z0-9\-]/', '-', $content['name'])));
		$data['category_id'] = $content['category_id'];
		$data['subcatefory_id'] = $content['subcatefory_id'];
		$data['pincode'] = implode(',',$content['pincode']);
		$data['discount'] = $content['discount'];
		$data['short_desc'] = $content['short_desc'];
		$data['description'] = $content['description'];
		$data['specification'] = $content['specification'];
		$data['howtouse'] = $content['howtouse'];
		$data['status']=1;
		$data['vendor_id'] = $this->session->userdata('userid');*/

		$data['name'] = $content['name'];
		$data['page_url'] = strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $content['name'])));

		if ($content['wllness_category_id'] != '') {
			$data['wllness_category_id'] = implode(',', $content['wllness_category_id']);
		} else {
			$data['wllness_category_id'] = '';
		}

		if ($content['category_id'] != '') {
			$data['category_id'] = implode(',', $content['category_id']);
		} else {
			$data['category_id'] = '';
		}

		if ($content['subcatefory_id'] != '') {
			$data['subcatefory_id'] = implode(',', $content['subcatefory_id']);
		} else {
			$data['subcatefory_id'] = '';
		}

		if ($content['is_perishable'] != '') {
			$data['is_perishable'] = $content['is_perishable'];
		} else {
			$data['is_perishable'] = "0";
		}

		if ($content['keywords_filter'] != '') {
			$data['keywords_filter'] = implode(',', $content['keywords_filter']);
		} else {
			$data['keywords_filter'] = "";
		}

		if ($content['pincode'] != '') {
			$data['pincode'] = implode(',', $content['pincode']);
		}
		//$data['discount'] = $content['discount'];
		$data['short_desc'] = $content['short_desc'];
		$data['description'] = $content['description'];
		$data['specification'] = $content['specification'];
		$data['howtouse'] = $content['howtouse'];
		$data['ingredients'] = $content['ingredients'];
		$data['vendor_id'] = $this->session->userdata('userid');
		$data['video_url'] = $content['video_url'];
		$data['funfacts'] = $content['funfacts'];

		//$data['metatitle'] = $content['metatitle'];
		//$data['metakeywords'] = $content['metakeywords'];
		//$data['metadescription'] = $content['metadescription'];
		$data['tags'] = $content['tags'];

		$data['gst'] = $content['gst'];
		$data['hsn_code'] = $content['hsn_code'];
		//	$data['sku_code'] = $content['sku_code'];
		$data['vendor_percentage'] = '25'; //$content['vendor_percentage'];
		$data['status'] = 1;
		$data['added_date'] = date("Y-m-d");

		//print_r($data); die;

		$this->_data = $data;
		if ($this->db->insert('product', $this->_data)) {
			$id = $this->db->insert_id();

			$data5['vendor_id'] 	= '0';
			$data5['tagname'] 	    = 'New Product Added';
			$data5['message'] 	    = 'New Product ' . $content['name'] . ' has been Added.';
			$data5['added_date'] 	= date('Y-m-d');
			$this->_data5 = $data5;
			if ($this->db->insert('notifications', $this->_data5)) { }


			if ($content['product_filter']) {
				$filter_data = array();
				$filter_data['product_id'] = $id;
				foreach ($content['product_filter'] as $filter_id) {
					$filter_data['filter_id'] = $filter_id;
					$this->db->insert('product_filter', $filter_data);
				}
			}


			if (isset($_POST['input_value']) && count($_POST['input_value']) > 0 && $_POST['input_value'] != '') {
				for ($i = 0; $i < count($_POST['input_value']); $i++) {
					$product_property['pro_id']   	  = $id;
					$product_property['cat_id']   	  = $_POST['cat_id'][$i];
					$product_property['cat_input_id'] = $_POST['cat_input_id'][$i];
					$product_property['value']   	  = $_POST['input_value'][$i];
					if ($this->db->insert('product_property_details', $product_property)) { }
				}
			}


			if (count($_POST['gram_size']) > 0 && $_POST['gram_size'] != '') {
				for ($i = 0; $i < count($_POST['gram_size']); $i++) {
					if ($_POST['gram_size'][$i] != '') {
						$content['p_id']   		= $id;
						$content['gram_size']   = $_POST['gram_size'][$i];
						$content['size']   		= $_POST['size'][$i];
						$content['gram']  		= $_POST['gram'][$i];
						$content['ml']  		= $_POST['ml'][$i];
						$content['ltr']  		= $_POST['ltr'][$i];
						$content['units']  		= $_POST['units'][$i];
						$content['cm']  		= $_POST['cm'][$i];
						$content['kg']  		= $_POST['kg'][$i];
						$content['colour'] 		= $_POST['colour'][$i];
						$content['price']  		= $_POST['price'][$i];
						$content['qty']    		= $_POST['qty'][$i];
						$content['sku_code']    = $_POST['sku_code'][$i];
						$content['discount'] 	= $_POST['discount'][$i];
						$content['discount_price'] = $_POST['discount_price'][$i];
						$this->insert_product_attribute($content);
					}
				}
			}
			return $id;
		} else {
			return false;
		}
	}

	function insert_product_attribute($content)
	{

		$data['pid'] = $content['p_id'];
		$data['gram_size']  = $content['gram_size'];
		$data['size']  = $content['size'];
		$data['gram']  = $content['gram'];
		$data['ml']  = $content['ml'];
		$data['ltr']  = $content['ltr'];
		$data['units']  = $content['units'];
		$data['cm']  = $content['cm'];
		$data['kg']  = $content['kg'];
		$data['colour']  = $content['colour'];
		$data['price'] = $content['price'];
		$data['qty'] = $content['qty'];
		$data['sku_code'] = $content['sku_code'];
		$data['discount'] = $content['discount'];
		$data['discount_price'] = $content['discount_price'];
		$this->_data = $data;
		if ($this->db->insert('product_attribute', $this->_data)) {
			return true;
		} else {
			return false;
		}
	}

	function edit($id, $content)
	{

		/*$data['name'] = $content['name'];
		//$data['page_url']  	  =  strtolower(str_replace(' ', '-',preg_replace('/[^A-Za-z0-9\-]/', '-', $content['name'])));
		$data['category_id'] = $content['category_id'];
		$data['subcatefory_id'] = $content['subcatefory_id'];
		$data['pincode'] = implode(',',$content['pincode']);
		$data['discount'] = $content['discount'];
		$data['short_desc'] = $content['short_desc'];
		$data['description'] = $content['description'];
		$data['specification'] = $content['specification'];
		$data['howtouse'] = $content['howtouse'];
        */

		$data['name'] = $content['name'];
		//$data['page_url'] = $content['page_url'];

		if ($content['category_id'] != '') {
			$data['category_id'] = implode(',', $content['category_id']);
		} else {
			$data['category_id'] = "";
		}

		if ($content['wllness_category_id'] != '') {
			$data['wllness_category_id'] = implode(',', $content['wllness_category_id']);
		} else {
			$data['wllness_category_id'] = "";
		}

		if ($content['subcatefory_id'] != '') {
			$data['subcatefory_id'] = implode(',', $content['subcatefory_id']);
		} else {
			$data['subcatefory_id'] = "";
		}

		if ($content['keywords_filter'] != '') {
			$data['keywords_filter'] = implode(',', $content['keywords_filter']);
		} else {
			$data['keywords_filter'] = "";
		}

		if ($content['is_perishable'] != '') {
			$data['is_perishable'] = $content['is_perishable'];
		} else {
			$data['is_perishable'] = "0";
		}

		//  if($content['pincode']!='')		{		$data['pincode'] = implode(',',$content['pincode']);		}		else		{			$data['pincode'] = '';		}
		// $data['discount'] = $content['discount'];
		$data['short_desc'] = $content['short_desc'];
		$data['description'] = $content['description'];
		$data['specification'] = $content['specification'];
		$data['howtouse'] = $content['howtouse'];
		$data['ingredients'] = $content['ingredients'];
		$data['vendor_id'] = $this->session->userdata('userid');
		$data['video_url'] = $content['video_url'];
		$data['funfacts'] = $content['funfacts'];

		//$data['metatitle'] = $content['metatitle'];
		//$data['metakeywords'] = $content['metakeywords'];
		//$data['metadescription'] = $content['metadescription'];
		$data['tags'] = $content['tags'];


		$data['gst'] = $content['gst'];
		$data['hsn_code'] = $content['hsn_code'];
		//$data['sku_code'] = $content['sku_code'];
		$data['vendor_percentage'] = '25'; //$content['vendor_percentage'];
		$data['modified_date'] = date("Y-m-d H:i:s");
		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('product', $this->_data)) {


			$data5['vendor_id'] 	= '0';
			$data5['tagname'] 	    = 'Product Updated';
			$data5['message'] 	    = 'Product ' . $content['name'] . ' has been Updated.';
			$data5['added_date'] 	= date('Y-m-d');
			$this->_data5 = $data5;
			if ($this->db->insert('notifications', $this->_data5)) { }


			/* Start Add Category Attribute Value */
			$this->db->where('pro_id', $id);
			$this->db->delete('product_property_details');
			if (isset($_POST['input_value']) && count($_POST['input_value']) > 0 && $_POST['input_value'] != '') {
				for ($i = 0; $i < count($_POST['input_value']); $i++) {
					$product_property['pro_id']   	  = $id;
					$product_property['cat_id']   	  = $_POST['cat_id'][$i];
					$product_property['cat_input_id'] = $_POST['cat_input_id'][$i];
					$product_property['value']   	  = $_POST['input_value'][$i];
					if ($this->db->insert('product_property_details', $product_property)) { }
				}
			}
			/* End Add Category Attribute Value */

			$this->db->where('product_id', $id);
			$this->db->delete('product_filter');
			$filter_data = array();
			$filter_data['product_id'] = $id;
			foreach ($content['product_filter'] as $filter_id) {
				$filter_data['filter_id'] = $filter_id;
				$this->db->insert('product_filter', $filter_data);
			}


			if (count($_POST['gram_size']) > 0 && $_POST['gram_size'] != '') {
				for ($i = 0; $i < count($_POST['gram_size']); $i++) {
					if ($_POST['gram_size'][$i] != '') {

						$content2['p_id']   = $id;
						$content2['gram_size']   = $_POST['gram_size'][$i];
						$content2['size']   = $_POST['size1'][$i];
						$content2['gram']  = $_POST['gram1'][$i];
						$content2['ml']  = $_POST['ml1'][$i];

						$content2['ltr']  = $_POST['ltr1'][$i];
						$content2['units']  = $_POST['units1'][$i];
						$content2['cm']  	= $_POST['cm1'][$i];
						$content2['kg']  	= $_POST['kg1'][$i];
						$content2['colour'] = $_POST['colour1'][$i];
						$content2['price']  = $_POST['price1'][$i];
						$content2['qty']    = $_POST['qty1'][$i];
						$content2['sku_code']    = $_POST['sku_code1'][$i];

						$content2['discount'] = $_POST['discount1'][$i];
						$content2['discount_price'] = $_POST['discount_price1'][$i];


						$this->insert_product_attribute($content2);
					}
				}
			}
			if (count($_POST['gram_sizeuu']) > 0 && $_POST['gram_sizeuu'] != '') {
				for ($i = 0; $i < count($_POST['gram_sizeuu']); $i++) {
					$content1['p_id']   	= $id;
					$content1['gram_sizeuu'] = $_POST['gram_sizeuu'][$i];
					$content1['sizeu']   	= $_POST['sizeu'][$i];
					$content1['gramu']  	= $_POST['gramu'][$i];
					$content1['mlu']  		= $_POST['mlu'][$i];
					$content1['ltru']  		= $_POST['ltru'][$i];
					$content1['unitsu']  	= $_POST['unitsu'][$i];
					$content1['cmu']  		= $_POST['cmu'][$i];
					$content1['kgu']  		= $_POST['kgu'][$i];
					$content1['colouru']   	= $_POST['colouru'][$i];
					$content1['priceu'] 	= $_POST['priceu'][$i];
					$content1['qtyu'] 		= $_POST['qtyu'][$i];
					$content1['sku_codeu'] 	= $_POST['sku_codeu'][$i];

					$content1['discountu'] 	= $_POST['discountu'][$i];
					$content1['discount_priceu'] 		= $_POST['discount_priceu'][$i];
					$content1['updateid1xxx'] = $_POST['updateid1xxx'][$i];
					$this->update_product_attribute($content1);
				}
			}


			return true;
		} else {
			return false;
		}
	}

	function update_product_attribute($content)
	{

		$data1['pid'] = $content['p_id'];
		$data1['gram_size']  = $content['gram_sizeuu'];
		$data1['size']  = $content['sizeu'];
		$data1['gram']  = $content['gramu'];
		$data1['ml']  = $content['mlu'];
		$data1['ltr']  = $content['ltru'];
		$data1['units']  = $content['unitsu'];
		$data1['cm']  = $content['cmu'];
		$data1['kg']  = $content['kgu'];
		$data1['colour']  = $content['colouru'];
		$data1['price'] = $content['priceu'];
		$data1['qty'] = $content['qtyu'];
		$data1['sku_code'] = $content['sku_codeu'];
		$data1['discount'] = $content['discountu'];
		$data1['discount_price'] = $content['discount_priceu'];
		$this->db->where('id =', $content['updateid1xxx']);
		if ($this->db->update('product_attribute', $data1)) {
			return true;
		} else {
			return false;
		}
	}

	function addition_item_product($id)
	{
		$this->db->where('pid = ', $id);
		$query = $this->db->get('product_attribute');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function presult($id)
	{
		$query = "SELECT * from product where id = '" . $id . "' and is_deleted = 0";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0) {
			$result = $result->row();
			return $result;
		}
	}

	function productimages($id)
	{
		$query = "SELECT * from product_image where pid = '" . $id . "' ORDER BY image_index ASC";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0) {
			$result = $result->result();
			return $result;
		}
	}

	function setImageSequence($data)
	{
		$image_list = explode(',', $data['image_list']);
		foreach ($image_list as $key => $image_id) {
			$image_data = array(
				'image_index' => $key + 1
			);

			$this->db->where('id', $image_id);
			$this->db->update('product_image', $image_data);
		}
		return true;
	}

	function product_add_fields($id)
	{
		$query = "SELECT pd.*,ci.input_name from product_property_details pd
		          inner join category_input ci on ci.id = pd.cat_input_id
		          where pd.pro_id = '" . $id . "'";

		$result = $this->db->query($query);
		if ($result->num_rows() > 0) {
			$result = $result->result();
			return $result;
		}
	}
	function getuser_bank_data($id)
	{
		$query = "SELECT * from users where id = '" . $id . "'";


		$result = $this->db->query($query);
		if ($result->num_rows() > 0) {
			$result = $result->row();
			return $result;
		}
	}

	function add_product_image($content)
	{

		$query2 = "select * from product_image where baseimage = '1' and  pid = '" . $content['pid'] . "'";
		$result2 = $this->db->query($query2);
		if ($result2->num_rows() > 0) {
			$data['baseimage']    = '0';
		} else {
			$data['baseimage']    = '1';
		}

		$data['pid']           = $content['pid'];
		$data['image']         = $content['image'];

		$this->_data = $data;
		if ($this->db->insert('product_image', $this->_data)) {
			return true;
		} else {
			return false;
		}
	}

	function setbaseimg($id, $pid)
	{
		$query2 = "update product_image set baseimage = '0'  where pid = '" . $pid . "'";
		$result2 = $this->db->query($query2);
		$query = "update product_image set baseimage = '1'  where id = '" . $id . "'";
		$result = $this->db->query($query);
		return true;
	}

	function removeimage($id)
	{
		$this->db->where('id = ', $id);
		if ($this->db->delete('product_image')) {
			return true;
		} else {
			return false;
		}
	}



	function getcategory_id($name)
	{
		$sql   = "select * from category where page_url= '" . $name . "'";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->row()->id;
		} else {
			return false;
		}
	}

	function getcategory_id1($name)
	{
		$sql   = "select * from category where page_url= '" . $name . "'";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return false;
		}
	}


	function subcateid($name)
	{
		$sql = "select * from subcategory where page_url= '" . $name . "'";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->row()->id;
		} else {
			return false;
		}
	}

	function subcateid1($name)
	{
		$sql = "select * from subcategory where page_url= '" . $name . "'";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return false;
		}
	}

	function getproductbaseimage($id)
	{
		$sql = "SELECT im.image, IFNULL(im.image,'noimage.jpg') as base_image FROM product_image im 
                where im.pid='" . $id . "' and im.baseimage=1";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->row()->base_image;
		} else {
			return false;
		}
	}



	function getSubcategoryFilter($id = 0)
	{
		$this->db->select('filtername.*');
		$this->db->from('filtername');
		if ($id != 0) {
			$this->db->where("subcat_id", $id);
		}
		$getfiltername =  $this->db->get()->result_array();
		if ($getfiltername != "" && count($getfiltername) > 0) {
			foreach ($getfiltername as &$name) {
				$name['filters_value'] = array();
				$this->db->from('filters_value');
				$this->db->select('filters_value.*');
				$this->db->where("filters_value.filter_id", $name["id"]);
				$name['filters_value'] = $this->db->get()->result_array();
			}
		}
		return $getfiltername;
	}

	function getCategoryFilter($id = 0)
	{
		if ($id != '0') {
			$this->db->select('filtername.*');
			$this->db->from('filtername');
			if ($id != 0) {
				$this->db->where("cat_id", $id);
			}
			$getfiltername =  $this->db->get()->result_array();
			if ($getfiltername != "" && count($getfiltername) > 0) {
				foreach ($getfiltername as &$name) {
					$name['filters_value'] = array();
					$this->db->from('filters_value');
					$this->db->select('filters_value.*');
					$this->db->where("filters_value.filter_id", $name["id"]);
					$name['filters_value'] = $this->db->get()->result_array();
				}
			}
		}
		return $getfiltername;
	}

	function getservicecategoryFilter($id = 0)
	{
		$this->db->select('servicefiltername.*');
		$this->db->from('servicefiltername');
		if ($id != 0) {
			$this->db->where("subcat_id", $id);
		}
		$this->db->or_where("id", '5');

		$getfiltername =  $this->db->get()->result_array();
		if ($getfiltername != "" && count($getfiltername) > 0) {
			foreach ($getfiltername as &$name) {
				$name['filters_value'] = array();
				$this->db->from('servicefilters_value');
				$this->db->select('servicefilters_value.*');
				$this->db->where("servicefilters_value.filter_id", $name["id"]);
				$name['filters_value'] = $this->db->get()->result_array();
			}
		}
		return $getfiltername;
	}

	function product_image($pid)
	{
		$sql = "SELECT * from product_image where pid = '" . $pid . "' and baseimage = 1";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function all_category()
	{
		$sql = "SELECT * FROM category order by set_order asc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function index_category()
	{
		$sql = "SELECT * from category where set_home = 1 order by id desc limit 3";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function featuredproducts()
	{
		$sql = "SELECT p.*,( select min(price) from product_attribute where pid = p.id ) as
    		`minprice`,IFNULL(im.image,'noimage.jpg') as base_image FROM product p
    		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1 where is_featured = '1' and p.status = 0 and is_deleted = 0 and is_blocked = 0";
		$sql .=	" order by rand() limit 8";
		//echo $sql; die;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return 0;
		}
	}

	function recfeaturedproducts($productid)
	{
		$sql = "SELECT p.*,( select min(price) from product_attribute where pid = p.id ) as
    		`minprice`,IFNULL(im.image,'noimage.jpg') as base_image FROM product p
    		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1 where p.id IN ($productid) and p.status = 0 and is_deleted = 0 and is_blocked = 0";
		$sql .=	" order by rand() limit 8";
		//echo $sql; die;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return 0;
		}
	}

	function latestviews()
	{
		$id = get_cookie('productview');
		if ($id != '') {
			$sql = "SELECT p.*,( select min(price) from product_attribute where pid = p.id ) as
    		`minprice`,IFNULL(im.image,'noimage.jpg') as base_image FROM product p
    		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1 where  p.id IN ($id)  and p.status = 0 and is_deleted = 0 and is_blocked = 0 ";

			//$sql .=	"group by p.id order by rand() limit 8";

			$sql .=	"order by rand() limit 8";

			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$result = $query->result();
				return $result;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function getcatname($id)
	{
		$sql = "SELECT * FROM category where page_url = '" . $id . "' ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function getcatnamearray($id)
	{
		$sql = "SELECT * FROM category where id IN ('" . $id . "') ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}



	function getsubcatname($id)
	{
		$sql = "SELECT * FROM subcategory where page_url = '" . $id . "' ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function getsubcatnamearray($id)
	{
		$sql = "SELECT * FROM subcategory where id = '" . $id . "' ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}



	function allsubcategory($id)
	{
		$sql = "SELECT * FROM subcategory where category_id ='" . $id . "'order by set_order asc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function all_color_list()
	{
		$sql = "SELECT * from colour order by id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}



	function all_gram_list()
	{
		$sql = "SELECT * from gram order by id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function allbanners()
	{
		$sql = "SELECT * from banner order by id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function product_detail($url)
	{

		$sql = "SELECT p.*,( select min(price) from product_attribute where pid = p.id ) as
		`minprice`,IFNULL(im.image,'noimage.jpg') as base_image FROM product p
		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1
		where page_url='$url' and p.status = 0 and p.is_deleted = 0 and p.is_blocked = 0 ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function product_images($product_id)
	{
		$sql = "SELECT * from product_image where pid = '" . $product_id . "'  order by image_index asc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function services_images($product_id)
	{
		$sql = "SELECT * from service_image where pid = '" . $product_id . "'  order by id desc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function workshop_images($product_id)
	{
		$sql = "SELECT * from workshop_image where pid = '" . $product_id . "'  order by id desc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}


	function checkpincode_detail($pincode)
	{
		$sql = "SELECT * FROM pincode where pincode = '" . $pincode . "' AND (service = 'Deliveries Only' OR service = 'Pickup & Deliveries')";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	function getvendorperishablepincode($vendorid)
	{
		$sql = "SELECT * FROM pick_up_address where user_id = '" . $vendorid . "' AND perishable = '1'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	function controllingcity($vpincode)
	{
		$sql = "SELECT * FROM pincode where pincode = '" . $vpincode . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {

			$controllingarea = $query->row()->controlling_area;

			$sql_ca = "SELECT * FROM pincode where controlling_area = '" . $controllingarea . "' AND (service = 'Deliveries Only' OR service = 'Pickup & Deliveries')";
			$query_ca = $this->db->query($sql_ca);
			if ($query_ca->num_rows() > 0) {
				return $query_ca->result();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function relatedproduct($id, $cid)
	{
		$sql = "SELECT p.*,( select min(price) from product_attribute where pid = p.id ) as
    		`minprice` FROM product p
    		where  p.id!='" . $id . "' and p.status = 0 and p.is_deleted = 0 and p.is_blocked = 0 ";

		if (!empty($cid)) {
			$categorys = explode(',', $cid);
			if ($categorys != '') {
				$sql .= " AND (";
				for ($i = '0'; $i < count($categorys); $i++) {
					$sql .= "  find_in_set( '" . $categorys[$i] . "',  p.subcatefory_id ) ";
					if ($i != count($categorys) - 1) {
						$sql .= " OR ";
					}
				}
				$sql .= ") ";
			}
		}

		$sql .=	" group by p.id  order by rand() limit 15 ";
		//echo $sql; die;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return 0;
		}
	}



	function getcolour($id)
	{
		//$sql = "SELECT sp.*,s.colour as colorname FROM product_attribute sp Inner JOIN colour s ON s.id=sp.colour where pid='".$id."' group by s.id";
		$sql = "SELECT sp.*, s.colour as colorname FROM product_attribute sp Inner JOIN colour s ON s.id=sp.colour where pid='" . $id . "'";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function product_size($id)
	{
		//$sql = "SELECT sp.*,s.name as sizename FROM product_attribute sp LEFT JOIN size s ON s.id=sp.size where pid='".$id."' group by s.id";
		$sql = "SELECT s.name as sizename FROM product_attribute sp LEFT JOIN size s ON s.id=sp.size where pid='" . $id . "' group by s.id";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}


	function product_minprice($id)
	{
		$sql = "SELECT * FROM product_attribute where pid = '" . $id . "' order by price asc limit 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function lists_worshshop($num, $offset, $content)
	{
		if ($offset == '') {
			$offset = '0';
		}
		if ($content['minPrice'] != '' && $content['maxPrice'] != '') {
			$where = ' and pa.price between ' . $content['minPrice'] . ' and ' . $content['maxPrice'];
		}
		/*$sql = "SELECT * FROM workshop  where id <> 0  ";*/
		$sql = "SELECT e.*, ( select min(price) from add_workshop_price where e_id = e.id ) as `minprice` FROM workshop e 
		        left join add_workshop_price pa ON pa.e_id = e.id
		where e.id <> 0 and ( e.start_date > now() OR e.end_date >= now() ) $where ";

		if (!empty($content['worksho_cate'])) {
			$sql .= " and e.category_id = " . $content['worksho_cate'] . " ";
		}

		if (isset($content['filters']) and count($content['filters']) > 0) {
			$sql .= " and e.location IN (" . implode(',', $content['filters']) . ")  ";
		}

		if ($num != '' || $offset != '') {
			$sql .=	" group by e.id ";
			if ($content['sort_by'] == 'Date') {
				$sql .=	" order by e.start_date asc";
			} else {
				$sql .=	" order by e.id desc ";
			}
			$sql .=	" limit " . $offset . " , " . $num . " ";
		}
		$query = $this->db->query($sql);

		$sql_1 = "SELECT min(pa.price) as minprice , max(pa.price) as maxprice  FROM add_workshop_price pa
	     	LEFT JOIN workshop e ON pa.e_id = e.id
	     	 ";
		if (!empty($content['worksho_cate'])) {
			$sql_1 .= " and e.category_id = " . $content['worksho_cate'] . " ";
		}
		if (isset($content['filters']) and count($content['filters']) > 0) {
			$sql_1 .= " and e.location IN (" . implode(',', $content['filters']) . ")  ";
		}
		$sql_1 .= " group by e.id ";
		$query_1 = $this->db->query($sql_1);
		$pricedata = $query_1->row();

		//print_r($pricedata); die;
		$ret['minprice']  = $pricedata->minprice;
		$ret['maxprice']  = $pricedata->maxprice;

		$sql_count = "SELECT e.*,( select min(price) from add_workshop_price where e_id = e.id ) as `minprice` FROM workshop e 
		left join add_workshop_price pa ON pa.e_id = e.id
		where e.id <> 0 and ( e.start_date > now() OR e.end_date >= now() ) $where ";

		/*$sql_count = "SELECT * FROM workshop  where id <> 0  ";*/

		if (!empty($content['worksho_cate'])) {
			$sql_count .= " and e.category_id = " . $content['worksho_cate'] . " ";
		}
		$sql_count .= " group by e.id ";
		$query1 = $this->db->query($sql_count);

		if ($query->num_rows() > 0) {
			$ret['result'] = $query->result();
			$ret['count']  = $query1->num_rows();
		} else {
			//return false;
		}

		return $ret;
	}

	function lists_worshshop_past($num, $offset, $content)
	{
		if ($offset == '') {
			$offset = '0';
		}
		if ($content['minPrice'] != '' && $content['maxPrice'] != '') {
			$where = ' and pa.price between ' . $content['minPrice'] . ' and ' . $content['maxPrice'];
		}
		/*$sql = "SELECT * FROM workshop  where id <> 0  ";*/
		$sql = "SELECT e.*, ( select min(price) from add_workshop_price where e_id = e.id ) as `minprice` FROM workshop e 
		        left join add_workshop_price pa ON pa.e_id = e.id
		where e.id <> 0 and ( e.end_date < now() ) $where ";

		if (!empty($content['worksho_cate'])) {
			$sql .= " and e.category_id = " . $content['worksho_cate'] . " ";
		}

		if (isset($content['filters']) and count($content['filters']) > 0) {
			$sql .= " and e.location IN (" . implode(',', $content['filters']) . ")  ";
		}

		if ($num != '' || $offset != '') {
			$sql .=	" group by e.id ";
			if ($content['sort_by'] == 'Date') {
				$sql .=	" order by e.start_date asc";
			} else {
				$sql .=	" order by e.id desc ";
			}
			$sql .=	" limit " . $offset . " , " . $num . " ";
		}
		$query = $this->db->query($sql);

		$sql_1 = "SELECT min(pa.price) as minprice , max(pa.price) as maxprice  FROM add_workshop_price pa
	     	LEFT JOIN workshop e ON pa.e_id = e.id
	     	 ";
		if (!empty($content['worksho_cate'])) {
			$sql_1 .= " and e.category_id = " . $content['worksho_cate'] . " ";
		}
		if (isset($content['filters']) and count($content['filters']) > 0) {
			$sql_1 .= " and e.location IN (" . implode(',', $content['filters']) . ")  ";
		}
		$sql_1 .= " group by e.id ";
		$query_1 = $this->db->query($sql_1);
		$pricedata = $query_1->row();

		//print_r($pricedata); die;
		$ret['minprice']  = $pricedata->minprice;
		$ret['maxprice']  = $pricedata->maxprice;

		$sql_count = "SELECT e.*,( select min(price) from add_workshop_price where e_id = e.id ) as `minprice` FROM workshop e 
		left join add_workshop_price pa ON pa.e_id = e.id
		where e.id <> 0 and ( e.end_date < now() ) $where ";

		/*$sql_count = "SELECT * FROM workshop  where id <> 0  ";*/

		if (!empty($content['worksho_cate'])) {
			$sql_count .= " and e.category_id = " . $content['worksho_cate'] . " ";
		}
		$sql_count .= " group by e.id ";
		$query1 = $this->db->query($sql_count);

		if ($query->num_rows() > 0) {
			$ret['result'] = $query->result();
			$ret['count']  = $query1->num_rows();
		} else {
			//return false;
		}

		return $ret;
	}


	function all_workshop_category()
	{
		$sql = "SELECT * from workshop_category order by id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function getcaworkshopcate($id)
	{
		$sql = "SELECT * FROM workshop_category where page_url = '" . $id . "' ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function get_services($page_url, $content)
	{
		$sql = "SELECT s.*,sc.name as category_name FROM services AS s  INNER JOIN service_category as sc ON sc.id=s.category ";
		if ($page_url != "") {
			$sql .= "where sc.pageurl = '" . $page_url . "'";
		}

		if (isset($content['filters']) and count($content['filters']) > 0) {
			$sql .= " and s.id IN(SELECT product_id FROM serviceproduct_filter WHERE filter_id IN (" . implode(',', $content['filters']) . "))";
		}

		if ($content['sort_by'] != "") {
			if ($content['sort_by'] == 'atoz') {
				$sql .=  " order by s.name asc ";
			}

			if ($content['sort_by'] == 'ztoa') {
				$sql .=  " order by s.name desc ";
			}

			if ($content['sort_by'] == 'new') {
				$sql .=  " order by s.id desc ";
			}
		} else {
			$sql .=  " order by s.id desc ";
		}


		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function get_services_category($page_url)
	{
		$sql = "SELECT * FROM service_category where pageurl = '" . $page_url . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function allservicecategory()
	{
		$sql = "SELECT * FROM service_category order by name asc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function services_detail($id)
	{
		$sql = "SELECT * FROM services where id = " . $id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function services_additional_details($id)
	{
		$sql = "SELECT * FROM service_details where service_id = " . $id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function getcaworkshopcate1($id)
	{
		$sql = "SELECT * FROM workshop_category where id = '" . $id . "' ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function getevents($id)
	{
		$sql = "SELECT e.* FROM workshop e where e.id='" . $id . "'  ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}



	function get_speaker($id)
	{
		$sql = "SELECT * FROM speaker where id='" . $id . "'  ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function get_events_price($id)
	{
		$sql = "SELECT * from add_workshop_price where e_id = '" . $id . "' order by e_id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function all_blog_category($cateid = '')
	{
		if ($cateid != '') {
			$sql = "SELECT * from blogsubcategory where blogcategory = " . $cateid . " order by id desc";
		} else {
			$sql = "SELECT * from blogsubcategory order by id desc";
		}
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function latestblogs()
	{
		$sql = "SELECT * FROM blog order by blog_id desc limit 4";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function upcomingworkshops()
	{
		$sql = "SELECT e.*, ( select min(price) from add_workshop_price where e_id = e.id ) as `minprice` FROM workshop e 
		        left join add_workshop_price pa ON pa.e_id = e.id
		where e.id <> 0 and ( e.start_date > now() OR e.end_date >= now() )";

		$sql .=	" group by e.id ";
		$sql .=	" order by e.start_date asc limit 2";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function get_blog($id)
	{
		if ($id != '') {
			$sql = "SELECT * FROM blog  where blogcategory=" . $id . "  order by blog_id desc ";
		} else {
			$sql = "SELECT * FROM blog order by blog_id desc ";
		}
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function get_blog_related($id)
	{
		$sql = "SELECT * FROM blog  where blogcategory=" . $id . "  order by blog_id desc limit 5 ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function get_journal_detail($page_url)
	{
		$sql = "SELECT * FROM blog where pageurl = '" . $page_url . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function get_cate_name_blog($id)
	{
		$sql = "SELECT * FROM blogcategory where id = '" . $id . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function get_subcate_name_blog($id)
	{
		$sql = "SELECT * FROM blogsubcategory where id = '" . $id . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function get_subcate_name_page_url($id)
	{
		$sql = "SELECT * FROM blogsubcategory where pageurl = '" . $id . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function get_tag_journal($id)
	{


		/*$sql = "SELECT * FROM blog where FIND_IN_SET ('".$id."',tags) order by blog_id desc ";*/

		$sql = "SELECT * FROM blog where tags like '%" . $id . "%' order by blog_id desc ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function getfees($product_id)
	{
		$sql = "SELECT * from add_workshop_price where id=" . $product_id . "";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function getevent($eventid)
	{
		$sql = "SELECT * from workshop where id=" . $eventid . "";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function all_collections()
	{

		if ($this->session->userdata('check_pincode') != '') {
			$pincode = $this->session->userdata('check_pincode');
		} else if ($this->session->userdata('pincode') != '') {
			$pincode = $this->session->userdata('pincode');
		} else {
			$pincode = '0';
		}

		//$sql = "SELECT * FROM tbl_collection where start_date <= '".date("Y-m-d")."' and end_date >= '".date("Y-m-d")."' and enabled =1";

		$sql = "SELECT p.* FROM tbl_collection p 
		LEFT JOIN pincode as pincode ON pincode.city_id = p.city_id 
		where start_date <= '" . date("Y-m-d") . "' and end_date >= '" . date("Y-m-d") . "' and enabled =1 and pincode.name IN (" . $pincode . ")  ";


		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function spdistributors()
	{
		if ($this->session->userdata('check_pincode') != '') {
			$pincode = $this->session->userdata('check_pincode');
		} else if ($this->session->userdata('pincode') != '') {
			$pincode = $this->session->userdata('pincode');
		} else {
			$pincode = '0';
		}

		// $sql = "SELECT * FROM users where user_vendor = '2' and status='0' and FIND_IN_SET(" . $pincode . ",pincode)";
		$sql = "SELECT * FROM users where user_vendor = '2' and status='0' and FIELD(" . $pincode . ",pincode)";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function alldistributors()
	{
		$sql = "SELECT * FROM users where user_vendor = '2' and status='0'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function allproductCollection($ids)
	{
		$sql = "SELECT * FROM product where id IN(" . $ids . ") and is_deleted = 0 and status = 0 order by material_name ASC";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function selectcoupancode($id)
	{
		$sql = "SELECT * FROM tbl_coupan where start_date <= '" . date("Y-m-d") . "' and end_date >= '" . date("Y-m-d") . "' and code='" . $id . "' and enabled =1 and (type=2 or type=0) ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function getusage_coupon($id, $user_id = "")
	{
		$sql = "SELECT count(*) as usagetotal FROM ci_coupon_usage where coupon_id=" . $id;
		if ($user_id != '') {
			$sql .= " and user_id=" . $user_id;
		}
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row()->usagetotal;
			return $result;
		} else {
			return false;
		}
	}

	function checkvalidemail_workshop($content)
	{
		$this->db->select('*');
		$this->db->where(array('email' => $content['email_address']));
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	function add_user($content)
	{

		$L_strErrorMessage = '';
		$data['fname'] = $content['first_name'];
		$data['email'] = $content['email_address'];
		$data['lname'] = $content['last_name'];
		$data['mobile'] = $content['phone_number'];
		$data['password'] = "123465";

		$this->_data = $data;
		if ($this->db->insert('users', $this->_data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	function addorder($content)
	{
		$this->_data = $content;
		if ($this->db->insert('ci_orders_experiences', $this->_data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	function add_attendees($id)
	{
		for ($i = 0; $i < count($_POST['first_name_attendee']); $i++) {
			if ($_POST['first_name_attendee'][$i] != '') {
				$arrData['first_name'] = $_POST['first_name_attendee'][$i];
				$arrData['last_name'] = $_POST['last_name_attendee'][$i];
				$arrData['expe_order_id'] = $id;
				if ($this->db->insert('ci_expr_attendees', $arrData)) { }
			}
		}
	}

	function getorder($id)
	{
		$this->db->select('*');
		$this->db->where(array('id' => $id));
		$query = $this->db->get('ci_orders_experiences');

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function updateOrderDetails($arrData)
	{
		$this->db->where('id', $arrData['id']);
		if ($this->db->update('ci_orders_experiences', $arrData)) {
			return true;
		} else {
			return false;
		}
	}

	function updatestock($attribute_id, $qty)
	{
		$sql = "Update workshop set num_attendees_ava = num_attendees_ava +" . $qty . "  where id = '" . $attribute_id . "'";
		$query = $this->db->query($sql);
	}

	function coupon_usage($arrData)
	{
		if ($this->db->insert('ci_coupon_usage', $arrData)) {
			return true;
		} else {
			return false;
		}
	}

	function getgifthampercate($pageurl)
	{
		$sql = "SELECT * FROM gift_hamper_category where pageurl = '" . $pageurl . "' ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function lists_gift_hamper($num, $offset, $content)
	{

		if ($offset == '') {
			$offset = '0';
		}
		/*$sql = "SELECT * FROM workshop  where id <> 0  ";*/

		$sql = "SELECT e.* FROM gift_hampers e where e.id <> 0 ";


		if (!empty($content['gift_hamper_cate'])) {
			$sql .= " and e.category_id = " . $content['gift_hamper_cate'] . " ";
		}

		if ($num != '' || $offset != '') {
			$sql .=	"  order by e.id desc limit " . $offset . " , " . $num . " ";
		}

		$query = $this->db->query($sql);

		$sql_count = "SELECT e.* FROM gift_hampers e where e.id <> 0 ";

		/*$sql_count = "SELECT * FROM workshop  where id <> 0  ";*/

		if (!empty($content['gift_hamper_cate'])) {
			$sql_count .= " and e.category_id = " . $content['gift_hamper_cate'] . " ";
		}

		$query1 = $this->db->query($sql_count);

		if ($query->num_rows() > 0) {
			$ret['result'] = $query->result();
			$ret['count']  = $query1->num_rows();
			return $ret;
		} else {
			return false;
		}
	}

	function get_gift_hampers_detail($page_url)
	{
		$sql = "SELECT * FROM gift_hampers where page_url = '" . $page_url . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function all_gift_hamper_category()
	{

		$sql = "SELECT * from gift_hamper_category order by id desc";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function getgifthampercate_id($id)
	{
		$sql = "SELECT * FROM gift_hamper_category where id = '" . $id . "' ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function gift_hamper_product($id)
	{
		$sql = "SELECT p.*, IFNULL(im.image,'noimage.jpg') as base_image FROM product p
		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage = 1
 		where  p.id IN (" . $id . ") and p.status = 0 and is_deleted = 0 and is_blocked = 0";

		//echo $sql; die;

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}


	function order_detail($uid, $flag, $status)
	{
		$sql = "SELECT ci.*, u.fname, u.lname,sp.* from ci_order_item ci
		        inner join ci_orders o ON o.order_id = ci.order_id
		        inner join users u on u.id = ci.user_info_id
				left join ci_shipping_address sp on sp.order_id = o.order_id
		        where ci.vendor_id = '" . $uid . "' and o.order_status = 'C' and o.payment_status='1'";

		if ($status == '') {
			$sql .= " AND ci.trackingid = ''";
		}
		if ($status == 'pending') {
			$sql .= " AND ci.packstatus = '0' and (ci.vendor_accept='0' and ci.is_cancel = '0') ";
		}

		if ($status == 'pack') {
			$sql .= " AND ci.trackingid = '' AND ci.packstatus = '1' ";
		}

		if ($status == 'transit') {
			$sql .= " AND ci.trackingid = '' AND ( ci.packstatus = '2' || ci.packstatus = '3') ";
		}

		if ($flag == 'new') {
			$todaydate = date('Y-m-d');
			$sql .= " AND ci.cdate ='" . $todaydate . "'";
		}

		$sql .= "order by ci.order_id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function order_pendinglisting($uid)
	{
		$sql = "SELECT * from ci_order_item where vendor_id = '" . $uid . "'  order by order_id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}
	function order_canlisting($uid)
	{
		$sql = "SELECT ci.*, u.fname, u.lname,sp.* from ci_order_item ci
		        inner join ci_orders o ON o.order_id = ci.order_id
		        inner join users u on u.id = ci.user_info_id
				left join ci_shipping_address sp on sp.order_id = o.order_id
		        where ci.vendor_id = '" . $uid . "' and (ci.is_cancel = '1' OR ci.vendor_accept='2') ";

		$sql .= "order by ci.order_id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function orderdownload($uid)
	{
		$sql = "SELECT ci.*, u.fname, u.lname,sp.* from ci_order_item ci
		        inner join ci_orders o ON o.order_id = ci.order_id
		        inner join users u on u.id = ci.user_info_id
				left join ci_shipping_address sp on sp.order_id = o.order_id
		        where ci.vendor_id = '" . $uid . "' ";

		$sql .= "order by ci.order_id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function order_returnlisting($uid)
	{
		$sql = "SELECT * from ci_order_item where vendor_id = '" . $uid . "'   order by order_id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function order_detail_status($uid)
	{
		$sql = "SELECT item.*,ci.*,addres.* from ci_order_item item

		LEFT JOIN ci_orders ci ON ci.order_id = item.order_id

		LEFT JOIN ci_shipping_address addres ON addres.order_id = item.order_id

		where item.order_item_id = '" . $uid . "' order by item.order_id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function order_user($uid)
	{
		$sql = "SELECT * from users where id = '" . $uid . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function get_order_status($uid)
	{
		$sql = "SELECT * from ci_orders where order_id = '" . $uid . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}
	function order_item_status($uid)
	{
		$sql = "SELECT * from ci_order_item where order_id = '" . $uid . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row()->order_status;
			return $result;
		} else {
			return false;
		}
	}
	function  product_imagess($productid)
	{
		$this->db->where('pid = ', $productid);
		$this->db->where('baseimage= ', "1");
		$query = $this->db->get('product_image');
		if ($query->num_rows() > 0) {
			$result = $query->row()->image;
			return $result;
		} else {
			return false;
		}
	}

	function  getOrders($order_id = '', $status = '')
	{
		$this->db->join('users', 'ci_orders.user_id = users.id', 'left');
		$this->db->join('ci_shipping_address', 'ci_orders.order_id = ci_shipping_address.order_id', 'left');
		$this->db->select('users.email as user_email');
		$this->db->select('users.fname as user_name');
		$this->db->select('users.mobile as user_mobile');
		$this->db->select('users.lname as lname');
		$this->db->select('ci_orders.*');
		$this->db->select('ci_shipping_address.*');

		if ($order_id != '') {
			$this->db->where('ci_orders.order_id', $order_id);
		}

		if ($status != '') {
			if ($status == 'Success' or $status == 'FAILED') {
				$this->db->where('ci_orders.payment_status', $status);
			} else {
				$this->db->where('ci_orders.order_status', $status);
			}
		}

		$this->db->order_by('ci_orders.order_id', 'DESC');
		$order_list = $this->db->get('ci_orders')->result_array();


		foreach ($order_list as &$order) {
			$this->db->where('order_id', $order['order_id']);
			$item_list = $this->db->get('ci_order_item')->result_array();
			$total = 0;
			$additonal_cost = 0;
			foreach ($item_list as &$item) {
				$this->db->where('id', $item['product_id']);
				$product = $this->db->get('product')->result_array();
				$total += $item['product_item_price'] * $item['product_quantity'];

				//$item['product_name'] = $product[0];

				//$pname=$product['product_name'];
			}

			$order['items'] = $item_list;
			$order['sub_total'] = $total;
		}
		return $order_list;
	}


	public function update_status($order_id, $order_status)
	{
		$data = array(
			'order_status' => $order_status,
			'status_date' => date("Y-m-d H:i:s"),
		);


		$this->db->where('order_item_id', $order_id);
		if ($this->db->update('ci_order_item', $data)) {
			return true;
		} else {
			return false;
		}
	}
	function allcategoryuser($id)
	{
		$sql = "SELECT * from users where id = '" . $id . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	public function productminpricesearch($pageurl)
	{
		$sql = "select pro.id as id,pa.* from product pro
				inner join product_attribute pa ON pa.pid = pro.id  
				where pro.page_url = '" . $pageurl . "' and is_deleted = 0 and pa.price = (select min(price) from product_attribute where pid = pro.id)";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			$returnprice = round($result->price);
			if ($result->discount > 0 || $result->discount_price > 0) {
				if ($result->discount > 0) {
					$returnprice = round($result->price - ($result->price * ($result->discount / 100)));
				} else {
					$returnprice = round($result->price - $result->discount_price);
				}
			}
			return $returnprice;
		} else {
			return false;
		}
	}
	public function getProductsAjax($search)
	{
		$count = 5;
		$result = array();
		$search_term_array = preg_split('/\s+/', $search['search_term']);
		if (count($search_term_array) == 0) {
			$search_term_array[] = $search['search_term'];
		}
		$search_term_array = array_filter($search_term_array);
		#category (country wise)

		$this->db->select('name as label, page_url as pageurl');
		$this->db->from('category');
		$category_range = "( (";
		foreach ($search_term_array as $category) {
			$category_range .= "name LIKE '%" . $category . "%' AND ";
		}
		$category_range = rtrim($category_range, " AND ");
		$category_range .= ") )";
		$this->db->where($category_range);
		$category_list =  $this->db->get()->result_array();

		//echo "<br/>".$this->db->last_query();  die;
		if ($category_list != null and count($category_list) > 0) {
			foreach ($category_list as $category_price) {
				$below = array();
				$names = $category_price['label'];
				$below[] = array("label" => $names, "url" => "category/" . $category_price['pageurl'], "title" => "Categories");
				$result = array_merge($result, $below);
			}
		}

		#subcategory (country wise)
		$this->db->select('name as label, page_url as pageurl');
		$this->db->from('subcategory');
		//$this->db->where(" FIND_IN_SET ('".$this->session->userdata('country_id')."', countryids) ");
		$subcategory_range = "( (";
		foreach ($search_term_array as $subcategory) {
			$subcategory_range .= "name LIKE '%" . $subcategory . "%' AND ";
		}
		$subcategory_range = rtrim($subcategory_range, " AND ");
		$subcategory_range .= ") ) ";
		$this->db->where($subcategory_range);
		$this->db->limit(5);
		$subcategory_list =  $this->db->get()->result_array();
		//echo "<br/>".$this->db->last_query();
		if ($subcategory_list != null and count($subcategory_list) > 0) {
			foreach ($subcategory_list as $subcatp) {
				$below = array();
				$names = $subcatp['label'];
				$below[] = array("label" => $names, "url" => "category/cat/" . $subcatp['pageurl'], "title" => "Categories");
				$result = array_merge($result, $below);
			}
			//$result = array_merge($result, $subcategory_list);
		}


		$sql = "select s.name as label, s.id from services s 
                left join servicekeywords k ON FIND_IN_SET(k.id,s.keywords_filter) > 0 
                where s.id > 0";

		$sql .= " AND ( MATCH (keywords) AGAINST ('" . addslashes($search['search_term']) . "') OR MATCH (addkeywords) AGAINST ('" . addslashes($search['search_term']) . "') OR MATCH (name) AGAINST ('" . addslashes($search['search_term']) . "') )";

		//$sql .= " AND ( (";
		$i = '1';

		/*foreach ($search_term_array as $category) {
            $sql .= "( keywords LIKE '%".$category."%' OR addkeywords LIKE '%".$category."%' OR name LIKE '%".$category."%')";
            $cnt = count($search_term_array);
            if($i < count($search_term_array)){
                $sql .= " OR ";
            }
            $i++;
        }
        //$sql .= rtrim($sql, " OR ");
        $sql .= ") )"; */

		$sql .= " group by s.id";
		$query = $this->db->query($sql);
		$category_list = $query->result_array();

		//echo "<br/>".$this->db->last_query();  die;
		if ($category_list != null and count($category_list) > 0) {
			foreach ($category_list as $category_price) {
				$below = array();
				$names = $category_price['label'];
				$below[] = array("label" => $names, "url" => "services-detail/" . $category_price['id'], "title" => "Services");
				$result = array_merge($result, $below);
			}
		}

		//print_r($color_list); die;
		//echo "<br/>".$this->db->last_query();

		$this->db->select('product.id as id, product.name as label, product.page_url as pageurl,product.category_id,  (select min(price) from product_attribute where pid = product.id) as
    		`price` ');
		$this->db->from('product');
		//$this->db->select('product_image.image as image');
		//$this->db->where('product_image.baseimage', 1);
		$this->db->where('product.is_deleted', 0);
		$this->db->where('product.is_blocked', 0);
		$this->db->where('product.status', 0);
		//$this->db->join('product_image', 'product_image.pid = product.id', 'left');
		$this->db->join('productkeywords', 'FIND_IN_SET(productkeywords.id,product.keywords_filter) > 0', 'left');

		//$this->db->where_in('categoryid', $category_array);
		$product_range = "(";
		foreach ($search_term_array as $product) {
			//$product_range .= "product.name LIKE '%".$product."%' OR product.tags LIKE '%".$product."%' OR ";
			$product_range .= "( MATCH (product.name, product.tags) AGAINST ('" . addslashes($product) . "') )  OR ";
		}
		$product_range = rtrim($product_range, " OR ");
		$product_range .= ")";

		$product_range = " ((";
		foreach ($search_term_array as $product) {
			$product_range .= "product.name LIKE '%" . addslashes($product) . "%' AND ";
		}

		$product_range = rtrim($product_range, " AND ");
		//$product_range .= ") OR (lower(product.tags) like '%".strtolower($search['search_term'])."%' ) OR (lower(productkeywords.keywords) like '%".strtolower($search['search_term'])."%' ))";
		$product_range .= ") OR ( MATCH (product.tags) AGAINST ('" . addslashes($search['search_term']) . "') ) OR ( MATCH (productkeywords.keywords) AGAINST ('" . addslashes($search['search_term']) . "') ))";

		$this->db->where($product_range);
		$this->db->group_by("product.id");
		$this->db->limit('10');
		//$this->db->order_by('added_date', 'DESC');
		$this->db->order_by('rand()');
		$product_list =  $this->db->get()->result_array();

		if ($product_list != null and count($product_list) > 0) {
			foreach ($product_list as &$product) {
				$this->db->from('product_image');
				$this->db->select('product_image.image as image');
				$this->db->where('product_image.baseimage', 1);
				$this->db->where("baseimage", "1");
				$this->db->where("pid", $product['id']);
				$productimage = $this->db->get()->row();
				$product['image'] = $productimage->image;

				/* $this->db->from('category');
					$this->db->select('category.pageurl,category.categoryname');
					$this->db->where("category.id", $product['categoryid']);
					$category = $this->db->get()->result_array();
					$product['category_pageurl'] = $category[0]['pageurl'];
					$product['category_name'] = $category[0]['categoryname'];*/
			}
			$result = array_merge($result, $product_list);
		}
		/*    $this->db->select('name as label, page_url as pageurl');
        $this->db->from('category');
        $category_range = "( (";
        foreach ($search_term_array as $category) {
            $category_range .= "name LIKE '%".$category."%' AND ";
        }
        $category_range= rtrim($category_range, " AND ");
        $category_range .= ") )";
        $this->db->where($category_range);
		$category_list =  $this->db->get()->result_array();
 */


		return ($result);
		/*  return json_encode($result); */
	}

	function all_service_list($search_term)
	{
		$search_term_array = preg_split('/\s+/', $search_term);
		if (count($search_term_array) == 0) {
			$search_term_array[] = $search_term;
		}
		$search_term_array = array_filter($search_term_array);

		$sql = "select s.* from services s 
                left join servicekeywords k ON FIND_IN_SET(k.id,s.keywords_filter) > 0 
                where s.id > 0";
		$sql .= " AND ( MATCH (keywords) AGAINST ('" . addslashes($search_term) . "') OR MATCH (addkeywords) AGAINST ('" . addslashes($search_term) . "') OR MATCH (name) AGAINST ('" . addslashes($search_term) . "') )";


		/*$sql .= " AND ( (";
        $i='1';
        foreach ($search_term_array as $category) {
            $sql .= "( keywords LIKE '%".$category."%' OR addkeywords LIKE '%".$category."%' OR name LIKE '%".$category."%')";
            $cnt = count($search_term_array);
            if($i < count($search_term_array)){
                $sql .= " OR ";
            }
            $i++;
        }
        //$sql .= rtrim($sql, " OR ");
        $sql .= ") )";*/

		$sql .= " group by s.id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function show_input($id)
	{
		$this->db->where_in('category_id', explode(",", $id));
		$query = $this->db->get('category_input');
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	function show_input_value($product_id, $category_id, $id)
	{
		$value = "";
		if ($product_id != "") {
			$this->db->where('pro_id', $product_id);
			$this->db->where('cat_id', $category_id);
			$this->db->where('cat_input_id', $id);
			$query = $this->db->get('product_property_details');
			if ($query->num_rows() > 0) {
				$value = $query->row()->value;
			}
		}
		return $value;
	}
	function getfiltername($id = 0)
	{
		$this->db->select('filtername.*');
		$this->db->from('filtername');
		if ($id != 0) {
			$this->db->where("subcat_id", $id);
		}
		$getfiltername =  $this->db->get()->result_array();
		if ($getfiltername != "" && count($getfiltername) > 0) {
			foreach ($getfiltername as &$name) {
				$this->db->from('filters_value');
				$this->db->select('filters_value.*');
				$this->db->where("filters_value.filter_id", $name["id"]);
				$name['filters_value'] = $this->db->get()->result_array();
			}
		}
		return $getfiltername;
	}


	function getkeywordsname($id = 0)
	{
		$this->db->select('productkeywords.*');
		$this->db->from('productkeywords');
		if ($id != 0) {
			$this->db->where("service_id", $id);
		}
		$getfiltername =  $this->db->get()->result_array();
		return $getfiltername;
	}

	function deletes_product($content)
	{
		$data1['is_deleted'] = 1;
		$this->db->where('id =', $content);
		if ($this->db->update('product', $data1)) {
			$productdetails = $this->productget($content);
			$vendorid = $productdetails[0]->vendor_id;
			$data2['vendor_id'] 	= $vendorid;
			$data2['tagname'] 	    = 'Product Deleted';
			$data2['message'] 	    = 'Your ' . $productdetails[0]->name . ' has been Deleted.';
			$data2['added_date'] 	= date('Y-m-d');

			$this->_data = $data2;
			if ($this->db->insert('notifications', $this->_data)) { }

			$vendorid = '0';
			$data2['vendor_id'] 	= $vendorid;
			$data2['tagname'] 	    = 'Product Deleted';
			$data2['message'] 	    = 'Your ' . $productdetails[0]->name . ' has been Deleted.';
			$data2['added_date'] 	= date('Y-m-d');

			$this->_data = $data2;
			if ($this->db->insert('notifications', $this->_data)) { }

			return true;
		} else {
			return false;
		}
	}

	function productget($id)
	{
		$this->db->where('id = ', $id);
		$query = $this->db->get('product');
		if ($query->num_rows() > 0) {
			$result = $query->result();

			$product_filter = array();
			$this->db->where('product_id', $id);
			$query = $this->db->get('product_filter');
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $filter) {
					$product_filter[] = $filter->filter_id;
				}
			}
			$result[0]->product_filter = $product_filter;

			return $result;
		} else {
			return false;
		}
	}

	function avgrating($id)
	{
		$sql = "select avg(rating) as rating from reviews where productid = '" . $id . "' and is_approved = '1'";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->row()->rating;
		} else {
			return "0";
		}
	}

	/*function totalreviews($id){
	    $sql = "select r.*, u.fname, u.lname from reviews r
	            left join users u ON u.id = r.userid 
	            where r.productid = '".$id."'  and is_approved = '1'";
		$result = $this->db->query($sql);
		if($result->num_rows() > 0){
			return $result->result();
		} else {
			return false;
		}
	}*/

	function allbadges($id)
	{
		$sql = "select * from badges where id IN (" . $id . ")";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return false;
		}
	}

	function all_data($table, $order_by)
	{
		$sql = "SELECT * from " . $table . " order by " . $order_by . " desc ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function catewiseproduct($cate)
	{
		$sql = "SELECT * from product where category_id = '" . $cate . "' and is_deleted = '0' and status = '0' order by id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	public function getDistributorOrderscount($order_id = '', $status = '')
	{
		$result = array();
		$sql = "SELECT `ci_order_item`.* from ci_order_item Left JOIN ci_orders as ci ON ci_order_item.order_id = ci.order_id where ci_order_item.user_info_id = '" . $this->session->userdata('userid') . "' ";
		if ($status != '') {
			$sql .= " and ci.order_status = '" . $status . "' ";
		}
		$sql .= ' and ci.payment_status = "Success" ';
		$sql .= " order by order_item_id  desc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return $result;
		}
	}

	public function getDistributorOrders($order_id = '', $status = '')
	{
		$this->db->join('users', 'ci_orders.user_id = users.id', 'left');
		$this->db->join('ci_shipping_address', 'ci_orders.order_id = ci_shipping_address.order_id', 'left');
		$this->db->select('users.email as user_email');
		$this->db->select('users.name as user_name');
		$this->db->select('users.mobile as user_mobile');
		//$this->db->select('users.lname as lname');
		$this->db->select('ci_orders.*');
		$this->db->select('ci_shipping_address.*');

		$this->db->where('ci_orders.user_id', $this->session->userdata('userid'));

		//$this->db->where("find_in_set('".$this->session->userdata("userid")."',ci_orders.vendor_id)");

		if ($order_id != '') {
			$this->db->where('ci_orders.order_id', $order_id);
		}
		if ($status != '') {
			$this->db->where('ci_orders.order_status', $status);
		}
		$this->db->where('ci_orders.payment_status', 'Success');
		$this->db->order_by('ci_orders.order_id', 'DESC');
		$order_list = $this->db->get('ci_orders')->result_array();
		// var_dump($this->db->last_query()); exit;
		foreach ($order_list as &$order) {
			$this->db->where('order_id', $order['order_id']);
			$item_list = $this->db->get('ci_order_item')->result_array();
			$total = 0;
			$additonal_cost = 0;
			foreach ($item_list as &$item) {
				$this->db->where('id', $item['product_id']);
				$product = $this->db->get('product')->result_array();
				$total += $item['product_item_price'] * $item['product_quantity'];
				//$item['product_name'] = $product[0];
				//$pname=$product['product_name']; 
			}
			$order['items'] = $item_list;
			$order['sub_total'] = $total;
		}
		return $order_list;
	}

	public function getDistributorTotalOrders($order_id = '', $status = '')
	{
		$this->db->join('users', 'ci_orders.user_id = users.id', 'left');
		$this->db->join('ci_shipping_address', 'ci_orders.order_id = ci_shipping_address.order_id', 'left');
		$this->db->select('users.email as user_email');
		$this->db->select('users.name as user_name');
		$this->db->select('users.mobile as user_mobile');
		//$this->db->select('users.lname as lname');
		$this->db->select('ci_orders.*');
		$this->db->select('ci_shipping_address.*');

		$this->db->where('ci_orders.user_id', $this->session->userdata('userid'));

		//$this->db->where("find_in_set('".$this->session->userdata("userid")."',ci_orders.vendor_id)");

		if ($order_id != '') {
			$this->db->where('ci_orders.order_id', $order_id);
		}
		$this->db->where('ci_orders.payment_status', 'Success');
		$this->db->order_by('ci_orders.order_id', 'DESC');
		$order_list = $this->db->get('ci_orders')->result_array();
		//echo $this->db->last_query(); die;
		foreach ($order_list as &$order) {
			$this->db->where('order_id', $order['order_id']);
			$item_list = $this->db->get('ci_order_item')->result_array();
			$total = 0;
			$additonal_cost = 0;
			foreach ($item_list as &$item) {
				$this->db->where('id', $item['product_id']);
				$product = $this->db->get('product')->result_array();
				$total += $item['product_item_price'] * $item['product_quantity'];
				//$item['product_name'] = $product[0];
				//$pname=$product['product_name']; 
			}
			$order['items'] = $item_list;
			$order['sub_total'] = $total;
		}
		return $order_list;
	}

	function addtowishlistajax($id)
	{
		$sql = "select * from wishlist where userid ='" . $this->session->userdata('userid') . "' and pid = '" . $id . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() == '0') {
			$sql = "INSERT INTO `wishlist` (`userid`, `pid`,`added_date`) VALUES ('" . $this->session->userdata('userid') . "', '" . $id . "','" . date('Y-m-d') . "');";
			$query = $this->db->query($sql);
			return '1';
		}
	}

	function wishlist($uid)
	{

		$sql = "SELECT p.*,w.id as wish_id FROM product p INNER JOIN wishlist w on w.pid=p.id where w.userid=" . $uid . " order by w.id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function allproductCustomer($pg_num, $offset, $content)
	{
		//print_r($content); die;
		if ($this->session->userdata('check_pincode') != '') {
			$pincode = $this->session->userdata('check_pincode');
		} else if ($this->session->userdata('pincode') != '') {
			$pincode = $this->session->userdata('pincode');
		} else {
			$pincode = '0';
		}
		if ($offset == '') {

			$offset = '0';
		}

		/*$sql = "SELECT p.* FROM product p 
		INNER JOIN ci_order_item item ON item.product_id  = p.id 
		LEFT JOIN product_stock_details as stock ON stock.pro_id = p.id  
		LEFT JOIN pincode as pincode ON pincode.id = stock.pincode_id 
		where p.id <> 0 and p.is_deleted = 0 and p.status = 0 and pincode.name IN (".$pincode.")  ";*/

		$sql = "SELECT p.*,item.user_info_id FROM product p 
		INNER JOIN ci_order_item item ON item.product_id  = p.id  and item.is_customer = 0 
		LEFT JOIN users as users ON users.id = item.user_info_id 
		where p.id <> 0 and p.is_deleted = 0 and p.status = 0 and FIND_IN_SET(" . $pincode . ",users.pincode) ";

		if (!empty($content['subcateid'])) {
			$sql .= " and p.subcatefory_id =" . $content['subcateid'] . " ";
		}

		if ($content['search'] != '') {
			$sql .= " and ( p.name Like '%" . $content['search'] . "%' OR p.product_code Like '%" . $content['search'] . "%') ";
		}

		if (!empty($content['subcateid'])) {
			$sql .= " and p.subcatefory_id =" . $content['subcateid'] . " ";
		}

		if (!empty($content['brand'])) {
			$categorys = explode(',', $content['brand']);
			if ($categorys != '') {
				$sql .= " AND (";
				for ($i = '0'; $i < count($categorys); $i++) {
					$sql .= "  find_in_set( '" . $categorys[$i] . "', p.brand_id ) ";
					if ($i != count($categorys) - 1) {
						$sql .= " OR ";
					}
				}
				$sql .= ") ";
			}
		}

		if ($content['sort_by'] != "") {
			if ($content['sort_by'] == 'lowtohigh') {
				$sql .=  " GROUP BY p.id order by p.bpcl_special_price asc LIMIT " . $offset . "," . $pg_num;
			}
			if ($content['sort_by'] == 'hightolow') {
				$sql .=  " GROUP BY p.id order by p.bpcl_special_price desc LIMIT " . $offset . "," . $pg_num;
			}

			if ($content['sort_by'] == 'atoz') {
				$sql .=  " GROUP BY p.id order by p.material_name asc LIMIT " . $offset . "," . $pg_num;
			}
		} else {
			$sql .=  " GROUP BY p.id ORDER BY p.id desc LIMIT " . $offset . "," . $pg_num;
		}
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		/*$sql_couint = "SELECT p.* FROM product p INNER JOIN ci_order_item item ON item.product_id = p.id LEFT JOIN product_stock_details as stock ON stock.pro_id = p.id LEFT JOIN pincode as pincode ON pincode.id = stock.pincode_id  where p.id <> 0 and p.is_deleted = 0 and p.status = 0 and pincode.name IN (".$pincode.")  ";*/

		$sql_couint = "SELECT p.*,item.user_info_id FROM product p 
		INNER JOIN ci_order_item item ON item.product_id  = p.id  and item.is_customer = 0 
		LEFT JOIN users as users ON users.id = item.user_info_id 
		where p.id <> 0 and p.is_deleted = 0 and p.status = 0 and FIND_IN_SET(" . $pincode . ",users.pincode)  ";

		if (!empty($content['category_serarch'])) {
			$sql_couint .= " and p.category_id =" . $content['category_serarch'] . " ";
		}

		if ($content['search'] != '') {
			$sql_couint .= " and ( p.name Like '%" . $content['search'] . "%' OR p.product_code Like '%" . $content['search'] . "%') ";
		}

		/*if($content['subcategory'] == 'search')
			{
				$sql_couint .=" and ( p.name Like '%".$content['subcategory']."%' OR p.product_code Like '%".$content['subcategory']."%') ";
			}*/

		if (!empty($content['brand'])) {
			$categorys = explode(',', $content['brand']);
			if ($categorys != '') {
				$sql_couint .= " AND (";
				for ($i = '0'; $i < count($categorys); $i++) {
					$sql_couint .= "  find_in_set( '" . $categorys[$i] . "', p.brand_id ) ";
					if ($i != count($categorys) - 1) {
						$sql_couint .= " OR ";
					}
				}
				$sql_couint .= ") ";
			}
		}

		if (!empty($content['subcateid'])) {
			$sql_couint .= " and p.subcatefory_id =" . $content['subcateid'] . " ";
		}

		//$sql_couint .=  "  GROUP BY p.id ORDER BY p.id desc ";

		if ($content['sort_by'] != "") {
			if ($content['sort_by'] == 'lowtohigh') {
				$sql_couint .=  " GROUP BY p.id order by p.bpcl_special_price asc ";
			}
			if ($content['sort_by'] == 'hightolow') {
				$sql_couint .=  " GROUP BY p.id order by p.bpcl_special_price desc ";
			}

			if ($content['sort_by'] == 'atoz') {
				$sql_couint .=  " GROUP BY p.id order by p.material_name asc ";
			}
		} else {
			$sql_couint .=  "  GROUP BY p.id ORDER BY p.id desc";
		}


		$query1 = $this->db->query($sql_couint);
		//$results = $query->result();
		if ($query->num_rows() > 0) {
			$ret['result'] = $query->result();
			$ret['count']  = $query1->num_rows();
			return $ret;
		} else {
			return false;
		}
	}



	public function checkLoginCustomer($data)
	{
		$sql = "select * from users where (email = '" . $data['email'] . "') AND password = '" . $data['password'] . "' AND user_vendor = 0 ";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return "0";
		}
	}

	public function checkLogin_active_new_customer($data)
	{
		$sql = "select * from users where (email = '" . addslashes($data['email']) . "') AND password = '" . addslashes($data['password']) . "' AND user_vendor = 0 and status = 0";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->row();
		} else {
			return false;
		}
	}

	function userlogincustomer($arrContent)
	{

		$sql = "select * from users where (email = '" . addslashes($arrContent['email']) . "' ) AND password = '" . addslashes($arrContent['password']) . "' AND user_vendor = 0";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function add_user_data($content)
	{
		$data['name'] = $content['name'];
		$data['email'] = $content['email'];
		$data['password'] = $content['password'];
		$data['pincode'] = $content['pincode'];
		$data['mobile'] = $content['mobile'];
		$data['added_date'] = date('Y-m-d');
		$data['user_vendor'] = '0';
		$this->_data = $data;
		if ($this->db->insert('users', $this->_data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function getDistributorOrdersCustomerStock($order_id = '', $status = '')
	{

		$sql = "SELECT ci.*,sum(ci.product_quantity) as product_quantity from ci_order_item ci
		inner join ci_orders o ON o.order_id = ci.order_id
				where ci.user_info_id = '" . $this->session->userdata("userid") . "' and o.payment_status = 'Success' and o.order_status = 'R' group by ci.product_id ";


		$sql .= " order by ci.order_id desc";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	public function getVendorOrdersCustomerStock()
	{

		$sql = "SELECT * from product where user_id='" . $this->session->userdata("userid") . "' and is_deleted = 0";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	public function getDistributorDeliveryBoys()
	{

		$sql = "SELECT * from users where distributor_id = '" . $this->session->userdata("userid") . "' and user_vendor = 3 order by name asc";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	public function assign_delivery_boy_order($deliveryBoyId, $orderid)
	{
		$data = array(
			'deliveryBoyId' => $deliveryBoyId,
		);
		$this->db->where('order_id', $orderid);
		if ($this->db->update('ci_orders', $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function get_vendor_tqty($pid)
	{

		$sql = "SELECT sum(inventory) as total_qty from product_stock_details ci
				where ci.pro_id = '" . $pid . "'";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->row()->total_qty;
			return $result;
		} else {
			return false;
		}
	}


	public function get_vendor_qty($pid)
	{

		$sql = "SELECT sum(product_quantity) as total_qty from ci_order_item ci
		inner join ci_orders o ON o.order_id = ci.order_id
		where ci.product_id = '" . $pid . "' and ci.vendor_id = '" . $this->session->userdata("userid") . "' and ci.is_customer = 0 and o.payment_status = 'Success'";

		$sql .= " order by ci.order_id desc";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->row()->total_qty;
			return $result;
		} else {
			return false;
		}
	}

	public function get_distributor_qty($pid)
	{

		// $sql = "SELECT sum(product_quantity) as total_qty from ci_order_item ci
		// 		where ci.product_id = '".$pid."' and distributor_id = '".$this->session->userdata("userid")."' ";

		$sql = "SELECT sum(product_quantity) as total_qty from ci_order_item ci
		inner join ci_orders o ON o.order_id = ci.order_id
		where ci.product_id = '" . $pid . "' and ci.distributor_id = '" . $this->session->userdata("userid") . "' and ci.is_customer = 1 and o.payment_status = 'Success'";

		$sql .= " order by ci.order_id desc";


		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->row()->total_qty;
			return $result;
		} else {
			return false;
		}
	}


	public function getDistributorOrdersCustomer($order_id = '', $status = '')
	{

		$status;
		$sql = "SELECT o.*,sp.* from ci_order_item ci
		        inner join ci_orders o ON o.order_id = ci.order_id
		        -- inner join users u on u.id = ci.user_info_id
				left join ci_shipping_address sp on sp.order_id = o.order_id
				where ci.distributor_id = '" . $this->session->userdata("userid") . "' and ci.is_customer=2 or ci.is_customer=1 ";
		if ($status != '') {
			$sql .= ' and ci.order_status = "' . $status . '" ';
		}
		$sql .= " and o.payment_status = 'Success' ";
		$sql .= "group by o.order_id order by ci.order_id desc";

		//echo $sql;
		$query = $this->db->query($sql);
		// var_dump($this->db->last_query());exit;
		if ($query->num_rows() > 0) {
			$order_list = $query->result_array();
			foreach ($order_list as &$order) {
				$this->db->where('order_id', $order['order_id']);
				$item_list = $this->db->get('ci_order_item')->result_array();
				$total = 0;
				$additonal_cost = 0;
				foreach ($item_list as &$item) {
					$this->db->where('id', $item['product_id']);
					$product = $this->db->get('product')->result_array();
					$total += $item['product_item_price'] * $item['product_quantity'];
					//$item['product_name'] = $product[0];
					//$pname=$product['product_name']; 
				}
				$order['items'] = $item_list;
				$order['sub_total'] = $total;
			}
			return $order_list;
			//return $result;
		}

		/*$this->db->join('users','ci_orders.user_id = users.id', 'left');
			$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
			$this->db->select('users.email as user_email');
			$this->db->select('users.name as user_name');
			$this->db->select('users.mobile as user_mobile');
			//$this->db->select('users.lname as lname');
			$this->db->select('ci_orders.*');
			$this->db->select('ci_shipping_address.*');
		 	
		 	//$this->db->where('ci_orders.user_id', $this->session->userdata('userid'));
		 	$this->db->where('ci_orders.is_customer', 1);
		 	$this->db->where("find_in_set('".$this->session->userdata("userid")."',ci_orders.distributor_id)");

        if ($order_id != '') {
            $this->db->where('ci_orders.order_id', $order_id);
		}
		if ($status != '') {
            if($status == 'Success' OR $status == 'FAILED'){ 
				$this->db->where('ci_orders.payment_status',$status);
			}else{
				$this->db->where('ci_orders.order_status',$status);
			}
		}				
	    $this->db->order_by('ci_orders.order_id', 'DESC');
        $order_list = $this->db->get('ci_orders')->result_array();
		echo $this->db->last_query(); die;
        foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $item_list = $this->db->get('ci_order_item')->result_array();
            $total = 0;
            $additonal_cost = 0;
            foreach ($item_list as &$item) {
                $this->db->where('id', $item['product_id']);
                $product = $this->db->get('product')->result_array(); 
                $total += $item['product_item_price']*$item['product_quantity'];
				//$item['product_name'] = $product[0];
				//$pname=$product['product_name']; 
            }
    		$order['items'] = $item_list;
            $order['sub_total'] = $total;
	    }
        return $order_list;*/
	}

	public function getDeliveryBoyOrdersCustomer($order_id = '', $status = '')
	{

		$sql = "SELECT o.*,sp.* from ci_order_item ci
		        inner join ci_orders o ON o.order_id = ci.order_id
		        inner join users u on u.id = ci.user_info_id
				left join ci_shipping_address sp on sp.order_id = o.order_id
				where o.deliveryBoyId = '" . $this->session->userdata("userid") . "' ";

		$sql .= "group by o.order_id order by ci.order_id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$order_list = $query->result_array();
			foreach ($order_list as &$order) {
				$this->db->where('order_id', $order['order_id']);
				$item_list = $this->db->get('ci_order_item')->result_array();
				$total = 0;
				$additonal_cost = 0;
				foreach ($item_list as &$item) {
					$this->db->where('id', $item['product_id']);
					$product = $this->db->get('product')->result_array();
					$total += $item['product_item_price'] * $item['product_quantity'];
				}
				$order['items'] = $item_list;
				$order['sub_total'] = $total;
			}
			return $order_list;
		}
	}

	function allproductCustomerlatest()
	{
		/*$sql = "SELECT p.* FROM product p INNER JOIN ci_order_item item ON item.product_id  = p.id  where p.id <> 0 and is_deleted = 0 and status = 0 ";*/

		if ($this->session->userdata('pincode') != '') {
			$pincode = $this->session->userdata('pincode');
		} else if ($this->session->userdata('check_pincode') != '') {
			$pincode = $this->session->userdata('check_pincode');
		} else {
			$pincode = '0';
		}
		$sql = "SELECT p.* FROM product p 
		INNER JOIN ci_order_item item ON item.product_id  = p.id  and item.is_customer = 0 
		LEFT JOIN users as users ON users.id = item.user_info_id 
		where p.id <> 0 and p.is_deleted = 0 and p.status = 0 and FIND_IN_SET(" . $pincode . ",users.pincode)  ";

		$sql .=  " GROUP BY p.id ORDER BY item.product_id desc LIMIT 4";

		$query = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0) {
			$ret['result'] = $query->result();
			return $ret;
		} else {
			return false;
		}
	}

	// function allproductCustomerFeatured()
	// {
	// 	$sql = "SELECT p.* FROM product p INNER JOIN ci_order_item item ON item.product_id  = p.id  where p.id <> 0 and p.is_deleted = 0 and p.status = 0 and p.featured = '1' ";
	// 	$sql .=  " GROUP BY p.id ORDER BY item.product_id desc LIMIT 4";
	// 	$query = $this->db->query($sql);
	//     if($query->num_rows() > 0){
	// 		$ret = $query->result();
	// 		return $ret;
	// 	} else {
	// 		return false;
	// 	}
	// }

	function allproductCustomerFeatured()
	{
		//print_r($content); die;
		if ($this->session->userdata('check_pincode') != '') {
			$pincode = $this->session->userdata('check_pincode');
		} else if ($this->session->userdata('pincode') != '') {
			$pincode = $this->session->userdata('pincode');
		} else {
			$pincode = '0';
		}

		$sql = "SELECT p.*,item.user_info_id FROM product p 
		INNER JOIN ci_order_item item ON item.product_id  = p.id  and item.is_customer = 0 
		LEFT JOIN users as users ON users.id = item.user_info_id 
		where p.id <> 0 and p.is_deleted = 0 and p.status = 0 and p.featured = '1' and FIND_IN_SET(" . $pincode . ",users.pincode) ";

		$sql .=  " GROUP BY p.id ORDER BY p.id desc LIMIT 4";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$ret = $query->result();
			return $ret;
		} else {
			return false;
		}
	}


	function get_product_image($id)
	{
		$sql = "SELECT e.* FROM product_image e where e.pid='" . $id . "'  ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function updatepassword($password, $user_id)
	{
		$data['password'] = $password;
		$this->db->where('id', $user_id);
		if ($this->db->update('users', $data)) {
			return true;
		} else {
			return false;
		}
	}

	function all_state()
	{
		$query = $this->db->get('state');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function totalreviews($id)
	{
		$sql = "select r.*, u.name from reviews r
	            left join users u ON u.id = r.userid 
	            where r.productid = '" . $id . "'  and is_approved = '1' order by id desc";
		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return false;
		}
	}

	function add_review($data)
	{
		if ($this->db->insert('reviews', $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	function  getOrdersDistributor($order_id = '', $status = '')
	{
		//echo $order_id; die;
		$this->db->join('users', 'ci_orders.user_id = users.id', 'left');
		$this->db->join('ci_shipping_address', 'ci_orders.order_id = ci_shipping_address.order_id', 'left');
		$this->db->select('users.email as user_email');
		$this->db->select('users.name as user_name');
		$this->db->select('users.mobile as user_mobile');
		//$this->db->select('users.lname as lname');
		$this->db->select('ci_orders.*');
		$this->db->select('ci_shipping_address.*');

		if ($order_id != '') {
			$this->db->where('ci_orders.order_id', $order_id);
		}

		if ($status != '') {
			if ($status == 'Success' or $status == 'FAILED') {
				$this->db->where('ci_orders.payment_status', $status);
			} else {
				$this->db->where('ci_orders.order_status', $status);
			}
		}

		$this->db->order_by('ci_orders.order_id', 'DESC');
		$order_list = $this->db->get('ci_orders')->result_array();


		foreach ($order_list as &$order) {
			$this->db->where('order_id', $order['order_id']);
			$item_list = $this->db->get('ci_order_item')->result_array();
			$total = 0;
			$additonal_cost = 0;
			foreach ($item_list as &$item) {
				$this->db->where('id', $item['product_id']);
				$product = $this->db->get('product')->result_array();
				$total += $item['product_item_price'] * $item['product_quantity'];

				//$item['product_name'] = $product[0];

				//$pname=$product['product_name'];
			}

			$order['items'] = $item_list;
			$order['sub_total'] = $total;
		}
		return $order_list;
	}

	public function getOrdersDistributors($order_id = '', $status = '', $startdate = '', $enddate = '', $distributor_id = '')
	{
		$this->db->join('users', 'ci_orders.user_id = users.id', 'left');
		$this->db->join('ci_shipping_address', 'ci_orders.order_id = ci_shipping_address.order_id', 'left');
		$this->db->select('users.email as user_email');
		$this->db->select('users.name as user_name');
		$this->db->select('users.mobile as user_mobile');
		//$this->db->select('users.lname as lname');
		$this->db->select('ci_orders.*');
		$this->db->select('ci_shipping_address.*');

		$this->db->where('ci_orders.is_customer', '0');
		if ($order_id != '') {
			$this->db->where('ci_orders.order_id', $order_id);
		}

		if ($startdate != '') {
			$this->db->where("DATE(`ci_orders`.`cdate`) >= '" . date('Y-m-d', strtotime($startdate)) . "' ");
		}

		if ($enddate != '') {
			$this->db->where("DATE(`ci_orders`.`cdate`) <= '" . date('Y-m-d', strtotime($enddate)) . "' ");
		}
		if ($distributor_id != '') {
			$this->db->where('ci_orders.user_id', $distributor_id);
		}

		if ($status != '') {
			if ($status == 'SUCCESS' or $status == 'FAILED') {
				$this->db->where('ci_orders.payment_status', $status);
			} else {
				$this->db->where('ci_orders.order_status', $status);
			}
		}
		$this->db->order_by('ci_orders.order_id', 'DESC');
		$order_list = $this->db->get('ci_orders')->result_array();
		//echo $this->db->last_query(); die;
		foreach ($order_list as &$order) {
			$this->db->where('order_id', $order['order_id']);
			$item_list = $this->db->get('ci_order_item')->result_array();
			$total = 0;
			$additonal_cost = 0;
			foreach ($item_list as &$item) {
				$this->db->where('id', $item['product_id']);
				$product = $this->db->get('product')->result_array();
				$total += $item['product_item_price'] * $item['product_quantity'];
				//$item['product_name'] = $product[0];
				//$pname=$product['product_name']; 
			}
			$order['items'] = $item_list;
			$order['sub_total'] = $total;
		}
		return $order_list;
	}

	public function getDistributorName($user_id)
	{
		$sql = $this->db->select("id, name")->from("users")->where("id", $user_id)->get()->result_array();
		return $sql;
	}
}
