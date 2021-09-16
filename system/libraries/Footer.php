<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2010, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------
/**
 * Session Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/sessions.html
 */
	/**
	 * Session Constructor
	 *
	 * The constructor runs the session routines automatically
	 * whenever the class is instantiated.
	 */
class CI_Footer {
       var $CI;

       function CI_Footer() {
            $this->CI =& get_instance();
			$this->CI->load->database();
       }
	   
	   function allsubscribe_head()
		{
			$sql = "SELECT * FROM subscribe order by id desc";
			$query = $this->CI->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}else{
			return false;
		}
		}
		function allcategory()
		{
			$sql = "SELECT * FROM category order by id asc";
			$query = $this->CI->db->query($sql);
			if ($query->num_rows() > 0)
			{
				$result = $query->result();
				return $result;
			}else{
				return false;
			}
		}
		
		function allsubcategory($id)
		{
			$sql = "SELECT * FROM subcategory where category_id = '".$id."' order by id desc";
			$query = $this->CI->db->query($sql);
			if ($query->num_rows() > 0)
			{
				$result = $query->result();
				return $result;
			}else{
				return false;
			}
		}
		
		function category_name($id="")
		{
			if($id !='')
			{
				$sql = "SELECT * FROM category where id=".$id;
				$query = $this->CI->db->query($sql);
				if ($query->num_rows() > 0)
				{
					$result = $query->row()->name;
					return $result;
				}else{
					return false;
				}	
			}else
			{
				echo "All Categories ";
			}
			
		}
		
		
		function all_sub_subcategory($subcate_id,$pincode_session,$flag)
		{
			if($flag==0){
			$sql = "SELECT *,( select count(*) from product p INNER JOIN customer c ON c.id=p.vendor where subsubcategory_id = subsubcategory.id and c.pincode='".$pincode_session."' ) as `totalproduct` FROM subsubcategory where subcategory_id=".$subcate_id." order by id desc";
			}else{
			$sql = "SELECT *,( select count(*) from product p where subsubcategory_id = subsubcategory.id ) as `totalproduct` FROM subsubcategory where subcategory_id=".$subcate_id." order by id desc";	
				
			}
			$query = $this->CI->db->query($sql);
			if ($query->num_rows() > 0)
			{
				$result = $query->result();
				return $result;
			}else{
				return false;
			}
		}
		
		
}
// END Session Class

/* End of file Session.php */
/* Location: ./system/libraries/Session.php */
