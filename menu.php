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

        if (isset($_POST['small']))
        {
            if ($get_table['status'] == 'For Payment' || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
            {
                echo "<script>
                    alert('You got already an order');
                    location.href = 'order.php';
                </script>";
            }

            else
            {
                if ($_POST['qty_small'] <= 0)
                {
                    echo "<script>
                            alert('Quantity must be greater than 0');
                    </script>";
                }

                else
                {
                    $id = $_POST['id'];

                    $filter_select = "select* from tbl_item where id_no = '$id'";
                    $query1 = @mysqli_query($connection, $filter_select);

                    $get_filter = @mysqli_fetch_array($query1);

                    $itemname = $get_filter['Itemname'];

                    $category = $get_filter['Category'];

                    $price = $get_filter['Price_Grande'];

                    if ($category == "Coffee" || $category == "Iced Coffee" || $category == "Frosted Hills")
                    {
                        $size = "GRANDE";
                    }

                    elseif ($category == "Pastry")
                    {
                        $size = "PC/SLICE";
                    }

                    elseif ($category == "Pasta")
                    {
                        $size = "REGULAR";
                    }

                    elseif ($category == "Custom")
                    {
                        $size = "Single Shot";
                    }

                    $qty = $_POST['qty_small'];

                    $total = $price * $qty;

                    if ($table == "1")
                    {
                        $check_table = "select* from tbl_table_1 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_1 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_1 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "2")
                    {
                        $check_table = "select* from tbl_table_2 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_2 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_2 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "3")
                    {
                        $check_table = "select* from tbl_table_3 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_3 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_3 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "4")
                    {
                        $check_table = "select* from tbl_table_4 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_4 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_4 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "5")
                    {
                        $check_table = "select* from tbl_table_5 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_5 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_5 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "6")
                    {
                        $check_table = "select* from tbl_table_6 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_6 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_6 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    $query2 = @mysqli_query($connection, $update_cart);

                    if ($query2)
                    {
                        echo "<script>
                                alert('Successfully Updated Cart');
                                location.href = '';
                        </script>";
                    }
                }
            }
        }

        if (isset($_POST['large']))
        {
            if ($get_table['status'] == 'For Payment' || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
            {
                echo "<script>
                    alert('You got already an order');
                    location.href = 'order.php';
                </script>";
            }

            else
            {
                if ($_POST['qty_large'] <= 0)
                {
                    echo "<script>
                            alert('Quantity must be greater than 0');
                    </script>";
                }

                else
                {
                    $id = $_POST['id'];

                    $filter_select = "select* from tbl_item where id_no = '$id'";
                    $query1 = @mysqli_query($connection, $filter_select);

                    $get_filter = @mysqli_fetch_array($query1);

                    $itemname = $get_filter['Itemname'];

                    $category = $get_filter['Category'];

                    $price = $get_filter['Price_Venti'];

                    if ($category == "Coffee" || $category == "Iced Coffee" || $category == "Frosted Hills")
                    {
                        $size = "VENTI";
                    }

                    elseif ($category == "Pastry")
                    {
                        $size = "WHOLE";
                    }

                    elseif ($category == "Pasta")
                    {
                        $size = "LARGE";
                    }

                    elseif ($category == "Custom")
                    {
                        $size = "Double Shot";
                    }

                    $qty = $_POST['qty_large'];

                    $total = $price * $qty;

                    if ($table == "1")
                    {
                        $check_table = "select* from tbl_table_1 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_1 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_1 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "2")
                    {
                        $check_table = "select* from tbl_table_2 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_2 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_2 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "3")
                    {
                        $check_table = "select* from tbl_table_3 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_3 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_3 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "4")
                    {
                        $check_table = "select* from tbl_table_4 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_4 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_4 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "5")
                    {
                        $check_table = "select* from tbl_table_5 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_5 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_5 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    elseif ($table == "6")
                    {
                        $check_table = "select* from tbl_table_6 where id_no = '$id' and Size = '$size'";
                        $query4 = @mysqli_query($connection, $check_table);
                        $get2 = @mysqli_fetch_array($query4);

                        $check_id = $get2['id_no'];

                        if ($check_id == "")
                        {
                            $update_cart = "insert into tbl_table_6 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$itemname', '$category', '$size', '$price', '$qty', '$total')";
                        }

                        else
                        {
                            $update_cart = "update tbl_table_6 set Quantity = '$qty', Total_Price = '$total' where id_no = '$check_id' and Size = '$size'";
                        }
                    }

                    $query2 = @mysqli_query($connection, $update_cart);

                    if ($query2)
                    {
                        echo "<script>
                                alert('Successfully Updated Cart');
                                location.href = '';
                        </script>";
                    }
                }
            }
        }
    }

    else
    {
        header ("Location: table_used.php");
    }
?>

<?php require './headers_footers/header.php'; ?>

<div id="main" class="container-fluid mt-5">
    <div style="mr-5">
        <a href="order.php" class="btn" style="background-color: black; color: white;">VIEW ORDER</a>
    </div>
	<div class="mt-5">
    	<h5 class="text-center">MENU LIST<br><br>ALL CATEGORY</h5>
  	</div>
    <div class="container-fluid mt-5">
        <div class="row">
            <?php
                $connection2 = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

                $select_product = "select* from tbl_item";
                $query = @mysqli_query($connection2, $select_product);

                $in = 0;

                while ($get = @mysqli_fetch_array($query))
                {
                    if ($table == "1")
                    {
                        $filter = "select* from tbl_table_1 where id_no = '$get[id_no]' and (Size = 'GRANDE' or Size = 'PC/SLICE' or Size = 'REGULAR' or Size = 'Single Shot')";
                        $filter1 = "select* from tbl_table_1 where id_no = '$get[id_no]' and (Size = 'VENTI' or Size = 'WHOLE' or Size = 'LARGE' or Size = 'Double Shot')";
                    }

                    elseif ($table == "2")
                    {
                        $filter = "select* from tbl_table_2 where id_no = '$get[id_no]' and (Size = 'GRANDE' or Size = 'PC/SLICE' or Size = 'REGULAR' or Size = 'Single Shot')";
                        $filter1 = "select* from tbl_table_2 where id_no = '$get[id_no]' and (Size = 'VENTI' or Size = 'WHOLE' or Size = 'LARGE' or Size = 'Double Shot')";
                    }

                    elseif ($table == "3")
                    {
                        $filter = "select* from tbl_table_3 where id_no = '$get[id_no]' and (Size = 'GRANDE' or Size = 'PC/SLICE' or Size = 'REGULAR' or Size = 'Single Shot')";
                        $filter1 = "select* from tbl_table_3 where id_no = '$get[id_no]' and (Size = 'VENTI' or Size = 'WHOLE' or Size = 'LARGE' or Size = 'Double Shot')";
                    }

                    elseif ($table == "4")
                    {
                        $filter = "select* from tbl_table_4 where id_no = '$get[id_no]' and (Size = 'GRANDE' or Size = 'PC/SLICE' or Size = 'REGULAR' or Size = 'Single Shot')";
                        $filter1 = "select* from tbl_table_4 where id_no = '$get[id_no]' and (Size = 'VENTI' or Size = 'WHOLE' or Size = 'LARGE' or Size = 'Double Shot')";
                    }

                    elseif ($table == "5")
                    {
                        $filter = "select* from tbl_table_5 where id_no = '$get[id_no]' and (Size = 'GRANDE' or Size = 'PC/SLICE' or Size = 'REGULAR' or Size = 'Single Shot')";
                        $filter1 = "select* from tbl_table_5 where id_no = '$get[id_no]' and (Size = 'VENTI' or Size = 'WHOLE' or Size = 'LARGE' or Size = 'Double Shot')";
                    }

                    elseif ($table == "6")
                    {
                        $filter = "select* from tbl_table_6 where id_no = '$get[id_no]' and (Size = 'GRANDE' or Size = 'PC/SLICE' or Size = 'REGULAR' or Size = 'Single Shot')";
                        $filter1 = "select* from tbl_table_6 where id_no = '$get[id_no]' and (Size = 'VENTI' or Size = 'WHOLE' or Size = 'LARGE' or Size = 'Double Shot')";
                    }

                    $query3 = @mysqli_query($connection, $filter);

                    $get1 = @mysqli_fetch_array($query3);

                    $get_qty = $get1['Quantity'];

                    $query4 = @mysqli_query($connection, $filter1);

                    $get2 = @mysqli_fetch_array($query4);

                    $get_qty1 = $get2['Quantity'];
            ?> 
                    
                    <div class="col-lg-4 col-md-6 p-4">
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $get['id_no']; ?>">
                            <div style="background-color: #f6e0db; height: 300px;">
                                <div style="display: flex;" class="p-3">
                                    <div id="item-holder">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($get['Image']); ?>" class="rounded" style="width: 140px; height: 120px;"><br>
                                    </div>
                
                                    <div class="ml-4" id="1">
                                        <textarea disabled style="resize: none;" class="form-control" rows="4" cols="100%"><?php echo $get['Description']; ?></textarea>
                                    </div>
                                </div>
                                <div style="width: 100%;" class="ml-4">
                                    <h5 style="color: black; text-shadow: 1px 1px white;" id="item-name"><?php echo $get['Itemname']; ?></h5>
                                </div>

                                <div class="d-flex">                            
                                    <div style="width: 50%;">
                                        <center>
                                            <?php
                                                if ($get_qty == "")
                                                {
                                            ?>
                                                    <div class="d-flex p-1">
                                                        <input type="button" value="(+)" id="click<?php echo $in; ?>" class="btn ml-3" style="background-color: #3D3324;; color: white;">
                                                        <input type="number" id="counting<?php echo $in; ?>" <?php if($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served"){ ?> readonly <?php } ?> name="qty_small" class="form-control numbers-only ml-1" style="width: 40%;" value="0">
                                                        <input type="button" value="(-)" id="clickby<?php echo $in; ?>" class="btn ml-1" style="background-color: #3D3324;; color: white;">
                                                    </div>
                                                    
                                                    <?php
                                                        if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
                                                        {

                                                        }

                                                        else
                                                        {
                                                    ?>
                                                            <script>
                                                                $('#click'+<?php echo $in; ?>+'').on('click', function(){
                                                                    var data = parseInt(document.getElementById('counting'+<?php echo $in; ?>+'').value);
                                                                    data = data + 1;
                                                                    document.getElementById('counting'+<?php echo $in; ?>+'').value = data;
                                                                });
                                                                $('#clickby'+<?php echo $in; ?>+'').on('click', function(){
                                                                    var data = parseInt(document.getElementById('counting'+<?php echo $in; ?>+'').value);
                                                                    data = data - 1;
                                                                    document.getElementById('counting'+<?php echo $in; ?>+'').value = data;
                                                                });
                                                            </script>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                            <?php
                                                }

                                                else
                                                {
                                            ?>
                                                    <div class="d-flex p-1">
                                                        <input type="button" value="(+)" id="click<?php echo $in; ?>" class="btn ml-3" style="background-color: #3D3324;; color: white;">
                                                        <input type="number" id="counting<?php echo $in; ?>" <?php if($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served"){ ?> readonly <?php } ?> name="qty_small" class="form-control numbers-only ml-1" style="width: 40%;" value="<?php echo $get_qty; ?>">
                                                        <input type="button" value="(-)" id="clickby<?php echo $in; ?>" class="btn ml-1" style="background-color: #3D3324;; color: white;">
                                                    </div>

                                                    <?php
                                                        if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
                                                        {

                                                        }

                                                        else
                                                        {
                                                    ?>
                                                            <script>
                                                                $('#click'+<?php echo $in; ?>+'').on('click', function(){
                                                                    var data = parseInt(document.getElementById('counting'+<?php echo $in; ?>+'').value);
                                                                    data = data + 1;
                                                                    document.getElementById('counting'+<?php echo $in; ?>+'').value = data;
                                                                });
                                                                $('#clickby'+<?php echo $in; ?>+'').on('click', function(){
                                                                    var data = parseInt(document.getElementById('counting'+<?php echo $in; ?>+'').value);
                                                                    data = data - 1;
                                                                    document.getElementById('counting'+<?php echo $in; ?>+'').value = data;
                                                                });
                                                            </script>
                                                    <?php
                                                        }
                                                    ?>
                                            <?php
                                                }
                                            ?>
                                            
                                        </center>
                                    </div>

                                    <div style="width: 50%;">
                                        <center>
                                            <?php
                                                if ($get_qty1 == "")
                                                {
                                            ?>
                                                    <div class="d-flex p-1">
                                                        <input type="button" value="(+)" id="clickclick<?php echo $in; ?>" class="btn ml-3" style="background-color: #3D3324;; color: white;">
                                                        <input type="number" id="countingcounting<?php echo $in; ?>" <?php if($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served"){ ?> readonly <?php } ?> name="qty_large" class="form-control numbers-only ml-1" style="width: 40%;" value="0">
                                                        <input type="button" value="(-)" id="clickbyclickby<?php echo $in; ?>" class="btn ml-1" style="background-color: #3D3324;; color: white;">
                                                    </div>

                                                    <?php
                                                        if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
                                                        {
                                                    ?>

                                                    <?php
                                                        }

                                                        else
                                                        {
                                                    ?>
                                                            <script>
                                                                $('#clickclick'+<?php echo $in; ?>+'').on('click', function(){
                                                                    var data = parseInt(document.getElementById('countingcounting'+<?php echo $in; ?>+'').value);
                                                                    data = data + 1;
                                                                    document.getElementById('countingcounting'+<?php echo $in; ?>+'').value = data;
                                                                });
                                                                $('#clickbyclickby'+<?php echo $in; ?>+'').on('click', function(){
                                                                    var data = parseInt(document.getElementById('countingcounting'+<?php echo $in; ?>+'').value);
                                                                    data = data - 1;
                                                                    document.getElementById('countingcounting'+<?php echo $in; ?>+'').value = data;
                                                                });
                                                            </script>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                            <?php
                                                }

                                                else
                                                {
                                            ?>
                                                    <div class="d-flex p-1">
                                                        <input type="button" value="(+)" id="clickclick<?php echo $in; ?>" class="btn ml-3" style="background-color: #3D3324;; color: white;">
                                                        <input type="number" <?php if($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served"){ ?> readonly <?php } ?> name="qty_large" id="countingcounting<?php echo $in; ?>" class="form-control numbers-only" style="width: 40%;" value="<?php echo $get_qty1; ?>">
                                                        <input type="button" value="(-)" id="clickbyclickby<?php echo $in; ?>" class="btn ml-1" style="background-color: #3D3324;; color: white;">
                                                    </div>

                                                    <?php
                                                        if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
                                                        {
                                                    ?>

                                                    <?php
                                                        }

                                                        else
                                                        {
                                                    ?>
                                                            <script>
                                                                $('#clickclick'+<?php echo $in; ?>+'').on('click', function(){
                                                                    var data = parseInt(document.getElementById('countingcounting'+<?php echo $in; ?>+'').value);
                                                                    data = data + 1;
                                                                    document.getElementById('countingcounting'+<?php echo $in; ?>+'').value = data;
                                                                });
                                                                $('#clickbyclickby'+<?php echo $in; ?>+'').on('click', function(){
                                                                    var data = parseInt(document.getElementById('countingcounting'+<?php echo $in; ?>+'').value);
                                                                    data = data - 1;
                                                                    document.getElementById('countingcounting'+<?php echo $in; ?>+'').value = data;
                                                                });
                                                            </script>
                                                    <?php
                                                        }
                                                    ?>
                                            <?php
                                                }
                                            ?>
                                        </center>
                                    </div>
                                </div>

                                <div class="d-flex mt-3">
                                    <div class="col-lg-6 mb-3">
                                        <input type="submit" name="small" class="btn" style="width: 100%; color: white; background-color: #3D3324;" value="<?php if ($get['Category'] == 'Coffee' || $get['Category'] == 'Iced Coffee' || $get['Category'] == 'Frosted Hills'){ ?> GRANDE P<?php echo $get['Price_Grande']; } elseif ($get['Category'] == 'Pastry'){ ?> PC/SLICE P<?php echo $get['Price_Grande']; } elseif ($get['Category'] == 'Pasta'){ ?> REGULAR P<?php echo $get['Price_Grande']; } elseif ($get['Category'] == 'Custom'){ ?> Single Shot P<?php echo $get['Price_Grande']; } ?>">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="submit" class="btn" name="large" style="width: 100%; color: white; background-color: #3D3324;" value="<?php if ($get['Category'] == 'Coffee' || $get['Category'] == 'Iced Coffee' || $get['Category'] == 'Frosted Hills'){ ?> VENTI P<?php echo $get['Price_Venti']; } elseif ($get['Category'] == 'Pastry'){ ?> WHOLE P<?php echo $get['Price_Venti']; } elseif ($get['Category'] == 'Pasta'){ ?> LARGE P<?php echo $get['Price_Venti']; } elseif ($get['Category'] == 'Custom'){ ?> Double Shot P<?php echo $get['Price_Venti']; } ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
                $in = $in + 1;
                }
            ?>

        </div>
    </div>
</div>

<script>
    const inputField = document.querySelector('.numbers-only');

inputField.onkeydown = (event) => {
  // Only allow if the e.key value is a number or if it's 'Backspace'
  if(isNaN(event.key) && event.key !== 'Backspace') {
    event.preventDefault();
  }
};
</script>
<?php require './headers_footers/admin_footer.php'; ?>