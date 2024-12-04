<?php
    session_start();
    $_SESSION['table'] = "5";    

    unset($_SESSION['order_no']);

    $connection2 = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

    $update_filter = "update tbl_tables set filtered = '1' where table_no = '5'";
    $query = @mysqli_query($connection2, $update_filter);
    
    header ("Location: home.php");
?>