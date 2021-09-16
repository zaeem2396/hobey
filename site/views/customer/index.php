<?php include('includes/header.php'); ?>
<style>
  .gradn {
    background: rgb(255, 190, 0);
    background: linear-gradient(0deg, rgba(255, 190, 0, 1) 23%, rgba(255, 255, 255, 1) 62%);
  }

  .carousel-inner>.item>a>img,
  .carousel-inner>.item>img {
    width: 100%;
  }

  .bdg {
    border-top: 5px solid #646464;
    border-bottom: 5px solid #646464;
    padding: 50px 0;
    margin: 50px 0px;
  }

  .testmnl {
    padding: 50px 0px;
  }
</style>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


<div class="container">

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog ">
    

      <div class="modal-content login-wrap">
        <form action="<?php echo $base_url; ?>home/set_pincode" method="post" id="set_pincode" name="set_pincode">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enter Your PIN Code</h4>
        </div>
        <div class="modal-body">
             <div id="error_pincode" class="alert-message valierror " style="display:none;width: 100%;">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
       <div class="form-group">
          <label for="email">PIN Code :</label>
          <input type="text" id="check_pincode" name="check_pincode" class="form-control" value="<?php echo $this->session->userdata('check_pincode'); ?>">
      </div>
      
      <button type="button" onclick="set_pincode_check();" class="btn btn-default-red">Submit </button>
  </form>
        </div>
     
      </div>
      
    </div>
  </div>
  
</div> -->


<div class="">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <?php
      if ($allbanners != '') {
        $k = 0;
        foreach ($allbanners as $banners) {
          ?>
          <div class="item  <?php if ($k == 0) { ?> active <?php } ?> ">
            <a href="<?php echo $banners->url; ?>">
              <img class="img-responsive" src="<?php echo $http_host; ?>upload/banner/<?php echo $banners->image; ?>" />
              <!--<div class="banner_textt">
			<h1><?php echo $banners->title; ?> </h1>
			<hr/>
			<p><?php echo $banners->title_2; ?></p>
			
		
            </div>--></a>
          </div>
      <?php $k++;
        }
      } ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>


<!--full width slider-->

<!-- slider end-->
<!--center block content-->
<div class="gradn">
  <div class="container-fluid">
    <div class="padd-t-b-50 center-block">
      <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-6 text-center mob-mrg-20"> <img class="center-block" src="<?php echo $base_url_views; ?>customer/images/home-care.png" alt="" />
          <h4 class="hed4">Home Care</h4>
          <hr class="hr1">
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center mob-mrg-20"> <img class="center-block" src="<?php echo $base_url_views; ?>customer/images/kitchen.png" alt="" />
          <h4 class="hed4">Kitchen Appliances</h4>
          <hr class="hr1">
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center mob-mrg-20"> <img class="center-block" src="<?php echo $base_url_views; ?>customer/images/solar.png" alt="" />
          <h4 class="hed4">Solar </h4>
          <hr class="hr1">
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center mob-mrg-20"> <img class="center-block" src="<?php echo $base_url_views; ?>customer/images/health.png" alt="" />
          <h4 class="hed4">Health & Hygiene </h4>
          <hr class="hr1">
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center mob-mrg-20"> <img class="center-block" src="<?php echo $base_url_views; ?>customer/images/grossary.png" alt="" />
          <h4 class="hed4">Grocery </h4>
          <hr class="hr1">
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6 text-center mob-mrg-20"> <img class="center-block" src="<?php echo $base_url_views; ?>customer/images/Gas.png" alt="" />
          <h4 class="hed4">Mini Bharatgas </h4>
          <hr class="hr1">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Products category end-->


<div class="bdg">
  <!-- Poster start-->
  <div class="poster">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <img src="<?php echo $base_url_views; ?>customer/images/poster1.jpeg">
        </div>
        <div class="col-md-4">
          <img src="<?php echo $base_url_views; ?>customer/images/poster2.jpeg">
        </div>

        <div class="col-md-4">
          <img src="<?php echo $base_url_views; ?>customer/images/poster3.jpeg">
        </div>
      </div>
    </div>
  </div>
  <!-- Poster end-->


  <div class="gogreen">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4>Go Green</h4>
        </div>
        <div class="col-md-4">
          <div class="go1">
            <img src="<?php echo $base_url_views; ?>customer/images/pp1.png">
            <p>charge while moving with solar based mobile charger</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="go2">
            <img src="<?php echo $base_url_views; ?>customer/images/pp2.png">
            <p>Saving LPG and Save Money with India's First energry efficient hotplate</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="go3">
            <img src="<?php echo $base_url_views; ?>customer/images/pp3.png">
            <p>Saving electricity with our range of solar lights</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>









<?php if ($allproductfeatured != '') { ?>
  <div class="col-md-12 product-title text-center">
    <h3>

      <strong>Featured Products</strong>

    </h3>
  </div>
  <div class="container">
    <div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade in active" id="brand1" aria-labelledby="brand1-tab">
        <div class="new-arrivals-wrap">
          <div class="row">
            <?php
              if ($allproductfeatured != '') {
                foreach ($allproductfeatured as $prod_featu) {
                  ?>
                <div class="col-md-3 col-xs-6 mob-mrg-10">
                  <div class="new-arrivals text-xs-center"> <a href="<?php echo $base_url; ?>product-detail/<?php echo $prod_featu->page_url; ?>-<?php echo $prod_featu->user_info_id; ?>"><img src="<?php echo $http_host; ?>upload/product/<?php echo $prod_featu->product_image; ?>" alt="" class="img-responsive" /></a> </div>
                  <a style="color: #000;" href="<?php echo $base_url; ?>product-detail/<?php echo $prod_featu->page_url; ?>-<?php echo $prod_featu->user_info_id; ?>"><span class="product-title"><?php echo $prod_featu->material_name; ?></a> <br />
                  </span> <span class="product-price"><span class="price-color"><i class="fa fa-rupee"></i> <?php echo $prod_featu->bpcl_special_price; ?></span>
                    <?php if ($prod_featu->mrp != '') { ?>
                      <strike><i class="fa fa-rupee"></i> <?php echo $prod_featu->mrp; ?></strike>
                    <?php } ?>
                  </span>
                </div>
            <?php }
              } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<!--Featured Products end-->
<div class="col-md-12 product-title">
  <h3>

    <strong>Top Selling Products</strong>

  </h3>
</div>
<div class="toppp">
  <div class="container">
    <div class="row">
      <?php
      if ($this->session->userdata('userid') != "" || $this->session->userdata('check_pincode') != "") {
        if (count($allproductLatest) > 0) {
          foreach ($allproductLatest as $latest_prod) {
            ?>
            <div class="col-md-6 col-xs-12 mob-mrg-10">
              <ul>
                <li> <a href="<?php echo $base_url; ?>product-detail/<?php echo $latest_prod->page_url; ?>"><img src="<?php echo $http_host; ?>upload/product/<?php echo $latest_prod->product_image; ?>" alt="" class="img-responsive" /></a></li>
                <li class="media-middle">
                  <a href="<?php echo $base_url; ?>product-detail/<?php echo $latest_prod->page_url; ?>"><span class="product-title"><?php echo $latest_prod->material_name; ?><br /></span></a>
                  <span class="product-price"><span class="price-color"><i class="fa fa-rupee"></i> <?php echo $latest_prod->mrp; ?></span>
                    <?php if ($latest_prod->mrp != '') { ?><strike><i class="fa fa-rupee"></i> <?php echo $latest_prod->bpcl_special_price; ?></strike></span><?php } ?>
                </li>
              </ul>
            </div>
        <?php }
          }
        } else {  ?>
        <div class="col-md-6 col-xs-12 mob-mrg-10">
          <a class="login" href="#login-form">Please Login to show top products</a>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<!--top product end-->

<div class="testmnl">
  <div class="container-fluid">
    <div class="col-md-12 product-title text-center">
      <h3>

        <strong>Testimonials</strong>

      </h3>
    </div>
    <p></p><br>
    <div class="col-md-10 col-md-offset-1">
      <div class="owl-carousel owl-theme owl_trv_vgal text-center owl-loaded owl-drag">

        <div class="item">
          <div class="">
            <iframe width="100%" height="200" src="https://www.youtube.com/embed/Dz6BtMcMkdY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>

        <div class="item">
          <div class="travel_grid_blk">
            <iframe width="100%" height="200" src="https://www.youtube.com/embed/YaBZyMURbfY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
        <div class="item">
          <div class="">
            <iframe width="100%" height="200" src="https://www.youtube.com/embed/JSSAt_5-t8E" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>

        <div class="item">
          <div class="travel_grid_blk">
            <iframe width="100%" height="200" src="https://www.youtube.com/embed/tKJktSQBAoo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</div>



<div class="">
  <img src="<?php echo $base_url_views; ?>customer/images/free-delivery.jpg" class="img-responsive" style="width:100%;">
</div>






<!-- <?php //if($this->session->userdata('check_pincode') =='') { 
      ?>
<script type="text/javascript">
$(window).load(function()
{
    $('#myModal').modal('show');
});
</script>
<?php //} 
?>
<script type="text/javascript">
$(document).ready(function(){
  $("#OpenPincodeModal").click(function(){
    $('#myModal').modal('show');
  });
});
</script> -->

<script>
  //Owl Carousel
  $(".all-banner-slide").owlCarousel({
    items: 1,
    smartSpeed: 1000,
    autoplay: true,
    lazyLoad: true,
    dots: false,
    autoplayTimeout: 3000
  });
</script>
<?php include('includes/footer.php'); ?>