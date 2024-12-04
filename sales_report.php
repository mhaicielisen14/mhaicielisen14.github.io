<?php
    session_start();

    if (isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

        $select = "select* from tbl_kitchen_login";
        $query = @mysqli_query($connection, $select);

        while ($get = @mysqli_fetch_array($query))
        {
            if ($get['Username'] == $username && $get['Password'] == $password)
            {                
                $_SESSION['username2'] = $get['Username'];
                header ("Location: kitchen.php");
            }
        }

        echo "<script>
                    alert('Incorrect Username or Password');
        </script>";
    }

    if (isset($_POST['register']))
    {
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if ($firstname == "" || $surname == "" || $username == "" || $password == "" || $password2 == "")
        {
            echo "<script>
                    alert('Firstname, Surname, Username and Password must be filled up');
            </script>";
        }

        else
        {
            if ($password != $password2)
            {
                echo "<script>
                    alert('Password did not match');
                </script>";
            }

            else
            {
                $pass_length = strlen($password);
                
                if ($pass_length <= 7)
                {
                    echo "<script>
                            alert('Password must be more than 7 characters');
                    </script>";
                }

                else
                {
                    $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

                    $insert = "insert into tbl_kitchen_login (Firstname, Middlename, Surname, Username, Password) values ('$firstname', '$middlename', '$surname', '$username', '$password')";
                    $query = @mysqli_query($connection, $insert);

                    if ($query)
                    {
                        echo "<script>
                            alert('Successfully Registered');
                        </script>";
                    }
                }
            }
        }
    }

    if (isset($_POST['logout']))
    {
        $_SESSION['username'] = "";
    }

    $username = $_SESSION['username'];

    if ($username == "")
    {
        header("Location: login.php");
    }

    else
    {
        require './headers_footers/admin_header2.php';

        date_default_timezone_set('Asia/Manila');
        $year_now = date("Y");
        $month_now = date("F");

        $january_count = 0;
        $february_count = 0;
        $march_count = 0;
        $april_count = 0;
        $may_count = 0;
        $june_count = 0;
        $july_count = 0;
        $august_count = 0;
        $september_count = 0;
        $october_count = 0;
        $november_count = 0;
        $december_count = 0;

        $january_price = 0;
        $february_price = 0;
        $march_price = 0;
        $april_price = 0;
        $may_price = 0;
        $june_price = 0;
        $july_price = 0;
        $august_price = 0;
        $september_price = 0;
        $october_price = 0;
        $november_price = 0;
        $december_price = 0;



        $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

        if (isset($_POST['select']))
        {
            $select_1 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'January'";
        }

        else
        {
            $select_1 = "select* from tbl_order where Year = '$year_now' and Month = 'January'";
        }
        
        $query_1 = @mysqli_query($connection, $select_1);

        while ($get_1 = @mysqli_fetch_array($query_1))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_1['order_no'])
                {
                    $january_count = $january_count + 1;
                }

                else
                {
                    $january_count = $january_count;
                }
            }

            else
            {
                $january_count = $january_count + 1;
            }
            
            $january_price = $january_price + $get_1['Total_Price'];

            $order_no = $get_1['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_2 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'February'";
        }

        else
        {
            $select_2 = "select* from tbl_order where Year = '$year_now' and Month = 'February'";
        }

        $query_2 = @mysqli_query($connection, $select_2);

        while ($get_2 = @mysqli_fetch_array($query_2))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_2['order_no'])
                {
                    $february_count = $february_count + 1;
                }

                else
                {
                    $february_count = $february_count;
                }
            }

            else
            {
                $february_count = $february_count + 1;
            }
            
            $february_price = $february_price + $get_2['Total_Price'];

            $order_no = $get_2['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_3 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'March'";
        }

        else
        {
            $select_3 = "select* from tbl_order where Year = '$year_now' and Month = 'March'";
        }

        $query_3 = @mysqli_query($connection, $select_3);

        while ($get_3 = @mysqli_fetch_array($query_3))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_3['order_no'])
                {
                    $march_count = $march_count + 1;
                }

                else
                {
                    $march_count = $march_count;
                }
            }

            else
            {
                $march_count = $march_count + 1;
            }
            
            $march_price = $march_price + $get_3['Total_Price'];

            $order_no = $get_3['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_4 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'April'";
        }

        else
        {
            $select_4 = "select* from tbl_order where Year = '$year_now' and Month = 'April'";
        }

        $query_4 = @mysqli_query($connection, $select_4);

        while ($get_4 = @mysqli_fetch_array($query_4))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_4['order_no'])
                {
                    $april_count = $april_count + 1;
                }

                else
                {
                    $april_count = $april_count;
                }
            }

            else
            {
                $april_count = $april_count + 1;
            }
            
            $april_price = $april_price + $get_4['Total_Price'];

            $order_no = $get_4['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_5 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'April'";
        }

        else
        {
            $select_5 = "select* from tbl_order where Year = '$year_now' and Month = 'April'";
        }

        $query_5 = @mysqli_query($connection, $select_5);

        while ($get_5 = @mysqli_fetch_array($query_5))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_5['order_no'])
                {
                    $may_count = $may_count + 1;
                }

                else
                {
                    $may_count = $may_count;
                }
            }

            else
            {
                $may_count = $may_count + 1;
            }
            
            $may_price = $may_price + $get_5['Total_Price'];

            $order_no = $get_5['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_6 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'June'";
        }

        else
        {
            $select_6 = "select* from tbl_order where Year = '$year_now' and Month = 'June'";
        }

        $query_6 = @mysqli_query($connection, $select_6);

        while ($get_6 = @mysqli_fetch_array($query_6))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_6['order_no'])
                {
                    $june_count = $june_count + 1;
                }

                else
                {
                    $june_count = $june_count;
                }
            }

            else
            {
                $june_count = $june_count + 1;
            }
            
            $june_price = $june_price + $get_6['Total_Price'];

            $order_no = $get_6['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_7 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'July'";
        }

        else
        {
            $select_7 = "select* from tbl_order where Year = '$year_now' and Month = 'July'";
        }

        $query_7 = @mysqli_query($connection, $select_7);

        while ($get_7 = @mysqli_fetch_array($query_7))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_7['order_no'])
                {
                    $july_count = $july_count + 1;
                }

                else
                {
                    $july_count = $july_count;
                }
            }

            else
            {
                $july_count = $july_count + 1;
            }
            
            $july_price = $july_price + $get_7['Total_Price'];

            $order_no = $get_7['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_8 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'August'";
        }

        else
        {
            $select_8 = "select* from tbl_order where Year = '$year_now' and Month = 'August'";
        }

        $query_8 = @mysqli_query($connection, $select_8);

        while ($get_8 = @mysqli_fetch_array($query_8))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_8['order_no'])
                {
                    $august_count = $august_count + 1;
                }

                else
                {
                    $august_count = $august_count;
                }
            }

            else
            {
                $august_count = $august_count + 1;
            }
            
            $august_price = $august_price + $get_8['Total_Price'];

            $order_no = $get_8['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_9 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'September'";
        }

        else
        {
            $select_9 = "select* from tbl_order where Year = '$year_now' and Month = 'September'";
        }

        $query_9 = @mysqli_query($connection, $select_9);

        while ($get_9 = @mysqli_fetch_array($query_9))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_9['order_no'])
                {
                    $september_count = $september_count + 1;
                }

                else
                {
                    $september_count = $september_count;
                }
            }

            else
            {
                $september_count = $september_count + 1;
            }
            
            $september_price = $september_price + $get_9['Total_Price'];

            $order_no = $get_9['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_10 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'October'";
        }

        else
        {
            $select_10 = "select* from tbl_order where Year = '$year_now' and Month = 'October'";
        }

        $query_10 = @mysqli_query($connection, $select_10);

        while ($get_10 = @mysqli_fetch_array($query_10))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_10['order_no'])
                {
                    $october_count = $october_count + 1;
                }

                else
                {
                    $october_count = $october_count;
                }
            }

            else
            {
                $october_count = $october_count + 1;
            }
            
            $october_price = $october_price + $get_10['Total_Price'];

            $order_no = $get_10['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_11 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'November'";
        }

        else
        {
            $select_11 = "select* from tbl_order where Year = '$year_now' and Month = 'November'";
        }

        $query_11 = @mysqli_query($connection, $select_11);

        while ($get_11 = @mysqli_fetch_array($query_11))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_11['order_no'])
                {
                    $november_count = $november_count + 1;
                }

                else
                {
                    $november_count = $november_count;
                }
            }

            else
            {
                $november_count = $november_count + 1;
            }
            
            $november_price = $november_price + $get_11['Total_Price'];

            $order_no = $get_11['order_no'];
        }

        if (isset($_POST['select']))
        {
            $select_12 = "select* from tbl_order where Year = '$_POST[year]' and Month = 'December'";
        }

        else
        {
            $select_12 = "select* from tbl_order where Year = '$year_now' and Month = 'December'";
        }

        $query_12 = @mysqli_query($connection, $select_12);

        while ($get_12 = @mysqli_fetch_array($query_12))
        {
            if (isset($order_no))
            {
                if ($order_no != $get_12['order_no'])
                {
                    $december_count = $december_count + 1;
                }

                else
                {
                    $december_count = $december_count;
                }
            }

            else
            {
                $december_count = $december_count + 1;
            }
            
            $december_price = $december_price + $get_12['Total_Price'];

            $order_no = $get_12['order_no'];
        }

        $total = $january_count + $february_count + $march_count + $april_count + $may_count + $june_count + $july_count + $august_count + $september_count + $october_count + $november_count + $december_count;

        if ($total > 0)
        {
            $january_count = $january_count / $total * 100;
            $february_count = $february_count / $total * 100;
            $march_count = $march_count / $total * 100;
            $april_count = $april_count / $total * 100;
            $may_count = $may_count / $total * 100;
            $june_count = $june_count / $total * 100;
            $july_count = $july_count / $total * 100;
            $august_count = $august_count / $total * 100;
            $september_count = $september_count / $total * 100;
            $october_count = $october_count / $total * 100;
            $november_count = $november_count / $total * 100;
            $december_count = $december_count / $total * 100;

            $dataPoints = array( 
            array("label"=>"January", "y"=>$january_count),
            array("label"=>"February", "y"=>$february_count),
            array("label"=>"March", "y"=>$march_count),
            array("label"=>"April", "y"=>$april_count),
            array("label"=>"May", "y"=>$may_count),
            array("label"=>"June", "y"=>$june_count),
            array("label"=>"July", "y"=>$july_count),
            array("label"=>"August", "y"=>$august_count),
            array("label"=>"September", "y"=>$september_count),
            array("label"=>"October", "y"=>$october_count),
            array("label"=>"November", "y"=>$november_count),
            array("label"=>"December", "y"=>$december_count)
            );

            $dataPoints2 = array(
                array("y" => $january_price, "label" => "January"),
                array("y" => $february_price, "label" => "February"),
                array("y" => $march_price, "label" => "March"),
                array("y" => $april_price, "label" => "April"),
                array("y" => $may_price, "label" => "May"),
                array("y" => $june_price, "label" => "June"),
                array("y" => $july_price, "label" => "July"),
                array("y" => $august_price, "label" => "August"),
                array("y" => $september_price, "label" => "September"),
                array("y" => $october_price, "label" => "October"),
                array("y" => $november_price, "label" => "November"),
                array("y" => $december_price, "label" => "December")
            );
        }
?>
        
        <?php 
            $target_past = $year_now - 5;
        ?>
        
        <div class="mt-5 ml-5">
            <form action="" method="post">
                <select required name="year">
                    <option value="">SELECT YEAR</option>
                    <?php
                        while ($year_now >= $target_past)
                        {
                    ?>
                            <option value="<?php echo $target_past; ?>" <?php if($_POST['year'] == $target_past){ ?> selected <?php } ?>><?php echo $target_past; ?></option>
                    <?php
                            $target_past++;
                        }
                    ?>
                </select><br>
                <input type="submit" class="btn mt-1" style="background-color: black; color: white;" value="SELECT" name="select">
            </form>
        </div>
        
        <div class="mt-5">
            <?php
                if (isset($_POST['select']))
                {
            ?>
                    <center><h3>YEAR <?php echo $_POST['year']; ?><br>SALES REPORT</h3></center>
            <?php
                }

                else
                {
            ?>
                    <center><h3><?php echo $month_now; ?> <?php echo $year_now; ?><br>SALES REPORT</h3></center>
            <?php
                }
            ?>

            <div class="row mt-5">
                <?php
                    $total_check = $january_count + $february_count + $march_count + $april_count + $may_count + $june_count + $july_count + $august_count + $september_count + $october_count + $november_count + $december_count;

                    if ($total_check == 0)
                    {
                ?>
                        <br><br><br><br><br><br><br><br><br>
                        <center>NO RECORD FOR THIS YEAR</center>
                <?php
                    }

                    else
                    {
                ?>
                        <script>
                            window.onload = function() {
                            
                            var chart = new CanvasJS.Chart("chartContainer", {
                                animationEnabled: true,
                                title: {
                                    text: "Monthly Sales Report"
                                },
                                subtitles: [{
                                    text: "Year <?php if(isset($_POST['year'])){ echo $_POST['year']; } else{ echo $year_now; } ?>"
                                }],
                                data: [{
                                    type: "pie",
                                    yValueFormatString: "#,##0.00\"%\"",
                                    indexLabel: "{label} ({y})",
                                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart.render();
                                        
                            var chart2 = new CanvasJS.Chart("chartContainer1", {
                                title: {
                                    text: "Monthly Financial Sales Report"
                                },
                                axisY: {
                                    title: "Year <?php echo $year_now; ?>"
                                },
                                data: [{
                                    type: "line",
                                    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart2.render();            
                            }
                        </script>
                        
                        <div class="col-lg-6 mt-5">
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                        </div>

                        <div class="col-lg-6 mt-5">
                            <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                        </div>
                <?php        
                    }
                ?>
            </div>
        </div>
<?php
        require './headers_footers/admin_footer.php';
    }
?>

