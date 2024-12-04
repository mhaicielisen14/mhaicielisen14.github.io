<?php
    session_start();

    if (isset($_POST['verify']))
    {
        $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

        $username = $_POST['username'];

        $search_username = "select* from tbl_kitchen_login where Username = '$username'";
        $query1 = @mysqli_query($connection, $search_username);

        $get1 = @mysqli_fetch_array($query1);

        if ($get1['Username'] == "")
        {
            echo "<script>
                    alert('Username does not found');
            </script>";
        }

        else
        {
            if ($get1['sec_question'] != $_POST['sec_question'] || $get1['answer'] != $_POST['answer'])
            {
                echo "<script>
                    alert('Security Question and Answer does not match in your record');
                </script>";
            }

            else
            {
                if ($_POST['password99'] != $_POST['confirm_password'])
                {
                    echo "<script>
                            alert('Password did not match');
                    </script>";
                }

                else
                {
                    $pass_length = strlen($_POST['password99']);

                    if ($pass_length <= 7)
                    {
                        echo "<script>
                                alert('Password must be more than 7 characters');
                        </script>";
                    }

                    else
                    {
                        $update_pass = "update tbl_kitchen_login set Password = '$_POST[password99]' where Username = '$username'";
                        $query2 = @mysqli_query($connection, $update_pass);

                        if ($query2)
                        {
                            echo "<script>
                                    alert('Verification success and updated password');
                            </script>";
                        }
                    }
                }
            }
        }
    }

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

    if (isset($_SESSION['username2']))
    {
        if ($_SESSION['username2'] == "")
        {

        }

        else
        {
            header ("Location: kitchen.php");
        }
    }
?>

<?php require './headers_footers/admin_header.php'; ?>

<script>
    function myFunction1() {
        var x1 = document.getElementById("password99");
        var x2 = document.getElementById("confirm_password");
        if (x1.type === "password") 
        {
            x1.type = "text";
        } 
        else 
        {
            x1.type = "password";
        }

        if (x2.type === "password") 
        {
            x2.type = "text";
        } 
        else 
        {
            x2.type = "password";
        }
    }
</script>

<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") 
        {
            x.type = "text";
        } 
        else 
        {
            x.type = "password";
        }
    }
</script>

    <style>
    #intro {
      background: url("./img/hv_coffe_logo_1.png");
      background-repeat: no-repeat;
      height: 100%;
      background-size: cover;
      opacity: 1;
    }

    /* Height for devices larger than 576px */
    @media (min-width: 992px) {
      #intro {
        margin-top: -58.59px;
      }
    }

    .navbar .nav-link {
      color: #fff !important;
    }
  </style>


<div class="container-fluid p-0" style="margin-top: 0.1%;" id="intro">
    <div class="d-flex">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item ml-3 mr-3"> <a class="nav-link" href="login.php" style="color: black; text-shadow: 1px 1px white; font-size: 20px;"><u>Admin Log In</u></a></li>
        </ul>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 mt-5" id="intro2">
            <center>
            <h2><b>Log in as Kitchen</b></h2>
            </center>
            <div class="card mt-5 mb-5">

                <div class="card-body">
                    <form method="POST" action="" class="mt-5">
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">USERNAME</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" required autocomplete="username" autofocus>
                            </div>
                        </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">PASSWORD</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="showPassword" id="showPassword" onclick="myFunction()">
                                    <label class="form-check-label" for="remember">Show Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0 mt-5">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn form-control" style="background-color: black; color: white;" name="login">
                            LOGIN
                            </button>
                        </div>
                    </div>

                    <div class="mt-5 mb-2">
                        <a href="" data-toggle="modal" data-target="#forgotModal"><center>FORGOT PASSWORD</center></a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="forgotModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black; color: white;">
                        <img src="/img/hv_logo.png" width="50">
                        <h4 class="modal-title ml-2" id="modalTitle">FORGOT PASSWORD</h4>
                        <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                    </div>
                        
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">USERNAME</label>
                            <input type="text" required name="username" id="username"  class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="sec_question">SECURITY QUESTION</label>
                            <select name="sec_question" required class="form-control">
                                <option value="">Please select security question</option>
                                <option value="sec1">What city were you born in?</option>
                                <option value="sec2">What is your oldest sibling’s middle name?</option>
                                <option value="sec3">What was the first concert you attended?</option>
                                <option value="sec4">In what city or town did your parents meet?</option>
                                <option value="sec5">What was the name of your favorite childhood pet?</option>
                                <option value="sec6">What is your child’s nickname?</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="answer">ANSWER TO SECURITY QUESTION</label>
                            <input type="text" required name="answer" id="answer"  class="form-control">
                        </div>

                         <div class="form-group">
                            <label for="password">NEW PASSWORD</label>
                            <input type="password" required name="password99" id="password99"  class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">CONFIRM NEW PASSWORD</label>
                            <input type="password" required name="confirm_password" id="confirm_password" name="confirm_password" class="form-control">
                        </div>

                        <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="showPassword" id="showPassword" onclick="myFunction1()">
                                <label class="form-check-label" for="remember">Show Password</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="verify" value="VERIFY">
                        <input type="button" class="btn" style="background-color: black; color: white;" value="CLOSE" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>

<?php require './headers_footers/admin_footer.php'; ?>