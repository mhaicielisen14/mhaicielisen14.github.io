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
                    alert('Table no. is already used or ordering $_SESSION[original_table]');
                    location.href = 'login.php';
                </script>";
            }
        }

        if ($_GET['id'] == "" || $_GET['size'] == "")
        {
            header ("Location: menu.php");
        }

        else
        {
            if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
            {
                echo "<script>
                    alert('You got already an order');
                    location.href = 'order.php';
                </script>";
            }

            if ($_GET['size'] == "reg" || $_GET['size'] == "lar")
            {
                $id = $_GET['id'];

                $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

                $query = "select* from tbl_item";
                $mysql = @mysqli_query($connection, $query);

                $count = 0;

                while ($get = @mysqli_fetch_array($mysql))
                {
                    if ($id == $get['id_no'])
                    {
                        $count = $count + 1;
                    }
                }

                $query1 = "select* from tbl_item where id_no = '$id'";
                $mysql1 = @mysqli_query($connection, $query1);
                $get1 = @mysqli_fetch_array($mysql1);

                if (isset($_POST['add']))
                {
                    $id = $_POST['id'];
                    $size = $_POST['size'];
                    $quantity = $_POST['quantity'];

                    if ($size == "GRANDE" || $size == "PC/SLICE" || $size == "REGULAR" || $size == "Single Shot")
                    {
                        $select_price = "select* from tbl_item where id_no = '$id'";
                        $query2 = @mysqli_query($connection, $select_price);
                        $get2 = @mysqli_fetch_array($query2);

                        $price = $get2['Price_Grande'];
                    }

                    else
                    {
                        $select_price = "select* from tbl_item where id_no = '$id'";
                        $query2 = @mysqli_query($connection, $select_price);
                        $get2 = @mysqli_fetch_array($query2);

                        $price = $get2['Price_Venti'];
                    }

                    $totalprice = $price * $quantity;

                    if ($table == "1")
                    {
                        $add = "insert into tbl_table_1 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$get1[Itemname]', '$get1[Category]', '$size', '$price', '$quantity', '$totalprice')";
                    }

                    else if ($table == "2")
                    {
                        $add = "insert into tbl_table_2 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$get1[Itemname]', '$get1[Category]', '$size', '$price', '$quantity', '$totalprice')";
                    }

                    else if ($table == "3")
                    {
                        $add = "insert into tbl_table_3 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$get1[Itemname]', '$get1[Category]', '$size', '$price', '$quantity', '$totalprice')";
                    }

                    else if ($table == "4")
                    {
                        $add = "insert into tbl_table_4 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$get1[Itemname]', '$get1[Category]', '$size', '$price', '$quantity', '$totalprice')";
                    }

                    else if ($table == "5")
                    {
                        $add = "insert into tbl_table_5 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$get1[Itemname]', '$get1[Category]', '$size', '$price', '$quantity', '$totalprice')";
                    }

                    else if ($table == "6")
                    {
                        $add = "insert into tbl_table_6 (id_no, Itemname, Category, Size, Price, Quantity, Total_Price) values ('$id', '$get1[Itemname]', '$get1[Category]', '$size', '$price', '$quantity', '$totalprice')";
                    }

                    $query3 = @mysqli_query($connection, $add);

                    if ($query3)
                    {
                        $changestatus = "update tbl_tables set status = 'In Ordering' where table_no = '$table'";
                        $query4 = @mysqli_query($connection, $changestatus);

                        if ($query4)
                        {
                            $_SESSION['original_table'] = $table;

                            echo "<script>
                                alert('Successfully added to cart');
                                location.href = 'order.php';
                            </script>";
                        }
                    }
                }

                if ($count == 0)
                {
                    header ("Location: menu.php");    
                }        
            }

            else
            {
                header ("Location: menu.php");
            }
        }
    }

    else
    {
        header ("Location: login.php");
    }
?>

<?php require './headers_footers/header.php'; ?>

<div class="container-fluid p-5">
    <div class="row mt-5">
        <div class="col-lg-6 p-5">
            <center>
                <?php if ($get1['Image'] == "") { ?> <img id="profile-pic" src="/img/producct_icon.png"  class="img-fluid"> <?php } else { ?><img style="<?php if($get1['Category']=='Coffee' || $get1['Category']=='Iced Coffee' || $get1['Category'] == 'Frosted Hills'){ ?> width: 30%; <?php } else{ ?> width: 55%; <?php } ?>" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($get1['Image']); ?>" class="img-fluid"><?php } ?><br><br>
                <h6><?php echo $get1['Description']; ?></h6>
            </center>
        </div>
        <div class="col-lg-6">
            <form action="" method="post">
                <center>
                    <h4 class="mt-3"><?php echo $get1['Itemname']; ?></h4>
                    <?php
                        if ($_GET['size'] == "reg" && $get1['Category'] == "Coffee")
                        {
                            $size = "GRANDE";
                        }

                        else if($_GET['size'] == "lar" && $get1['Category'] == "Coffee")
                        {
                            $size = "VENTI";
                        }

                        else if($_GET['size'] == "reg" && $get1['Category'] == "Iced Coffee")
                        {
                            $size = "GRANDE";
                        }

                        else if($_GET['size'] == "lar" && $get1['Category'] == "Iced Coffee")
                        {
                            $size = "VENTI";
                        }

                        else if($_GET['size'] == "reg" && $get1['Category'] == "Frosted Hills")
                        {
                            $size = "GRANDE";
                        }

                        else if($_GET['size'] == "lar" && $get1['Category'] == "Frosted Hills")
                        {
                            $size = "VENTI";
                        }

                        else if($_GET['size'] == "reg" && $get1['Category'] == "Pastry")
                        {
                            $size = "PC/SLICE";
                        }

                        else if($_GET['size'] == "reg" && $get1['Category'] == "Pasta")
                        {
                            $size = "REGULAR";
                        }

                        else if($_GET['size'] == "lar" && $get1['Category'] == "Pasta")
                        {
                            $size = "LARGE";
                        }

                        else if($_GET['size'] == "lar" && $get1['Category'] == "Pastry")
                        {
                            $size = "WHOLE";
                        }

                        else if($_GET['size'] == "reg" && $get1['Category'] == "Custom")
                        {
                            $size = "Single Shot";
                        }

                        else if($_GET['size'] == "lar" && $get1['Category'] == "Custom")
                        {
                            $size = "Double Shot";
                        }
                    ?>
                    <h5><?php echo $size; ?></h5>
                    <div class="col-lg-4 col-md-4 mt-3">
                        <b>Quantity</b>
                        <input id="quantity" type="number" min="1" value="1" name="quantity" class="form-control">
                        <input type="button" class="btn btn-primary form-control confirmbtn mt-5" value="ADD TO CART" data-toggle="modal" data-target="#confirmmodal">
                    </div>
                </center>
                <div class="modal fade" id="confirmmodal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: green;">
                                <img src="/img/hv_logo.png" width="50">
                                <h4 class="modal-title ml-2" style="Color: white;">Add to Order</h4>
                                <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                            </div>
                                                        
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        Are you sure you want to add <?php echo $get1['Itemname']; ?> to your order?
                                        <input type="hidden" name="id" value="<?php echo $get1['id_no']; ?>">
                                        <input type="hidden" name="size" value="<?php echo $size; ?>">
                                    </div>
                                </div>
                            </div>
                                                    
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="add" value="YES">
                                <input type="button" class="btn btn-info" value="NO" data-dismiss="modal">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require './headers_footers/admin_footer.php'; ?>