<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
require "./assets/Helper/jdf.php";
global $i;
if (!(isset($_SESSION['username']))) {
    header("location:login.php");
}
if($_SESSION['permition'] == '1' || $_SESSION['permition'] =='2') {
    if (isset($_GET['id']) && !(empty($_GET['id'])) && !($_GET['id'] == "")) {
        $id = $_GET['id'];
        $sql = "SELECT * from personaccount WHERE cust_id =?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $person = $stmt->fetch();
        if ($person == null) {
            header("location:personlist.php");
        } else {
            // $sql = "SELECT buyfactor.buy_date,buyfactor.product_qty as buy_qty,buyfactor.factor_fi as buy_fi,products.product_name,sellfactors.sell_date,sellfactors.product_qty as sell_qty,sellfactors.factor_fi as sell_fi, FROM buyfactor,products,sellfactors where buyfactor.product_id=sellfactors.product_id and buyfactor.product_id=? and sellfactors.product_id=? order by ";
            $sql = "SELECT buyfactor.buyfactor_id,buyfactor.cust_id,buyfactor.buy_date,buyfactor.buy_sum,credits.credit_after from buyfactor,credits where buyfactor.cust_id=? and buyfactor.cust_id=credits.personaccount_id and credits.buyfactor_id = buyfactor.buyfactor_id   order by buyfactor.buy_date ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $buys = $stmt->fetchAll();


            $sql = "SELECT sellfactors.sellfactor_id,sellfactors.sell_date,sellfactors.sell_sum,credits.credit_after from sellfactors,credits where sellfactors.cust_id=? and sellfactors.cust_id=credits.personaccount_id and credits.sellfactor_id = sellfactors.sellfactor_id order by sellfactors.sell_date ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $sells = $stmt->fetchAll();


            $sql = "SELECT transfer.*,credits.credit_after from transfer,credits where transfersend_from = ? and transfer.transfersend_id =credits.transfer_id and transfer.transfersend_from =credits.personaccount_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $transfers_from = $stmt->fetchAll();



            $sql = "SELECT transfer.*,credits.credit_after from transfer,credits where transfersend_to = ?and transfer.transfersend_id =credits.transfer_id and transfer.transfersend_to =credits.personaccount_id ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            $transfers_to = $stmt->fetchAll();


        }
    } else {
        header("location:personlist.php");

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
        <div class="purchasecontainerpeople">
            <div class="container-fluid invoice-container">

                <main>
                    <header>
                        <div class=" userlist">
                            <h2> جزییات کاردکس <?= $person->cust_name ?>
                            </h2>
                        </div>

                    </header>
                    <div class="row">
                        <div class="text-end" style="margin-bottom: 15px ;"> <strong> مانده کل <?= $person->cust_name ?>
                                : <?= number_format(abs($person->total_credit)) ?>
                                <?php if(($person->total_credit) > 0) {
                                    echo "بستانکار";
                                } elseif (($person->total_credit) == 0) {
                                    echo "-";
                                } else {
                                    echo "بدهکار";
                                } ?> </strong>
                        </div>

                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive usertable">
                                    <table class="table mb-0" id="detailTable">
                                        <thead class="card-header">
                                            <tr>
                                                <th onclick="sortTable(0)" class="col-3 text-center"><strong> وضعیت کلی
                                                    </strong></th>
                                                <th onclick="sortTable(1)" class="col-3 text-center"><strong>مانده
                                                    </strong></th>
                                                <th onclick="sortTable(2)" class="col-3 text-center"><strong> مبلغ
                                                        بستانکاری </strong></th>
                                                <th onclick="sortTable(3)" class="col-3 text-center"><strong> مبلغ
                                                        بدهکاری</strong></th>
                                                <th onclick="sortTable(4)" class="col-3 text-center"><strong> شماره سند
                                                    </strong></th>
                                                <th onclick="sortTable(5)" class="col-3 text-center"><strong> تاریخ
                                                    </strong></th>
                                                <th onclick="sortTable(6)" class="col-3 text-center">
                                                    <strong>ردیف</strong>
                                                </th>

                                            </tr>
                                        </thead>

                                        <?php $i = 1;
foreach ($buys as $buy) {?>
                                        <tr>
                                            <td class="col-3 text-center"><strong> <?php if(($buy->credit_after) > 0) {
                                                echo "بستانکار";
                                            } elseif (($buy->credit_after) == 0) {
                                                echo "-";
                                            } else {
                                                echo "بدهکار";
                                            } ?> </strong></td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= number_format(abs($buy->credit_after)) ?> </strong></td>
                                            <td class="col-3 text-center"><strong> 0 </strong></td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= number_format(abs($buy->buy_sum)) ?> </strong></td>
                                            <td class="col-3 text-center"><strong> <a
                                                        href="./buyfactorpre.php?id=<?= $buy->buyfactor_id ?>">فاکتور
                                                        خرید شماره
                                                        <?= $buy->buyfactor_id ?></a> </strong></td>
                                            <td class="col-3 text-center">
                                                <strong><?= jdate("Y/m/d ", $buy->buy_date) ?></strong>
                                            </td>
                                            <td class="col-3 text-center"><strong> <?= $i ?> </strong></td>
                                        </tr>

                                        <?php  ++$i;
} ?>
                                        <?php ;
foreach ($sells as $sell) {?>

                                        <tr>
                                            <td class="col-3 text-center"><strong> <?php if(($sell->credit_after) > 0) {
                                                echo "بستانکار";
                                            } elseif (($sell->credit_after) == 0) {
                                                echo "-";
                                            } else {
                                                echo "بدهکار";
                                            } ?> </strong></td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= number_format(abs($sell->credit_after)) ?> </strong></td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= number_format(abs($sell->sell_sum)) ?> </strong></td>
                                            <td class="col-3 text-center"><strong> 0 </strong></td>
                                            <td class="col-3 text-center"><strong> <a
                                                        href="./sellfactorpre.php?id=<?= $sell->sellfactor_id ?>">فاکتور
                                                        فروش
                                                        شماره <?= $sell->sellfactor_id ?></a> </strong></td>
                                            <td class="col-3 text-center">
                                                <strong><?= jdate("Y/m/d ", $sell->sell_date) ?></strong>
                                            </td>
                                            <td class="col-3 text-center"><strong> <?= $i ?> </strong></td>
                                        </tr>
                                        <?php ++$i;
} ?>
                                        <?php ;
foreach ($transfers_from as $transfer_from) {?>
                                        <tr>
                                            <td class="col-3 text-center"><strong> <?php if(($transfer_from->credit_after) > 0) {
                                                echo "بستانکار";
                                            } elseif (($transfer_from->credit_after) == 0) {
                                                echo "-";
                                            } else {
                                                echo "بدهکار";
                                            } ?> </strong></td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= number_format(abs($transfer_from->credit_after)) ?>
                                                </strong></td>
                                            <td class="col-3 text-center"><strong> 0 </strong></td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= number_format(abs($transfer_from->transfersend_price)) ?>
                                                </strong></td>
                                            <td class="col-3 text-center"><strong> <a
                                                        href="./havaleview.php?id=<?= $transfer_from->transfersend_id ?>">
                                                        حواله
                                                        شماره <?= $transfer_from->transfersend_id ?></a> </strong>
                                            </td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= jdate("Y/m/d ", $transfer_from->transfersend_date) ?></strong>
                                            </td>
                                            <td class="col-3 text-center"><strong> <?= $i ?> </strong></td>
                                        </tr>
                                        <?php ++$i;
} ?>
                                        <?php ;
foreach ($transfers_to as $transfer_to) {?>
                                        <tr>
                                            <td class="col-3 text-center"><strong> <?php if(($transfer_to->credit_after) > 0) {
                                                echo "بستانکار";
                                            } elseif (($transfer_to->credit_after) == 0) {
                                                echo "-";
                                            } else {
                                                echo "بدهکار";
                                            } ?> </strong></td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= number_format(abs($transfer_to->credit_after)) ?> </strong>
                                            </td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= number_format(abs($transfer_to->transfersend_price)) ?>
                                                </strong></td>
                                            <td class="col-3 text-center"><strong> 0 </strong></td>
                                            <td class="col-3 text-center"><strong> <a
                                                        href="./havaleview.php?id=<?= $transfer_to->transfersend_id ?>">
                                                        حواله
                                                        شماره <?= $transfer_to->transfersend_id ?></a> </strong>
                                            </td>
                                            <td class="col-3 text-center"><strong>
                                                    <?= jdate("Y/m/d ", $transfer_to->transfersend_date) ?></strong>
                                            </td>
                                            <td class="col-3 text-center"><strong> <?= $i ?> </strong></td>
                                        </tr>
                                        <?php ++$i;
} ?>
                                    </table>
                                    <script>
                                    function sortTable(n) {
                                        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                                        table = document.getElementById("detailTable");
                                        switching = true;
                                        //Set the sorting direction to ascending:
                                        dir = "asc";
                                        /*Make a loop that will continue until
                                        no switching has been done:*/
                                        while (switching) {
                                            //start by saying: no switching is done:
                                            switching = false;
                                            rows = table.rows;
                                            /*Loop through all table rows (except the
                                            first, which contains table headers):*/
                                            for (i = 1; i < (rows.length - 1); i++) {
                                                //start by saying there should be no switching:
                                                shouldSwitch = false;
                                                /*Get the two elements you want to compare,
                                                one from current row and one from the next:*/
                                                x = rows[i].getElementsByTagName("TD")[n];
                                                y = rows[i + 1].getElementsByTagName("TD")[n];
                                                /*check if the two rows should switch place,
                                                based on the direction, asc or desc:*/
                                                if (dir == "asc") {
                                                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                                        //if so, mark as a switch and break the loop:
                                                        shouldSwitch = true;
                                                        break;
                                                    }
                                                } else if (dir == "desc") {
                                                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                                        //if so, mark as a switch and break the loop:
                                                        shouldSwitch = true;
                                                        break;
                                                    }
                                                }
                                            }
                                            if (shouldSwitch) {
                                                /*If a switch has been marked, make the switch
                                                and mark that a switch has been done:*/
                                                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                                                switching = true;
                                                //Each time a switch is done, increase this count by 1:
                                                switchcount++;
                                            } else {
                                                /*If no switching has been done AND the direction is "asc",
                                                set the direction to "desc" and run the while loop again.*/
                                                if (switchcount == 0 && dir == "asc") {
                                                    dir = "desc";
                                                    switching = true;
                                                }
                                            }
                                        }
                                    }
                                    </script>
                                </div>

                            </div>
                        </div>
                    </div>
                </main>



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