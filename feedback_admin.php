<?php
    session_start();

    $connection2 = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

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

        if (isset($_POST['select']) && $_POST['filter_sentiment'] == "all")
        {
            $select_feedback = "select* from tbl_feedback";
        }

        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "male")
        {
            $select_feedback = "select* from tbl_feedback where gender = 'Male'";
        }

        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "female")
        {
            $select_feedback = "select* from tbl_feedback where gender = 'Female'";
        }

        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "kid_15")
        {
            $select_feedback = "select* from tbl_feedback where age = 'age below 15 yrs old'";
        }

        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "teen_30")
        {
            $select_feedback = "select* from tbl_feedback where age = 'age 15 - 30 yrs old'";
        }

        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "31_old")
        {
            $select_feedback = "select* from tbl_feedback where age = 'age 31 and above'";
        }

        else
        {
            $select_feedback = "select* from tbl_feedback";
        }
        
        $query = @mysqli_query($connection2, $select_feedback);
        $happy = 0;
        $neutral = 0;
        $sad = 0;
        $total = 0;
        

        while ($get = @mysqli_fetch_array($query))
        {
            if ($get['rate'] == "Positive")
            {
                $happy = $happy + 1;
            }

            elseif ($get['rate'] == "Neutral")
            {
                $neutral = $neutral + 1;
            }

            elseif ($get['rate'] == "Negative")
            {
                $sad = $sad + 1;
            }

            $total = $total + 1;
        }

        if ($total == 0)
        {

        }

        else
        {
            $happy_percent = $happy/$total*100;
            $neutral_percent = $neutral/$total*100;
            $sad_percent = $sad/$total*100;
        }
        
?>
        <div class="container-fluid mt-5 ml-3">
            <center>
                <h3><b>FEEDBACK/SENTIMENTS ANALYSIS</b></h3>
            </center>
            <div class="mt-5">
                <form action="" method="post">
                    <select name="filter_sentiment">
                        <option <?php if(isset($_POST['select']) && $_POST['filter_sentiment'] == "all"){ ?> selected <?php } ?> value="all">ALL</option>
                        <option <?php if(isset($_POST['select']) && $_POST['filter_sentiment'] == "male"){ ?> selected <?php } ?> value="male">BY MALE</option>
                        <option <?php if(isset($_POST['select']) && $_POST['filter_sentiment'] == "female"){ ?> selected <?php } ?> value="female">BY FEMALE</option>
                        <option <?php if(isset($_POST['select']) && $_POST['filter_sentiment'] == "kid_15"){ ?> selected <?php } ?> value="kid_15">BY AGE BELOW 15 YRS OLD</option>
                        <option <?php if(isset($_POST['select']) && $_POST['filter_sentiment'] == "teen_30"){ ?> selected <?php } ?> value="teen_30">BY AGE 15-30 YRS OLD</option>
                        <option <?php if(isset($_POST['select']) && $_POST['filter_sentiment'] == "31_old"){ ?> selected <?php } ?> value="31_old">BY AGE ABOVE 30 YRS OLD</option>
                    </select><br>
                    <input type="submit" class="btn mt-1" style="background-color: black; color: white;" value="SELECT" name="select">
                </form>
                
                <div class="row">
                    <?php
                        if ($total == 0)
                        {
                    ?>
                            <br><br><br><br><br><br><br><br><br><br><br><br><br>
                            <center><h3>NO RECORDS</h3></center>
                    <?php
                        }

                        else
                        {
                    ?>
                            <div class="col-lg-4 mt-3">
                                <center>
                                    <img src="/img/happy.png" style="width: 40%;">
                                    <h5><?php echo $happy; ?>/<?php echo $total; ?> VERY SATISFIED<br><?php echo round($happy_percent, 2); ?>%
                                    </h5>
                                </center>
                            </div>
                            <div class="col-lg-4 mt-3">
                                <center>
                                    <img src="/img/neutral_new.png" style="width: 34%;">
                                    <br><br>
                                    <h5><?php echo $neutral; ?>/<?php echo $total; ?> SATISFIED<br><?php echo round($neutral_percent, 2); ?>%</h5>
                                </center>
                            </div>
                            <div class="col-lg-4 mt-3">
                                <center>
                                    <img src="/img/sad.png" style="width: 33%;">
                                    <br><br>
                                    <h5><?php echo $sad; ?>/<?php echo $total; ?> NOT SATISFIED<br><?php echo round($sad_percent, 2); ?>%</h5>
                                </center>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>

            <?php
                if ($total == 0)
                {

                }

                else
                {
            ?>
                    <div class="mt-5 mb-5">
                        <center>
                            <table class="admin-menu-table table table-striped">
                                <thead>
                                    <tr style="color: white; text-shadow: 1px 1px black; font-size: 1.8vw; text-align: center;">
                                        <th style="border: 1px solid white; background-color: black;" class="p-2">ID FEEDBACK NO.</th>
                                        <th style="border: 1px solid white; background-color: black;" class="p-2">AGE</th>
                                        <th style="border: 1px solid white; background-color: black;" class="p-2">GENDER</th>
                                        <th style="border: 1px solid white; background-color: black;" class="p-2">COMMENT</th>
                                        <th style="border: 1px solid white; background-color: black;" class="p-2">SENTIMENTS</th>
                                        <th style="border: 1px solid white; background-color: black;" class="p-2">DATE AND TIME</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($_POST['select']) && $_POST['filter_sentiment'] == "all")
                                        {
                                            $select_feedback_all = "select* from tbl_feedback order by id desc";
                                        }

                                        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "male")
                                        {
                                            $select_feedback_all = "select* from tbl_feedback where gender = 'Male' order by id desc";
                                        }

                                        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "female")
                                        {
                                            $select_feedback_all = "select* from tbl_feedback where gender = 'Female' order by id desc";
                                        }

                                        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "kid_15")
                                        {
                                            $select_feedback_all = "select* from tbl_feedback where age = 'age below 15 yrs old' order by id desc";
                                        }

                                        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "teen_30")
                                        {
                                            $select_feedback_all = "select* from tbl_feedback where age = 'age 15 - 30 yrs old' order by id desc";
                                        }

                                        elseif (isset($_POST['select']) && $_POST['filter_sentiment'] == "31_old")
                                        {
                                            $select_feedback_all = "select* from tbl_feedback where age = 'age 31 and above' order by id desc";
                                        }

                                        else
                                        {
                                            $select_feedback_all = "select* from tbl_feedback order by id desc";
                                        }

                                        $query1 = @mysqli_query($connection2, $select_feedback_all);

                                        while ($get1 = @mysqli_fetch_array($query1))
                                        {
                                            $newDate = date("F j, Y, g:i a", strtotime($get1['date_feedback']));
                                            
                                            if ($get1['rate'] == "Positive")
                                            {
                                                $rate = "Very Satisfied";
                                            }

                                            elseif ($get1['rate'] == "Negative")
                                            {
                                                $rate = "Not Satisfied";
                                            }

                                            elseif ($get1['rate'] == "Neutral")
                                            {
                                                $rate = "Satisfied";
                                            }
                                    ?>
                                            <tr style="color: black; font-size: 1.8vw;">
                                                <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get1['id']; ?></td>
                                                <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get1['age']; ?></td>
                                                <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get1['gender']; ?></td>
                                                <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get1['feedback']; ?></td>
                                                <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $rate; ?></td>
                                                <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $newDate; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </center>
                    </div>
            <?php
                }
            ?>
        </div>
<?php
        require './headers_footers/admin_footer.php';
    }
?>