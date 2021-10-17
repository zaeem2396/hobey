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
                        <h4> Edit Order: <?= $order_id ?> </h4>
                        <hr>
                        <div class="mt-5">
                            <!-- <form action="<?= $base_url ?>/editOrder" method="POST"> -->
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="container">
                                        <input type="text" class="form-control" id="myInput" onkeyup="searchProducts()" placeholder="Search for products..">
                                        <table class="table table-striped" id="productList">
                                            <tr class="font-weight-bold">
                                                <th>Item</th>
                                                <th>Package size</th>
                                                <th>MRP</th>
                                                <th>Special price</th>
                                                <th>Order qty</th>
                                            </tr>
                                            <?php
                                            foreach ($orderList as $orders) :
                                                ?>
                                                <tr>
                                                    <td><?php echo $orders['material_name']; ?></td>
                                                    <td><?php echo $orders['weight']; ?></td>
                                                    <td>Rs. <span><?php echo $orders['realprice']; ?></span>
                                                    </td>
                                                    <td>Rs. <span id="price-<?= $orders['order_item_id'] ?>">
                                                            <?= round($orders['product_item_price']); ?>
                                                        </span></td>
                                                    <td>
                                                        <select class="form-control allOrderList" name="productqty[]" oninput="this.value = Math.abs(this.value)" value="0" min="1" data-order_item_id="<?= $orders['order_item_id'] ?>" data-order_id="<?= $orders['order_id'] ?>" data-qty=<?= $orders['product_quantity'] ?> id="qty-<?= $orders['order_item_id'] ?>">
                                                            <option value="0" selected disabled>0</option>
                                                            <?php for ($i = 1; $i <= 20; $i++) : ?>
                                                                <option value="<?= $i ?>" <?= ($orders['product_quantity'] == $i) ? "selected" : ""; ?>><?= $i ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                        <span id="order_id-<?= $orders['order_id'] ?>"></span>
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
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col text-center">
                                                            <button type="button" onclick="editOrder()" class="btn btn-xl btn-warning text-white text-uppercase">update order <i class="fa fa-shopping-basket" aria-hidden="true"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const editOrder = () => {
        let url = '<?= $base_url ?>'
        let prodids = [
            <?php foreach ($orderList as $orders) :
                echo "'" . $orders['order_item_id'] . "',";
            endforeach; ?>
        ]
        let data = []
        for (let prodid of prodids) {
            let qty = document.getElementById(`qty-${prodid}`).value
            let price = document.getElementById(`price-${prodid}`).innerText
            data.push({
                prodPrice: price,
                prodQty: qty,
                order_item_id: prodid,
                order_id: <?= $order_id ?>
            })
        }
        $.ajax({
            url: `${url}/home/edit_order`,
            method: 'POST',
            data: {
                data: JSON.stringify(data)
            },
            success: (response) => {
                // console.log(response);
                let res = JSON.parse(response)
                if (res.status === 200) {
                    window.location.href = "<?= $_SERVER['HTTP_REFERER'] ?>"
                }
            }
        })
    }
</script>
<?php include('includes/footer.php'); ?>