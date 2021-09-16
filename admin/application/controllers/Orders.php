<?php
class Orders extends CI_Controller
{
    private $data = array();
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('adminId') == null) {
            redirect($this->config->item('base_url'));
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->model('orders_model');
    }

    public function lists($status='')
    {
        $this->data['startdate'] = $startdate = $this->input->post('startdate');
		$this->data['enddate'] = $enddate = $this->input->post('enddate');
		$this->data['distributor_id'] = $distributor_id = $this->input->post('distributor_id');

        $this->data['alldistributors'] = $this->orders_model->alldistributors();

        $this->data['orders_list'] = $this->orders_model->getOrdersDistributors($id='',$status,$startdate,$enddate,$distributor_id);

	    $this->load->view('list_order', $this->data);
    }

    public function download_distiorder($status='')
    {
        $this->data['startdate'] = $startdate = $this->input->post('startdate');
		$this->data['enddate'] = $enddate = $this->input->post('enddate');
		$this->data['distributor_id'] = $distributor_id = $this->input->post('distributor_id');

        $orders_list =  $this->orders_model->getOrdersDistributors($id='',$status,$startdate,$enddate,$distributor_id);
        //echo "<pre>";print_r($orders_list);echo "</pre>";
	    $output = 'OrderId,OrderDate,User Name,Email,Mobile,Total';
		$output .="\n";
		
                                 $i = 1;
                                 if($orders_list!='' && count($orders_list) > 0) {
                                 foreach($orders_list as  $key => $orders)
                                 {	
                                     $order_date = strtotime( $orders['cdate'] );
								     $mysqldate = date( 'F d, Y', $order_date );
                                   
            $output .= '"'.$orders['order_id'].'","'.$mysqldate.'","'.$orders['user_name'].'","'.$orders['user_email'].'","'.$orders['user_mobile'].'","'.number_format($orders['order_total'],false,'','').'"';
		    $output .="\n";
            $output .= ',Product Name,Unit price,Quantity,Total Price';
            $output .="\n";
            foreach ($orders['items'] as $item) {
                $output .= ',"'.$item['order_item_name'].'","'.number_format($item['product_item_price']).'","'.$item['product_quantity'].'","'.$item['product_item_price']*$item['product_quantity'].'"';
                $output .="\n";
            }

            $output .="\n";
		    
                              
                               $i++;   } }   
                              
		$filename = "distributor-order.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
        //echo "<pre>";print_r($output);echo "</pre>";
		exit;
    }

    public function lists_customer($status='')
    {

        $this->data['startdate'] = $startdate = $this->input->post('startdate');
		$this->data['enddate'] = $enddate = $this->input->post('enddate');
		$this->data['user_id'] = $user_id = $this->input->post('user_id');

        $this->data['allcustomers'] = $this->orders_model->allcustomers();

        $this->data['orders_list'] = $this->orders_model->getOrdersCustomer($id='',$status,$startdate,$enddate,$user_id);
	    $this->load->view('list_customer', $this->data);
    }

    public function download_customerorder($status='')
    {
        $this->data['startdate'] = $startdate = $this->input->post('startdate');
		$this->data['enddate'] = $enddate = $this->input->post('enddate');
		$this->data['user_id'] = $user_id = $this->input->post('user_id');

        $orders_list =  $this->orders_model->getOrdersCustomer($id='',$status,$startdate,$enddate,$user_id);
        //echo "<pre>";print_r($orders_list);echo "</pre>";
	    $output = 'OrderId,OrderDate,User Name,Email,Mobile,Total';
		$output .="\n";
		
                                 $i = 1;
                                 if($orders_list!='' && count($orders_list) > 0) {
                                 foreach($orders_list as  $key => $orders)
                                 {	
                                     $order_date = strtotime( $orders['cdate'] );
								     $mysqldate = date( 'F d, Y', $order_date );
                                   
            $output .= '"'.$orders['order_id'].'","'.$mysqldate.'","'.$orders['user_name'].'","'.$orders['user_email'].'","'.$orders['user_mobile'].'","'.number_format($orders['order_total'],false,'','').'"';
		    $output .="\n";
            $output .= ',Product Name,Unit price,Quantity,Total Price';
            $output .="\n";
            foreach ($orders['items'] as $item) {
                $output .= ',"'.$item['order_item_name'].'","'.number_format($item['product_item_price']).'","'.$item['product_quantity'].'","'.$item['product_item_price']*$item['product_quantity'].'"';
                $output .="\n";
            }

            $output .="\n";
		    
                              
                               $i++;   } }   
                              
		$filename = "customer-order.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
        //echo "<pre>";print_r($output);echo "</pre>";
		exit;
    }
    
    public function lists_specialcustomer($status='')
    {
        $this->data['startdate'] = $startdate = $this->input->post('startdate');
		$this->data['enddate'] = $enddate = $this->input->post('enddate');
		$this->data['distributor_id'] = $distributor_id = $this->input->post('distributor_id');

        $this->data['alldistributors'] = $this->orders_model->alldistributors();
        $this->data['orders_list'] = $this->orders_model->getspecialOrdersCustomer($id='',$status,$startdate,$enddate,$distributor_id);
	    $this->load->view('lists_specialcustomer', $this->data);
    }
    
    public function download_specialcustomer($status='')
    {
        $this->data['startdate'] = $startdate = $this->input->post('startdate');
		$this->data['enddate'] = $enddate = $this->input->post('enddate');
		$this->data['distributor_id'] = $distributor_id = $this->input->post('distributor_id');

        $orders_list = $this->orders_model->getspecialOrdersCustomer($id='',$status,$startdate,$enddate,$distributor_id);
	    $output = 'OrderId,OrderDate,DistributoraName,CustomerName,Mobile,Total';
		$output .="\n";
		
                                 $i = 1;
                                 if($orders_list!='' && count($orders_list) > 0) {
                                 foreach($orders_list as  $key => $orders)
                                 {	
                                     $order_date = strtotime( $orders['cdate'] );
								     $mysqldate = date( 'F d, Y', $order_date );
                                   
            $output .= '"'.$orders['order_id'].'","'.$mysqldate.'","'.$this->orders_model->getUsername($orders['distributor_id']).'","'.$orders['first_name'].'","'.$orders['phone_number'].'","'.number_format($orders['order_total'],false,'','').'"';
		    $output .="\n";
            $output .= ',Product Name,Unit price,Quantity,Total Price';
            $output .="\n";
            foreach ($orders['items'] as $item) {
                $output .= ',"'.$item['order_item_name'].'","'.number_format($item['product_item_price']).'","'.$item['product_quantity'].'","'.$item['product_item_price']*$item['product_quantity'].'"';
                $output .="\n";
            }

            $output .="\n";
		    
                              
                               $i++;   } }   
                              
		$filename = "spcustomer-order.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
        //echo "<pre>";print_r($output);echo "</pre>";
		exit;
    }
	
	  public function lists_experiance()
    {
        $this->data['get_experiance_order'] = $this->orders_model->get_experiance_order();
        $this->load->view('list_experiance_order', $this->data);
    }
	
	
	public function view_experiance_orders($order_id)
    {
		$data['order'] = $this->orders_model->get_experiance_order_detail($order_id);
		$data['order_attendees'] = $this->orders_model->get_experiance_attendees_detail($order_id);
        $this->load->view('view_experiance_orders', $data);
    }
	
    public function detail($order_id)
    {
		$order = $this->orders_model->getOrders($order_id);
		
		$this->data['order'] = $order[0];
		$this->data['totol_words'] = $this->convert_number_to_words(round($order[0]['order_total']));
		$this->load->view('view_orders', $this->data);
    }
    
    
    public function detail1($order_id)
    {
		$order = $this->orders_model->getOrders($order_id);
		
		$this->data['order'] = $order[0];
		$this->data['totol_words'] = $this->convert_number_to_words(round($order[0]['order_total']));
		$this->load->view('view_orders1', $this->data);
    }

    public function deleteOrders()
    {
        $order_id = $this->input->post('order_id');
		$order = $this->orders_model->delete_order_by_id($order_id);
        $this->session->set_flashdata('L_strErrorMessage','Order Deleted Successfully!!!!');
        echo "Deleted";
        // $this->session->set_flashdata('L_strErrorMessage','Order Deleted Successfully!!!!');
		// redirect($this->config->item('base_url').'orders/lists_specialcustomer');
    }


	public function vendordetail($order_id,$bookingapiid)
    {
		$order = $this->orders_model->getOrders_vendoritem_bookingid($order_id,$bookingapiid);
		$this->data['order'] = $order[0];
		$this->data['totol_words'] = $this->convert_number_to_words(round($order[0]['order_total']));
		
		$this->load->library('shipping');
		$id = $order[0]['api_booking_id'];
		$postfields['order_ids'] = $id;
		$result = $this->shipping->deliveredstatus($postfields);
		$schedulepickuparray = json_decode($result);
		
		$this->data['schedulepickuparray'] = $schedulepickuparray;
		$this->load->view('view_vendororders', $this->data);
    }





	public function Invoice($order_id)
	{
		$order = $this->orders_model->getOrders($order_id);
		$this->data['order'] = $order[0];
		$this->data['totol_words'] = $this->convert_number_to_words(round($order[0]['order_total']));
		  
        $this->load->view('view_invoice', $this->data);
	}
	public function packing_slip()
	{
		 $this->load->view('packing_slip');
	}
  function changeStatusmail($orderid)
   {
		$status=$this->input->post("status");
		$trackadd=$this->input->post("tracking");
		
		
	   	if($request=$this->orders_model->status($orderid,$status,$trackadd))
		{
				$order1 = $this->orders_model->getOrders($orderid);
				$data["order"]=$order1[0];
				
				if($status=='S'){	
						$message =  $this->load->view('emailer/order-shipped.php',$data,true);
				}
				if($status=='D'){	
						$message =  $this->load->view('emailer/order-delivered.php',$data,true);	
				}
				if($status=='C'){	
						$message =  $this->load->view('emailer/order-cancelled.php',$data,true);	
				}	
				
			$to=$data["order"]["user_email"];
			
			if($status=='P'){	
					$subject  = 'Pending Order';
				}
			if($status=='S'){	
					$subject  = 'Shipped Order';
					
				}
			if($status=='D'){	
					$subject  = 'Delivered Order';
					
				}
			if($status=='C'){	
			$subject  = 'Canceled Order ';
						
				}
				
			if($status !='P'){
						
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: coalbrass.com <info@coalbrass.com>' . "\r\n" .
						'Reply-To: info@coalbrass.com' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
			$headers .= 'BCC: amvisolution@gmail.com' . "\r\n";
				mail($to, $subject, $message, $headers);
				
				mail('amvi.himanshu@gmail.com', $subject, $message, $headers);
			
			}	
 			$this->session->set_flashdata('L_strErrorMessage','Your Order Status Update  successfully.');
			}
			else
			{
				$this->session->set_flashdata('flashError','Some Errors prevented from Adding!!!!');
			}
	   //redirect($this->config->item('base_url').'orders/lists');
	   redirect($this->config->item('base_url').'orders/detail/'.$orderid);
	   
   }
   
    public function changeStatus()
    {
        $order_id     = $this->input->get('order_id');
        $order_status = $this->input->get('order_status');
        $order        = $this->orders_model->setOrderStatus($order_id, $order_status);
        echo $order;
    }
  
    public function changeItemStatus()
    {
        $order_item_id      = $this->input->get('order_item_id');
        $order_item_status  = $this->input->get('order_item_status');
        $order_item         = $this->orders_model->changeItemStatus($order_item_id, $order_item_status);
        echo $order_item;
    }
	public function download_report()
	{
		$order_list  = $this->orders_model->getOrders($id='',$status='');
		$output = '';
		$output .= 'Order No,Order Date,User Name,Product,Color,Size,MRP,City,Payment status,Order Status,Delivery Date';
		
		$output .="\n";
		if($order_list != '' && count($order_list) > 0) {
			$i=1;
		foreach($order_list as $order) {
				foreach($order['items'] as $items){
					
					if($order['order_status'] == 'P')
					{
						$order_status = 'Pending';
						$status_date	="-";	
					}
					else if($order['order_status'] == 'R')
					{
						$order_status = 'Processing';
						$status_date	="-";	
					} 
					else if($order['order_status'] == 'S')
					{
						$order_status = 'Shipped';
						$status_date	="-";	
					} 
					else if($order['order_status'] == 'D')
					{
						$order_status = 'Delivered';
						$status_date =date("Y-m-d",strtotime($order['status_date']));	
					} else 
					{
						$order_status ='Canceled';
						$status_date	="-";
					}
			if($order['city']=='rest_of_mum_guj' || $order['city']=='rest_of_india'){ $city = $order['city1']; }else{ $city = $order['city']; }		
					
			$orderdate=date("Y-m-d",strtotime($order['cdate']));
		$output .= '"'.$order['order_id'].'","'.$orderdate.'","'.$order['user_name'].'","'.$items['order_item_name'].'","'.$items['colour_name'].'","'.$items['size_name'].'","'.$items['product_item_price'].'","'.$city.'","'.$order['payment_status'].'","'.$order_status.'","'.$status_date.'"';  
		$output .="\n";
		$i++;  }  }
		}
		$filename = "Order-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		exit;
	}
function convert_number_to_words($number)
{
   
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . $this->convert_number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->convert_number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
   
    return $string;
}	
}