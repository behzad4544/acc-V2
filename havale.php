<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
$errors = [];
if (!(isset($_SESSION['username']))) {
    header("location:./login.php");
}
if($_SESSION['permition'] == '1' || $_SESSION['permition'] =='2') {

    $sql = "SELECT * FROM personaccount where (account_type='1' or account_type='3')";
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $customers = $stmt->fetchAll();
    if (isset($_POST['submit'])) {
        date_default_timezone_set('Iran');
        $realTimestamp = substr($_POST['havale_date'], 0, 10);
        $bestankar = $_POST['bestankar'];
        $bedehkar = $_POST['bedehkar'];
        $havale_fi = $_POST['havale_fi'];
        $havale_explanation = $_POST['havale_explanation'];
        if (!($bestankar == $bedehkar)) {
            $tok = 1;
            $sql = "INSERT INTO transfer SET transfersend_date=?,transfersend_from=?,transfersend_to=?,transfersend_price=?,useredit_id=?,transfersend_explanation=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$realTimestamp,$bestankar,$bedehkar,$havale_fi,$_SESSION['user_id'],$havale_explanation]);
            $id = $db->lastInsertId();
            $sql = "SELECT * FROM personaccount WHERE cust_id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$bestankar]);
            $bestan= $stmt->fetch();
            $ttl_bestan_old = $bestan->total_credit;
            if($ttl_bestan_old < 0) {
                $ttl_bestan_new = $ttl_bestan_old + $havale_fi;
            } else {
                $ttl_bestan_new = $ttl_bestan_old - $havale_fi;

            }
            $sql = "INSERT INTO credits SET personaccount_id=?,credit=?,transfer_id=?,credit_after=?,edit_user=?,created_at =?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$bestankar,$havale_fi,$id,$ttl_bestan_new,$_SESSION['user_id'],$realTimestamp]);
            $id1 = $db->lastInsertId();



            $sql = "SELECT * FROM personaccount WHERE cust_id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$bedehkar]);
            $bedeh= $stmt->fetch();
            $ttl_bedeh_old = $bedeh->total_credit;
            if($ttl_bedeh_old < 0) {
                $ttl_bedeh_new = $ttl_bedeh_old + $havale_fi;
            } else {
                $ttl_bedeh_new = $ttl_bedeh_old - $havale_fi;

            }
            $sql = "INSERT INTO credits SET personaccount_id=?,credit=?,transfer_id=?,credit_after=?,edit_user=?,created_at =?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$bedehkar,-$havale_fi,$id,$ttl_bedeh_new,$_SESSION['user_id'],$realTimestamp]);
            $id2 = $db->lastInsertId();


            $sql = "SELECT * FROM personaccount WHERE cust_id=? ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$bestankar]);
            $res1 = $stmt->fetch();
            $total_bestan_old = $res1->total_credit;
            if($total_bestan_old < 0) {
                $total_bestan_new = $total_bestan_old + $havale_fi;
            } else {
                $total_bestan_new = $total_bestan_old - $havale_fi;

            }        $sql = "UPDATE personaccount SET total_credit=? WHERE cust_id=? ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$total_bestan_new,$bestankar]);


            $sql = "SELECT * FROM personaccount WHERE cust_id=? ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$bedehkar]);
            $res2 = $stmt->fetch();
            $total_bedeh_old = $res2->total_credit;
            if($total_bedeh_old < 0) {
                $total_bedeh_new = $total_bedeh_old + $havale_fi;
            } else {
                $total_bedeh_new = $total_bedeh_old - $havale_fi;

            }        $sql = "UPDATE personaccount SET total_credit=? WHERE cust_id=? ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$total_bedeh_new,$bedehkar]);


            $bedehkar_name = $res2->cust_name;
            $bestankar_name = $res1->cust_name;

        } else {
            $errors[] = "هر دو شخص نمیتواند یکی باشد";
            $tok = 0;
        }
    }
} else {
    header("location:./menu.php");

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

        <div class="flex wrapper">
            <div class="title">
                ثبت سند حسابداری
            </div>
            <div class="form form-group was-validated ">
                <form method="POST" action="">
                    <div class="input-field">
                        <div class="mb-3">
                            <label> طرف حساب بدهکار</label>
                            <div class="custom_select">
                                <select name="bestankar" required>
                                    <option value="">لطفا طرف حساب بدهکار را انتخاب فرمایید</option>
                                    <?php foreach ($customers as $customer) : ?>
                                    <option value="<?= $customer->cust_id ?>" class="inputBox">
                                        <?= $customer->cust_name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <span> نام بدهکار را وارد کنید </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-field">
                        <div class="mb-3">
                            <label> طرف حساب بستانکار </label>
                            <div class="custom_select">
                                <select name="bedehkar" required>
                                    <option value="">لطفا طرف حساب بستانکار انتخاب فرمایید</option>
                                    <?php foreach ($customers as $customer) : ?>
                                    <option value="<?= $customer->cust_id ?>" class="inputBox">
                                        <?= $customer->cust_name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <span> نام بستانکار را وارد کنید </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-field">
                        <div class="mb-3">
                            <label class="form-label"> تاریخ </label>
                            <input type="text" class="form-control d-none" id="havale_date" name="havale_date" required
                                autofocus>
                            <input type="text" class="form-control" id="havale_view" required autofocus>
                            <div class="invalid-feedback">
                                <span> تاریخ را وارد کنید </span>
                            </div>
                        </div>
                    </div>

                    <div class="input-field">
                        <div class="mb-3">
                            <label class="form-label"> مبلغ </label>
                            <input type="text" placeholder="مبلغ حواله" name="havale_fi" required>
                            <div class="invalid-feedback">
                                <span> مبلغ را وارد کنید </span>
                            </div>
                        </div>
                    </div>

                    <div class="input-field">
                        <div class="mb-3 end-text ">
                            <label for="comment" class="form-label"> توضیحات </label>
                            <textarea name="havale_explanation" rows="5" cols="45"></textarea>
                        </div>
                    </div>

                    <div class="input-field">
                        <input type="submit" value="ثبت حواله" class="btn btn-success" name=" submit" id="submit">
                    </div>
                    <?php
            if (isset($_POST['submit']) && $tok == 1) {
                echo "
        <script>
        setTimeout(function() {
            swal('حواله شماره {$id} ثبت شد','حواله شماره {$id1} برای {$bestankar_name} و حواله شماره {$id2} برای {$bedehkar_name} ثبت شد', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./havaleview.php?id={$id}');
        }, 5000);
        </script>
        ";
            }
?>
                </form>


            </div>
        </div>
    </div>

    <script src="./assets/JS/jquery-3.3.1.slim.min.js"></script>
    <script src="./assets/JS/bootstrap5.bundle.min.js"></script>
    <script src="./assets/Public/jalalidatepicker/persian-date.min.js"></script>
    <script src="./assets/Public/jalalidatepicker/persian-datepicker.min.js"></script>
    <script src='./assets/JS/sweet-alert.min.js'></script>
    <script>
    $(document).ready(function() {
        $("#havale_view").persianDatepicker({
            format: 'YYYY-MM-DD',
            toolbax: {
                calendarSwitch: {
                    enabled: true
                }
            },
            observer: true,
            altField: '#havale_date'
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
    </div>
</body>