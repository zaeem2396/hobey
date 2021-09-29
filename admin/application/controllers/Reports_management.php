<?php
class Reports_management extends CI_Controller
{
	private $data = array();
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('adminId') == null) {
			redirect($this->config->item('base_url'));
		}
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$this->load->model('reports_management_model');
	}

	/*public function order()
    {
		$this->data['status'] = $this->input->post('status');
		$this->data['startdate'] = $this->input->post('startdate');
		$this->data['enddate'] = $this->input->post('enddate');
		
		
        $data = $this->reports_management_model->getOrders($id='',$this->data);
		$this->data['orders_list']=$data['order_list'];
		
		//print_r($this->data['orders_list']); die;
		
		$this->data['ordertotal']=$data['ordertotal'];
		$this->data['totalorder']=$data['totalorder'];
		
		$this->load->view('list_reports_sales', $this->data);
    }
	 */

	function deliveryreport()
	{
		$id = $this->input->post("bookingid");
		$html = $this->load->view('deliveryreport', $data, true);
		echo $html;
	}

	function order()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/order/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['userid'] = $this->input->post('userid');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->reports_management_model->lists_salesreport($this->uri->segment(3), $data);

		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
		$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('list_reports_sales', $data);
	}

	function vendororder()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/vendororder/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$data['salesreports'] = $this->reports_management_model->salesreports($data);

		$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('list_reports_vendorsales.php', $data);
	}


	function amount_reconcilation_report()
	{

		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/amount_reconcilation_report/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...

		$this->data['sstartdate'] = $sstartdate = $this->input->post('sstartdate');
		$this->data['senddate'] = $senddate = $this->input->post('senddate');

		$per_page = '1';
		$perpage = '10';
		//below is used in all perpose
		//$data = $this->reports_management_model->getOrders($id='',$this->data);
		//$this->data['orders_list']=$data['order_list'];

		//print_r($this->data['orders_list']); die;

		//$this->data['ordertotal']=$data['ordertotal'];
		//$this->data['totalorder']=$data['totalorder'];

		$this->load->view('amount_reconcilation_report.php', $this->data);
	}

	public function download_reconcilation()
	{

		$sstartdate = $this->input->post('sstartdate');
		$senddate = $this->input->post('senddate');

		$output = 'Sr. No,Date,Txn Type,Payer,Payee,Order ID,Txn No,Amount (+/-)';
		$output .= "\n";

		if ($sstartdate != '' and $senddate != '') {
			$startdate = date('Y-m-d', strtotime($senddate));
			$enddate = date('Y-m-d', strtotime($sstartdate));
		} else {
			$startdate = date('Y-m-d');
			$enddate = date('Y-m-d', strtotime('-7 days'));
		}

		$counter = 1;
		while ($enddate <= $startdate) {
			$data['startdate'] = $enddate;
			$data['enddate'] = $enddate;
			$orders_list = $this->reports_management_model->getOrdersreport($id = '', $data);
			$allblclpayments = $this->reports_management_model->allblclpayments($data);
			//echo "<pre>";print_r($allblclpayments);echo "</pre>";


			if (isset($orders_list['order_list']) and count($orders_list['order_list'])) {
				foreach ($orders_list['order_list'] as $key => $orders) {
					$txnType = '';
					$payer = '';
					$payee = '';

					if ($orders['is_customer'] == 0) {
						$txnType = 'Distributor to Vendor';
						$payer = $orders['user_name'];
						$payee = $this->reports_management_model->get_vendor_name($orders['vendor_id']);
					}
					if ($orders['is_customer'] == 1) {
						$txnType = 'Customer to Distributor';
						$payer = $orders['user_mobile'];
						$payee = $this->reports_management_model->get_vendor_name($orders['distributor_id']);
					}
					$order_date = strtotime($orders['cdate']);
					$mysqldate = date('F d, Y', $order_date);
					$output .= '"' . $counter . '","' . $mysqldate . '","' . $txnType . '","' . $payer . '","BPCL, ' . $payee . '","' . $orders['order_id'] . '","' . $orders['transactionid'] . '","+ ' . $orders['sub_total'] . '"';
					$output .= "\n";

					$totalPlus += $orders['sub_total'];
					$counter++;
				}
			}

			if (isset($allblclpayments) and count($allblclpayments)) {
				foreach ($allblclpayments as $key => $payment) {
					$txnType = '';
					$payer = 'BPCL';
					$payee = $this->reports_management_model->get_vendor_name($payment->user_id);
					if ($payment->user_vendor == 1) {
						$txnType = 'BPCL to Vendor';
					}
					if ($payment->user_vendor == 2) {
						$txnType = 'BPCL to Distributor';
					}
					if ($payment->user_vendor == 3) {
						$txnType = 'BPCL to Delivery man';
					}
					$order_date = strtotime($payment->pdate);
					$mysqldate = date('F d, Y', $order_date);
					$output .= '"' . $counter . '","' . $mysqldate . '","' . $txnType . '","' . $payer . '","' . $payee . '",,,"- ' . $payment->amount . '"';
					$output .= "\n";

					$totalMinus += $payment->amount;
					$counter++;
				}
			}

			$enddate = date('Y-m-d', strtotime($enddate . '+1 days'));
		}
		$fullTotal = $totalPlus - $totalMinus;
		$output .= 'Total,,,,,,,"' . $fullTotal . '"';

		$filename = "reconcilation-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		// echo "<pre>";print_r($output);echo "</pre>";
		exit;
	}

	function vendor_paybale_report()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/vendor_paybale_report/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		//$data['salesreports'] = $this->reports_management_model->salesreports($data);

		//$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('vendor_paybale_report.php', $data);
	}

	public function download_vpaybale()
	{

		$allvendor = $this->reports_management_model->allvendor($data);

		$output = 'Vendor Name,Amount Payabale to vendor (Rs)';
		$output .= "\n";
		$i = 1;
		$total[$i] = '0';
		if ($allvendor != '' && count($allvendor) > 0) {
			foreach ($allvendor as $vendorlist) {
				//$get_vendor_name= $this->reports_management_model->get_vendor_name($vendorlist->id);
				$allorders = $this->reports_management_model->get_vendor_orders($vendorlist->id);
				foreach ($allorders as $order) {
					$total[$i] = $total[$i] + ($order->billing_price * $order->package * $order->product_quantity);
				}

				$output .= '"' . $vendorlist->name . '","' . number_format($total[$i], false, '', '') . '"';
				$output .= "\n";

				$i++;
			}
		}
		$output .= "\n";

		$filename = "vendorpaybale-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		//echo "<pre>";print_r($output);echo "</pre>";
		exit;
	}




	function vendor_special_report()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/vendor_paybale_report/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		// using for searching data...
		// $data['startdate'] = $this->input->post('startdate');
		// $data['enddate'] = $this->input->post('enddate');
		// $data['status'] = $this->input->post('status');
		// $data['product'] = $this->input->post('product');
		// $data['vendor'] = $this->input->post('vendor');

		$data['product_id'] = $this->input->post('product_id');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		//$data['salesreports'] = $this->reports_management_model->salesreports($data);

		//$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();

		$data['allSpProducts'] = $this->reports_management_model->allSpProducts();
		$data['allvendor'] = $this->reports_management_model->allvendorspecialproducts($data);
		// echo "<pre>";var_dump($data['allvendor']);exit;
		$this->load->view('vendor_special_products_report.php', $data);
	}

	function distributor_special_report()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/vendor_paybale_report/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		// $data['startdate'] = $this->input->post('startdate');
		// $data['enddate'] = $this->input->post('enddate');
		$data['product_id'] = $this->input->post('product_id');
		$data['distributor_id'] = $this->input->post('distributor_id');
		// $data['status'] = $this->input->post('status');
		// $data['product'] = $this->input->post('product');
		// $data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		//$data['salesreports'] = $this->reports_management_model->salesreports($data);

		//$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allSpProducts'] = $this->reports_management_model->allSpProducts();
		$data['Sdistributor'] = $this->reports_management_model->Sdistributor();
		$data['alldistributor'] = $this->reports_management_model->alldistributor($data);
		$data['allvendor'] = $this->reports_management_model->allvendorspecialproducts($data);
		$data['test'] = $this->reports_management_model->get_alldistrspecialproducts_bkup();
		// echo "<pre>";
		// var_dump($data['test']);
		// exit;
		$this->load->view('distributor_special_report.php', $data);
	}

	function distributor_paybale_report()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/vendor_paybale_report/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		//$data['salesreports'] = $this->reports_management_model->salesreports($data);

		//$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['alldistributor'] = $this->reports_management_model->alldistributor($data);
		// echo "<pre>";var_dump($data['alldistributor'][0]->email);exit;
		$this->load->view('distributor_paybale_report.php', $data);
	}

	public function download_dpaybale()
	{

		$alldistributor = $this->reports_management_model->alldistributor($data);

		$output = 'Distributor Name,Amount Payabale to Distributor (Rs)';
		$output .= "\n";
		$i = 1;
		$total[$i] = '0';
		if ($alldistributor != '' && count($alldistributor) > 0) {
			foreach ($alldistributor as  $distributor) {
				$allorders = $this->reports_management_model->get_distributor_orders($distributor->id);
				//echo "<pre>";print_r($allorders);echo "</pre>";
				foreach ($allorders as $order) {
					$total[$i] = $total[$i] + ($order->distributorpay * $order->product_quantity);
				}

				$output .= '"' . $distributor->name . '","' . number_format($total[$i], false, '', '') . '"';
				$output .= "\n";

				$i++;
			}
		}
		$output .= "\n";

		$filename = "distributorpaybale-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		//echo "<pre>";print_r($output);echo "</pre>";
		exit;
	}

	function distributor_special_report_download()
	{
		// $content['status'] = $this->input->post('status');
		// $content['startdate'] = $this->input->post('startdate');
		// $content['enddate'] = $this->input->post('enddate');
		// $content['vendor'] = $this->input->post('vendor');
		// $content['product'] = $this->input->post('product');

		$data['product_id'] = $this->input->post('product_id');
		$data['distributor_id'] = $this->input->post('distributor_id');

		$alldistributor = $this->reports_management_model->alldistributor($data);
		$allvendor = $this->reports_management_model->allvendorspecialproducts($data);

		$output = 'DistributorName,ProductName,Weight,Amount,Qty';
		$output .= "\n";


		$i = 1;
		if ($alldistributor != '' && count($alldistributor) > 0) {
			foreach ($alldistributor as $distributor) {

				if ($allvendor != '' && count($allvendor) > 0) {
					foreach ($allvendor as $vendorlist) {
						$total[$i] = '0';
						$qty = '0';
						$allorders = $this->reports_management_model->get_alldistrspecialproducts($vendorlist->id, $distributor->id);
						foreach ($allorders as $order) {
							$total[$i] = $total[$i] + ($order->product_item_price * $order->product_quantity);
							$qty =  $qty + $order->product_quantity;
						}
						if ($qty > 0) {
							$output .= '"' . $distributor->name . '","' . str_replace(',', ' ', $vendorlist->material_name) . '","' . $vendorlist->weight . '","' . number_format($total[$i], false, '', '') . '","' . $qty . '"';
							$output .= "\n";


							$i++;
						}
					}
				}
			}
		}





		$filename = "distributor-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		exit;
	}

	function vendor_special_report_download()
	{
		$data['product_id'] = $this->input->post('product_id');
		// var_dump($data['product_id']);exit;
		$allvendor = $this->reports_management_model->allvendorspecialproducts($data);

		$output = 'VendorName,ProductName,Weight,Amount,Qty';
		$output .= "\n";


		$i = 1;


		if ($allvendor != '' && count($allvendor) > 0) {
			foreach ($allvendor as $vendorlist) {
				$total[$i] = '0';
				$qty = '0';
				$allorders = $this->reports_management_model->get_allvendorspecialproducts($vendorlist->id);
				foreach ($allorders as $order) {
					$total[$i] = $total[$i] + ($order->product_item_price * $order->product_quantity);
					$qty =  $qty + $order->product_quantity;
				}
				if ($qty > 0) {
					$output .= '"' . $vendorlist->vendorname . '","' . str_replace(',', ' ', $vendorlist->material_name) . '","' . $vendorlist->weight . '","' . number_format($total[$i], false, '', '') . '","' . $qty . '"';
					$output .= "\n";


					$i++;
				}
			}
		}





		$filename = "vendor-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		exit;
	}

	function delivery_man_paybale_report()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/vendor_paybale_report/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		//$data['salesreports'] = $this->reports_management_model->salesreports($data);

		//$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['alldeliveryman'] = $this->reports_management_model->alldeliveryman($data);
		$this->load->view('delivery_man_paybale_report.php', $data);
	}

	public function download_delpaybale()
	{

		$alldeliveryman = $this->reports_management_model->alldeliveryman($data);

		$output = 'Delivery Man Name,Amount Payabale to Delivery Man (Rs)';
		$output .= "\n";

		$i = 1;
		$total[$i] = '0';
		if ($alldeliveryman != '' && count($alldeliveryman) > 0) {
			foreach ($alldeliveryman as  $deliveryman) {
				$allorders = $this->reports_management_model->get_deliveryman_orders($deliveryman->id);
				foreach ($allorders as $order) {
					$total[$i] = $total[$i] + ($order->deliverypay * $order->product_quantity);
				}


				$output .= '"' . $deliveryman->name . '","' . number_format($total[$i], false, '', '') . '"';
				$output .= "\n";

				$i++;
			}
		}
		$output .= "\n";

		$filename = "deliverymanpaybale-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		//echo "<pre>";print_r($output);echo "</pre>";
		exit;
	}

	function rejectorder($id, $vid)
	{
		$this->load->model('vendor_model');

		$orderitemid = $id;
		$this->vendor_model->rejectorder($id);
		$productdetails = $this->vendor_model->get_product_order_item($vid, $orderitemid);
		$sellerdetails = $this->vendor_model->sellerdetails($vid);
		//$customerdetails = $this->account_model->sellerdetails($vid);
		// Pickup Request Mail to Admin.
		$to = $productdetails->email;
		$message = '<!doctype html><html lang="en"><head>
			<title>Admin cancelled Order</title>
			<style>
				@import url("https://fonts.googleapis.com/css?family=Lato");
			</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
			<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
				<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
				<a href="' . $this->config->item('base_url') . '"><img src="' . $this->config->item('base_url_views') . 'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
				</div>
				<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
					<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi ' . $productdetails->fname . ' ' . $productdetails->lname . ',</p>
					<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Oh No! It seems your ' . $productdetails->order_item_name . ' from order ' . $productdetails->order_id . ' cannot be processed. The product value will be credited to your account within 7 working days. Please go through our website for alternative wonderful options & Let us put a smile back on your face!  </p>
				</div>
				<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
					<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Have a Fabulous Day!<BR>
		With Miles of Smiles,<br>Team Happy Soul</p><br>
					<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100; margin: 0;">Need Help?<br>
					</p>
				</div>
				<div style="clear: both">
			</div></div>
		</body>
		</html>';
		$subject = "Admin has cancelled the order.";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		mail($to, $subject, $message, $headers);

		$email_ad = $this->config->item('customercare_email');
		mail($email_ad, $subject, $message, $headers);


		$message = '<!doctype html><html lang="en"><head>
			<title>Admin cancelled Order</title>
			<style>
				@import url("https://fonts.googleapis.com/css?family=Lato");
			</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
			<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
				<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
				<a href="' . $this->config->item('base_url') . '"><img src="' . $this->config->item('base_url_views') . 'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
				</div>
				<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
					<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Admin has cancelled vendor item id: ' . $orderitemid . '. Please look into the details and ensure refund of order amount!</p>
				</div>
				<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
					<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Have a Fabulous Day!<BR>
		With Miles of Smiles,Team Happy Soul</p><br>
					<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100; margin: 0;">Need Help?<br>
					</p>
				</div>
				<div style="clear: both">
			</div></div>
		</body>
		</html>';
		$subject = "Admin has cancelled the order.";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		$email_ad = $this->config->item('shipping_email');
		mail($email_ad, $subject, $message, $headers);
		//$email_ad = $sellerdetails->email;
		//mail($email_ad, $subject, $message, $headers);
		$this->session->set_flashdata('L_strErrorMessage', 'Order has been Cancelled');
		redirect($this->config->item('base_url') . 'reports_management/vendororder');
	}

	function cancelorder()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/vendororder/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$data['salesreports'] = $this->reports_management_model->cancelorder($data);

		$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('cancelorder.php', $data);
	}

	function cancelrequest()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/cancelrequest/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$data['salesreports'] = $this->reports_management_model->cancelrequest($data);

		$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('cancelrequest.php', $data);
	}

	function gstreport()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/gstreport/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$data['salesreports'] = $this->reports_management_model->salesreports($data);

		$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('gstreport.php', $data);
	}

	function tcsreport()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/tcsreport/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$data['salesreports'] = $this->reports_management_model->salesreports($data);
		$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('tcsreport.php', $data);
	}

	function shippingreport()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/shippingreport/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$data['salesreports'] = $this->reports_management_model->salesreports($data);
		$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('shippingreport.php', $data);
	}

	function commissionreport()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/commissionreport/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$data['salesreports'] = $this->reports_management_model->salesreports($data);
		$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('commissionreport.php', $data);
	}

	function vendorreport()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'reports_management/vendorreport/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$data['status'] = $this->input->post('status');
		$data['product'] = $this->input->post('product');
		$data['vendor'] = $this->input->post('vendor');

		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$data['salesreports'] = $this->reports_management_model->salesreports($data);
		$data['allvendorproducts'] = $this->reports_management_model->allvendorproducts();
		$data['allvendor'] = $this->reports_management_model->allvendor($data);
		$this->load->view('vendorreport.php', $data);
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

	function download_report()
	{
		$content['status'] = $this->input->post('status');
		$content['startdate'] = $this->input->post('startdate');
		$content['enddate'] = $this->input->post('enddate');
		$content['vendor'] = $this->input->post('vendor');
		$content['product'] = $this->input->post('product');

		$salesreports = $this->reports_management_model->salesreports($content);

		$output = 'OrderId,VendorItemId,ProductName,VendorName,CustomerName,CustomerEmail,CustomerMobile,OrderDate,ProductVariant,VendorStatus,DelieryStatus,DeliveryBookingID,Quantity,Price';
		$output .= "\n";

		if ($salesreports != '' && count($salesreports) > 0) {
			foreach ($salesreports as  $prd) {
				$get_vendor_name = $this->reports_management_model->get_vendor_name($prd->vendor_id);


				if ($prd->vendor_accept == '0') {
					$vendoraccept = 'Pending';
				} else if ($prd->vendor_accept == '1') {
					$vendoraccept = 'Accepted';
				} else if ($prd->vendor_accept == '2') {
					$vendoraccept = 'Rejected';
				}

				if ($prd->packstatus == '1') {
					$packstatus = 'Package Created';
				} else if ($prd->packstatus == '2') {
					$packstatus = 'Dispatched';
				} else if ($prd->packstatus == '3') {
					$packstatus = 'Delivered';
				} else if ($prd->packstatus == '0') {
					$packstatus = 'Pending';
				}

				$output .= '"' . $prd->order_id . '","' . $prd->order_item_id . '","' . $prd->order_item_name . '","' . $get_vendor_name . '","' . $prd->first_name . " " . $prd->last_name . '","' . $prd->email . '","' . $prd->phone_number . '","' . date('d/m/Y', strtotime($prd->cdate)) . '","' . $prd->size_name . '","' . $vendoraccept . '","' . $packstatus . '","' . $prd->api_booking_id . '","' . $prd->product_quantity . '","' . round($prd->product_item_price * $prd->product_quantity) . '"';
				$output .= "\n";

				$i++;
			}
		}


		$filename = "vendor-sales.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		exit;
	}

	function tcsdownload()
	{
		$content['status'] = $this->input->post('status');
		$content['startdate'] = $this->input->post('startdate');
		$content['enddate'] = $this->input->post('enddate');
		$content['vendor'] = $this->input->post('vendor');
		$content['product'] = $this->input->post('product');

		$salesreports = $this->reports_management_model->salesreports($content);

		$output = 'OrderId,VendorItemId,OrderDate,VendorName,GstNumber,ProductCostWithoutGst,ProductCostWithGst,TCS-IGST,TCS-SGST,TCS-CGST';
		$output .= "\n";

		if ($salesreports != '' && count($salesreports) > 0) {
			foreach ($salesreports as  $prd) {
				$get_vendor_name = $this->reports_management_model->get_vendor_name_details($prd->vendor_id);

				$prductwithoutgst = number_format(($prd->product_item_price * $prd->product_quantity * 100 / (100 + $prd->gst)), '2', '.', '');
				$prductwithgst = number_format($prd->product_item_price * $prd->product_quantity, '2', '.', '');
				$statename = 	$this->reports_management_model->get_state_name($get_vendor_name->vendor_state);
				$state = strtolower($statename->state);

				if (strtolower($prd->state) != $state) {
					$igst = round($prductwithoutgst * (0.01));
				} else {
					$igst = '-';
				}
				if (strtolower($prd->state) == $state) {
					$sgst = round($prductwithoutgst * (0.01) / 2);
				} else {
					$sgst = '-';
				}
				if (strtolower($prd->state) == $state) {
					$cgst = round($prductwithoutgst * (0.01) / 2);
				} else {
					$cgst = '-';
				}

				$output .= '"' . $prd->order_id . '","' . $prd->order_item_id . '","' . date('d/m/Y', strtotime($prd->cdate)) . '","' . $get_vendor_name->company_name . '","' . $get_vendor_name->service_tax_no . '","' . $prductwithoutgst . '","' . number_format($prd->product_item_price * $prd->product_quantity, '2', '.', '') . '","' . $igst . '","' . $sgst . '","' . $cgst . '"';


				$output .= "\n";

				$i++;
			}
		}


		$filename = "tcs-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		exit;
	}

	function shippingdownload()
	{
		$content['status'] = $this->input->post('status');
		$content['startdate'] = $this->input->post('startdate');
		$content['enddate'] = $this->input->post('enddate');
		$content['vendor'] = $this->input->post('vendor');
		$content['product'] = $this->input->post('product');

		$salesreports = $this->reports_management_model->salesreports($content);

		$output = 'OrderId,VendorItemId,OrderDate,ProductCostBeforeGst,ProductGst,ShippingInBill,ShippingGst,TotalValue,RealTimeShippingCharges,GstOnShipping@18%,PaymentToBeMadeToEcourierz,ProfitOnShipping';
		$output .= "\n";

		if ($salesreports != '' && count($salesreports) > 0) {
			foreach ($salesreports as  $prd) {
				//$get_vendor_name= $this->reports_management_model->get_vendor_name($prd->vendor_id);

				$prductwithoutgst = number_format(($prd->product_item_price * 100 / (100 + $prd->gst)), '2', '.', '');

				$gstamt = ($prd->product_item_price * $prd->product_quantity) - $prductwithoutgst;

				$shippwithoutgst = number_format(($prd->productshipping * 100 / (100 + 18)), '2', '.', '');

				$shippinggst = number_format($prd->productshipping - $shippwithoutgst, '2', '.', '');

				$shipwithoutgst1 = number_format(($shippwithoutgst * 100 / (100 + 20)), '2', '.', '');

				$realshippinggst = number_format($shipwithoutgst1 * 0.18, '2', '.', '');

				$totalshp = number_format($shipwithoutgst1 + $realshippinggst, '2', '.', '');

				$output .= '"' . $prd->order_id . '","' . $prd->order_item_id . '","' . date('d/m/Y', strtotime($prd->cdate)) . '","' . $prductwithoutgst . '","' . $gstamt . '","' . $shippwithoutgst . '","' . $shippinggst . '","' . number_format(($prd->productshipping + $prd->product_item_price), '2', '.', '') . '","' . $shipwithoutgst1 . '","' . $realshippinggst . '","' . $totalshp . '","' . number_format($shippwithoutgst - $shipwithoutgst1, '2', '.', '') . '"';


				$output .= "\n";

				$i++;
			}
		}


		$filename = "shipping-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		exit;
	}

	function downloadcommission()
	{
		$content['status'] = $this->input->post('status');
		$content['startdate'] = $this->input->post('startdate');
		$content['enddate'] = $this->input->post('enddate');
		$content['vendor'] = $this->input->post('vendor');
		$content['product'] = $this->input->post('product');

		$salesreports = $this->reports_management_model->salesreports($content);

		$output = 'OrderId,VendorItemId,OrderDate,VendorName,GstNumber,ProductCostBeforeGst,Comission-%,Comission-Amt,IGST,SGST,CGST,TotalCommission';
		$output .= "\n";

		if ($salesreports != '' && count($salesreports) > 0) {
			foreach ($salesreports as  $prd) {
				$get_vendor_name = $this->reports_management_model->get_vendor_name_details($prd->vendor_id);

				$statename = 	$this->reports_management_model->get_state_name($get_vendor_name->vendor_state);
				$state = strtolower($statename->state);


				$prductwithoutgst = number_format((($prd->product_item_price * $prd->product_quantity) * 100 / (100 + $prd->gst)), '2', '.', '');

				$comamt = number_format($prductwithoutgst * ($prd->vendor_percentage / 100), '2', '.', '');

				if ($prd->state != $state) {
					$igst = number_format($comamt * (18 / 100), '2', '.', '');
				} else {
					$igst = '-';
				}
				if ($prd->state == $state) {
					$sgst = number_format($comamt * (18 / 100), '2', '.', '') / 2;
				} else {
					$sgst = '-';
				}
				if ($prd->state == $state) {
					$cgst = number_format($comamt * (18 / 100), '2', '.', '') / 2;
				} else {
					$cgst = '-';
				}

				$totalcommissionamt = number_format(($comamt) + ($comamt * (18 / 100)), '2', '.', '');

				$output .= '"' . $prd->order_id . '","' . $prd->order_item_id . '","' . date('d/m/Y', strtotime($prd->cdate)) . '","' . $get_vendor_name->company_name . '","' . $get_vendor_name->service_tax_no . '","' . $prductwithoutgst . '","' . $prd->vendor_percentage . '","' . $comamt . '","' . $igst . '","' . $sgst . '","' . $cgst . '","' . $totalcommissionamt . '"';


				$output .= "\n";

				$i++;
			}
		}


		$filename = "commission-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		exit;
	}

	function downloadvendorpayment()
	{
		$content['status'] = $this->input->post('status');
		$content['startdate'] = $this->input->post('startdate');
		$content['enddate'] = $this->input->post('enddate');
		$content['vendor'] = $this->input->post('vendor');
		$content['product'] = $this->input->post('product');

		$salesreports = $this->reports_management_model->salesreports($content);

		$output = 'OrderId,VendorItemId,OrderDate,VendorName,ProductCostBeforeGst,ProductGst,ProductCostAfterGst,Shipping-incl-gst,OrderAmt,HappysoulCommission-%,HappsoulCommissionAmt,GstOnHappysoulPayment,TotalHappySoulPayment,VendorPayment,LessTcs,FinalVendorPayment';
		$output .= "\n";

		if ($salesreports != '' && count($salesreports) > 0) {
			foreach ($salesreports as  $prd) {
				$get_vendor_name = $this->reports_management_model->get_vendor_name_details($prd->vendor_id);

				$prductwithoutgst = number_format((($prd->product_item_price * $prd->product_quantity) * 100 / (100 + $prd->gst)), '2', '.', '');

				$productgst = number_format((($prd->product_item_price * $prd->product_quantity) - $prductwithoutgst), '2', '.', '');

				$prductwithoutgst1 = number_format(($prd->product_item_price * $prd->product_quantity), '2', '.', '');
				$comamt = number_format($prductwithoutgst * ($prd->vendor_percentage / 100), '2', '.', '');

				if ($get_vendor_name->state != 'Goa') {
					$igst = number_format($comamt * (18 / 100), '2', '.', '');
				} else {
					$igst = '-';
				}

				$totalcommissionamt = number_format(($comamt) + ($comamt * (18 / 100)), '2', '.', '');
				$vendoramt = number_format($prductwithoutgst1 - $totalcommissionamt, '2', '.', '');
				$tcsmt = number_format($prductwithoutgst * (0.01), '2', '.', '');
				$finalvendoramt =  number_format(($vendoramt - $tcsmt), '2', '.', '');

				$output .= '"' . $prd->order_id . '","' . $prd->order_item_id . '","' . date('d/m/Y', strtotime($prd->cdate)) . '","' . $get_vendor_name->company_name . '","' . $prductwithoutgst . '","' . $productgst . '","' . $prductwithoutgst1 . '","' . number_format($prd->productshipping, '2', '.', '') . '","' . number_format($prd->productshipping + $prductwithoutgst1, '2', '.', '') . '","' . $prd->vendor_percentage . '","' . $comamt . '","' . $igst . '","' . $totalcommissionamt . '","' . $vendoramt . '","' . $tcsmt . '","' . $finalvendoramt . '"';


				$output .= "\n";

				$i++;
			}
		}


		$filename = "vendorpayment-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		exit;
	}

	function downloadgstreport()
	{
		$content['status'] = $this->input->post('status');
		$content['startdate'] = $this->input->post('startdate');
		$content['enddate'] = $this->input->post('enddate');
		$content['vendor'] = $this->input->post('vendor');
		$content['product'] = $this->input->post('product');

		$salesreports = $this->reports_management_model->salesreports($content);

		$output = 'OrderDate,OrderId,VendorItemId,ProductName,Quantity,ProductCostBeforeGst,GST-%,IGST,SGST,CGST,GstAmount,ProductCostWithGst';
		$output .= "\n";

		if ($salesreports != '' && count($salesreports) > 0) {
			foreach ($salesreports as  $prd) {
				$get_vendor_name = $this->reports_management_model->get_vendor_name_details($prd->vendor_id);
				$statename = 	$this->reports_management_model->get_state_name($get_vendor_name->vendor_state);
				$state = strtolower($statename->state);

				$productamt = number_format(($prd->product_item_price * $prd->product_quantity), '2', '.', '');

				$prductwithoutgst = number_format((($prd->product_item_price * $prd->product_quantity) * 100 / (100 + $prd->gst)), '2', '.', '');

				$gstamt = $productamt - $prductwithoutgst;

				if (strtolower($prd->state) != $state) {
					$igst = number_format($gstamt, '2', '.', '');
				} else {
					$igst = '-';
				}
				if (strtolower($prd->state) == $state) {
					$sgst = number_format($gstamt, '2', '.', '') / 2;
				} else {
					$sgst = '-';
				}
				if (strtolower($prd->state) == $state) {
					$cgst = number_format($gstamt, '2', '.', '') / 2;
				} else {
					$cgst = '-';
				}



				$output .= '"' . date('d/m/Y', strtotime($prd->cdate)) . '","' . $prd->order_id . '","' . $prd->order_item_id . '","' . $prd->order_item_name . '","' . $prd->product_quantity . '","' . $prductwithoutgst . '","' . $prd->gst . '","' . $igst . '","' . $sgst . '","' . $cgst . '","' . $gstamt . '","' . $productamt . '"';


				$output .= "\n";

				$i++;
			}
		}


		$filename = "gst-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		exit;
	}

	function download_salesreport()
	{
		$content['status'] = $this->input->post('status');
		$content['startdate'] = $this->input->post('startdate');
		$content['enddate'] = $this->input->post('enddate');
		$content['vendor'] = $this->input->post('vendor');
		$content['product'] = $this->input->post('product');

		$salesreports = $this->reports_management_model->lists_salesreport($this->uri->segment(3), $content);

		$salesreports =	$salesreports['result'];

		$output = 'OrderId,OrderDate,VendorName,BuyerName,ProductName,ProductAmountBeforeGst,Discount,IGST,CGST,SGST,ShippingAmountBeforeGst,ShippingGst,OrderValue,OrderStatus';
		$output .= "\n";

		if ($salesreports != '' && count($salesreports) > 0) {
			foreach ($salesreports as  $prd) {
				/* $get_vendor_name= $this->reports_management_model->get_vendor_name($prd->vendor_id);
			if($prd->vendor_accept == '0')
			{ $vendoraccept = 'Pending'; }
			else if($prd->vendor_accept == '1')
			{ $vendoraccept = 'Accepted'; }
			else if($prd->vendor_accept == '2')
			{ $vendoraccept = 'Rejected'; }    
          
		if($prd->packstatus == '1')
			{ $packstatus = 'Package Created'; }
			else if($prd->packstatus == '2')
			{ $packstatus = 'Dispatched'; }
			else if($prd->packstatus == '3')
			{ $packstatus = 'Delivered'; }
			else if($prd->packstatus == '0')
			{ $packstatus = 'Pending'; } */

				/*$output .= '"'.$prd->order_id.'","'.$prd->order_item_id.'","'.$prd->order_item_name.'","'.$get_vendor_name.'","'.$prd->first_name." ".$prd->last_name.'","'.$prd->email.'","'.$prd->phone_number.'","'.date('d/m/Y',strtotime($prd->cdate)).'","'.$prd->size_name.'","'.$vendoraccept.'","'.$packstatus.'","'.$prd->api_booking_id.'","'.$prd->product_quantity.'","'.round($prd->product_item_price*$prd->product_quantity).'"';
		$output .="\n"; */

				$output .= '"' . $prd->order_id . '","' . date('d/m/Y', strtotime($prd->cdate)) . '","","' . $prd->first_name . " " . $prd->last_name . '","","","","","","","","","' . number_format($prd->order_total, '2', '.', '') . '",""';
				$output .= "\n";

				$orderitemsproucts = $this->reports_management_model->orderitemsproucts($prd->order_id);
				if ($orderitemsproucts != '' && count($orderitemsproucts) > 0) {
					foreach ($orderitemsproucts as $ordtitem) {
						$get_vendor_name = $this->reports_management_model->get_vendor_name_details($ordtitem->vendor_id);

						$statename = 	$this->reports_management_model->get_state_name($get_vendor_name->vendor_state);
						$state = strtolower($statename->state);

						$prductwithoutgst = number_format((($ordtitem->product_item_price * $ordtitem->product_quantity) * 100 / (100 + $ordtitem->gst)), '2', '.', '');

						$status = "Pending";
						if ($ordtitem->is_cancel == '1') {
							$status = "Cancelled";
						}
						if ($ordtitem->packstatus == '1') {
							$status = "Packed";
						} else if ($ordtitem->packstatus == '2') {
							$status = "Dispatched";
						} else if ($ordtitem->packstatus == '3') {
							$status = "Delivered";
						}

						$gstamt = ($ordtitem->product_item_price * $ordtitem->product_quantity) - $prductwithoutgst;

						if (strtolower($ordtitem->state) != $state) {
							$igst = $gstamt * $ordtitem->product_quantity;
						} else {
							$igst = "-";
						}

						if (strtolower($ordtitem->state) == $state) {
							$cgst = number_format($gstamt * $ordtitem->product_quantity / 2, '2', '.', '');
						} else {
							$cgst = "-";
						}

						if (strtolower($ordtitem->state) == $state) {
							$sgst = number_format($gstamt * $ordtitem->product_quantity / 2, '2', '.', '');
						} else {
							$sgst = "-";
						}

						$shippingwithoutgst = number_format((($ordtitem->productshipping) * 100 / (100 + 18)), '2', '.', '');

						if ($ordtitem->pcoupondiscount > 0) {
							$displaydiscount = "-" . $ordtitem->pcoupondiscount;
						} else {
							$displaydiscount = "0";
						}


						$output .= '"","","' . $get_vendor_name->company_name . '","","' . $ordtitem->order_item_name . '","' . number_format($prductwithoutgst) . '","' . $displaydiscount . '","' . $igst . '","' . $cgst . '","' . $sgst . '","' . number_format($shippingwithoutgst) . '","' . number_format($ordtitem->productshipping - $shippingwithoutgst) . '","' . number_format($ordtitem->product_item_price * $ordtitem->product_quantity + $ordtitem->productshipping) . '","' . $status . '"';
						$output .= "\n";
					}
				}

				$i++;
			}
		}


		$filename = "sales-report.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		exit;
	}
}
