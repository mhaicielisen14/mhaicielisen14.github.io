<?php
    session_start();
    $table = $_SESSION['table'];

    $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

    $get_status = "select* from tbl_tables where table_no = '$table'";
    $query = @mysqli_query($connection, $get_status);
    $fetch_status = @mysqli_fetch_array($query);
?>

<?php

if ($fetch_status['status'] == "Vacant" || $fetch_status['status'] == "In Ordering")
{
    echo "<script>
        location.href = 'menu.php';
    </script>";
}

else
{
    if ($fetch_status['status'] == "For Payment")
    {
?>
        <h1><?php echo $fetch_status['status']; ?> <br> Please go to cashier <br> </h1>
<?php
    }

    elseif ($fetch_status['status'] == "Order Processing")
    {
?>
        <h1>Please wait your <br> <?php echo $fetch_status['status']; ?></h1>
<?php
    }

    elseif ($fetch_status['status'] == "Order Served")
    {
?>
        <h1>Claim your Order<br>Thank you<br>Please rate us<br><a href="feedback_form.php">click for feedback<a></h1>
<?php
    }
}
?>

