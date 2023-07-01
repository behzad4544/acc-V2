<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
if (!(isset($_SESSION['username']))) {
  header("location:./login.php");
}
$sql = "SELECT * FROM personaccount where account_type=?";
$stmt = $db->prepare($sql);
$stmt->execute([1]);
$suppliers = $stmt->fetchAll();
$sql = "SELECT products.product_name,stocks.stock_productid,stocks.stock FROM products,stocks where products.product_id = stocks.stock_productid AND stocks.stock > 0 ";
$stmt = $db->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
if (isset($_POST['submit'])) {
  $errors = [];
  $sql = "SELECT stock FROM stocks where stock_productid=? ";
  $stmt = $db->prepare($sql);
  $stmt->execute([(int)$_POST['product_id']]);
  $oldstock = $stmt->fetch();
  $newstock = (int)$oldstock->stock - (int)$_POST['product_qty'];
  if ($newstock < 0) {
    $errors[] = "تعداد فروش از تعداد موجودی بیشتر می باشد";
    $tok = 0;
  } else {
    $tok = 1;
    date_default_timezone_set('Iran');
    $realTimestamp = substr($_POST['sell_date'], 0, 10);
    $total = ((int)$_POST['product_qty'] * (int)$_POST['factor_fi']) - (int)$_POST['sell_off'];


    $sql = "SELECT stock FROM stocks where stock_productid=? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$_POST['product_id']]);
    $oldstock = $stmt->fetch();
    $newstock = (int)$oldstock->stock - (int)$_POST['product_qty'];
    $sql = "UPDATE stocks SET stock=? where stock_productid=? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$newstock, (int)$_POST['product_id']]);



    $sql = 'INSERT INTO `sellfactors` SET sell_date=?,cust_id=?,product_id=?,product_qty=?,factor_fi=?,sell_off=?,sell_sum=?,factor_explanation=?,user_editfactor=?,credit_after_sell=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$realTimestamp, (int)$_POST['cust_id'], (int)$_POST['product_id'], (int)$_POST['product_qty'], (int)$_POST['factor_fi'], (int)$_POST['sell_off'], (int)$total, $_POST['factor_explanation'], $_SESSION['user_id'], (int)$newstock]);
    $id = $db->lastInsertId();


    $sql = "SELECT * from personaccount where cust_id =? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$_POST['cust_id']]);
    $total_credit = $stmt->fetch();
    $total_credit_old = $total_credit->total_credit;
    $total_credit_new = $total_credit_old - $total;
    $sql = "UPDATE personaccount SET total_credit = $total_credit_new where cust_id =? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$_POST['cust_id']]);

    $sql = "SELECT * From personaccount where cust_id =? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$_POST['cust_id']]);
    $rr = $stmt->fetch();
    $ttl1 = $rr->total_credit;


    $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,sellfactor_id=?,created_at=?,edit_user=?,credit_after=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$_POST['cust_id'], -(int)$total, $id, $realTimestamp, $_SESSION['user_id'], $ttl1]);
    $id1 = $db->lastInsertId();


    $sql = 'SELECT * from personaccount where cust_name=?';
    $sell1 = 'فروش';
    $stmt = $db->prepare($sql);
    $stmt->execute([$sell1]);
    $sell2 = $stmt->fetch();
    $sell = $sell2->cust_id;
    $total_sell_old = $sell2->total_credit;
    $total_sell_new = $total_sell_old + $total;
    $sql = "UPDATE personaccount SET total_credit = $total_sell_new where cust_id =? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$sell]);

    $sql = "SELECT * From personaccount where cust_id =? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$sell]);
    $rrr = $stmt->fetch();
    $ttl2 = $rrr->total_credit;


    $sql = 'INSERT INTO `credits` SET personaccount_id=?,credit=?,sellfactor_id=?,created_at=?,edit_user=?,credit_after=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([(int)$sell, (int)$total, $id, $realTimestamp, $_SESSION['user_id'], $ttl2]);
    $id2 = $db->lastInsertId();
    $sql = 'SELECT * FROM personaccount where cust_id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$_POST['cust_id']]);
    $customer = $stmt->fetch();
    $cus = $customer->cust_name;

    // $sql= "SELECT stock FROM stocks where stock_productid=? ";
    // $stmt = $db->prepare($sql);
    // $stmt->execute([(int)$_POST['product_id']]);
    // $oldstock= $stmt->fetch();
    // $newstock = (int)$oldstock->stock - (int)$_POST['product_qty'];
    // $sql = "UPDATE stocks SET stock=? where stock_productid=? " ;
    // $stmt = $db->prepare($sql);
    // $stmt->execute([(int)$newstock,(int)$_POST['product_id']]);
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
    <link rel='stylesheet' href='./assets/css/sweet-alert.css'>
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
                <h2> فاکتور فروش</h2>
                <div class="content">
                    <div class="input-box">
                        <label for="name"> نام مشتری </label>
                        <select name="cust_id" required>
                            <option value="">لطفا یکی از خریداران زیر را انتخاب فرمایید</option>
                            <?php foreach ($suppliers as $supplier) : ?>
                            <option value="<?= $supplier->cust_id ?>" class="inputBox"><?= $supplier->cust_name ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <span> نام مشتری را وارد کنید </span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="productname">نام کالا</label>
                        <select name="product_id" required>
                            <option value="">لطفا یکی از کالاهای زیر را انتخاب فرمایید</option>
                            <?php foreach ($products as $product) : ?>
                            <option value="<?= $product->stock_productid ?>" class="inputBox">
                                <?= $product->product_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <span> نام کالا را وارد کنید </span>
                        </div>
                    </div>



                    <div class="input-box">
                        <label for="howmany">تعداد کالا</label>
                        <input type="number" placeholder="تعداد کالا" name="product_qty" required>
                        <div class="invalid-feedback">
                            <span> تعداد کالا را وارد کنید</span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="price"> قیمت کالا</label>
                        <input type="text" placeholder="قیمت فی کالا به تومان" name="factor_fi" required>
                        <div class="invalid-feedback">
                            <span> قیمت کالا را وارد کنید </span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="discount"> مبلغ تخفیف</label>
                        <input type="text" placeholder="مقدار تخفیف به تومان" name="sell_off" required>
                        <div class="invalid-feedback">
                            <span> مبلغ تخفیف را وارد کنید </span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="date"> تاریخ</label>
                        <input type="text" class="form-control d-none" id="sell_date" name="sell_date" required
                            autofocus>
                        <input type="text" class="form-control" id="date_view" required autofocus>
                        <div class="invalid-feedback">
                            <span> تاریخ را وارد کنید </span>
                        </div>
                    </div>



                    <div class="input-box">
                        <div class="mb-3 end-text ">
                            <label for="comment" class="form-label"> توضیحات </label>
                            <textarea name="factor_explanation" rows="5" cols="45"></textarea>
                        </div>
                    </div>

                    <div class="input-box">
                        <input type="submit" value="ثبت فاکتور" class="btn btn-success" name="submit">
                    </div>



                </div>
                <?php
        if (isset($_POST['submit']) && $tok == 1) {
          echo "
        <script>
        setTimeout(function() {
            swal('فاکتور فروش شماره {$id} ثبت شد ', 'حواله شماره {$id1} برای طرف حساب {$cus} و همچنین حواله شماره {$id2} برای حساب فروش ثبت شد', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./sellfactorpre.php?id={$id}');
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
    $(document).ready(function() {
        $("#date_view").persianDatepicker({
            format: 'YYYY-MM-DD',
            toolbax: {
                calendarSwitch: {
                    enabled: true
                }
            },
            observer: true,
            altField: '#sell_date'

        })
    });
    </script>

    <script>
    var el = document.getElementById("wrapper")
    var toggleButton = document.getElementById("menu-toggle")

    toggleButton.onclick = function() {
        el.classList.toggle("toggled")
    }
    </script>

</body>