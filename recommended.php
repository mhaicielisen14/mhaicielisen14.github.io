<?php
    session_start();

    $table = $_SESSION['table'];
    if ($table == "1" || $table == "2" || $table == "3" || $table == "4" || $table == "5" || $table == "6")
    {
        $_SESSION['table'] = $table;

        $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");
        
        $check_table = "select* from tbl_tables where table_no = '$table'";
        $query = @mysqli_query($connection, $check_table);
        $get_table = @mysqli_fetch_array($query);

        if ($table != $_SESSION['original_table'])
        {
            if ($get_table['status'] != "Vacant")
            { 
                echo "<script>
                    alert('Table no. is already used or ordering');
                    location.href = 'table_used.php';
                </script>";
            }
        }

        if ($get_table['status'] == "Vacant")
        {
            header ("Location: table_used.php");
        }
    }

    else
    {
        header ("Location: table_used.php");
    }
?>

<?php require './headers_footers/header.php'; ?>

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-6 p-0">
            <a href="menu.php"><img src="/img/hv_header_image.jpg" class="img-fluid" style="height: 270px; width: 100%;"></a>
        </div>
        <div class="col-lg-6 p-0">
            <a href="category_frosted_hills.php"><img src="/img/summer_splash.jpg" class="img-fluid" style="height: 270px; width: 100%;"></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 p-0">
            <a href="category_frosted_hills.php"><img src="/img/img_1.jpg" class="img-fluid" style="height: 220px; width: 100%;"></a>
        </div>
        <div class="col-lg-2 p-0">
            <a href="category_frosted_hills.php"><img src="/img/img_2.jpg" class="img-fluid" style="height: 220px; width: 100%;"></a>
        </div>
        <div class="col-lg-2 p-0">
            <a href="category_pasta.php"><img src="/img/img_3.jpg" class="img-fluid" style="height: 220px; width: 100%;"></a>
        </div>
        <div class="col-lg-2 p-0">
            <a href="category_frosted_hills.php"><img src="/img/img_4.jpg" class="img-fluid" style="height: 220px; width: 100%;"></a>
        </div>
        <div class="col-lg-2 p-0">
            <a href="category_pasta.php"><img src="/img/img_5.jpg" class="img-fluid" style="height: 220px; width: 100%;"></a>
        </div>
        <div class="col-lg-2 p-0">
            <a href="category_frosted_hills.php"><img src="/img/img_6.jpg" class="img-fluid" style="height: 220px; width: 100%;"></a>
        </div>
    </div>
</div>

<?php require './headers_footers/admin_footer.php'; ?>

