<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
require "./assets/Helper/jdf.php";
global $i;
if (!(isset($_SESSION['username']))) {
     header("location:login.php");
}
if (isset($_GET['id']) && !(empty($_GET['id'])) && !($_GET['id'] == "")) {
     $id = $_GET['id'];
     $sql = "SELECT * from products WHERE product_id =?";
     $stmt = $db->prepare($sql);
     $stmt->execute([$id]);
     $product = $stmt->fetch();
     if ($product == null) {
          header("location:productlist.php");
     } else {
          // $sql = "SELECT buyfactor.buy_date,buyfactor.product_qty as buy_qty,buyfactor.factor_fi as buy_fi,products.product_name,sellfactors.sell_date,sellfactors.product_qty as sell_qty,sellfactors.factor_fi as sell_fi, FROM buyfactor,products,sellfactors where buyfactor.product_id=sellfactors.product_id and buyfactor.product_id=? and sellfactors.product_id=? order by ";
          $sql = "SELECT buyfactor.buyfactor_id,buyfactor.credit_prod_after,buyfactor.buy_date,buyfactor.product_qty,buyfactor.factor_fi,products.product_name from buyfactor,products where buyfactor.product_id=? and buyfactor.product_id=products.product_id order by buyfactor.buy_date ";
          $stmt = $db->prepare($sql);
          $stmt->execute([$id]);
          $buys = $stmt->fetchAll();
          $sql = "SELECT sellfactors.sellfactor_id,sellfactors.credit_after_sell,sellfactors.sell_date,sellfactors.product_qty,sellfactors.factor_fi,products.product_name from sellfactors,products where sellfactors.product_id=? and sellfactors.product_id=products.product_id order by sellfactors.sell_date ";
          $stmt = $db->prepare($sql);
          $stmt->execute([$id]);
          $sells = $stmt->fetchAll();
     }
} else {
     header("location:productlist.php");
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

                <main>
                    <header>
                        <div class=" userlist">
                            <h2> مشخصات کالای <?= $product->product_name ?> </h2>
                        </div>

                    </header>
                    <div class="row">

                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive usertable">
                                    <table class="table mb-0" id="detailTable">
                                        <thead class="card-header">
                                            <tr>
                                                <th onclick="sortTable(0)" class="col-3 text-center"><strong>مانده
                                                    </strong></th>
                                                <th onclick="sortTable(1)" class="col-3 text-center"><strong> تعداد فروش
                                                        کالا </strong></th>
                                                <th onclick="sortTable(2)" class="col-3 text-center"><strong> تعداد خرید
                                                        کالا </strong></th>
                                                <th onclick="sortTable(3)" class="col-3 text-center"><strong> شماره
                                                        فاکتور </strong></th>
                                                <th onclick="sortTable(4)" class="col-3 text-center"><strong> تاریخ
                                                    </strong></th>
                                                <th onclick="sortTable(5)" class="col-3 text-center">
                                                    <strong>ردیف</strong>
                                                </th>

                                            </tr>
                                        </thead>


                                        <tbody>

                                            <?php $i = 1;
                                                       foreach ($buys as $buy) { ?>
                                            <tr>
                                                <td class="col-3 text-center"><?= $buy->credit_prod_after ?></td>
                                                <td class="col-3 text-center">
                                                    0 </td>
                                                <td class="col-3 text-center"><?= $buy->product_qty ?>
                                                </td>
                                                <td class="col-3 text-center"><a
                                                        href="./buyfactorpre.php?id=<?= $buy->buyfactor_id ?>">فاکتور
                                                        خرید شماره
                                                        <?= $buy->buyfactor_id ?></a></td>
                                                <td class="col-3 text-center">
                                                    <?= jdate("Y/m/d h:i:s", $buy->buy_date) ?> </td>
                                                <td class="col-3 text-center"><?= $i ?></td>
                                            </tr>
                                            <?php ++$i;
                                                       } ?>

                                            <?php
                                                       foreach ($sells as $sell) { ?>

                                            <tr>
                                                <td class="col-3 text-center"><?= $sell->credit_after_sell ?></td>
                                                <td class="col-3 text-center">
                                                    <?= $sell->product_qty ?>
                                                </td>
                                                <td class="col-3 text-center">0</td>
                                                <td class="col-3 text-center"><a
                                                        href="./sellfactorpre.php?id=<?= $sell->sellfactor_id ?>">فاکتور
                                                        فروش
                                                        شماره <?= $sell->sellfactor_id ?></a></td>
                                                <td class="col-3 text-center">
                                                    <?= jdate("Y/m/d h:i:s", $sell->sell_date) ?></td>
                                                <td class="col-3 text-center"><?= $i ?></td>
                                            </tr>
                                            <?php ++$i;
                                                       } ?>
                                        </tbody>

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