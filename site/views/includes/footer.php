<style>
footer {z-index:999;}
</style>
<footer>
    <p>2020 Copyright Bharat Petroleum Corporation Limited All Rights Reserved.</p>
</footer>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
  $('.open-menu-btn').on('click', function(){
  if($('body').hasClass('closed-menu')){
    $('body').removeClass('closed-menu');
  }else  $('body').addClass('closed-menu');
});
</script>
    <script>
    $(document).ready(function() {
      $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
      });
      $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
      });
    });
    
    </script> 
    
<script>
$(document).ready(function() {   
            var sideslider = $('[data-toggle=collapse-side]');
            var sel = sideslider.attr('data-target');
            var sel2 = sideslider.attr('data-target-2');
            sideslider.click(function(event){
                $(sel).toggleClass('in');
                $(sel2).toggleClass('out');
            });
        });
</script>
<script>
$(document).ready(function () {
        $(".navbar-toggle").on("click", function () {
            $(this).toggleClass("active");
        });
    });
</script>
<!--carosel-->
<!--login-->
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdowns").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtns')) {
    var dropdowns = document.getElementsByClassName("dropdowns-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
<!--sticky header-->
<script src="<?php echo $base_url_views; ?>assets/js/jquery-scrolltofixed-min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.nav1').scrollToFixed();
    });
</script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('.nav2').scrollToFixed();
    });
</script> 
 <!--search-->
<script>
function openSearch() {
    document.getElementById("myOverlay").style.display = "block";
}
function closeSearch() {
    document.getElementById("myOverlay").style.display = "none";
}
</script>  
<!--filter expand collpase-->
<script>
$( "h6" ).click(function() {
  $( this ).toggleClass( "down_arrow" );
});
</script>
<!--mobile filter-->
<script>
 $('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
  });
  $('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
  });
</script>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "100%";
}
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

const isNumber = evt => {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
</body>
</html>
