<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
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
class CI_Footer {
	var $CI;

	function CI_Footer() {
			$this->CI =& get_instance();
	}
 	
    function getuser($id)
	{
 	   	$sql = "SELECT * FROM admin_user where id =".$id."";
		$query = $this->CI->db->query($sql);
		return $query->result();
 	}
	function usercategory($id)
	{
 	   	$sql = "SELECT * FROM usercategory where id = '".$id."' ";
		$query = $this->CI->db->query($sql);
		return $query->result();
 	}
}
// END Session Class

/* End of file Session.php */
/* Location: ./system/libraries/Session.php */