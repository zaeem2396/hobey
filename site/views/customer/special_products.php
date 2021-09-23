<?php include('includes/header.php'); ?>
<div class="topalert successmain alert-message" id="order_succsess" style="display:none;"></div>
<div class="topalert valierror alert-message" id="order_succsess1" style="display:none;"></div>
<style>
  button.add-to-cart.btn.btn-default {
    background: #fdbb28;
    width: auto;
    color: #fff;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .brg {
    border: 2px solid #f2f2f2;
    display: grid;
    padding: 30px 8px;
  }

  .spp td,
  .spp th {

    padding: 8px;
  }

  .pdsp {
    padding-top: 10px;
  }

  .spp tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  .spp tr:hover {
    background-color: #f2f2f2;
  }

  .spp th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
  }

  @media (max-width: 767px) {
    .adtoc {
      display: none;
    }
  }
</style>
<!--navBar content End-->
<!--Product page-->
<div class="container">
  <div class="row mb-50 pdd50">
    <!--Right product section -->
    <div class="col-md-12 col-sm-12">
      <div class="row">
        <div class="col-md-12">
          <div class="brand-name-wrap">
            <span class="brand-name-title"> <a href="<?php echo $base_url; ?>"><i class="fa fa-home" aria-hidden="true"></i></a></span>
            <span class="product-total">All Products</span>
          </div>
        </div>
      </div>


      <form action="<?php echo $base_url; ?>billship/savespecialorders" method="post" />

      <?php foreach ($all_collections as $col) { ?>
        <h3><?php echo $col->name; ?></h3>


        <div class="row">
          <div class="col-md-7 col-sm-12">
            <table class="table table-striped spp">
              <tr style="font-weight:bold;">
                <td>Item</td>
                <td>Package size</td>
                <td>MRP</td>
                <td>Special Price</td>
                <td>Order Qty</td>
                <td></td>
              </tr>
              <?php
                $allProducts = $this->home_model->allproductCollection($col->product_id);
                foreach ($allProducts as $key => $value) { ?>
                <tr>
                  <td><?php echo $value->material_name; ?></td>
                  <td><?php echo $value->weight; ?></td>
                  <td>Rs. <span id="trpice_<?php echo $value->id; ?>"><?php echo $value->mrp; ?></span></td>
                  <td>Rs. <span id="trpice_<?php echo $value->id; ?>"><?php echo $value->price; ?></span></td>
                  <td><input style="width:50px;" name="productqty[]" oninput="this.value = Math.abs(this.value)" value="0" id="quantityb_<?php echo $value->id; ?>" min="1">
                    <input name="productid[]" value="<?php echo $value->id; ?>" type="hidden" />
                  </td>

                  <!-- td><button onclick="add_to_cart(<?php echo $value->id; ?>);" class="add-to-cart btn btn-default" type="button"><span class="fa fa-shopping-cart" style="padding-right: 10px;"></span> <span class="adtoc">add to cart</span></button></td -->
                </tr>
            <?php }
            } ?>
            </table>
          </div>
          <div class="col-md-5 col-sm-12">
            <div class="brg">
              <div class="form-group">

                <label class="control-label col-sm-3 pdsp">Select Distributor</label>

                <div class="col-sm-9">
                  <select class="form-control" id="distributorid" name="distributorid" required>
                    <option value="">Select Distributor</option>

                    <?php foreach ($alldistributors as $distributor) { ?>
                      <option value="<?php echo $distributor->id; ?>"><?php echo $distributor->name; ?></option>
                    <?php } ?>
                  </select>

                </div>

              </div>

              <div class="form-group">

                <label class="control-label col-sm-3 pdsp">Name</label>

                <div class="col-sm-9">

                  <input type="text" class="form-control" id="fname" name="fname" required>

                </div>

              </div>

              <div class="form-group">

                <label class="control-label col-sm-3 pdsp">Phone No.</label>

                <div class="col-sm-9">

                  <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>

                </div>

              </div>


              <div class="form-group">

                <label class="control-label col-sm-3 pdsp">Pincode</label>

                <div class="col-sm-9">

                  <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo $this->session->userdata('check_pincode'); ?>" readonly>

                </div>

              </div>
              <div class="form-group">

                <label class="control-label col-sm-3 pdsp">Address</label>

                <div class="col-sm-9">

                  <textarea class="form-control" rows="3" id="address" name="address" required></textarea>

                </div>

              </div>

              <br />

              <div class="form-group">

                <label class="control-label col-sm-3">&nbsp;</label>

                <div class="col-sm-9">

                  <button type="submit" class="btn btn-default-red plco">Place Order <i class="fa fa-shopping-basket" aria-hidden="true"></i></button>

                </div>

              </div>


            </div>
          </div>
        </div>

        </form>
    </div>



  </div>
  <!--Right product section End-->
</div>
</div>
<!--Product page End-->

<?php include('includes/footer.php'); ?>

<script>
  function add_to_cart(product_id) {

    var qty = $('#quantityb_' + product_id).val();
    var distributor_id = '0';
    var total_price = $('#trpice_' + product_id).text();
    if (qty == 0) {
      alert("Please Select Quantity");
      return false;
    }
    var url = "<?php echo $base_url; ?>cart/sp_customer_addtocart";
    $.ajax({
      url: url,
      type: 'post',
      data: 'product_id=' + product_id + '&qty=' + qty + '&total_price=' + total_price + '&distributor_id=' + distributor_id,
      success: function(msg) {
        //console.log(msg);
        //return false;
        //alert(msg);
        if (msg == 'nostock') {
          $("#order_succsess1").css("display", "block");
          $("#order_succsess1").addClass("success");
          $('#order_succsess1').show().delay(0).fadeIn('slow');
          $('#order_succsess1').hide().delay(2000).fadeOut('slow');
          $("#order_succsess1").html("Out Of Stock");

        } else {
          var msgs = 'Quote: ' + msg + ' item(s)';
          $("#total_quote").html(msgs);
          //var cart_url = '<?php echo $base_url; ?>customer-cart';
          //window.location.href = cart_url;
          $("#order_succsess").css("display", "block");
          $("#order_succsess").addClass("success");
          $('#order_succsess').show().delay(0).fadeIn('slow');
          $('#order_succsess').hide().delay(2000).fadeOut('slow');
          $("#order_succsess").html("Product has been added in Cart");
          /*$("#textmessage").html('Product has been added in Cart');
          $('#messagealert').modal();*/
          //}
        }

      }
    });
  }
  // function addtowishlist(fav)
  //         {
  //             $.ajax({
  //             url: '<?php //echo $base_url;
                        ?>home/addtowishlist',
  //             type: 'post',
  //             data: 'id='+fav,
  //             success:function(d)
  //             {   
  //                 if(d == '1') {              
  //                     $("#order_succsess").css("display","block");
  //                     $("#order_succsess").addClass("success");
  //                     $('#order_succsess').show().delay(0).fadeIn('slow');
  //                     $('#order_succsess').hide().delay(2000).fadeOut('slow');
  //                     $("#order_succsess").html("<i class='fa fa-check'></i>Product has been added to your wishlist list.");

  //                 }else{
  //                     $("#order_succsess").css("display","block");
  //                     $("#order_succsess").addClass("success");
  //                     $('#order_succsess').show().delay(0).fadeIn('slow');
  //                     $('#order_succsess').hide().delay(2000).fadeOut('slow');
  //                     $("#order_succsess").html("<i class='fa fa-check'></i>Product already added in whishlist."); 
  //                 }
  //             }
  //             }); 
  //         }
</script>