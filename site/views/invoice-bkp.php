<?php
$front_base_url = $this->config->item('front_base_url');
$base_url 		= $this->config->item('base_url');
$index_url 		= $this->config->item('index_url');
$findex_url 		= $this->config->item('findex_url');
$base_url_views = $this->config->item('base_url_views');
$http_host = $this->config->item('http_host');

function convert_number_to_words($number)
{
   
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ' ';
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

?>
<style>
.modal-dialog {
    width: 80%;
    /* margin: 30px auto; */
}

table,
th,
td {

    border: 1px solid black;

    border-collapse: collapse;

    text-align: center;

}

th,
td {

    padding: 10px;

}

th {
    background: #cccccc87;
}
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <div class="toolbar hidden-print" style="margin-right: 35px;">
        <div class="text-right">
            <?php if($panel == '1'){ ?>
            <button class="btn btn-default" id="btnExport" value="Export" onclick="Export()"><i
                    class="fa fa-file-pdf-o"></i> Duplicate copy of Transporter</button>
            <button class="btn btn-default" id="btnExport" value="Export" onclick="Export()"><i
                    class="fa fa-file-pdf-o"></i> Duplicate copy of Supplier</button>
            <?php } ?>
            <button class="btn btn-default" id="btnExport" value="Export" onclick="Export()"><i
                    class="fa fa-file-pdf-o"></i> Export as PDF</button>
        </div>
    </div>
    <div class="modal-body" id="tblCustomers">
        <div id="invoice tab">
            <div class="invoice overflow-auto">
                <div style="min-width: 600px">
                    <div class="row">
                        <?php echo "<pre>";print_r($orderdetails);echo "</pre>" ;?>
                        <div style="padding:20px;margin:10px 20px;display: flow-root;">
                            <div style="width:20%;float:left;">
                                <img src="<?php echo $base_url_views;?>customer/images/logo-new.png" style="">
                            </div>
                            <div style="width:80%;float:right;">
                                <h4 style="float:right"><strong>Tax Invoice/Bill of Supply/Cash Memo</strong>
                                    <br />(Original for Recipient)
                                </h4>
                            </div>
                        </div>
                        <div class="clear:both;"></div>
                        <div style="padding:10px 20px;;margin:10px 20px;display: flow-root;">
                            <div style="width:50%;float:left;">
                                <p><strong>Billing Address :</strong></p>
                                <p><span><?php echo $ship_address->bill_first_name; ?>
                                        <?php echo $ship_address->bill_last_name; ?><br />
                                        <?php echo $ship_address->bill_city; ?><br /><?php echo $ship_address->bill_state; ?>,
                                        <?php echo $ship_address->bill_country; ?>,
                                        <?php echo $ship_address->bill_post_code; ?></span></p>
                            </div>
                            <div style="width:50%;float:right;text-align:right;">
                                <p><strong>Sold By :</strong></p>
                                <p><span><?php echo $vendordetails->name; ?>
                                        <br /><?php echo $vendordetails->address_1; ?>
                                        <br /><?php echo $vendordetails->address_2; ?>
                                        <br /><?php echo $this->account_model->getcityname($vendordetails->city_id); ?>,<?php echo $this->account_model->getstatenamein($vendordetails->state_id); ?>,
                                        <?php echo $vendordetails->pincode; ?></span></p>
                            </div>


                        </div>
                        <div class="clear:both;"></div>

                        <div style="padding:0px 20px;;margin:10px 20px;display: flow-root;">
                            <div style="width:50%;float:left;">
                                <p><strong>PAN No:</strong> <span> AABCW7791A</span></p>
                                <p><strong>GST Registration No: </strong> <span>
                                        <?php echo $vendordetails->gst_no; ?></span></p>
                            </div>
                            <div style="width:50%;float:right;text-align:right;">
                                <p><strong>Shipping Address :</strong></p>
                                <p><?php echo $ship_address->first_name; ?> <?php echo $ship_address->last_name; ?>
                                    <br /><?php echo $ship_address->address1; ?>,
                                    <br /><?php echo $ship_address->city; ?>,<?php echo $ship_address->state; ?>,
                                    <?php echo $ship_address->post_code; ?>
                                </p>
                            </div>

                        </div>
                        <div class="clear:both;"></div>

                        <div style="padding:0px 20px;margin:10px 20px;display: flow-root;">
                            <div style="width:50%;float:left;">
                                <p><strong>Order Number :</strong> <span>
                                        <?php echo $orderdetails[0]->order_id; ?></span></p>
                                <p><strong>Order Date : </strong> <span>
                                        <?php echo date('d/m/Y',strtotime($orderdetails[0]->cdate)); ?></span></p>
                            </div>
                            <div style="width:50%;float:right;text-align:right;">
                                <p><strong>Invoice Number:</strong> <span>
                                        <?php echo $orderdetails[0]->order_id; ?></span></p>
                                <p><strong>Invoice Date : </strong> <span>
                                        <?php echo date('d/m/Y',strtotime($orderdetails[0]->cdate)); ?></span></p>
                            </div>
                        </div>


                        <div class="clear:both;"></div>

                        <div style="padding:20px;">

                            <table style="width:100%;padding-top:0px;border: 1px solid #000;">
                                <tr>
                                    <th style="width:5%;">Sr.No.</th>
                                    <th style="width:40%;">Description</th>
                                    <th>Unit Price</th>
                                    <th>Discount</th>
                                    <th>QTY</th>
                                    <th>Net Amount</th>
                                    <th>Tax Rate</th>
                                    <th>Tax Type</th>
                                    <th>Tax Amount</th>
                                    <th>Total Amount</th>
                                </tr>
                                <?php 
                               $j='1';
                               $qty = '0';
                               $shippingcost = '0';
                               if($orderdetails != '' && count($orderdetails) > 0){
                                   foreach($orderdetails as $order){ 
									   //$gstamt = ($order->product_item_price*($order->gst/100));
									   $gstamt11 = number_format((($order->product_item_price*$order->product_quantity) * 100 / (100+ $order->gst)),'2','.','');
									   $gstamt = ($order->product_item_price*$order->product_quantity) -$gstamt11;  
									   if(strtolower($ship_address->state) == strtolower($getstatename)){
											$displaygstamt = round($gstamt/2);
									   } else {
											$displaygstamt =  round($gstamt);
									   }
							  ?>
                                <tr>
                                    <td><?php echo $j; ?>.</td>
                                    <td><?php echo $order->order_item_name; ?></td>
                                    <td>Rs. <?php echo round($order->product_item_price); ?></td>
                                    <td>Rs. <?php echo round($order->pcoupondiscount); ?></td>
                                    <td><?php echo $order->product_quantity; ?></td>
                                    <td>Rs. <?php echo round(($order->product_item_price*$order->product_quantity)-$gstamt); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Rs. <?php echo round($order->product_item_price*$order->product_quantity); ?></td>
                                </tr>
                                <?php $j++; 
                              $qty = $qty + $order->product_quantity;
                              $price = $price + ($order->product_item_price*$order->product_quantity);   
                              $shippingcost = $shippingcost + $order->productshipping; 
							  $coupondiscount = $order->pcoupondiscount;
                              } } ?>
                                <tr>
                                    <td colspan="8" style="text-align:left;">Total:</td>
                                    <td></td>
                                    <td><?php echo round(($price + $shippingcost - $coupondiscount)); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="10" style="text-align:left;font-size:18px;">Amount in Words: <?php echo convert_number_to_words(round(($price + $shippingcost - $coupondiscount))); ?></td>
                                </tr>

                                <tr>
                                    <td colspan="10" style="text-align:right;font-size:18px;">For <strong>Wakefit
                                            innovations pvt ltd:</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="10" style="text-align:right;font-size:18px;border-top:0">
                                        <br /><br />Authorized Signatory
                                    </td>
                                </tr>
                            </table>


                        </div>
                        <!-- <main>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">Product</th>
                                        <th class="text-right">Qty</th>
                                        <th class="text-right">Price (INR)</th>
                                        <th class="text-right">Tax Rate</th>
                                        <th class="text-right">Tax Type</th>
                                        <th class="text-right">Tax Amt (INR)</th>
                                        <th class="text-right">Total (INR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                               $j='1';
                               $qty = '0';
                               $shippingcost = '0';
                               if($orderdetails != '' && count($orderdetails) > 0){
                                   foreach($orderdetails as $order){ 
									   //$gstamt = ($order->product_item_price*($order->gst/100));
									   $gstamt11 = number_format((($order->product_item_price*$order->product_quantity) * 100 / (100+ $order->gst)),'2','.','');
									   $gstamt = ($order->product_item_price*$order->product_quantity) -$gstamt11;  
									   if(strtolower($ship_address->state) == strtolower($getstatename)){
											$displaygstamt = round($gstamt/2);
									   } else {
											$displaygstamt =  round($gstamt);
									   }
							  ?>
                                    <tr>
                                        <td class="no"><?php echo $j; ?></td>
                                        <td class="text-left">
                                            <h3>
                                                <p><?php echo $order->order_item_name; ?> <br /> Variant:
                                                    <?php echo $order->size_name; ?></p>
                                        </td>
                                        <td class="unit"><?php echo $order->product_quantity; ?></td>
                                        <td class="qty">
                                            <?php echo round(($order->product_item_price*$order->product_quantity)-$gstamt); ?>
                                        </td>
                                        <td class="total">
                                            <?php if(strtolower($ship_address->state) == strtolower($getstatename)){ echo ($order->gst/2)."%"."<br/>".($order->gst/2)."%"; } else { echo $order->gst."%"; } ?>
                                        </td>
                                        <td class="total">
                                            <?php if(strtolower($ship_address->state) == strtolower($getstatename)){ echo "CGST"."<br/>"."SGST"; } else { echo "IGST"; } ?>
                                        </td>
                                        <td class="total">
                                            <?php if(strtolower($ship_address->state) == strtolower($getstatename)){ echo round($displaygstamt)."<br/>".round($displaygstamt); } else { echo round($displaygstamt); } ?>
                                        </td>
                                        <td class="total">
                                            <?php echo round($order->product_item_price*$order->product_quantity); ?>
                                        </td>
                                    </tr>
                                    <?php $j++; 
                              $qty = $qty + $order->product_quantity;
                              $price = $price + ($order->product_item_price*$order->product_quantity);   
                              $shippingcost = $shippingcost + $order->productshipping; 
							  $coupondiscount = $order->pcoupondiscount;
                              } } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right">Total</td>
                                        <td class="unit"><?php echo $qty; ?></td>
                                        <td class="qty"></td>
                                        <td class="total"></td>
                                        <td class="total"></td>
                                        <td class="total"></td>
                                        <td class="total">INR <?php echo round($price); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="4">Shipping Cost</td>
                                        <td>INR <?php echo round($shippingcost); ?></td>
                                    </tr>
                                    <?php if($coupondiscount != '0'){?>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="4">Coupon Discount</td>
                                        <td>INR <?php echo round($coupondiscount); ?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="4">Grand Total</td>
                                        <td>INR <?php echo round(($price + $shippingcost - $coupondiscount)); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </main> -->
                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>
    <script type="text/javascript">
    function Export() {
        //alert('s');
        html2canvas(document.getElementById('tblCustomers'), {
            onrendered: function(canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500
                    }]
                };
                pdfMake.createPdf(docDefinition).download("invoice.pdf");
            }
        });
    }
    </script>