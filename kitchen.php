<?php
    session_start();

    $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");
    
    if (isset($_POST['logout']))
    {
        $_SESSION['username2'] = "";
    }

    $username2 = $_SESSION['username2'];

    if ($username2 == "")
    {
        header("Location: kitchen_login.php");
    }

    if (isset($_POST['change_status']))
    {
        $status = $_POST['status'];
        $table = $_POST['table'];

        $update = "update tbl_tables set status = '$status' where table_no = '$table'";
        $query1 = @mysqli_query($connection, $update);

        if ($status == "Vacant")
        {
            $update = "update tbl_tables set status = '$status', order_no = '0', filtered = '0', customer_no = '0' where table_no = '$table'";
            $query1 = @mysqli_query($connection, $update);

            if ($table == "1")
            {
                $delete = "delete from tbl_table_1 where 1";
            }

            else if($table == "2")
            {
                $delete = "delete from tbl_table_2 where 1";
            }

            else if($table == "3")
            {
                $delete = "delete from tbl_table_3 where 1";
            }

            else if($table == "4")
            {
                $delete = "delete from tbl_table_4 where 1";
            }

            else if($table == "5")
            {
                $delete = "delete from tbl_table_5 where 1";
            }

            else if($table == "6")
            {
                $delete = "delete from tbl_table_6 where 1";
            }

            $query2 = @mysqli_query($connection, $delete);

            if ($query1 && $query2)
            {
                echo "<script>
                        alert('Successfully Updated the status of Table No. $table');
                </script>";
            }
        }

        else
        {
            if ($status == "Order Served")
            {
                if ($table == "1")
                {
                    $select_item = "select* from tbl_table_1";
                }

                else if($table == "2")
                {
                    $select_item = "select* from tbl_table_2";
                }

                else if($table == "3")
                {
                    $select_item = "select* from tbl_table_3";
                }   

                else if($table == "4")
                {
                    $select_item = "select* from tbl_table_4";
                }

                else if($table == "5")
                {
                    $select_item = "select* from tbl_table_5";
                }

                else if($table == "6")
                {
                    $select_item = "select* from tbl_table_6";
                }

                $query4 = @mysqli_query($connection, $select_item);

                while ($get_item = @mysqli_fetch_array($query4))
                {
                    $select_order_no = "select* from tbl_tables where table_no = '$table'";
                    $query5 = @mysqli_query($connection, $select_order_no);
                    $get_order_no = @mysqli_fetch_array($query5);

                    date_default_timezone_set('Asia/Manila');
                    $date_now = date('Y-m-d H:i:s');
                    $month_now = date('F');
                    $year_now = date("Y");

                    $insert_item = "insert into tbl_order (order_no, id_no, table_no, Itemname, Category, Size, Price, Quantity, Total_Price, date_order, Month, Year, customer_no) values ('$get_order_no[order_no]', '$get_item[id_no]', '$table', '$get_item[Itemname]', '$get_item[Category]', '$get_item[Size]', '$get_item[Price]', '$get_item[Quantity]', '$get_item[Total_Price]', '$date_now', '$month_now', '$year_now', '$get_order_no[customer_no]')";

                    $query6 = @mysqli_query($connection, $insert_item);

                    if ($query1 && $query6)
                    {
                        echo "<script>
                            alert('Successfully Updated the status of Table No. $table');
                            location.href='kitchen.php';
                        </script>";
                    }
                }
            }

            else
            {
                if ($query1)
                {
                    echo "<script>
                            alert('Successfully Updated the status of Table No. $table');
                    </script>";
                }
            }
        }
    }
?>

<?php require './headers_footers/kitchen_header.php'; ?>

<div class="p-2">
    <h3 class="mt-3 ml-3"><b>Orders</b></h3>
    <div class="row mt-5">
        <div class="col-lg-2 col-md-4 mt-3">
            <div style="background-color: black; color:white; height: 250px;" class="p-2">
                <center>
                    TABLE 1<br>
                    <?php

                        $check_table = "select* from tbl_tables where table_no = '1'";
                        $query = @mysqli_query($connection, $check_table);
                        $get_status = @mysqli_fetch_array($query);

                        if ($get_status['status'] == "For Payment")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="1" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Processing" <?php if ($get_status['status']=="Order Processing"){?> selected <?php } ?>>Order Processing</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="1">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus1" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus1" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 1?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "In Ordering")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            SEARCHING MENU<br>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant">Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="1">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus13" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">      
                                <div class="modal fade" id="confirmStatus13" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 1?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Processing")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="1" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Served" <?php if ($get_status['status']=="Order Served"){?> selected <?php } ?>>Order Served</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="1">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus11" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus11" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 1?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Served")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="1" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="1">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus12" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus12" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 1?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            NO ORDER YET OR VACANT TABLE
                    <?php
                        }
                    ?>
                </center>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 mt-3">
            <div style="background-color: black; color:white; height: 250px;" class="p-2">
                <center>
                    TABLE 2<br>
                    <?php

                        $check_table = "select* from tbl_tables where table_no = '2'";
                        $query = @mysqli_query($connection, $check_table);
                        $get_status = @mysqli_fetch_array($query);

                        if ($get_status['status'] == "For Payment")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="2" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Processing" <?php if ($get_status['status']=="Order Processing"){?> selected <?php } ?>>Order Processing</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="2">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus21" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus21" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 2?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "In Ordering")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            SEARCHING MENU<br>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant">Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="2">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus24" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">
                                <div class="modal fade" id="confirmStatus24" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 2?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Processing")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="2" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Served" <?php if ($get_status['status']=="Order Served"){?> selected <?php } ?>>Order Served</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="2">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus22" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus22" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 2?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Served")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="2" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="2">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus23" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus23" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 2?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            NO ORDER YET OR VACANT TABLE
                    <?php
                        }
                    ?>
                </center>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 mt-3">
            <div style="background-color: black; color:white; height: 250px;" class="p-2">
                <center>
                    TABLE 3<br>
                    <?php

                        $check_table = "select* from tbl_tables where table_no = '3'";
                        $query = @mysqli_query($connection, $check_table);
                        $get_status = @mysqli_fetch_array($query);

                        if ($get_status['status'] == "For Payment")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="3" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Processing" <?php if ($get_status['status']=="Order Processing"){?> selected <?php } ?>>Order Processing</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="3">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus31" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus31" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 3?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "In Ordering")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            SEARCHING MENU<br>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant">Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="3">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus34" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">
                                <div class="modal fade" id="confirmStatus34" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 3?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Processing")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="3" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Served" <?php if ($get_status['status']=="Order Served"){?> selected <?php } ?>>Order Served</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="3">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus32" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus32" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 3?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Served")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="3" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="3">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus33" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus33" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 3?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            NO ORDER YET OR VACANT TABLE
                    <?php
                        }
                    ?>
                </center>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 mt-3">
            <div style="background-color: black; color:white; height: 250px;" class="p-2">
                <center>
                    TABLE 4<br>
                    <?php

                        $check_table = "select* from tbl_tables where table_no = '4'";
                        $query = @mysqli_query($connection, $check_table);
                        $get_status = @mysqli_fetch_array($query);

                        if ($get_status['status'] == "For Payment")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="4" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Processing" <?php if ($get_status['status']=="Order Processing"){?> selected <?php } ?>>Order Processing</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="4">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus41" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus41" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 4?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "In Ordering")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            SEARCHING MENU<br>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant">Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="4">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus44" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">
                                <div class="modal fade" id="confirmStatus44" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 4?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Processing")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="4" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Served" <?php if ($get_status['status']=="Order Served"){?> selected <?php } ?>>Order Served</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="4">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus42" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus42" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 4?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Served")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="4" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="4">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus43" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus43" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 4?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            NO ORDER YET OR VACANT TABLE
                    <?php
                        }
                    ?>
                </center>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 mt-3">
            <div style="background-color: black; color:white; height: 250px;" class="p-2">
                <center>
                    TABLE 5<br>
                    <?php

                        $check_table = "select* from tbl_tables where table_no = '5'";
                        $query = @mysqli_query($connection, $check_table);
                        $get_status = @mysqli_fetch_array($query);

                        if ($get_status['status'] == "For Payment")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="5" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Processing" <?php if ($get_status['status']=="Order Processing"){?> selected <?php } ?>>Order Processing</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="5">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus51" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus51" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 5?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "In Ordering")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            SEARCHING MENU<br>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant">Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="5">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus54" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">
                                <div class="modal fade" id="confirmStatus54" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 5?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Processing")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="5" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Served" <?php if ($get_status['status']=="Order Served"){?> selected <?php } ?>>Order Served</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="5">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus52" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus52" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 5?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Served")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="5" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="5">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus53" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus53" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 5?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            NO ORDER YET OR VACANT TABLE
                    <?php
                        }
                    ?>
                </center>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 mt-3">
            <div style="background-color: black; color:white; height: 250px;" class="p-2">
                <center>
                    TABLE 6<br>
                    <?php

                        $check_table = "select* from tbl_tables where table_no = '6'";
                        $query = @mysqli_query($connection, $check_table);
                        $get_status = @mysqli_fetch_array($query);

                        if ($get_status['status'] == "For Payment")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="6" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Processing" <?php if ($get_status['status']=="Order Processing"){?> selected <?php } ?>>Order Processing</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="6">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus61" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus61" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 6?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "In Ordering")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            SEARCHING MENU<br>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant">Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="6">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus64" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">
                                <div class="modal fade" id="confirmStatus64" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 6?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Processing")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="6" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Order Served" <?php if ($get_status['status']=="Order Served"){?> selected <?php } ?>>Order Served</option>
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="6">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus62" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus62" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 6?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else if ($get_status['status'] == "Order Served")
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            ORDER NO. <?php echo $get_status['order_no']; ?><br>
                            <form action="#order_table" method="post">
                                <input type="hidden" value="6" name="table_no">
                                <input type="hidden" value="<?php echo $get_status['order_no']; ?>" name="order_no">
                                <input type="submit" name="details" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="DETAILS"><br>
                            </form>
                            <form action="" method="post">
                                <select name="status" class="mt-3" style="font-size: 13px;">
                                    <option value="Vacant" <?php if ($get_status['status']=="Vacant"){?> selected <?php } ?>>Vacant</option>
                                </select><br>
                                <input type="hidden" name="table" value="6">
                                <input type="button" data-toggle="modal" data-target="#confirmStatus63" style="background-color: white; color: black;" class="btn mt-3 border border-dark" value="APPLY STATUS">

                                <div class="modal fade" id="confirmStatus63" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: black; color: white;">
                                                <img src="/img/hv_logo.png" width="50">
                                                <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                            </div>
                                                
                                            <div class="modal-body">
                                                <div class="form-group" style="color: black;">
                                                    Are you sure you want to update table no 6?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="change_status" value="YES">
                                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                        }

                        else
                        {
                    ?>
                            <?php echo $get_status['status']; ?><br>
                            NO ORDER YET OR VACANT TABLE
                    <?php
                        }
                    ?>
                </center>
            </div>
        </div>
    </div>
</div>

<?php
    if (isset($_POST['details']))
    {
        $table_no = $_POST['table_no'];

        if ($_POST['table_no'] == "1")
        {
            $total = 0;
?>
            <div class="mt-5 mb-5 p-5" id="order_table">
                <center>
                    <h4>TABLE NO. <?php echo $table_no; ?><br>ORDER NO. <?php echo $_POST['order_no']; ?></h4>
                    <table class="admin-menu-table">
                        <thead>
                            <tr style="color: white; text-shadow: 1px 1px black; background-color: black; font-size: 1.8vw; text-align: center;">
                                <th style="border: 1px solid black;" class="p-2">ID NO</th>
                                <th style="border: 1px solid black;" class="p-2">ITEM NAME</th>
                                <th style="border: 1px solid black;" class="p-2">CATEGORY</th>
                                <th style="border: 1px solid black;" class="p-2">SIZE</th>
                                <th style="border: 1px solid black;" class="p-2">PRICE</th>
                                <th style="border: 1px solid black;" class="p-2">QUANTITY</th>
                                <th style="border: 1px solid black;" class="p-2">TOTAL PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $selectitem = "select* from tbl_table_1";
                                $query3 = @mysqli_query($connection, $selectitem);
                                
                                while ($get = @mysqli_fetch_array($query3))
                                {
                            ?>
                                    <tr style="color: black; font-size: 1.8vw;">
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['id_no']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Itemname']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Category']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Size']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Price']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Quantity']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Total_Price']; ?></td>
                                    </tr>
                            <?php
                                    $total = $total + $get['Total_Price'];
                                }
                            ?>
                        </tbody>
                    </table>
                </center>
            </div>

            <div class="mt-2">
                <center>
                    <h3>TOTAL PRICE P<?php echo $total; ?></h3>
                </center>
            </div>
<?php
        }

        else if($_POST['table_no'] == "2")
        {
            $total = 0;
?>
            <div class="mt-5 mb-5 p-5" id="order_table">
                <center>
                    <h4>TABLE NO. <?php echo $table_no; ?><br>ORDER NO. <?php echo $_POST['order_no']; ?></h4>
                    <table class="admin-menu-table">
                        <thead>
                            <tr style="color: white; text-shadow: 1px 1px black; background-color: black; font-size: 1.8vw; text-align: center;">
                                <th style="border: 1px solid black;" class="p-2">ID NO</th>
                                <th style="border: 1px solid black;" class="p-2">ITEM NAME</th>
                                <th style="border: 1px solid black;" class="p-2">CATEGORY</th>
                                <th style="border: 1px solid black;" class="p-2">SIZE</th>
                                <th style="border: 1px solid black;" class="p-2">PRICE</th>
                                <th style="border: 1px solid black;" class="p-2">QUANTITY</th>
                                <th style="border: 1px solid black;" class="p-2">TOTAL PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $selectitem = "select* from tbl_table_2";
                                $query3 = @mysqli_query($connection, $selectitem);
                                
                                while ($get = @mysqli_fetch_array($query3))
                                {
                            ?>
                                    <tr style="color: black; font-size: 1.8vw;">
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['id_no']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Itemname']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Category']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Size']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Price']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Quantity']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Total_Price']; ?></td>
                                    </tr>
                            <?php
                                    $total = $total + $get['Total_Price'];
                                }
                            ?>
                        </tbody>
                    </table>
                </center>
            </div>

            <div class="mt-2">
                <center>
                    <h3>TOTAL PRICE P<?php echo $total; ?></h3>
                </center>
            </div>
<?php
        }

        else if($_POST['table_no'] == "3")
        {
            $total = 0;
?>
            <div class="mt-5 mb-5 p-5" id="order_table">
                <center>
                    <h4>TABLE NO. <?php echo $table_no; ?><br>ORDER NO. <?php echo $_POST['order_no']; ?></h4>
                    <table class="admin-menu-table">
                        <thead>
                            <tr style="color: white; text-shadow: 1px 1px black; background-color: black; font-size: 1.8vw; text-align: center;">
                                <th style="border: 1px solid black;" class="p-2">ID NO</th>
                                <th style="border: 1px solid black;" class="p-2">ITEM NAME</th>
                                <th style="border: 1px solid black;" class="p-2">CATEGORY</th>
                                <th style="border: 1px solid black;" class="p-2">SIZE</th>
                                <th style="border: 1px solid black;" class="p-2">PRICE</th>
                                <th style="border: 1px solid black;" class="p-2">QUANTITY</th>
                                <th style="border: 1px solid black;" class="p-2">TOTAL PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $selectitem = "select* from tbl_table_3";
                                $query3 = @mysqli_query($connection, $selectitem);
                                
                                while ($get = @mysqli_fetch_array($query3))
                                {
                            ?>
                                    <tr style="color: black; font-size: 1.8vw;">
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['id_no']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Itemname']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Category']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Size']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Price']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Quantity']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Total_Price']; ?></td>
                                    </tr>
                            <?php
                                    $total = $total + $get['Total_Price'];
                                }
                            ?>
                        </tbody>
                    </table>
                </center>
            </div>

            <div class="mt-2">
                <center>
                    <h3>TOTAL PRICE P<?php echo $total; ?></h3>
                </center>
            </div>
<?php
        }

        else if($_POST['table_no'] == "4")
        {
            $total = 0;
?>
            <div class="mt-5 mb-5 p-5" id="order_table">
                <center>
                    <h4>TABLE NO. <?php echo $table_no; ?><br>ORDER NO. <?php echo $_POST['order_no']; ?></h4>
                    <table class="admin-menu-table">
                        <thead>
                            <tr style="color: white; text-shadow: 1px 1px black; background-color: black; font-size: 1.8vw; text-align: center;">
                                <th style="border: 1px solid black;" class="p-2">ID NO</th>
                                <th style="border: 1px solid black;" class="p-2">ITEM NAME</th>
                                <th style="border: 1px solid black;" class="p-2">CATEGORY</th>
                                <th style="border: 1px solid black;" class="p-2">SIZE</th>
                                <th style="border: 1px solid black;" class="p-2">PRICE</th>
                                <th style="border: 1px solid black;" class="p-2">QUANTITY</th>
                                <th style="border: 1px solid black;" class="p-2">TOTAL PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $selectitem = "select* from tbl_table_4";
                                $query3 = @mysqli_query($connection, $selectitem);
                                
                                while ($get = @mysqli_fetch_array($query3))
                                {
                            ?>
                                    <tr style="color: black; font-size: 1.8vw;">
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['id_no']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Itemname']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Category']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Size']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Price']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Quantity']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Total_Price']; ?></td>
                                    </tr>
                            <?php
                                    $total = $total + $get['Total_Price'];
                                }
                            ?>
                        </tbody>
                    </table>
                </center>
            </div>

            <div class="mt-2">
                <center>
                    <h3>TOTAL PRICE P<?php echo $total; ?></h3>
                </center>
            </div>
<?php
        }

        else if($_POST['table_no'] == "5")
        {
            $total = 0;
?>
            <div class="mt-5 mb-5 p-5" id="order_table">
                <center>
                    <h4>TABLE NO. <?php echo $table_no; ?><br>ORDER NO. <?php echo $_POST['order_no']; ?></h4>
                    <table class="admin-menu-table">
                        <thead>
                            <tr style="color: white; text-shadow: 1px 1px black; background-color: black; font-size: 1.8vw; text-align: center;">
                                <th style="border: 1px solid black;" class="p-2">ID NO</th>
                                <th style="border: 1px solid black;" class="p-2">ITEM NAME</th>
                                <th style="border: 1px solid black;" class="p-2">CATEGORY</th>
                                <th style="border: 1px solid black;" class="p-2">SIZE</th>
                                <th style="border: 1px solid black;" class="p-2">PRICE</th>
                                <th style="border: 1px solid black;" class="p-2">QUANTITY</th>
                                <th style="border: 1px solid black;" class="p-2">TOTAL PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $selectitem = "select* from tbl_table_5";
                                $query3 = @mysqli_query($connection, $selectitem);
                                
                                while ($get = @mysqli_fetch_array($query3))
                                {
                            ?>
                                    <tr style="color: black; font-size: 1.8vw;">
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['id_no']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Itemname']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Category']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Size']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Price']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Quantity']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Total_Price']; ?></td>
                                    </tr>
                            <?php
                                    $total = $total + $get['Total_Price'];
                                }
                            ?>
                        </tbody>
                    </table>
                </center>
            </div>

            <div class="mt-2">
                <center>
                    <h3>TOTAL PRICE P<?php echo $total; ?></h3>
                </center>
            </div>
<?php
        }

        else if($_POST['table_no'] == "6")
        {
            $total = 0;
?>
            <div class="mt-5 mb-5 p-5" id="order_table">
                <center>
                    <h4>TABLE NO. <?php echo $table_no; ?><br>ORDER NO. <?php echo $_POST['order_no']; ?></h4>
                    <table class="admin-menu-table">
                        <thead>
                            <tr style="color: white; text-shadow: 1px 1px black; background-color: black; font-size: 1.8vw; text-align: center;">
                                <th style="border: 1px solid black;" class="p-2">ID NO</th>
                                <th style="border: 1px solid black;" class="p-2">ITEM NAME</th>
                                <th style="border: 1px solid black;" class="p-2">CATEGORY</th>
                                <th style="border: 1px solid black;" class="p-2">SIZE</th>
                                <th style="border: 1px solid black;" class="p-2">PRICE</th>
                                <th style="border: 1px solid black;" class="p-2">QUANTITY</th>
                                <th style="border: 1px solid black;" class="p-2">TOTAL PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $selectitem = "select* from tbl_table_6";
                                $query3 = @mysqli_query($connection, $selectitem);
                                
                                while ($get = @mysqli_fetch_array($query3))
                                {
                            ?>
                                    <tr style="color: black; font-size: 1.8vw;">
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['id_no']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Itemname']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Category']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Size']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Price']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Quantity']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Total_Price']; ?></td>
                                    </tr>
                            <?php
                                    $total = $total + $get['Total_Price'];
                                }
                            ?>
                        </tbody>
                    </table>
                </center>
            </div>

            <div class="mt-2">
                <center>
                    <h3>TOTAL PRICE P<?php echo $total; ?></h3>
                </center>
            </div>
<?php
        }
    }
?>

<?php require './headers_footers/footer.php'; ?>