<?php
require "./assets/Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
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

<body class="menucolor">
    <div class="d-flex" id="wrapper">
        <!-- sidebar starts here -->

        <!-- sidebar ends here -->

        <?php
        require_once "./template/sidebar.php";
        require_once "./template/header.php";
        ?>

        <div class="purchasecontainer">

            <main>
                <header>
                    <div class=" userlist">
                        <h2> به حسابداری خوش آمدید </h2>
                    </div>
                </header>

            </main>

        </div>
    </div>
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

</html>