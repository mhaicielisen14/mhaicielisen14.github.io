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

        if (isset($_POST['update']))
        {
            $firstname = $_POST['firstname'];
            $middlename = $_POST['middlename'];
            $surname = $_POST['surname'];
            $password = $_POST['password'];

            $pass_length = strlen($password);

            if ($pass_length <= 7)
            {
                echo "<script>
                        alert('Password must be more than 7 characters');
                </script>";
            }

            else
            {
                $update = "update tbl_admin_login set Firstname = '$firstname', Middlename = '$middlename', Lastname = '$surname', Password = '$password' where Username = '$username'";
                $query1 = @mysqli_query($connection2, $update);

                if ($query1)
                {
                    echo "<script>
                        alert('Successfully updated admin user');
                    </script>";
                }
            }
        }

        require './headers_footers/admin_header2.php';

        $select_account = "select* from tbl_admin_login where Username = '$username'";
        $query = @mysqli_query($connection2, $select_account);
        $get_account = @mysqli_fetch_array($query);
?>        
        <div class="container-fluid mt-5 ml-3">
            <div class="row">
                <div class="col-lg-4">
                    <h3><b>Admin Profile</b></h3>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7 mt-5">
                    <div class="card mt-5 mb-5">
                        <div class="card-body" style="background-color: black;">
                            <form method="POST" action="">
                                <div class="form-group row">
                                    <label for="firstname" style="color: white;" class="col-md-4 col-form-label text-md-right">FIRSTNAME</label>
                                    <div class="col-md-6">
                                        <input id="firstname" type="text" value="<?php echo $get_account['Firstname']; ?>" class="form-control" name="firstname" required autocomplete="firstname" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="firstname" style="color: white;" class="col-md-4 col-form-label text-md-right">MIDDLE NAME</label>
                                    <div class="col-md-6">
                                        <input id="middlename" type="text" class="form-control" value="<?php echo $get_account['Middlename']; ?>" name="middlename" required autocomplete="middlename" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="surname" style="color: white;" class="col-md-4 col-form-label text-md-right">SURNAME</label>
                                    <div class="col-md-6">
                                        <input id="surname" type="text" value="<?php echo $get_account['Lastname']; ?>" class="form-control" name="surname" required autocomplete="surname" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" style="color: white;" class="col-md-4 col-form-label text-md-right">PASSWORD</label>
                                    <div class="col-md-6">
                                        <input id="password1" type="password" value="<?php echo $get_account['Password']; ?>" class="form-control" name="password" required autocomplete="current-password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="showPassword" id="showPassword" onclick="myFunction1()">
                                                <label class="form-check-label" style="color: white;" for="remember">Show Password</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="button" data-toggle="modal" data-target="#confirmModal1" data-dismiss="modal" class="btn form-control" style="background-color: white; color: black;">
                                        UPDATE
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
                                                    Are you sure you want to update this Admin user?
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn" style="background-color: black; color: white;" name="update" value="YES">
                                                <input type="button" class="btn border border-dark" style="background-color: white; color: black;" value="NO" data-dismiss="modal">
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

        <script>
            function myFunction1() {
                var x = document.getElementById("password1");
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

<?php
        require './headers_footers/admin_footer.php';
    }
?>