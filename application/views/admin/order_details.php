<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="admin-page-title">
            <i class="fa fa-list"></i> <span>Order Details [ <?= $order->order_number ?> ]</span>
        </h1>
        <div class="add-btn">
            <button class="btn btn-success" type="button" id="printOrderBtn"><i class="fa fa-print"></i> Print</button>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <br><br>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="box">
                    <div class="box-body" id="printOrder">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <th>Product Name</th>
								<th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <?php
                                    $gtotal = 0;
                                    foreach ($products as $product) {
                                        $total = $product->order_price * $product->quantity;
                                        $gtotal += $total;
                                        ?>
                                        <tr>
                                            <td><?= $product->product_name ?></td>
                                            <td><?= $product->order_price ?></td>
                                            <td><?= $product->quantity ?></td>
                                            <td><?= $total ?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <div class="order-gtotal">Grand Total: <b><?= $gtotal; ?></b></div>
                    </div>
                </div>
            </div>  
        </div>
    </section>
    <!-- /.content -->

</div>