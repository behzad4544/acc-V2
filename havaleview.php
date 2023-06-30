<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
require "./assets/Helper/jdf.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:login.php");
} else {
    if (isset($_GET['id']) && !(empty($_GET['id'])) && !($_GET['id'] == "")) {
        $id = $_GET['id'];
        $sql = "SELECT * from transfer WHERE transfersend_id =?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $transfer = $stmt->fetch();
        if ($transfer == null) {
            header("location:index.php");
        } else {
            $sql = "SELECT transfer.transfersend_date, personaccount.cust_name, transfer.transfersend_price,personaccount.total_credit from transfer,personaccount WHERE transfer.transfersend_from = personaccount.cust_id and transfer.transfersend_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $bestankar = $stmt->fetch();

            $sql = "SELECT transfer.transfersend_date, personaccount.cust_name, transfer.transfersend_price,personaccount.total_credit from transfer,personaccount WHERE transfer.transfersend_to = personaccount.cust_id and transfer.transfersend_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $bedehkar = $stmt->fetch();
        }
    } else {
        header("location:index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/swiper-bundle.min.css" />
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

                <main>
                    <header>
                        <div class=" userlist">
                            <h2> نمایش حواله شماره <?= $id ?> </h2>
                        </div>

                    </header>
                    <div class="row">
                        <div class="text-end" style="margin-bottom: 15px ;"> <strong> تاریخ: </strong>
                            <?= jdate("Y/m/d", $bestankar->transfersend_date) ?> </div>


                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive usertable">
                                    <table class="table mb-0">
                                        <thead class="card-header">
                                            <tr>
                                                <td class="col-3 text-center"><strong> بستانکار</strong></td>
                                                <td class="col-3 text-center"><strong> بدهکار</strong></td>
                                                <td class="col-3 text-center"><strong> طرف حساب </strong></td>
                                                <td class="col-3 text-center"><strong>ردیف</strong></td>

                                            </tr>
                                        </thead>


                                        <tbody>
                                            <tr>
                                                <td class="col-3 text-center"><strong>
                                                        <?= number_format($bestankar->transfersend_price) ?> </strong>
                                                </td>
                                                <td class="col-3 text-center"><strong> 0</strong></td>
                                                <td class="col-3 text-center"><strong> <?= $bestankar->cust_name ?>
                                                    </strong></td>
                                                <td class="col-3 text-center"><strong> 1 </strong></td>
                                            </tr>
                                        </tbody>

                                        <tbody>
                                            <tr>
                                                <td class="col-3 text-center"><strong> 0</strong></td>
                                                <td class="col-3 text-center"><strong>
                                                        <?= number_format($bedehkar->transfersend_price) ?> </strong>
                                                </td>
                                                <td class="col-3 text-center"><strong> <?= $bedehkar->cust_name ?>
                                                    </strong></td>
                                                <td class="col-3 text-center"><strong> 2 </strong></td>
                                            </tr>
                                        </tbody>



                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </main>

                <footer class="text-right mt-4">
                    <p class="text-end"><strong> :توضیحات</strong></p>
                    <p class="text-end"><?= $transfer->transfersend_explanation ?></p>
                </footer>
                <hr>

                <footer class="text-right mt-4">
                    <p class="text-end">مانده <?= $bestankar->cust_name ?> تا این تاریخ :
                        <?= number_format(abs($bestankar->total_credit)) ?>
                        <?php if(($bestankar->total_credit)> 0) {
            echo "بستانکار";
        } else {
            echo "بدهکار";
        } ?></p>

                </footer>

                <footer class="text-right mt-4">
                    <p class="text-end"> مانده <?= $bedehkar->cust_name ?> تا این تاریخ :
                        <?= number_format(abs($bedehkar->total_credit)) ?> <?php if(($bestankar->total_credit)< 0) {
        echo "بستانکار";
    } else {
        echo "بدهکار";
    } ?></p>

                </footer>

                <footer class="text-center mt-4 ">
                    <div class="btn-group btn-group-sm footer ">
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