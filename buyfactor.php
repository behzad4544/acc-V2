<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
// if (!(isset($_SESSION['username']))) {
//     header("location:./login.php");
// }
$sql = "SELECT * FROM personaccount where account_type=?";
$stmt = $db->prepare($sql);
$stmt->execute([1]);
$customers = $stmt->fetchAll();
$sql = "SELECT * FROM products";
$stmt = $db->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
$sql = "SELECT * FROM wearhouses";
$stmt = $db->prepare($sql);
$stmt->execute();
$wearhouses = $stmt->fetchAll();
if (isset($_POST['submit'])) {
    date_default_timezone_set('Iran');
    $realTimestamp = substr($_POST['buy_date'], 0, 10);
    $total = ((int)$_POST['product_qty'] * (int)$_POST['factor_fi']) - (int)$_POST['buy_off'];



    // $sql = 'INSERT INTO `buyfactor` SET buy_date=?,cust_id=?,product_id=?,warehouse_id=?,product_qty=?,factor_fi=?,buy_off=?,buy_sum=?,factor_explanation=?,user_editfactor=?';
    // $stmt = $db->prepare($sql);
    // $stmt->execute([$realTimestamp, (int)$_POST['cust_id'], (int)$_POST['product_id'], (int)$_POST['warehouse_id'], (int)$_POST['product_qty'], (int)$_POST['factor_fi'], (int)$_POST['buy_off'], (int)$total, $_POST['factor_explanation'], $_SESSION['user_id']]);
    // $id = $db->lastInsertId();
    // $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,buyfactor_id=?,created_at=?,edit_user=?';
    // $stmt = $db->prepare($sql);
    // $stmt->execute([(int)$_POST['cust_id'], (int)$total, $id, $realTimestamp, $_SESSION['user_id']]);
    // $id1 = $db->lastInsertId();
    // $sql = 'SELECT * from personaccount where cust_name=?';
    // $buy1 = 'خرید';
    // $stmt = $db->prepare($sql);
    // $stmt->execute([$buy1]);
    // $buy2 = $stmt->fetch();
    // $buy = $buy2->cust_id;
    // $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,buyfactor_id=?,created_at=?,edit_user=?';
    // $stmt = $db->prepare($sql);
    // $stmt->execute([(int)$buy, -(int)$total, $id, $realTimestamp, $_SESSION['user_id']]);
    // $id2 = $db->lastInsertId();
    // $sql = 'SELECT * FROM personaccount where cust_id=?';
    // $stmt = $db->prepare($sql);
    // $stmt->execute([$_POST['cust_id']]);
    // $supplier = $stmt->fetch();
    // $supp = $supplier->cust_name;


    $sql = "SELECT * from stocks where stock_productid=? and stock_wearhouseid=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$_POST['product_id'], (int)$_POST['warehouse_id']]);
    $res = $stmt->fetchAll();
    if ($res == null) {
        $sql = 'INSERT INTO stocks SET stock_productid=?,stock_wearhouseid=?,stock=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['product_id'], (int)$_POST['warehouse_id'], (int)$_POST['product_qty']]);
        $credit_prod_after = (int)$_POST['product_qty'];
        $sql = 'INSERT INTO `buyfactor` SET buy_date=?,cust_id=?,product_id=?,warehouse_id=?,product_qty=?,factor_fi=?,buy_off=?,buy_sum=?,factor_explanation=?,user_editfactor=?,credit_prod_after=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$realTimestamp, (int)$_POST['cust_id'], (int)$_POST['product_id'], (int)$_POST['warehouse_id'], (int)$_POST['product_qty'], (int)$_POST['factor_fi'], (int)$_POST['buy_off'], (int)$total, $_POST['factor_explanation'], $_SESSION['user_id'], $credit_prod_after]);
        $id = $db->lastInsertId();



        $sql = "SELECT * from personaccount where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['cust_id']]);
        $total_credit = $stmt->fetch();
        $total_credit_old = $total_credit->total_credit;
        $total_credit_new = $total_credit_old + $total;
        $sql = "UPDATE personaccount SET total_credit = $total_credit_new where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['cust_id']]);


        $sql = "SELECT * From personaccount where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['cust_id']]);
        $rr = $stmt->fetch();
        $ttl1 = $rr->total_credit;


        $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,buyfactor_id=?,created_at=?,edit_user=?,credit_after=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['cust_id'], (int)$total, $id, $realTimestamp, $_SESSION['user_id'], $ttl1]);
        $id1 = $db->lastInsertId();



        $sql = 'SELECT * from personaccount where cust_name=?';
        $buy1 = 'خرید';
        $stmt = $db->prepare($sql);
        $stmt->execute([$buy1]);
        $buy2 = $stmt->fetch();
        $buy = $buy2->cust_id;
        $total_buy_old = $buy2->total_credit;
        $total_buy_new = $total_buy_old - $total;
        $sql = "UPDATE personaccount SET total_credit = $total_buy_new where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$buy]);




        $sql = "SELECT * From personaccount where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$buy]);
        $rrr = $stmt->fetch();
        $ttl2 = $rrr->total_credit;

        $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,buyfactor_id=?,created_at=?,edit_user=?,credit_after=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$buy, -(int)$total, $id, $realTimestamp, $_SESSION['user_id'], $ttl2]);
        $id2 = $db->lastInsertId();



        $sql = 'SELECT * FROM personaccount where cust_id=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['cust_id']]);
        $supplier = $stmt->fetch();
        $supp = $supplier->cust_name;
        $token = 1;
    } else {

        $sql = "SELECT * from personaccount where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['cust_id']]);
        $total_credit = $stmt->fetch();
        $total_credit_old = $total_credit->total_credit;
        $total_credit_new = $total_credit_old + $total;
        $sql = "UPDATE personaccount SET total_credit = $total_credit_new where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['cust_id']]);



        $sql = 'SELECT * from personaccount where cust_name=?';
        $buy1 = 'خرید';
        $stmt = $db->prepare($sql);
        $stmt->execute([$buy1]);
        $buy2 = $stmt->fetch();
        $buy = $buy2->cust_id;
        $total_buy_old = $buy2->total_credit;
        $total_buy_new = $total_buy_old - $total;
        $sql = "UPDATE personaccount SET total_credit = $total_buy_new where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$buy]);



        $sql = "SELECT stock FROM stocks where stock_productid=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['product_id']]);
        $oldstock = $stmt->fetch();
        $newstock = (int)$oldstock->stock + (int)$_POST['product_qty'];
        $sql = "UPDATE stocks SET stock=? where stock_productid=? and stock_wearhouseid=?  ";
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$newstock, (int)$_POST['product_id'], (int)$_POST['warehouse_id']]);
        $credit_prod_after = (int)$newstock;
        $sql = 'INSERT INTO `buyfactor` SET buy_date=?,cust_id=?,product_id=?,warehouse_id=?,product_qty=?,factor_fi=?,buy_off=?,buy_sum=?,factor_explanation=?,user_editfactor=?,credit_prod_after=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$realTimestamp, (int)$_POST['cust_id'], (int)$_POST['product_id'], (int)$_POST['warehouse_id'], (int)$_POST['product_qty'], (int)$_POST['factor_fi'], (int)$_POST['buy_off'], (int)$total, $_POST['factor_explanation'], $_SESSION['user_id'], $credit_prod_after]);
        $id = $db->lastInsertId();

        $sql = "SELECT * From personaccount where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['cust_id']]);
        $rr = $stmt->fetch();
        $ttl1 = $rr->total_credit;

        $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,buyfactor_id=?,created_at=?,edit_user=?,credit_after=?';

        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$_POST['cust_id'], (int)$total, $id, $realTimestamp, $_SESSION['user_id'], $ttl1]);
        $id1 = $db->lastInsertId();
        $sql = 'SELECT * from personaccount where cust_name=?';
        $buy1 = 'خرید';
        $stmt = $db->prepare($sql);
        $stmt->execute([$buy1]);
        $buy2 = $stmt->fetch();
        $buy = $buy2->cust_id;

        $sql = "SELECT * From personaccount where cust_id =? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$buy]);
        $rrr = $stmt->fetch();
        $ttl2 = $rrr->total_credit;

        $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,buyfactor_id=?,created_at=?,edit_user=?,credit_after=?';

        $stmt = $db->prepare($sql);
        $stmt->execute([(int)$buy, -(int)$total, $id, $realTimestamp, $_SESSION['user_id'], $ttl2]);
        $id2 = $db->lastInsertId();
        $sql = 'SELECT * FROM personaccount where cust_id=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['cust_id']]);
        $supplier = $stmt->fetch();
        $supp = $supplier->cust_name;
        $token = 1;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/bootstrap5.min.css">
    <link rel="stylesheet" href="./assets/css/sweet-alert.css">
    <link href="./assets/Public/jalalidatepicker/persian-datepicker.min.css" rel="stylesheet" type="text/css">
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

        <div class="container">
            <form action="" method="POST" class="buyform form-group was-validated ">
                <h2> فاکتور خرید </h2>
                <div class="content">
                    <div class="input-box">
                        <label for="name">نام تامین کننده </label>
                        <select name="cust_id" required>
                            <option value="">لطفا یکی از تامین کنندگان زیر را انتخاب فرمایید</option>
                            <?php foreach ($customers as $customer) : ?>
                            <option value="<?= $customer->cust_id ?>" class="inputBox"><?= $customer->cust_name ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <span> نام تامین کننده را وارد کنید </span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="product_id">نام کالا</label>
                        <select name="product_id" required>
                            <option value="">لطفا یکی از کالاهای زیر را انتخاب فرمایید</option>
                            <?php foreach ($products as $product) : ?>
                            <option value="<?= $product->product_id ?>" class="inputBox"><?= $product->product_name ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <span> نام کالا را وارد کنید </span>
                        </div>
                    </div>

                    <div class="input-box">
                        <div class="mb-3">
                            <label for="warehouse_id"> نام انبار</label>
                            <div class="custom_select">
                                <select name="warehouse_id" required>
                                    <option value="">لطفا یکی از انبارهای زیر را انتخاب فرمایید</option>
                                    <?php foreach ($wearhouses as $wearhouse) : ?>
                                    <option value="<?= $wearhouse->wearhouse_id ?>" class="inputBox">
                                        <?= $wearhouse->wearhouse_name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <span> نام انبار را وارد کنید </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-box">
                        <label for="product_qty">تعداد کالا</label>
                        <input type="number" name="product_qty" required>
                        <div class="invalid-feedback">
                            <span> تعداد کالا را وارد کنید</span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="factor_fi"> قیمت کالا</label>
                        <input type="number" name="factor_fi" required>
                        <div class="invalid-feedback">
                            <span> قیمت کالا را وارد کنید </span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="buy_off"> مبلغ تخفیف</label>
                        <input type="number" name="buy_off" required>
                        <div class="invalid-feedback">
                            <span> مبلغ تخفیف را وارد کنید </span>
                        </div>
                    </div>

                    <div class="input-box">
                        <div class="mb-3 end-text ">
                            <label for="factor_explanation" class="form-label"> توضیحات </label>
                            <textarea name="factor_explanation" rows="3" cols="32"></textarea>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="buy_date"> تاریخ</label>
                        <input type="text" class="form-control d-none" id="buy_date" name="buy_date" required autofocus>
                        <input type="text" class="form-control" id="date_view" required autofocus>
                        <div class="invalid-feedback">
                            <span> تاریخ را وارد کنید </span>
                        </div>
                    </div>


                    <div class="input-box">
                        <input class="btn btn-success" type="submit" value="ثبت فاکتور" name="submit" id="submit">
                    </div>



                </div>


                <?php
                if (isset($_POST['submit']) &&  $token = 1) {
                    echo "
        <script>
        setTimeout(function() {
            swal('فاکتور خرید شماره {$id} ثبت شد ', 'حواله شماره {$id1} برای طرف حساب {$supp} و همچنین حواله شماره {$id2} برای حساب خرید ثبت شد', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./buyfactorpre.php?id={$id}');
        }, 5000);
        </script>
        ";
                }
                ?>
            </form>
        </div>
    </div>


    <script src="./assets/JS/jquery-3.3.1.slim.min.js"></script>
    <script src="./assets/JS/bootstrap5.bundle.min.js"></script>
    <script src="./assets/Public/jalalidatepicker/persian-date.min.js"></script>
    <script src="./assets/Public/jalalidatepicker/persian-datepicker.min.js"></script>
    <script src='./assets/JS/sweet-alert.min.js'></script>



    <script>
    var el = document.getElementById("wrapper")
    var toggleButton = document.getElementById("menu-toggle")

    toggleButton.onclick = function() {
        el.classList.toggle("toggled")
    }
    </script>
    <script>
    $(document).ready(function() {
        $("#date_view").persianDatepicker({
            format: 'YYYY-MM-DD',
            toolbax: {
                calendarSwitch: {
                    enabled: true
                }
            },
            observer: true,
            altField: '#buy_date'
        })
    });
    </script>

</body>