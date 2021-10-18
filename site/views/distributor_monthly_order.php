<?php include('includes/header.php'); ?>
<style>
    .content {
        display: block;
    }

    footer {
        background: #000;
        text-align: center;
        color: #fff;
        padding-top: 20px;
        padding-bottom: 10px;
        position: fixed;
        width: 100%;
        bottom: 0;
    }

    .product_list_right_main ul li {
        background: #ccc;
        padding: 50px 10px;
        height: 180px;
        display: inline-grid;
    }

    .product_list_right_main ul li {
        background: #ccc;
        padding: 50px 10px;
    }

    .product_list_right_main ul a li h2 {
        color: #000;
    }
</style>
<section class=" login-reg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php include('includes/sidebar_distributor.php'); ?>
                <div class="content-wrapper">
                    <div class="content">
                        <h4> Monthly orders </h4>
                        <hr>
                        <div class="mt-5">
                            <form action="<?php echo $base_url; ?>billship/savespecialorders" method="POST">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="container">
                                            <h3><?= $all_collections[0]->name; ?></h3>
                                            <hr>
                                            </hr>
                                            <input type="text" class="form-control" id="myInput" onkeyup="searchProducts()" placeholder="Search for products..">
                                            <table class="table table-striped" id="productList">
                                                <tr class="font-weight-bold">
                                                    <th>Item</th>
                                                    <th>MRP</th>
                                                    <th>Special price</th>
                                                    <th>Order qty</th>
                                                </tr>
                                                <?php
                                                $allProducts = $this->home_model->allproductCollection($all_collections[0]->product_id);
                                                foreach ($allProducts as $key => $value) :
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $value->material_name; ?></td>
                                                        <td>Rs. <span id="trpice_<?php echo $value->id; ?>"><?php echo $value->mrp; ?></span></td>
                                                        <td>Rs. <span id="trpice_<?php echo $value->id; ?>"><?php echo $value->price; ?></span></td>
                                                        <!-- <td><input style="width:50px;" name="productqty[]" oninput="this.value = Math.abs(this.value)" value="0" id="quantityb_<?php echo $value->id; ?>" min="1">
                                                            <input name="productid[]" value="<?php echo $value->id; ?>" type="hidden" />
                                                        </td> -->
                                                        <td>
                                                            <select class="form-control" name="productqty[]" oninput="this.value = Math.abs(this.value)" id="quantityb_<?= $value->id; ?>" value="0" min="1">
                                                                <option value="0" selected disabled>0</option>
                                                                <?php for ($i = 1; $i <= 20; $i++) : ?>
                                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                                <?php endfor; ?>
                                                            </select>
                                                            <input name="productid[]" value="<?= $value->id; ?>" type="hidden" />
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-5 col-form-label font-weight-bold">Distributor name</label>
                                                        <div class="col-sm-7 pt-2">
                                                            <span class="text-uppercase font-weight-bold"><?= $distributorName[0]['name'] ?></span>
                                                            <input type="hidden" name="distributorid" id="distributorid" value="<?= $distributorName[0]['id'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-5 col-form-label font-weight-bold">Name</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter customer name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-5 col-form-label font-weight-bold">Phone</label>
                                                        <div class="col-sm-7">
                                                            <input onkeypress="return isNumber(event)" type="text" class="form-control" id="phonenumber" name="phonenumber" placeholder="Enter customer phone" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-5 col-form-label font-weight-bold">Pincode</label>
                                                        <div class="col-sm-7">
                                                            <input onkeypress="return isNumber(event)" type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter customer pincode" maxlength="6" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-5 col-form-label font-weight-bold">Address</label>
                                                        <div class="col-sm-7">
                                                            <textarea name="address" id="address" cols="30" rows="5" class="form-control" placeholder="Enter customer address" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-5 col-form-label font-weight-bold">Expected delivery date</label>
                                                        <div class="col-sm-7">
                                                            <input type="date" name="exp_delivery_date" id="exp_delivery_date" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col text-center">
                                                                <button type="submit" class="btn btn-sm btn-warning text-white text-uppercase">place order <i class="fa fa-shopping-basket" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>
<?php include('includes/footer.php'); ?>