<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:./login.php");
}
if($_SESSION['permition'] == '1') {

    $sql = "SELECT users.*,permitions.permition_name from users,permitions where users.permition_id =permitions.permition_id ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
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
        <div class="purchasecontainer">
            <div class="container-fluid invoice-container">

                <main>
                    <header>
                        <div class=" userlist">
                            <h2> کاردکس لیست کاربران </h2>
                        </div>

                    </header>
                    <div class="row">

                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive usertable">
                                    <table class="table mb-0">
                                        <thead class="card-header">
                                            <tr>
                                                <td class="col-3 text-center"><strong> وضعیت </strong></td>
                                                <td class="col-3 text-center"><strong> نقش کاربری </strong></td>
                                                <td class="col-3 text-center"><strong> نام کاربری</strong></td>
                                                <td class="col-3 text-center"><strong>ردیف</strong></td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
foreach ($users as $user) { ?>
                                            <tr>
                                                <td class="col-3 text-center"><strong>
                                                        <?php if ($user->user_active == 2) {
                                                            echo "فعال";
                                                        } else {
                                                            echo "غیرفعال";
                                                        } ?> </strong></td>
                                                <td class="col-3 text-center"><strong> <?= $user->permition_name ?>
                                                    </strong>
                                                <td class="col-3 text-center"><strong> <?= $user->user_name ?> </strong>
                                                </td>
                                                <td class="col-3 text-center"><strong><?= $i ?></strong></td>
                                            </tr>
                                            <?php ++$i;
} ?>
                                        </tbody>

                                    </table>
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