<?php
class Shipping
{
    private $auth_code = '';
    private $url = '';
    private $fields = array();
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->config('shipping_config');
        $this->access_code  = $this->CI->config->item('access_code');
        $this->url          = $this->CI->config->item('url');
    }

    public function request($data)
    {
        $postfields = $data;
        $url = 'v1/courier-services/domestic/';

        $result = $this->execute($url, $postfields);
        return $result;
    }

    public function booking($data)
    {
        $postfields = $data;
        $url = 'v2/bookings/';

        $result = $this->execute($url, $postfields);
        return $result;
    }

    public function cancelBooking($id)
    {
        $postfields = array();
        $url = 'v1/bookings/'.$id;

        $result = $this->execute($url, $postfields);
        return $result;
    }

    public function deliveredstatus($data)
    {
        $postfields = $data;
        $url = 'v1/tracking/';

        $result = $this->execute($url, $postfields);
        return $result;
    }

    public function schedulePickup($data)
    {
        $postfields = $data;
        $url = 'v1/schedule-pickup/';

        $result = $this->execute($url, $postfields);
        return $result;
    }

    private function execute($post_url, $postfields = array())
    {
        
		//print_r(json_encode($postfields)); die;
		
		$auth_data = array(
            'X-API-Token: '.$this->access_code,
            'Content-Type: application/json',
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        if (count($postfields) > 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postfields));
        }
        curl_setopt($curl, CURLOPT_URL, $this->url.$post_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $auth_data);

        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    }
}
