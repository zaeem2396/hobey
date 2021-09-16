<?php
$front_base_url = $this->config->item('front_base_url');
$base_url 		= $this->config->item('base_url');
$http_host 		= $this->config->item('http_host');
$base_url_views = $this->config->item('base_url_views');
$base_upload = $this->config->item('upload');
?>
<style>
ul.vertical-menu a {
    color: #fff;
}
</style>
 <!-- Start: Sidebar -->
  <aside id="sidebar_left">
    
    <div class="sidebar-menu">
		<?php
			if($this->session->userdata('adminId') !='')
			{
			$uid = $this->session->userdata('adminId');
			$getuser['data'] = $this->footer->getuser($uid);
			$category = $getuser['data']->role_id;
			$usercategory = $this->footer->usercategory($category);
			$permission1=$usercategory->permission;
			$permission1 = explode(',',$permission1);
		?>
      <ul class="nav">
		<li class="active"> <a class="ajax-disable" href="<?php echo $base_url;?>home"><span class="glyphicons fa fa-tachometer"></span><span class="sidebar-title">Dashboard</span></a> </li>					

		<?php if (in_array('1',$permission1) ){ ?>
		
        <li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-vcard"></span><span class="sidebar-title">Master</span><span class="caret"></span></a>
          <ul id="resources" class="nav sub-nav">		

		  
			<?php if(in_array('1',$permission1)){ ?>
			<li><a class="ajax-disable" href="<?php echo $base_url;?>category/lists"><span class="glyphicons glyphicons-book"></span> Category </a></li>
			
			<li class="divider"></li>
			
				 <?php }?>	


				 
				 <?php if(in_array('1',$permission1)){ ?>
					<li><a class="ajax-disable" href="<?php echo $base_url;?>subcategory/lists"><span class="glyphicons glyphicons-book"></span>Sub Category</a></li>				
					<li class="divider"></li>
				 <?php } ?>			

			<?php if(in_array('1',$permission1)){ ?>
			<li><a class="ajax-disable" href="<?php echo $base_url;?>wellness_category/lists"><span class="glyphicons glyphicons-book"></span> Wellness Category </a></li>
			
			<li class="divider"></li>
			
				 <?php }?>	

				<?php  if(in_array('1',$permission1)){ ?>		 
				<li><a class="ajax-disable" href="<?php echo $base_url;?>size/lists"><span class="glyphicons glyphicons-book"></span>Size</a></li>		
				<li class="divider"></li>		
				<?php }  ?>		

				<!--<?php if(in_array('1',$permission1)){ ?>		 
				<li><a class="ajax-disable" href="<?php echo $base_url;?>gram/lists"><span class="glyphicons glyphicons-book"></span>Gram</a></li>		
				<li class="divider"></li>		
				<?php }?> -->

				<?php if(in_array('1',$permission1)){ ?>		 			
				<li><a class="ajax-disable" href="<?php echo $base_url;?>colour/lists"><span class="glyphicons glyphicons-book"></span>Colour</a></li>			
				<li class="divider"></li>			
				<?php } ?>	
				
				<?php if(in_array('1',$permission1)){ ?>		 			
				<li><a class="ajax-disable" href="<?php echo $base_url;?>pincode/lists"><span class="glyphicons glyphicons-book"></span>Pincode</a></li>			
				<li class="divider"></li>			
				<?php } ?>
				
				<?php if(in_array('1',$permission1)){ ?>		 			
				<li><a class="ajax-disable" href="<?php echo $base_url;?>cms/lists"><span class="glyphicons glyphicons-book"></span>CMS</a></li>			
				<li class="divider"></li>			
				<?php } ?>
				
				<?php if(in_array('1',$permission1)){ ?>		 			
				<li><a class="ajax-disable" href="<?php echo $base_url;?>banner/lists"><span class="glyphicons glyphicons-book"></span>Banners</a></li>			
				<li class="divider"></li>			
				<?php } ?>
					
			</ul>						 
			</li> 		
			<?php } ?>	
			


<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-vcard"></span><span class="sidebar-title">Product Management</span><span class="caret"></span></a>
          <ul id="resources" class="nav sub-nav">		
			
		 	<?php  if(in_array('1',$permission1)){ ?>		 			
				<li><a class="ajax-disable" href="<?php echo $base_url;?>product/lists"><span class="glyphicons glyphicons-book"></span>Product</a></li>			
 				<?php } ?>
 				
				<?php  if(in_array('1',$permission1)){ ?>		 			
				<li><a class="ajax-disable" href="<?php echo $base_url;?>product/deletedlists"><span class="glyphicons glyphicons-book"></span>Deleted Product</a></li>			
 				<?php } ?>
		  
			
		 
			
			</ul>
        </li>
        
        
		
				
				
				
				<?php  if(in_array('1',$permission1)){ ?>		 			
				<li><a class="ajax-disable" href="<?php echo $base_url;?>coupan/lists"><span class="glyphicons glyphicons-book"></span>Coupon</a></li>			
				<li class="divider"></li>			
				<?php } ?>
				
				<?php  if(in_array('1',$permission1)){ ?>		 			
				<li><a class="ajax-disable" href="<?php echo $base_url;?>offers/edit/1"><span class="glyphicons glyphicons-book"></span>System</a></li>			
				<li class="divider"></li>			
				<?php } ?>
				
					<?php if(in_array('1',$permission1)){ ?>		
			<li><a class="ajax-disable" href="<?php echo $base_url;?>reports_management/order"><span style="font-size:14px;" class="fa fa-lock"></span>Sales Report </a></li>	
			<li class="divider"></li> 			
			<?php } ?>	
				
				<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-vcard"></span><span class="sidebar-title">User Management</span><span class="caret"></span></a>
          <ul id="resources" class="nav sub-nav">		
			
		  <?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>user/lists"><span class="glyphicons fa fa-life-ring"></span>Register Users</a></li>			
			<?php } ?>	
			
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>vendor/lists"><span class="glyphicons fa fa-life-ring"></span>Vendor</a></li>			
			<?php } ?>
			
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>users/lists"><span class="glyphicons fa fa-life-ring"></span>Admin Users</a></li>			
			<?php } ?>
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>permission/list_permission"><span class="glyphicons fa fa-life-ring"></span>Admin Permission</a></li>			
			<?php } ?>
			
			</ul>
        </li>
		
		<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-vcard"></span><span class="sidebar-title">Workshops</span><span class="caret"></span></a>
          <ul id="resources" class="nav sub-nav">		
			
		  <?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>workspace_category/lists"><span class="glyphicons fa fa-life-ring"></span>Workshops Category</a></li>			
			<?php } ?>	
			
		  <?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>speaker/lists"><span class="glyphicons fa fa-life-ring"></span>Speaker</a></li>			
			<?php } ?>
			
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>event/lists"><span class="glyphicons fa fa-life-ring"></span>Workshops</a></li>			
			<?php } ?>
			
			</ul>
        </li>

		<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-vcard"></span><span class="sidebar-title">Receipes</span><span class="caret"></span></a>
          <ul id="resources" class="nav sub-nav">		
			
		  <?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>chef/lists"><span class="glyphicons fa fa-life-ring"></span>Chefs</a></li>			
			<?php } ?>	
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>recipes_main_category/lists"><span class="glyphicons fa fa-life-ring"></span>Receipes Main Category</a></li>			
			<?php } ?>
			
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>recipes_category/lists"><span class="glyphicons fa fa-life-ring"></span>Receipes Category</a></li>			
			<?php } ?>
			
		    <?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>receipes/lists"><span class="glyphicons fa fa-life-ring"></span>Receipes</a></li>			
			<?php } ?>
		 	
			</ul>
        </li>
		 
		
		<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-vcard"></span><span class="sidebar-title">Blog</span><span class="caret"></span></a>
          <ul id="resources" class="nav sub-nav">		
			
		  <?php /* if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>blog_category/lists"><span class="glyphicons fa fa-life-ring"></span>Blog Category</a></li>			
			<?php }  */ ?>	
			
		  <?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>blog_subcategory/lists"><span class="glyphicons fa fa-life-ring"></span>Blog Sub Category</a></li>			
			<?php } ?>
			
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>blog/lists"><span class="glyphicons fa fa-life-ring"></span>Blog</a></li>			
			<?php } ?>
			
			</ul>
        </li>
		
		<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-vcard"></span><span class="sidebar-title">Services</span><span class="caret"></span></a>
          <ul id="resources" class="nav sub-nav">		
		  <?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>service_category/lists"><span class="glyphicons fa fa-life-ring"></span>Service Category</a></li>			
			<?php } ?>
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>services/lists"><span class="glyphicons fa fa-life-ring"></span>Service</a></li>		
			<?php } ?>
			</ul>
        </li>
		
		<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-vcard"></span><span class="sidebar-title">Travel</span><span class="caret"></span></a>
          <ul id="resources" class="nav sub-nav">		
		  <?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>travel_category/lists"><span class="glyphicons fa fa-life-ring"></span>Travel Category</a></li>			
			<?php } ?>
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>travel/lists"><span class="glyphicons fa fa-life-ring"></span>Travel</a></li>		
			<?php } ?>
			</ul>
        </li>
		
		
		<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-vcard"></span><span class="sidebar-title">Gift Hamper</span><span class="caret"></span></a>
          <ul id="resources" class="nav sub-nav">		
			
		  <?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>gift_hamper_category/lists"><span class="glyphicons fa fa-life-ring"></span>Gift Hamper Category</a></li>			
			<?php } ?>
			
			<?php if(in_array('1',$permission1)){ ?>	
			<li><a class="ajax-disable" href="<?php echo $base_url;?>gift_hampers/lists"><span class="glyphicons fa fa-life-ring"></span>Gift Hamper</a></li>			
			<?php } ?>
			
			</ul>
        </li>
		
		<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-coins"></span><span class="sidebar-title">Order Management</span><span class="caret"></span></a>		
		<ul id="resources" class="nav sub-nav">		
		<li class="divider"></li> 
		
		<?php  if(in_array('1',$permission1)){ ?>		
		
		<li><a class="ajax-disable" href="<?php echo $base_url;?>orders/lists"><span class="glyphicons glyphicons-book"></span>Order </a></li>	
		
		<li class="divider"></li>		
		
		<?php }  ?>					

		<?php if(in_array('1',$permission1)){ ?>	
		<li><a class="ajax-disable" href="<?php echo $base_url;?>orders/lists_experiance"><span class="glyphicons glyphicons-book"></span>Workshop Order </a></li>	
		<li class="divider"></li>	
		<?php } ?>										

			</ul>        </li>	
			
			
		<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-coins"></span><span class="sidebar-title">Payment Management</span><span class="caret"></span></a>		
		<ul id="resources" class="nav sub-nav">		
		<li class="divider"></li> 
		
		<?php  if(in_array('1',$permission1)){ ?>		
 		<li><a class="ajax-disable" href="<?php echo $base_url;?>vendorpayment/lists"><span class="glyphicons glyphicons-book"></span>Vendor Payment</a></li>	
 		<li class="divider"></li>		
 		<?php }  ?>					

	 										

			</ul>        </li>	
			
			
		<li> <a class="accordion-toggle " href="#resources"><span class="glyphicons glyphicons-coins"></span><span class="sidebar-title">Reviews Management</span><span class="caret"></span></a>		
		<ul id="resources" class="nav sub-nav">		
		<li class="divider"></li> 
		
		<?php  if(in_array('1',$permission1)){ ?>		
 		<li><a class="ajax-disable" href="<?php echo $base_url;?>reviews/lists"><span class="glyphicons glyphicons-book"></span>Reviews</a></li>	
 		<li class="divider"></li>		
 		<?php }  ?>					
		</ul>
		</li>		
			
			
      </ul>	  			  	  		
			<?php  } ?>
    </div>
	
  </aside>
