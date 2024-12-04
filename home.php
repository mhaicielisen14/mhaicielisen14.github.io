<?php
    session_start();
    $table = $_SESSION['table'];
    if ($table == "1" || $table == "2" || $table == "3" || $table == "4" || $table == "5" || $table == "6")
    {
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

            else
            {
                $_SESSION['original_table'] = $table;
                unset($_SESSION['order_no']);
            }
        }
        
        if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
        {

        }

        else
        {
            if ($get_table['filtered'] == "0")
            {
                header ("Location: table_used.php");
            }

            else
            {
                $update_status = "update tbl_tables set status = 'In Ordering' where table_no = '$table'";
                $query1 = @mysqli_query($connection, $update_status);
            }
                        
        }

        $_SESSION['table'] = $table;
    }

    else
    {
        header ("Location: table_used.php");
    }
?>
<?php require './headers_footers/header.php'; ?>
<div class="container-fluid p-0">
    <img class="customer-header-img img-fluid" src="/img/hv_header_image.jpg">
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 mt-5">
            <center>
                <h1>What is Hills & Valleys Coffee?</h1>
            </center>
            <div class="mt-3">
                Hills & Valleys Coffee is the new instagrammable coffee shop in Bulacan. We deliver the latest premium coffee choices including bestsellers Vietnamese and Spanish Latte.
                <br>
                <br>
                With our tagline, “You coffee through ups and downs”. Hills & Valleys Coffee aims to be Bulacan’s most loved and respected coffee brand. 
                <br>
                <br>
                Our coffee shop is designed intricately for a comfortable environment that is sure to take the stress off your mind.
            </div>
            <div class="mt-5 form-group">
                <a href="menu.php" class=" btn form-control mt-3" style="color: white; background-color: black;">ORDER NOW</a>
            </div>
        </div>
        <div class="col-lg-6 p-3">
            <img src="./img/what_is_hv.webp" class="img-fluid">
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 p-3">
            <img src="./img/mission_vision.webp" class="img-fluid">
        </div>

        <div class="col-lg-6 mt-5">
            <center>
                <h3>Vision</h3>
            </center>
            <div class="mt-3">
                <center>
                    To be the most loved and respected coffee brand in Bulacan, delivering premium quality yet affordable coffee, friendly customer care, and a vibrant in-store experience.
                </center>
            </div>

            <div class="mt-5">
                <center>
                    <h3>Mission</h3>
                </center>
                <div class="mt-3">
                    <center>
                        To inspire every customer to live a better life and provide Filipinos with job opportunities. <?php echo $_SESSION['table']; ?>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './headers_footers/footer.php'; ?>
