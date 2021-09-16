<?php include('includes/header.php');?>
<style>

.hhdb{color: #0067AC;}
.txtj {text-align:justify;}
.bggy {background:#0067AC;margin:15px 0px;padding:15px 10px;display:flex; color:#fff;}
.bggy .hhdb{color: #fff;}
form {
    padding: 0px 0;
}
.successmain {
    background-color:#008000;
    border-color: #008000;
}
.valierror{
    background-color:#ee2e34;
    border-color: #ee2e34;
    color: #fff;
}
.topalert{ z-index:9999; text-align:center; padding:10px; font-size:18px; color:#fff;  position: fixed; top:0px;}
.alert-message{
    background-size: 40px 40px;
    background-image: linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
                        transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
                        transparent 75%, transparent);                                      
   /*  box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);*/
     width: 100%;
     border: 0px solid;
     color: #fff;
     padding: 10px;
     /*position: fixed;*/
    /* _position: absolute;
     text-shadow: 0 1px 0 rgba(0,0,0,.5);*/
     animation: animate-bg 5s linear infinite;
     display:block;
}

.valierror123{
    background-color:#008000;
    border-color: #008000;
    color: #fff;
}
.line-through {
    text-decoration: line-through;
}
</style>

<div class="container">
	<div class="cart-wrap">
	    
	   <div class="row mb-50 pdd50">
	    
	    	<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
				   <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>			
					<li class="breadcrumb-item active" aria-current="page">Pre Book Energy Efficient Hotplates</li>
				  </ol>
				</nav>

          
    	   <div class="row mb-15">
        		<div class="col-md-12 txtj">
                    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdMitQDPNm6cUU0Smvvl1YXtvCBGCXxGfXK_MhfO79d2mwvow/viewform" width="100%" height="1200" style="border:none;">
                    </iframe>
     		</div>
            </div>

            
    </div>
    </div>

</div>
<?php include('includes/footer.php');?>
<script>
function removeproduct(id){
        var p = confirm('Are you sure u want to remove product');
        if(p){
            $.ajax(
             {
                 type: 'POST',
                 url: '<?php echo $base_url; ?>cart/removeproduct_customer/'+id,
                  data:'',
                 success: function(result)
                    {
                        location.reload();
                        //cartupdatetotal();    
                    }
            });
        } else {
            return false;
        }
}

function changeqty(id,qty)
{
    if(qty != '0')
    {
        var url='<?php echo $base_url."cart/changeqty_customer/"; ?>'+id+'/'+qty;        
        window.location = url;
        return true;
    }
}
</script>