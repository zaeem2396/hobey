<?php
class Reviews extends CI_Controller
{
    private $data = array();
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminId') == null) {
            redirect($this->config->item('base_url'));
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->model('reviews_model');
    }

    public function lists($status='')
    {
        $this->data['orders_list'] = $this->reviews_model->getOrders($id='',$status);
        //print_R($this->data['orders_list']); die;
	    $this->load->view('list_reviews', $this->data);
    }
    
    function updatestatus($id,$value)
	{
		$result=$this->reviews_model->updatestatus($id,$value);
		$result_data = $this->reviews_model->getuserdata($id); 
		
		if($value == '1') {
            $email = $result_data->email; //$this->config->item('admin_email');
			$message = '<!doctype html><html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Reviews Posted</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('front_base_url').'"><img src="'.$this->config->item('front_base_url').'site/views/images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		 
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
 			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Dear '.$result_data->fname.' '.$result_data->lname.',</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Your review has been posted & we appreciate your valuable feedback. We look forward to giving you many positive experiences & healthy choices.</p>
		</div>
		
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		 
		<div style="clear: both">
	</div></div>
</body>
</html>';

        $subject = "Review Posted";
		$to = $email;
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Happysoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		mail($to, $subject, $message, $headers);


		$to = $this->config->item('review_email');
        mail($to, $subject, $message, $headers);    
            
		$this->session->set_flashdata('L_strErrorMessage','Product Approved Succcessfully');
    }
		
		
		$this->session->set_flashdata('L_strErrorMessage','Status Updated Succcessfully!!!!');
		//redirect($this->config->item('base_url').'vendor/allproducts');
		echo "1";
	}
   
}