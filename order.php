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

        if ($table == "1")
        {
            $selectCheckCart = "select* from tbl_table_1";

            if (isset($_POST['remove']))
            {
                $id = $_POST['id-no'];

                $deleteItem = "delete from tbl_table_1 where id = '$id'";
                $query6 = @mysqli_query($connection, $deleteItem);

                if ($query6)
                {
                    echo "<script>
                        alert('Successfully deleted item in your order');
                    </script>";
                }
            }
        }

        else if($table == "2")
        {
            $selectCheckCart = "select* from tbl_table_2";

            if (isset($_POST['remove']))
            {
                $id = $_POST['id-no'];

                $deleteItem = "delete from tbl_table_2 where id = '$id'";
                $query6 = @mysqli_query($connection, $deleteItem);

                if ($query6)
                {
                    echo "<script>
                        alert('Successfully deleted item in your order');
                    </script>";
                }
            }
        }

        else if($table == "3")
        {
            $selectCheckCart = "select* from tbl_table_3";

            if (isset($_POST['remove']))
            {
                $id = $_POST['id-no'];

                $deleteItem = "delete from tbl_table_3 where id = '$id'";
                $query6 = @mysqli_query($connection, $deleteItem);

                if ($query6)
                {
                    echo "<script>
                        alert('Successfully deleted item in your order');
                    </script>";
                }
            }
        }

        else if($table == "4")
        {
            $selectCheckCart = "select* from tbl_table_4";

            if (isset($_POST['remove']))
            {
                $id = $_POST['id-no'];

                $deleteItem = "delete from tbl_table_4 where id = '$id'";
                $query6 = @mysqli_query($connection, $deleteItem);

                if ($query6)
                {
                    echo "<script>
                        alert('Successfully deleted item in your order');
                    </script>";
                }
            }
        }

        else if($table == "5")
        {
            $selectCheckCart = "select* from tbl_table_5";

            if (isset($_POST['remove']))
            {
                $id = $_POST['id-no'];

                $deleteItem = "delete from tbl_table_5 where id = '$id'";
                $query6 = @mysqli_query($connection, $deleteItem);

                if ($query6)
                {
                    echo "<script>
                        alert('Successfully deleted item in your order');
                    </script>";
                }
            }
        }

        else if($table == "6")
        {
            $selectCheckCart = "select* from tbl_table_6";

            if (isset($_POST['remove']))
            {
                $id = $_POST['id-no'];

                $deleteItem = "delete from tbl_table_6 where id = '$id'";
                $query6 = @mysqli_query($connection, $deleteItem);

                if ($query6)
                {
                    echo "<script>
                        alert('Successfully deleted item in your order');
                    </script>";
                }
            }
        }
        
        $query3 = @mysqli_query($connection, $selectCheckCart);
        $count = 0;

        $total_price = 0;

        while ($fetchCheckCart = @mysqli_fetch_array($query3))
        {
            $count = $count + 1;
            $total_price = $total_price + $fetchCheckCart['Total_Price'];    
        }
    }

    else
    {
        header ("Location: table_used.php");
    }
?>

<?php require './headers_footers/header.php'; ?>

<?php
    if ($count == 0)
    {
    ?>
        <div class="container-fluid">
            <div class="card mb-3 mt-5 rounded" id="profile-div">
                <div class="row no-gutters">
                    <div class="col-lg-2 col-md-2 col-3 p-3">
                        <img src="/img/table_updated.png" class="cart-img">
                    </div>

                    <div class="col-lg-7 col-md-7 col-8">
                        <div id="cartHeader">
                            <h4>YOUR ORDER</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5 mb-5">
                <div class="col-lg-4 col=md-4">
                </div>
                <div class="col-lg-4 col=md-4">
                    <center>
                        <h3>EMPTY ORDER<br><br><a href="menu.php">ADD ORDER</a></h3>
                    </center>
                </div>
                <div class="col-lg-4 col=md-4">
                </div>
            </div>
        </div>
    <?php         
        }

        else
        {
    ?>
            <div class="container-fluid">
                <div class="card mb-3 mt-5 rounded" id="profile-div">
                    <div class="row no-gutters">
                        <div class="col-lg-2 col-md-2 col-3 p-3">
                            <img src="/img/table_updated.png" class="cart-img">
                        </div>

                        <div class="col-lg-7 col-md-7 col-8">
                            <div id="cartHeader">
                                <h4>YOUR ORDER</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="mr-5">
                    <?php
                        if ($get_table['status'] == "For Payment")
                        {
                    ?>
                            
                    <?php
                        }

                        else
                        {
                    ?>
                            <a href="menu.php" class="btn" style="background-color: black; color: white;">ADD ORDER</a>
                    <?php
                        }
                    ?>
                    
                </div>

                <div class="card mt-5 mb-5">
                    <div id="category-div"><img src="/img/hv_logo_dark.png" width="40" height="40"> &nbsp; There are <?php echo $count; ?> items in your order </div>
                    <div class="card-body" style="border: 2px solid #e3a305; color: black;">
                        <div class="row cart-prod-head" style="border-bottom: 1px solid black;">
                            <?php
                                $in = 0;
                                $query4 = @mysqli_query($connection, $selectCheckCart);
                                while ($fetchCheckCart1 = @mysqli_fetch_array($query4))
                                {
                                    $getImage = "select* from tbl_item where id_no = '$fetchCheckCart1[id_no]'";
                                    $query5 = @mysqli_query($connection, $getImage);
                                    $fetchImage = @mysqli_fetch_array($query5);
                            ?>
                                    <div class="col-lg-3 col-md-4 mb-3 mt-3">
                                        <center>
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($fetchImage['Image']); ?>" class="img-fluid" style="height: 17vw;"><br>
                                            <?php echo $fetchCheckCart1['Itemname']." ".$fetchCheckCart1['Size']; ?><br>
                                            <input type="hidden" value="<?php echo $fetchCheckCart1['id_no']; ?>" id="id<?php echo $in; ?>">
                                            <input type="hidden" value="<?php echo $fetchCheckCart1['Size']; ?>" id="size<?php echo $in; ?>">
                                            <?php
                                                if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
                                                {
                                                        
                                                }

                                                else
                                                {
                                            ?>
                                                    <input type="button"  class="btn" style="background-color: black; color: white;" value="(+)" id="increment<?php echo $in; ?>" data-id="<?php echo $fetchCheckCart1['id']; ?>" data-size="<?php echo $fetchCheckCart1['Size']; ?>">
                                            <?php
                                                }
                                            ?>
                                            
                                            <a id="qty<?php echo $in; ?>"><?php echo $fetchCheckCart1['Quantity']."x"; ?></a>
                                            <?php
                                                if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
                                                {
                                                        
                                                }

                                                else
                                                {
                                            ?>
                                                    <input type="button"   class="btn" style="background-color: black; color: white;" value="(-)" id="decrement<?php echo $in; ?>"><br>
                                            <?php
                                                }
                                            ?>
                                            
                                            <?php echo "P".$fetchCheckCart1['Price']; ?><br>
                                            <input type="hidden" value="<?php echo $fetchCheckCart1['Price']; ?>" id="price<?php echo $in; ?>">
                                            
                                            <div id="parent-div">
                                                <?php
                                                    if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
                                                    {
                                                        
                                                    }

                                                    else
                                                    {
                                                ?>
                                                        <input type="button" class="btn removebtn" style="background-color: black; color: white" value="REMOVE" data-toggle="modal" data-target="#confirmmodal1">
                                                <?php
                                                    }
                                                ?>
                                                <p id="child-input" style="display: none;"><?php echo $fetchCheckCart1['Itemname']; ?></p>
                                                <p id="child-input1" style="display: none;"><?php echo $fetchCheckCart1['id']; ?></p>
                                            </div>
                                        </center>
                                    </div>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                                    <script>
                                        $('#increment'+<?php echo $in; ?>+'').on('click', function(){
                                            var id = document.getElementById('id'+<?php echo $in; ?>+'').value;
                                            var size = document.getElementById('size'+<?php echo $in; ?>+'').value;
                                            var price = parseFloat(document.getElementById('price'+<?php echo $in; ?>+'').value);

                                            $.ajax(
                                            {
                                                type: 'post',
                                                url: 'sample2.php',
                                                data: { 
                                                    "id": id,
                                                    "size": size
                                                },
                                                
                                                success: function (response) {
                                                    var qty = parseFloat(document.getElementById('qty'+<?php echo $in; ?>+'').innerHTML);
                                                    qty = qty + 1;
                                                    document.getElementById('qty'+<?php echo $in; ?>+'').innerHTML = qty+"x";
                                                    document.getElementById('ex').value = parseFloat(document.getElementById('ex').value) + price;
                                                },
                                                error: function () {
                                                    alert("Error !!");
                                                }
                                            }
                                            );                                         
                                        });

                                        $('#decrement'+<?php echo $in; ?>+'').on('click', function(){
                                            var id = document.getElementById('id'+<?php echo $in; ?>+'').value;
                                            var size = document.getElementById('size'+<?php echo $in; ?>+'').value;
                                            var price = parseFloat(document.getElementById('price'+<?php echo $in; ?>+'').value);
                                            var qty = parseFloat(document.getElementById('qty'+<?php echo $in; ?>+'').innerHTML);

                                            $.ajax(
                                            {
                                                type: 'post',
                                                url: 'sample3.php',
                                                data: { 
                                                    "id": id,
                                                    "size": size,
                                                    "qty": qty
                                                },
                                                
                                                success: function (response) {
                                                    
                                                    if (qty == 1)
                                                    {
                                                        qty = qty;
                                                    }

                                                    else
                                                    {
                                                        qty = qty - 1;
                                                    }
                                                    
                                                    document.getElementById('qty'+<?php echo $in; ?>+'').innerHTML = qty+"x";
                                                    document.getElementById('ex').value = parseFloat(document.getElementById('ex').value) - price;
                                                },
                                                error: function () {
                                                    
                                                }
                                            }
                                            );                                         
                                        });                
                                    </script>
                            <?php
                                $in = $in + 1;
                                }
                            ?>
                        </div>
                        <div class="mt-3" id="total1">
                            <b>TOTAL PRICE</b>
                        </div>
                        <input type="text" readonly value="<?php echo $total_price; ?>" id="ex">
                    </div>
                </div>

                <form action="pay_no.php" method="post">
                <?php
                    if ($get_table['status'] == "In Ordering")
                    {
                ?>
                        <div class="mt-5">
                            Do you have a Loyalty Card?<br>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <select class="form-control" onchange="enable()" id="s" name="loyalty_card">
                                        <option value="Yes">YES</option>
                                        <option value="No" selected>NO</option>
                                    </select><br>
                                    <input type="number" class="form-control" id="mySelect" disabled required name="card_no">
                                </div>
                            </div>
                        </div>
                <?php
                    }
                ?>
                <script type="text/javascript">
                    function enable()
                    {
                        var obj = document.getElementById('s');
                        var txtObj = document.getElementById('mySelect');
                        var selValue = obj.options[obj.selectedIndex].value

                        if(selValue === "Yes"){
                            txtObj.disabled=false;
                            txtObj.style.backgroundColor = "";
                        }
                    
                        else if(selValue === "No"){
                            txtObj.disabled=true;
                            txtObj.style.backgroundColor = "#cccccc";
                            txtObj.value = "";
                        }
                    }
                </script>

                <div class="mt-3 mb-5 mt-5">
                    <?php
                        if ($get_table['status'] == "For Payment" || $get_table['status'] == "Order Processing" || $get_table['status'] == "Order Served")
                        {
                    ?>
                            <form action="pay_no.php" method="post">
                                <input type="submit" name="add" class="btn" style="background-color: black; color: white;" value="VIEW ORDER NO">        
                            </form>
                    <?php
                        }

                        else
                        {
                    ?>
                            <a href="" data-toggle="modal" data-target="#confirmmodal" class="btn" style="background-color: black; color: white;">PAY NOW AT THE COUNTER</a>
                    <?php
                        }
                    ?>
                    
                </div>
            </div>

            <div class="modal fade" id="confirmmodal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: black;">
                            <img src="/img/hv_logo.png" width="50">
                            <h4 class="modal-title ml-2" style="Color: white;">Confirmation</h4>
                            <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                        </div>
                                                                
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    Are you sure you want to pay now at the counter? 
                                </div>
                            </div>
                        </div>
                                                            
                        <div class="modal-footer">
                            <form action="pay_no.php" method="post">
                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="add" value="YES">
                                <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </form>
    <?php
        }
    ?>

    <div class="modal fade" id="confirmmodal1" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-header" style="background-color: black;">
                        <img src="/img/hv_logo.png" width="50">
                        <h4 class="modal-title ml-2" style="Color: white;">Confirmation</h4>
                        <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                    </div>
                                                            
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                Are you sure you want to remove <p id="categoryID1"></p>
                                <input type="hidden" name="id-no" id="categoryID2">
                            </div>
                        </div>
                    </div>
                                                        
                    <div class="modal-footer">  
                        <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="remove" value="YES">
                        <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.removebtn').on('click', function(){

                $tr1 = $(this).closest('#parent-div');

                var data1 = $tr1.children("#child-input").map(function () {
                    return $(this).text();
                }).get();

                var data2 = $tr1.children("#child-input1").map(function () {
                    return $(this).text();
                }).get();

                console.log(data1);
                console.log(data2);

                $('#categoryID1').text(data1[0]);
                $('#categoryID2').val(data2[0]);
            });
        });
    </script>

<?php require './headers_footers/admin_footer.php'; ?>