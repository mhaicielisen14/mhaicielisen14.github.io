<?php
    session_start();

    $table = $_SESSION['table'];

    $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");
    
    $id = $_POST['id'];
    $size = $_POST['size'];
    
    if ($table == "1")
    {
        $update = "update tbl_table_1 set Quantity = Quantity + 1, Total_Price = Total_Price + Price where id_no = '$id' and Size = '$size'";
    }

    elseif ($table == "2")
    {
        $update = "update tbl_table_2 set Quantity = Quantity + 1, Total_Price = Total_Price + Price where id_no = '$id' and Size = '$size'";
    }

    elseif ($table == "3")
    {
        $update = "update tbl_table_3 set Quantity = Quantity + 1, Total_Price = Total_Price + Price where id_no = '$id' and Size = '$size'";
    }

    elseif ($table == "4")
    {
        $update = "update tbl_table_4 set Quantity = Quantity + 1, Total_Price = Total_Price + Price where id_no = '$id' and Size = '$size'";
    }

    elseif ($table == "5")
    {
        $update = "update tbl_table_5 set Quantity = Quantity + 1, Total_Price = Total_Price + Price where id_no = '$id' and Size = '$size'";
    }

    elseif ($table == "6")
    {
        $update = "update tbl_table_6 set Quantity = Quantity + 1, Total_Price = Total_Price + Price where id_no = '$id' and Size = '$size'";
    }
    
    $query = @mysqli_query($connection, $update);
?>