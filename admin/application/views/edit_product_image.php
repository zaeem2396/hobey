<?php include('include/header.php');?>
<style>
.border_parts tr td {
    border: 1px solid #ccc;
    padding: 6px 6px 0px 6px;
    width: 413px;
    float: left;
    border-collapse: collapse;
    border-spacing: 0px;
}
.grid-square {
    width:300px;
    height:300px;
    display: inline-block;
    background-color: #fff;
    border: solid 1px rgb(0,0,0,0.2);
    padding: 10px;
    margin-right: 12px;
    margin-bottom: 12px;
}

.drgging-element {
    background-color: #F0FFF0;
}
</style>
<!-- Start: Main -->
<div id="main">
    <?php include('include/sidebar_left.php');?>
    <!-- Start: Content -->
    <section id="content_wrapper">
        <div id="topbar">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    
                    <li class="crumb-icon">
                        <a href="<?php echo $base_url; ?>">
                        <spanclass="glyphicon glyphicon-home"></span>
                        </a>
                    </li>
                    <li class="crumb-link"><a href="<?php echo $base_url; ?>product/lists">Product</a></li>
                    <li class="crumb-active"><a href="javascript:void(0);"> Edit Product Image</a></li>
                </ol>
            </div>
        </div>
        <div id="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <?php if ($this->session->flashdata('L_strErrorMessage')) { ?>
                            <div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage', 5); ?>
                            </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('flashError')!='') { ?>
                            <div
                                class="alert alert-danger alert-dismissable">
                                <i class="fa fa-warning"></i>
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <b>Error!</b> <?php echo $this->session->flashdata('flashError', 5); ?>
                            </div>
                            <?php } ?>
                            <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">
                                <i class="fa fa-warning"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <b>Error &nbsp; </b><span id="error_msg1"></span>
                            </div>
                            <div class="col-md-12">
                                <form role="form" id="form" method="post"
                                    action="<?php echo $base_url;?>product/editimage/<?php echo $result->id; ?>"
                                    enctype="multipart/form-data">
                                    <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                                    <INPUT TYPE="hidden" NAME="action" VALUE="edit">
                                    <INPUT TYPE="hidden" NAME="hiddenaction" VALUE="<?php echo $result->id;?>">
                                    <div class="form-group">
                                        <label for="fabricname">Upload Image (Image size max 1000px x 1000px at 72 dpi, JPG, JPEG accepted)</label>
                                        <input id="attachment1" name="attachment1[]" multiple type="file" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;" />
                                        <a href="<?php echo $base_url;?>product/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" >Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="gridDemo" class="col-md-12">
                <?php
                if ($productimages != '' && count($productimages) > 0) {
                    $i=1;
                    foreach ($productimages as $images) {
                ?>
                <div class="grid-square product-image" data-id="<?php echo $images->id ?>">
                    <img style="height: 202px; width: 100%;" src="<?php echo $this->config->item('front_base_url')."upload/product/".$images->image; ?>" />
                            &nbsp;<br>
                            <!--<label style="font-size:14px; font-weight:normal;" class="" for="inputEmail">Set Base Image
                            </label>
                            &nbsp;
                            <input type="radio" name="baseimage" value="<?php echo $images->pid; ?>"
                                <?php if ($images->baseimage == '1') { echo "checked='checked'"; } ?>
                                onclick="setbaseimg('<?php echo $images->id; ?>','<?php echo $images->pid; ?>','<?php echo $i; ?>');" /> -->
                            <button style="float: right; font-size: 12px; margin-bottom: 3px; padding: 3px 0 2px; width: 64px;"
                                class="btn btn-danger"
                                onclick="removeimage('<?php echo $this->config->item('base_url').'product/removeimage/'.$images->id.'/'.$images->pid ;?>');"
                                >Remove</button><br><br>
                </div>
                <?php
                        $i++;
                    }
                }
                ?>
                </div>
            </div>
        </div>
    </section> <!-- End: Content -->
    <?php include('include/sidebar_right.php');?>
</div>
<!-- End #Main --> <?php include('include/footer.php')?>
<script src="<?php echo $base_url_views ?>js/Sortable.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script> -->
<script>
$(document).ready(function() {
    new Sortable(gridDemo, {
        animation: 150,
        ghostClass: 'drgging-element',
        onEnd: function (evt) {
            var image_list = [];
            $(".product-image").each(function() {
                image_list.push($(this).data('id'));
            });
            $.ajax({
                url:'<?php echo $base_url; ?>product/set_image_sequence',
                type:'POST',
                data: { image_list: image_list.toString()},
                success:function(msg) {
                    if (msg == '1') {
                        // alert('The image sequense is saved');
                    }
                }
            });
        }
    });
});
</script>
<script>
function validate() {
    var attachment1 = $("#attachment1").val();
    if (attachment1 == '') {
        $("#error_msg1").html("Please Select Image.");
        $("#validator").css("display", "block");
        return false;
    }
    $('#form').submit();
}
</script>
<script>
function removeimage(url) {
    if (confirm('Are you sure you want to remove the image')) {
        window.location.href = url;
    }
}

function udpaterecors(val, id, pid) {
    if (confirm('Are you sure you want to set update order of image')) {
        var url = '<?php echo $this->config->item("base_url"); ?>product/updateorder/' + val + '/' + id + '/' + pid;
        window.location.href = url;
    }
}

function setbaseimg(id, pid, image_index) {
    if (confirm('Are you sure you want to set these image as baseimage')) {
        var url = '<?php echo $this->config->item("base_url"); ?>product/setbaseimg/' + id + '/' + pid + '/' +
            image_index;
        window.location.href = url;
    }
}
</script>