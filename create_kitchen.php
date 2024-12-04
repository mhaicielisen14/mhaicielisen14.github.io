<?php
    session_start();

    if (isset($_POST['logout']))
    {
        $_SESSION['username'] = "";
    }

    $username = $_SESSION['username'];

    if ($username == "")
    {
        header("Location: login.php");
    }

    if (isset($_POST['create']))
    {
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $sec_question = $_POST['sec_question'];
        $answer = $_POST['sec_question_answer'];

        if (ctype_space($username) || ctype_space($firstname) || ctype_space($surname))
        {
            echo "<script>
                    alert('Blank username, firstname, surname is invalid');
            </script>";
        }

        else
        {
            if ($password != $confirm_password)
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

                    $check_username = "select* from tbl_kitchen_login where Username = '$username'";
                    $query1 = @mysqli_query($connection, $check_username);
                    $check = 0;
                    while ($get = @mysqli_fetch_array($query1))
                    {
                        $check = $check + 1;
                    }

                    if ($check == 0)
                    {
                        $create = "insert into tbl_kitchen_login (Firstname, Middlename, Surname, Username, Password, sec_question, answer) values ('$firstname', '$middlename', '$surname', '$username', '$password', '$sec_question', '$answer')";
                        $query = @mysqli_query($connection, $create);

                        if ($query)
                        {
                            echo "<script>
                                alert('Successfully Created Account');
                                location.href = 'kitchen_user_list.php';
                            </script>";
                        }
                    }

                    else
                    {
                        echo "<script>
                            alert('duplicate username');
                        </script>";
                    }   
                }
            }    
        }
        
    }    
?>

<?php require './headers_footers/admin_header2.php'; ?>

<script>
    function myFunction() {
        var x = document.getElementById("password1");
        var x1 = document.getElementById("confirm_password")
        if (x.type === "password") 
        {
            x.type = "text";
        } 
        else 
        {
            x.type = "password";
        }

        if (x1.type === "password") 
        {
            x1.type = "text";
        } 
        else 
        {
            x1.type = "password";
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
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 mt-5" id="intro2">
            <center>
            <h2><b>Create Account Kitchen</b></h2>
            </center>
            <div class="card mt-5 mb-5">

                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">FIRSTNAME</label>
                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" required autocomplete="firstname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">MIDDLE NAME</label>
                            <div class="col-md-6">
                                <input id="middlename" type="text" class="form-control" name="middlename" required autocomplete="middlename" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">SURNAME</label>
                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control" name="surname" required autocomplete="surname" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">USERNAME</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" required autocomplete="username" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">PASSWORD</label>
                            <div class="col-md-6">
                                <input id="password1" type="password" class="form-control" name="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">CONFIRM PASSWORD</label>
                            <div class="col-md-6">
                                <input id="confirm_password" type="password" class="form-control" name="confirm_password" required autocomplete="current-password">
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

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">SECURTY QUESTION</label>
                            <div class="col-md-6">
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
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">ANSWER TO YOUR SECURITY QUESTION</label>
                            <div class="col-md-6">
                                <input id="password" type="text" class="form-control" name="sec_question_answer" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" data-toggle="modal" data-target="#confirmModal_kitchen" data-dismiss="modal" class="btn form-control" style="background-color: black; color: white;">
                                CREATE
                                </button>
                            </div>
                        </div>
                        <div class="form-group row mt-5">
                            <div class="col-md-6 offset-md-4">
                                <a class="nav-link" href="kitchen_login.php" style="color: black;"><u>Log In an Account</u></a>
                            </div>
                        </div>

                        <div class="modal fade" id="confirmModal_kitchen" role="dialog">
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
                                            Are you sure you want to add this Kitchen user?
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="create" value="YES">
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
</div>

<?php require './headers_footers/admin_footer.php'; ?>