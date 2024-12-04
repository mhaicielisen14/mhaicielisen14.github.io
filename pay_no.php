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
                    location.href = 'login.php';
                </script>";
            }
        }

        if (empty($_POST['add']))
        {
            header ("Location: menu.php");    
        }

        else
        {
            if (isset($_SESSION['order_no']))
            {
                $count = $_SESSION['order_no'];
            }

            else
            {
                $check_customer_no = "select* from tbl_customer_count";
                $query8 = @mysqli_query($connection, $check_customer_no);
                $get_customer_no = @mysqli_fetch_array($query8);

                if ($_POST['loyalty_card'] == "Yes")
                {
                    if ($_POST['card_no'] > $get_customer_no['customer_no'])
                    {
                        echo "<script>
                                alert('Invalid Customer No.');
                                location.href = 'order.php';
                        </script>";
                    }

                    else
                    {
                        $update_status = "update tbl_tables set status = 'For Payment', customer_no = '$_POST[card_no]' where table_no = '$table'";
                    }

                    $no = $get_customer_no['customer_no'];
                }

                else
                {
                    $no = $get_customer_no['customer_no'] + 1;

                    $update_status = "update tbl_tables set status = 'For Payment', customer_no = '$no' where table_no = '$table'";
                }
                
                $query2 = @mysqli_query($connection, $update_status);

                $update_cus_no = "update tbl_customer_count set customer_no = '$no' where 1";
                $query9 = @mysqli_query($connection, $update_cus_no);

                if (!$query2 || !$query9)
                {
                    echo "<script>
                        alert('Error in Paying');
                        location.href = 'order.php';
                    </script>";
                }

                else
                {
                    $select_count = "select* from tbl_order_count";
                    $query3 = @mysqli_query($connection, $select_count);
                    $fetch_count = @mysqli_fetch_array($query3);

                    date_default_timezone_set('Asia/Manila');
                    $date_now = date("Y-m-d");

                    if ($fetch_count['date'] != $date_now )
                    {
                        $count = 0 + 1;    
                        $update_count = "update tbl_order_count set order_count = '$count', date = '$date_now' where 1";
                    }

                    else
                    {
                        $count = $fetch_count[0] + 1;
                        $update_count = "update tbl_order_count set order_count = '$count' where 1";
                    }

                    

                    
                    $query6 = @mysqli_query($connection, $update_count);

                    $update_table = "update tbl_tables set order_no = '$count' where table_no = '$table'";
                    $query7 = @mysqli_query($connection, $update_table);



                    if ($query6 && $query7)
                    {
                        $_SESSION['order_no'] = $count;
                    }
                }
            }
        }
    }

    else
    {
        header ("Location: login.php");
    }
?>
<?php require './headers_footers/header.php'; ?>

<body onload="table();">
    <div class="p-5">
        <center>
            <h1>ORDER NO</h1>
            <p style="font-size: 140px;"><?php echo $count; ?></p><br>
            <div id="table"></div>
        </center>
    </div>
</body>

<script>
    function table(){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
            document.getElementById("table").innerHTML = this.responseText;
        }
        xhttp.open("GET", "system.php");
        xhttp.send();
    }

    setInterval(function(){
        table();
    }, 1);
</script>



<?php require './headers_footers/footer.php'; ?>
