<!-- sidebar starts here -->
<?php

if (isset($_SESSION['permition']) && !(empty($_SESSION['permition'])) && isset($_SESSION['username']) && !(empty($_SESSION['username']))) {
    $sql = "SELECT * FROM menus where permition_id = ? order by ordermenu ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION['permition']]);
    $menus = $stmt->fetchAll();
} else {
    header("location:login.php");
}
?>


<div class="bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
        <i></i> منو

    </div>


    <div class="list-group list-group-flush my-3">

        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active">
            <i></i> سامانه حسابداری
        </a>
        <?php foreach ($menus as $menu) : ?>
            <a href="<?= $menu->url ?>" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                <?= $menu->menu_name ?>
            </a> <?php endforeach; ?>


        <a href="./logout.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
            <i></i> خروج
        </a>



    </div>

</div>

<!-- sidebar ends here -->