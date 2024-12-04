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
    }

    else
    {
        header ("Location: login.php");
    }
    

    include('vendor/autoload.php');
    Use Sentiment\Analyzer;
    
    $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

    if (isset($_POST['submit_feedback']))
    {   
        $analyzer = new Analyzer();

        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $table_no_f = $_POST['table_no_f'];
        $comment = $_POST['comment'];

        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d H:i:s');
        $month_now = date('F');

        $ouput_text = $analyzer->getSentiment($comment);

        $negative = $ouput_text['neg'];
        $positive = $ouput_text['pos'];
        $neutal = $ouput_text['neu'];

        if ($negative > $neutal && $negative > $positive)
        {
            $rate = "Negative";
        }

        elseif ($positive > $neutal && $positive > $negative)
        {
            $rate = "Positive";
        }

        elseif ($neutal > $negative && $neutal > $positive)
        {
            $rate = "Neutral";
        }

        $insert_feedback = "insert into tbl_feedback (age, gender, table_no, feedback, rate, date_feedback, Month) values ('$age', '$gender', '$table_no_f', '$comment', '$rate', '$date_now', '$month_now')";
        $query = @mysqli_query($connection, $insert_feedback);

        $update_status = "update tbl_tables set status = 'Vacant', order_no = '0', filtered = '0' where table_no = '$table'";
        $query1 = @mysqli_query($connection, $update_status);

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

        if ($query && $query1 && $query2)
        {
            unset($_SESSION['table']);
            echo "<script>
                    alert('Thank you for your feedback!');
                    location.href = 'feedback_end.php';
            </script>";
        }
    }
?>

<?php require './headers_footers/header.php'; ?>

<div class="container-fluid mt-5 ml-3">
    <div class="row">
        <div class="col-lg-4">
            <h3><b>Customer Feedback Form</b></h3>
        </div>
    </div>
            
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 mt-5">
            <div class="card mt-5 mb-5">
                <div class="card-body" style="background-color: black;">
                    <form method="POST" action="">
                        <div class="form-group row">
                            <label for="firstname" style="color: white;" class="col-md-4 col-form-label text-md-right">AGE</label>
                            <div class="col-md-6">
                                <select class="form-control" name="age" required autocomplete="age" autofocus>
                                    <option value="age below 15 yrs old">Age below 15 yrs old</option>
                                    <option value="age 15 - 30 yrs old">Age 15-30 yrs old</option>
                                    <option value="age 31 and above">Age 31 and above</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" style="color: white;" class="col-md-4 col-form-label text-md-right">GENDER</label>
                                <div class="col-md-6">
                                        <select class="form-control" required name="gender">
                                            <option value="Male" selected>Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                        <?php
                            if (isset($_SESSION['table']))
                            {
                        ?>
                                <div class="form-group row">
                                    <label for="firstname" style="color: white;" class="col-md-4 col-form-label text-md-right">TABLE NO.</label>
                                    <div class="col-md-6">
                                        <select class="form-control" required name="table_no_f">
                                            <option value="<?php echo $_SESSION['table'] ?>" selected>TABLE NO. <?php echo $_SESSION['table'] ?></option>
                                        </select>
                                    </div>
                                </div>        
                        <?php
                            }

                            else
                            {
                        ?>
                                <div class="form-group row">
                                    <label for="firstname" style="color: white;" class="col-md-4 col-form-label text-md-right">TABLE NO.</label>
                                    <div class="col-md-6">
                                        <select class="form-control" required name="table_no_f">
                                            <option value="1" selected>TABLE NO. 1</option>
                                            <option value="2">TABLE NO. 2</option>
                                            <option value="3">TABLE NO. 3</option>
                                            <option value="4">TABLE NO. 4</option>
                                            <option value="5">TABLE NO. 5</option>
                                            <option value="6">TABLE NO. 6</option>
                                        </select>
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                        <div class="form-group row">
                            <label for="firstname" style="color: white;" class="col-md-4 col-form-label text-md-right">FEEDBACK/COMMENTS REGARDING FOOD & SERVICES OF THE COFFEE SHOP</label>
                            <div class="col-md-6">
                                <textarea rows="5" class="form-control" required name="comment"></textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" data-toggle="modal" data-target="#confirmModal1" data-dismiss="modal" class="btn form-control" style="background-color: white; color: black;">
                                    SUBMIT
                                </button>
                            </div>
                        </div>

                        <div class="modal fade" id="confirmModal1" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: black; color: white;">
                                        <img src="/img/hv_logo.png" width="50">
                                        <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                                        <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                                    </div>
                                                
                                    <div class="modal-body">
                                        <div class="form-group">
                                            Submit this feedback?
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="submit_feedback" value="YES">
                                        <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>            
                </div>
            </div>
        </div>
    </div>

<?php require './headers_footers/admin_footer.php'; ?>