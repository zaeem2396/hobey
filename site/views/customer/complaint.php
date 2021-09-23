<?php include('includes/header.php');?>
<style>
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
	<div class="cart-wrap pdd50">
	    
	        	<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
				   <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>			
					<li class="breadcrumb-item active" aria-current="page">Complaint / Feedback</li>
				  </ol>
				</nav>

    	   <div class="row mb-15">
        		<div class="col-md-12"><p>Coming Soon</p></div>
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