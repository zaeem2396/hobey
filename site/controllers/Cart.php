<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends CI_Controller {

	private $_data = array();
	function __construct() {
		parent::__construct();				
		$this->load->model('cart_model');

		$this->load->model('home_model');
		$product_name_rules = '\.\:\-_ a-z0-9\d\D';
	}
	
	function index()
	{
		$data['err_msg'] = '';	
		$this->load->view('cart',$data);
	} 
	function addtocart(){ 
		//print_r($this->input->post('extra_price')); die;
		$pid = $this->input->post('product_id');
		$qty = $this->input->post('qty');
		$price = $this->input->post('total_price');
		$min_qty = $this->input->post('min_qty');
		
		$details = $this->cart_model->prodetails($pid);	

		$get_total_qty = $this->cart_model->get_total_qty($pid);		
		//print_r($details); die;
		$cate_detaisl = $this->home_model->get_category($details->material_type);
		//	echo $get_total_qty; die;
		if(($details->inventory) >= ($qty+$get_total_qty))
		{

		$data['cartprod'] = array(
		'id'      => $details->id,
		'qty'     => $qty,
		'min_qty'     => $min_qty,
		'price'   => round($price),
		'name'    => $details->material_name,
		'options' => array('material_code'=>@$details->material_code,'material_type'=>$cate_detaisl->name,'base_image'=>@$details->product_image,'mrp'=>@$details->mrp,'vendor_id'=>@$details->user_id)
 	        );
		//print_r($data); die;
		$this->cart->insert($data);
		//print_R($this->cart->contents());
		echo $this->cart->total_items();		
		}else
		{
			/*redirect($this->config->item('base_url')."product/".$details->page_url);*/
			 echo "nostock"; 
		}
 	}		

 	function customer_addtocart(){ 
		//print_r($this->input->post('extra_price')); die;
		$pid = $this->input->post('product_id');
		$qty = $this->input->post('qty');
		$price = $this->input->post('total_price');
		$distributor_id = $this->input->post('distributor_id');
		$details = $this->cart_model->prodetailsCustomerNew($pid,$distributor_id);		
		//print_r($details); die;
		$cate_detaisl = $this->home_model->get_category(@$details->material_type);
		$sold_qty = $this->cart_model->productDistributorQty($pid,$distributor_id);	
		$sold_qty_new = $this->cart_model->productCustomreDistributorQty($pid,$distributor_id);	
		$total_qty_sold =  $sold_qty_new + $qty;
		//echo $total_qty_sold; die;
		if($sold_qty >= $total_qty_sold) {
		$data['cartprod'] = array(
		'id'      => $details->id,
		'qty'     => $qty,
		'price'   => round($price),
		'name'    => $details->material_name,
		'options' => array('is_col_product'=>@$details->is_col_product,'material_code'=>@$details->material_code,'material_type'=>$cate_detaisl->name,'base_image'=>@$details->product_image,'mrp'=>@$details->mrp,'vendor_id'=>@$details->user_id,'distributor_id'=>@$distributor_id)
 	        );
		//print_r($data); die;
		$this->cart->insert($data);
		//print_R($this->cart->contents());
		echo $this->cart->total_items();	
		} else {
			echo 'nostock';
		}	
		
 	}


	 function checkCartstock(){ 
		$pid = $this->input->post('product_id');
		$qty = $this->input->post('qty');
		$distributor_id = $this->input->post('distributor_id');
		$sold_qty = $this->cart_model->productDistributorQty($pid,$distributor_id);	
		$sold_qty_new = $this->cart_model->productCustomreDistributorQty($pid,$distributor_id);	
		$total_qty_sold =  $sold_qty_new + $qty;
		if($sold_qty >= $total_qty_sold) {
			echo 'instock';
		} else {
			echo 'nostock';
		}	
		
 	}

	 function sp_customer_addtocart(){ 
		//print_r($this->input->post('extra_price')); die;
		$pid = $this->input->post('product_id');
		$qty = $this->input->post('qty');
		$price = $this->input->post('total_price');
		$distributor_id = $this->input->post('distributor_id');
		$details = $this->cart_model->getSpPro($pid);		
		//echo "<pre>";print_r($details);echo "</pre>";
		$cate_detaisl = $this->home_model->get_category(@$details->material_type);
		$sold_qty = $this->cart_model->spSoldQty($pid);	
		$sold_qty_new = $details->quantity;	
		if($sold_qty == '' or $sold_qty == null){
			$sold_qty = 0;
		}
		//$total_qty_sold =  $sold_qty_new + $qty;
		if($sold_qty < $sold_qty_new) {
			
		$data['cartprod'] = array(
		'id'      => $details->id,
		'qty'     => $qty,
		'price'   => round($price),
		'name'    => $details->material_name,
		'options' => array('is_col_product'=>@$details->is_col_product,'material_code'=>@$details->material_code,'material_type'=>$cate_detaisl->name,'base_image'=>@$details->product_image,'mrp'=>@$details->mrp,'vendor_id'=>@$details->user_id,'distributor_id'=>@$distributor_id)
 	        );
		//print_r($data); die;
		$this->cart->insert($data);
		//echo "<pre>";print_r($this->cart->contents());echo "</pre>";

		echo $this->cart->total_items();	
		} else {
			echo 'nostock';
		}	
		
 	}
 	
	function update_header()	{

	$base_url =$this->config->item("base_url");	
	$http_host =$this->config->item("http_host");	
	$html ="";							
				
	if($this->cart->total_items() > 0) {
		$i = 1;		
		$html .='<ul class="cart-list">';		
		foreach($this->cart->contents() as $items) 
		{ 						
		$html .='<li>                      
		<a title="Remove item" class="remove" onclick="removeproduct_ajax(\''.$items['rowid'].'\')" href="javascript:void(0);">×</a>   
		<a href="#">					
		';						
		$html .='  <img width="90" height="90" alt="" src="'.$http_host.'upload/products/medium/'.$items['options']['base_image'].'">';				
		$html .=''.$items['name'].'</a> <span class="quantity">'.$items['qty'].' × <span class="amount">'.$this->session->userdata('currencysymbol').' '.round(($items['price'] / $this->session->userdata('currencyrate'))) .'</span></span> </li>';
		}							

		$html .='</ul> <p class="total">Subtotal: <span class="amount">
		'.$this->session->userdata('currencysymbol').' '.round(($this->cart->total() / $this->session->userdata('currencyrate'))).'</span>				
		</p>					
		<p class="buttons">		
		<a href="'.$base_url.'cart" class="btn btn-very-small-white no-margin-bottom margin-seven pull-left no-margin-lr">View Cart</a>';
		if($this->session->userdata('userid') !=''){ 
				$html .='<a href="'.$base_url.'cart/chekout" class="btn btn-very-small-white no-margin-bottom margin-seven no-margin-right pull-right">Checkout</a>';
			}else{ 
				$html .='<a href="javascript:void(0);" data-toggle="modal" data-target="#login" class="btn btn-very-small-white no-margin-bottom margin-seven no-margin-right pull-right">Checkout</a>';
			}                                    
								
		$html .='</p>';			
		}else{ $html .='<ul class="cart-list">Your cart is Empty.</ul>'; }			
		echo $html; 	
		}		
		
		function removeproduct_ajax($remove)	
		{		
		$data = array('rowid'=>$remove , 'qty' => 0);	
		$this->cart->update($data); 	
		echo $this->cart->total_items();	
		}			
		
		
	function removeproduct($remove)
	{
		$data = array('rowid'=>$remove , 'qty' => 0);
		$this->cart->update($data);
		$this->session->set_flashdata('register_success','Product Deleted Successfully!');
		redirect($this->config->item('base_url')."distributor-cart");
	}

	function removeproduct_customer($remove)
	{
		$data = array('rowid'=>$remove , 'qty' => 0);
		$this->cart->update($data);
		$this->session->set_flashdata('msg_success','Product Deleted Successfully!');
		redirect($this->config->item('base_url')."customer-cart");
	}
	function changeqty_customer($rowid, $qty)
	{
		$data = array('rowid'=>$rowid , 'qty' => $qty);
		$this->cart->update($data); 
		$this->session->set_flashdata('msg_success','Quantity Update Successfully!');
		redirect($this->config->item('base_url').'customer-cart');
	}
	function changeqty($rowid, $qty)
	{
		$data = array('rowid'=>$rowid , 'qty' => $qty);
		$this->cart->update($data); 
		$this->session->set_flashdata('msg_success','Quantity Update Successfully!');
		redirect($this->config->item('base_url').'distributor-cart');
	}
	function chekout()
	{
		$data['err_msg'] = '';	
		$data['user_address'] = $this->cart_model->user_address();
		$data['allcountry'] = $this->cart_model->allcountry();
		$this->load->view('chekout',$data);
	}
	function couponcheck()
	{
				$coupan = $this->input->post("coupon");		
				$select_coupan = $this->cart_model->selectcoupancode($coupan);
				if($this->session->userdata('coupancode') !=  $coupan)
				{							
					if($select_coupan !='')
					{			
						$coupan_data= array(
							'couponid'  => $select_coupan->id,
							'coupanname'  => $select_coupan->name,
							'coupancode'  => $select_coupan->code,
							'discount'  => $select_coupan->discount,
							'coupanvalue'  => $select_coupan->value,
						);	
						$this->session->set_userdata($coupan_data); 
						echo 'success';	
						}else
					{
						echo "invalid";
					} 
				}
				else
				{
					echo "Already";
				}		
	}
	function updatetotal()
	{	
			$html='';
			$total = $this->cart->total(); 
			$discountamount="0";
				if($this->session->userdata('coupancode') !='')
				{
					$coupan_type=$this->session->userdata('coupanvalue'); 
					if($coupan_type==0){ 
						$discount=($total*$this->session->userdata('discount')/100);
						$discountamount = $discount;
					 }else{
						$discountamount = $this->session->userdata('discount');
					 } 
				} 
			if($discountamount !="0")
				{
					$remove	='<a  title="Delete Coupon" onclick="removecoupon();" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
				}else
				{
					$remove	='';
				}
			
				$html .= '<div class="col-xs-12 cart-total"><div class="col-xs-6"><p>Total Products</p></div><div class="col-xs-6">
                    <p style="text-align:right;">'.$this->session->userdata("currencysymbol")." ".round(($total / $this->session->userdata("currencyrate"))).'</p></div></div>';			
									
									
				
							$html .='<div class="col-xs-12 cart-total"><div class="col-xs-6"><p>Bonus/Discount Total</p></div><div class="col-xs-6">
							<p style="text-align:right;">'.$this->session->userdata("currencysymbol")." ".round(($discountamount / $this->session->userdata("currencyrate")))." ".$remove.'</p></div></div>'; 				
				
				$shipping_charge = 0;
				
				$html .='<div class="col-xs-12 total"><div class="col-xs-6"><p>Total</p></div><div class="col-xs-6"><p style="text-align:right;">'.$this->session->userdata("currencysymbol")." ".round((($total-$discountamount+$shipping_charge) / $this->session->userdata('currencyrate'))).'</p></div></div>';				
								
		echo $html;
		
	}
	function checkoutupdatetotal()
	{	
			$country = $this->input->post('country');
			if($country == '3'){
				$shipping_charge = 0;
			}else{
				$getcountry = $this->cart_model->getcountry(5);
				$shipping_charge = ( $getcountry->flatrate *  ($this->cart->total_items()+4));
			}
			
			$html='';
			$total = $this->cart->total(); 
			$discountamount="0";
				if($this->session->userdata('coupancode') !='')
				{
					$coupan_type=$this->session->userdata('coupanvalue'); 
					if($coupan_type==0){ 
						$discount=($total*$this->session->userdata('discount')/100);
						$discountamount = $discount;
					 }else{
						$discountamount = $this->session->userdata('discount');
					 } 
				} 		  	
				
				$html .='<div class="col-xs-12 total-pay" style="padding: 0px;">
						Shipping Charges
                    <span class="total-amt">'.$this->session->userdata('currencysymbol').' '.round((($shipping_charge) / $this->session->userdata('currencyrate'))).'</span></div>';
				
					$total	= ($total-$discountamount+$shipping_charge);
					

					$html .='<div class="col-xs-12 total-pay" style="padding: 0px;">
                    Total To Pay 
                    <span class="total-amt">'.$this->session->userdata('currencysymbol').' '.round(($total / $this->session->userdata('currencyrate'))).'</span>
					</div>';			
					$this->session->set_userdata("discount_amount",$discountamount);
					$this->session->set_userdata("shipping_cost",$shipping_charge);
					$this->session->set_userdata("total_amount",$total);									
		echo $html;
		
	}
	
	function removecoupon()
	{	
		 $this->session->unset_userdata('couponid');
		 $this->session->unset_userdata('coupanname'); 
		 $this->session->unset_userdata('coupancode'); 
		 $this->session->unset_userdata('discount');
		 $this->session->unset_userdata('coupanvalue'); 
		 $this->session->unset_userdata('discount_amount');	
		 echo "0";
	}
}