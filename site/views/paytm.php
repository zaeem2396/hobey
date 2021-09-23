Please wait. Do not refresh the page...
<div id="paytm-checkoutjs"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
    function onScriptLoad(){
        var config = {
         "root": "",
         "flow": "DEFAULT",
         "data": {
          "orderId": "<?php echo $orderid; ?>" /* update order id */,
          "token": "<?php echo $token; ?>" /* update token value */,
          "tokenType": "TXN_TOKEN",
          "amount": "<?php echo $amount; ?>" /* update amount */
         },
         "handler": {
            "notifyMerchant": function(eventName,data){
              console.log("notifyMerchant handler function called");
              console.log("eventName => ",eventName);
              console.log("data => ",data);
            } 
          }
        };

        if(window.Paytm && window.Paytm.CheckoutJS){
            window.Paytm.CheckoutJS.onLoad(function excecuteAfterCompleteLoad() {
                // initialze configuration using init method 
                window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
                   // after successfully update configuration invoke checkoutjs
                   window.Paytm.CheckoutJS.invoke();
                }).catch(function onError(error){
                    console.log("error => ",error);
                });
            });
        } 
    }
</script>
<script type="application/javascript" crossorigin="anonymous" src="https://securegw-stage.paytm.in/merchantpgpui/checkoutjs/merchants/Bharat39191867247929.js" onload="onScriptLoad();"></script>