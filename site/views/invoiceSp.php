<?php
$front_base_url = $this->config->item('front_base_url');
$base_url         = $this->config->item('base_url');
$index_url         = $this->config->item('index_url');
$findex_url         = $this->config->item('findex_url');
$base_url_views = $this->config->item('base_url_views');
$http_host = $this->config->item('http_host');
function AmountInWords(float $amount)
{
    $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
    // Check if there is any number after decimal
    $amt_hundred = null;
    $count_length = strlen($num);
    $x = 0;
    $string = array();
    $change_words = array(
        0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );
    $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($x < $count_length) {
        $get_divider = ($x == 2) ? 10 : 100;
        $amount = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;
        if ($amount) {
            $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
            $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
            $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
       ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
       ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
        } else $string[] = null;
    }
    $implode_to_Rupees = implode('', array_reverse($string));
    $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
    return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}

function gst($total, $gst_rate)
{
    $res = $gst_rate / (100 + $gst_rate) * $total;
    return $res;
}
?>
<style>
<<<<<<< HEAD
.modal-dialog {
    width: 80%;
    /* margin: 30px auto; */
}
.modal-header { line-height:20px; }
table,
th,
td {
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
}
th,
td {
    padding: 2px;
}
th {
    background: #cccccc87;
}
=======
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
>>>>>>> a49cb9f5aea90095701258e9216b8d73dda2ef81
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <div class="toolbar hidden-print" style="margin-right: 35px;">
        <div class="text-right">
            <?php if ($panel == '1') { ?>
                <button class="btn btn-default" id="btnExport" value="Export" onclick="Export()"><i class="fa fa-file-pdf-o"></i> Duplicate copy of Transporter</button>
                <button class="btn btn-default" id="btnExport" value="Export" onclick="Export()"><i class="fa fa-file-pdf-o"></i> Duplicate copy of Supplier</button>
            <?php } ?>
            <button class="btn btn-default-red" id="btnExport" style="padding: 6px 20px;" value="Export" onclick="Export()"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
        </div>
    </div>
    <div class="modal-body" id="tblCustomers">
        <div id="invoice tab">
            <div class="invoice overflow-auto">
                <div style="min-width: 600px">
                    <div class="row">
<<<<<<< HEAD
                        <?php //echo "<pre>";print_r($orderdetails);echo "</pre>" ;?>
                        <div style="padding:2px;margin:10px 20px;display: flow-root;">
=======
                        <?php //echo "<pre>";print_r($orderdetails);echo "</pre>" ;
                        ?>
                        <div style="padding:20px;margin:10px 20px;display: flow-root;">
>>>>>>> a49cb9f5aea90095701258e9216b8d73dda2ef81
                            <div style="width:20%;float:left;">
                                <img src="<?php echo $base_url_views; ?>customer/images/logo-new.png" style="">
                            </div>
                            <div style="width:80%;float:right;">
                                <h4 style="float:right"><strong>Tax Invoice/Bill of Supply/Cash Memo</strong>
                                    <br />(Original for Recipient)
                                </h4>
                            </div>
                        </div>
                        <div class="clear:both;"></div>
                        <div style="padding:2px 20px;;margin:10px 20px;display: flow-root;">
                            <div style="width:50%;float:left;">
                                <p><strong>Sold By :</strong></p>
                                <p><span><?php echo $vendordetails->name; ?>
                                        <br /><?php echo $vendordetails->address_1; ?>
                                        <?php if ($vendordetails->address_2 != '') { ?>
                                            <br /><?php echo $vendordetails->address_2; ?>
                                        <?php } ?>
                                        <br /><?php echo $this->account_model->getcityname($vendordetails->city_id); ?>, <?php echo $this->account_model->getstatenamein($vendordetails->state_id); ?>,
                                        <?php //echo $vendordetails->pincode; 
                                        ?></span></br>IN</p>

                            </div>
                            <div style="width:50%;float:right;text-align:right;">
                                <p><strong>Billing Address :</strong></p>
                                <p><span><?php echo $ship_address->bill_first_name; ?>
                                        <?php echo $ship_address->bill_last_name; ?><br />
                                        <?php echo $ship_address->bill_city; ?><br /><?php echo $ship_address->bill_state; ?>,
                                        <?php echo $ship_address->bill_country; ?>,
                                        <?php echo $ship_address->bill_post_code; ?></span></p>
                            </div>


                        </div>
                        <div class="clear:both;"></div>

                        <div style="padding:0px 20px;;margin:10px 20px;display: flow-root;">
                            <div style="width:50%;float:left;">
                                <p><strong>PAN No:</strong> <span> </span></p>
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
                                        <?php echo date('d/m/Y', strtotime($orderdetails[0]->cdate)); ?></span></p>
                            </div>
                            <div style="width:50%;float:right;text-align:right;">
                                <p><strong>Invoice Number:</strong> <span>
                                        <?= $orderdetails[0]->order_id; ?><?= $ccno[0]['cc_code']; ?></span></p>
                                <p><strong>Invoice Date : </strong> <span>
                                        <?php echo date('d/m/Y', strtotime($orderdetails[0]->cdate)); ?></span></p>
                            </div>
                        </div>


                        <div class="clear:both;"></div>

                        <div style="padding:5px;">

                            <table style="width:100%;padding-top:0px;border: 1px solid #000;">
                                <tr>
                                    <th style="width:5%;">Sr.No.</th>
                                    <th style="width:30%;">Description</th>
                                    <th style="width:8%;">HSN/SAC Code</th>
                                    <th style="width:10%;">MRP</th>
                                    <th>Special Unit Price</th>
                                    <th>QTY</th>
                                    <th>Total</th>
                                    <th>Rate of GST</th>
                                    <th>CGST</th>
                                    <th>SGST</th>
                                    <th>Total Saving</th>
                                </tr>
<<<<<<< HEAD
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
									   
									   if($j<30){
							  ?>
                                <tr>
                                    <td><?php echo $j; ?>.</td>
                                    <td><?php echo $order->order_item_name; ?></td>
                                    <td>Rs. <?php echo round($order->realprice); ?></td>
                                    <td>Rs. <?php echo round($order->product_item_price); ?></td>
                                    <td><?php echo $order->product_quantity; ?></td>
                                    <td>Rs. <?php echo round(($order->product_item_price*$order->product_quantity)-$gstamt); ?></td>
                                    <td>Rs. <?php echo round(($order->realprice-$order->product_item_price)*$order->product_quantity); ?></td>
                                </tr>
                                
                                <?php }  $j++;
                                
                               // if($j>10){break;}
                                
                              $qty = $qty + $order->product_quantity;
                              $price = $price + ($order->product_item_price*$order->product_quantity);   
                              $shippingcost = $shippingcost + $order->productshipping; 
							  $coupondiscount = $order->coupondiscount;
                              $totalSaving = $totalSaving + (($order->realprice-$order->product_item_price)*$order->product_quantity);   
                              } } ?>
                                <tr>
                                    <td colspan="5" style="text-align:right;">Grand Total:</td>
=======
                                <?php
                                $j = '1';
                                $qty = '0';
                                $shippingcost = '0';
                                if ($orderdetails != '' && count($orderdetails) > 0) {
                                    foreach ($orderdetails as $order) {
                                        //$gstamt = ($order->product_item_price*($order->gst/100));
                                        $gstamt11 = number_format((($order->product_item_price * $order->product_quantity) * 100 / (100 + $order->gst)), '2', '.', '');
                                        $gstamt = ($order->product_item_price * $order->product_quantity) - $gstamt11;
                                        if (strtolower($ship_address->state) == strtolower($getstatename)) {
                                            $displaygstamt = round($gstamt / 2);
                                        } else {
                                            $displaygstamt =  round($gstamt);
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $j; ?>.</td>
                                            <td><?php echo $order->order_item_name; ?></td>
                                            <td><?php echo $order->hsn_code; ?></td>
                                            <td>Rs. <?php echo round($order->realprice); ?></td>
                                            <td>Rs. <?php echo round($order->product_item_price); ?></td>
                                            <td><?php echo $order->product_quantity; ?></td>
                                            <!-- <td>Rs. <?php echo round(($order->product_item_price * $order->product_quantity) - $gstamt); ?></td> -->
                                            <td>Rs. <?php echo round(($order->product_item_price * $order->product_quantity)); ?></td>
                                            <td><?= $order->gst; ?>%</td>
                                            <td>
                                                <?php
                                                        // $total_price = round(($order->product_item_price * $order->product_quantity) - $gstamt);
                                                        $total_price = round(($order->product_item_price * $order->product_quantity));
                                                        $res = $order->gst / (100 + $order->gst) * $total_price;
                                                        echo number_format($res / 2, 2);
                                                        ?>
                                            </td>
                                            <td><?php echo number_format($res / 2, 2); ?></td>
                                            <td>Rs. <?php echo round(($order->realprice - $order->product_item_price) * $order->product_quantity); ?></td>
                                        </tr>
                                <?php $j++;
                                        $qty = $qty + $order->product_quantity;
                                        $price = $price + ($order->product_item_price * $order->product_quantity);
                                        $shippingcost = $shippingcost + $order->productshipping;
                                        $coupondiscount = $order->coupondiscount;
                                        $totalSaving = $totalSaving + (($order->realprice - $order->product_item_price) * $order->product_quantity);
                                    }
                                } ?>
                                <tr>
                                    <td colspan="6" style="text-align:right;">Grand Total:</td>
>>>>>>> a49cb9f5aea90095701258e9216b8d73dda2ef81
                                    <td>Rs. <?php echo round(($price + $shippingcost - $coupondiscount)); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align:right;">Total Savings:</td>
                                    <td>Rs. <?php echo round($totalSaving); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="7" style="text-align:left;font-size:18px;">Amount in Words: <?php echo AmountInWords(round(($price + $shippingcost - $coupondiscount))); ?></td>
                                </tr>

                                <tr>
                                    <td colspan="7" style="text-align:right;font-size:18px;">For <strong><?php echo $vendordetails->name; ?>:</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="7" style="text-align:right;font-size:18px;border-top:0">
                                        <br /><br />Authorized Signatory
                                    </td>
                                </tr>
                            </table>


                        </div>

                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js">
    </script>
    <script type="text/javascript">
        function Export() {
            // html2canvas(document.getElementById('tblCustomers'), {
            //     onrendered: function(canvas) {
            //         var data = canvas.toDataURL();
            //         var docDefinition = {
            //             content: [{
            //                 image: data,
            //                 width: 500
            //             }]
            //         };
            //         pdfMake.createPdf(docDefinition).download("invoice.pdf");
            //     }
            // });

            html2canvas($("#tblCustomers")[0], {
                allowTaint: true
            }).then(function(canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500
                    }]
                };
                pdfMake.createPdf(docDefinition).download("invoice.pdf");
            });

        }
    </script>