<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
require "./assets/Helper/jdf.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:login.php");
}
if (isset($_GET['id']) && !(empty($_GET['id']) && !($_GET['id'] == ""))) {
    $id = $_GET['id'];
    $sql = "SELECT buyfactor.buyfactor_id,buyfactor.buy_date,wearhouses.wearhouse_name,buyfactor.user_editfactor,personaccount.cust_name,personaccount.cust_id,personaccount.total_credit,products.product_name,buyfactor.product_qty,buyfactor.factor_fi,buyfactor.buy_off,buyfactor.buy_sum,buyfactor.factor_explanation,users.user_name FROM buyfactor,wearhouses,personaccount,products,users WHERE buyfactor.cust_id = personaccount.cust_id and buyfactor.warehouse_id = wearhouses.wearhouse_id and buyfactor.product_id=products.product_id and buyfactor.user_editfactor = users.user_id and buyfactor.buyfactor_id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $factor = $stmt->fetch();
    if ($factor == null) {
        header("location:.php");
    }
} else {
    header("location:menu.php");

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/bootstrap5.min.css">
    <script src="./assets/JS/bootstrap5.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="product">

    <div class="d-flex" id="wrapper">

        <!-- sidebar starts here -->

        <!-- sidebar ends here -->

        <?php
        require_once "./template/sidebar.php";
require_once "./template/header.php";
?>
        <div class="purchasecontainer">
            <div class="container-fluid invoice-container">
                <header>
                    <div class="row align-items-center">
                        <div class="col-sm-7">
                            <img id="logo" src="./assets/css/LOGO.jpg" alt="">
                        </div>
                        <div class="col-sm-5 text-end">
                            <h2 class="mb-1 text-end"> فاکتور خرید </h2>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="row">
                        <div class="col-sm-6 "><strong> تاریخ:</strong><?= jdate("Y/m/d", $factor->buy_date) ?> </div>
                        <div class="col-sm-6 text-end"><strong>شماره فاکتور:</strong><?= $factor->buyfactor_id ?></div>
                        <div class="col-sm-6 text-left"><strong> نام انبار:</strong><?= $factor->wearhouse_name ?></div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6 text-end order-sm-1"><strong> :نام ثبت کننده فاکتور</strong>
                                <address>
                                    <?= $factor->user_name  ?><br>
                                </address>
                            </div>

                            <div class="col-sm-6 order-sm-0"><strong>:نام تامین کننده</strong>
                                <address>
                                    <?= $factor->cust_name  ?><br>
                                </address>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="card-header">
                                        <tr>
                                            <td class="col-3 text-center"><strong> مبلغ کل(تومان)</strong></td>
                                            <td class="col-3 text-center"><strong>فی کالا</strong></td>
                                            <td class="col-3 text-center"><strong>تعداد کالا</strong></td>
                                            <td class="col-3 text-center"><strong>نام کالا </strong></td>
                                            <td class="col-3 text-center"><strong>ردیف</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="col-3 text-center">
                                                <strong><?= number_format(($factor->factor_fi * $factor->product_qty))  ?></strong>
                                            </td>
                                            <td class="col-3 text-center">
                                                <strong><?= number_format($factor->factor_fi)  ?></strong>
                                            </td>
                                            <td class="col-3 text-center"><strong><?= $factor->product_qty  ?></strong>
                                            </td>
                                            <td class="col-3 text-center"><strong><?= $factor->product_name  ?></strong>
                                            </td>
                                            <td class="col-3 text-center"><strong>1</strong></td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="card-footer">
                                        <tr>
                                            <td class="text-center">
                                                <strong><?= number_format($factor->buy_off) ?></strong>
                                            </td>
                                            <td colspan="4" class="text-left"><strong> :مبلغ تخفیف </strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong> <?= number_format($factor->buy_sum)   ?>
                                                </strong></td>
                                            <td colspan="4" class="text-left"><strong> : مبلغ کل فاکتور </strong></td>
                                        </tr>
                                        <ion-icon name="menu-outline"></ion-icon>
                                        <tr>
                                            <td class="text-center"><strong> <?php
                                                                        if (($factor->total_credit) > 0) {
                                                                            echo "(بستانکار)";
                                                                        } else {
                                                                            echo "(بدهکار)";
                                                                        }
?> <?= number_format(abs($factor->total_credit)) ?> </strong></td>
                                            <td colspan="4" class="text-left"><strong> :مانده
                                                    <?= $factor->cust_name  ?></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="text-right mt-4">
                    <p class="text-end"><strong> :توضیحات</strong></p>
                    <p class="text-end"><?= $factor->factor_explanation  ?></p>
                </footer>

                <footer class="text-center mt-4">
                    <div class="btn-group btn-group-sm ">
                        <a href="javascript:window.print()" class="btn btn-light border">
                            <ion-icon name="print-outline"></ion-icon> پرینت
                        </a>
                        <a href="javascript:window.print()" class="btn btn-light border">
                            <ion-icon name="download-outline"></ion-icon> دانلود
                        </a>
                    </div>
                </footer>
            </div>
        </div>



        <script>
        var el = document.getElementById("wrapper")
        var toggleButton = document.getElementById("menu-toggle")

        toggleButton.onclick = function() {
            el.classList.toggle("toggled")
        }
        </script>

</body>