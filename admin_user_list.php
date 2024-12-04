<?php
    session_start();

    $connection2 = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

    if (isset($_POST['delete']))
    {
        $id = $_POST['id'];

        $delete = "delete from tbl_admin_login where id_no = '$id'";
        $query = @mysqli_query($connection2, $delete);

        if ($query)
        {
            echo "<script>
                    alert('Successfully Deleted Admin User');
                    window.location.href = 'admin_user_list.php';
            </script>";
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

?>
        <div class="container-fluid mt-5 ml-3">
        <div class="mt-4">
            <a href="admin_user_list.php" class="btn" style="background-color: black; color: white;">ADMIN USER LIST</a>
            <a href="kitchen_user_list.php" class="btn" style="background-color: black; color: white;">KITCHEN USER LIST</a>
        </div>
            <center>
                <h3 class="mt-5"><b>ADMIN USER LIST</b></h3>

                <div class="mt-5 mb-5">
                    <table class="admin-menu-table">
                        <thead>
                            <tr style="color: white; background-color: black; text-shadow: 1px 1px white; font-size: 1.8vw; text-align: center;">
                                <th style="border: 1px solid white;" class="p-2">ID NO</th>
                                <th style="border: 1px solid white;" class="p-2">FIRSTNAME</th>
                                <th style="border: 1px solid white;" class="p-2">MIDDLE NAME</th>
                                <th style="border: 1px solid white;" class="p-2">SURNAME</th>
                                <th style="border: 1px solid white;" class="p-2">USERNAME</th>
                                <th colspan="2" style="border: 1px solid white;" class="p-2">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $selectitem = "select* from tbl_admin_login";
                                $query1 = @mysqli_query($connection2, $selectitem);

                                while ($get = @mysqli_fetch_array($query1))
                                {
                            ?>
                                    <tr style="color: black; font-size: 1.8vw;">
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['id_no']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Firstname']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Middlename']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Lastname']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Username']; ?></td>
                                        <td style="border: 1px solid black;" class="p-1 text-center"><form action="edit_profile.php?id=<?php echo $get['id_no']; ?>" method="post"><input type="submit" class="btn btn-sm border border-dark" style="font-size: 1.5vw; color: black; background-color: white;" value="EDIT"></form></td>
                                <td style="border: 1px solid black;" class="p-1 text-center"><input type="button" style="font-size: 1.5vw; color: white; background-color: black;" class="btn btn-sm deletebtn" data-toggle="modal" data-target="#deletemodal" value="DELETE"></td>
                                    </tr>
                            <?php    
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </center>
        </div>

    <div class="modal fade" id="deletemodal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form action="" method="post">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <img src="/img/hv_logo.png" width="50">
                        <h4 class="modal-title ml-2" style="Color: white;">Delete Admin User</h4>
                        <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                    </div>
                                        
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                Are you sure you want to delete Admin User Id No <p id="categoryID1"></p>
                                <input type="hidden" name="id" id="categoryID2">
                            </div>
                        </div>
                    </div>
                                    
                    <div class="modal-footer">
                        <input type="submit" class="btn" style="background-color: black; color: white;" name="delete" value="YES">
                        <input type="button" class="btn border border-dark" style="background-color: white; color: black;" value="NO" data-dismiss="modal">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        var loadFile = function(event) {
	        var image = document.getElementById('profile-pic');
	        image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>

    <script>
        $(document).ready(function () {
            $('.deletebtn').on('click', function(){

                $tr1 = $(this).closest('tr');

                var data1 = $tr1.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data1);

                $('#categoryID1').text(data1[0]);
                $('#categoryID2').val(data1[0]);
            });
        });
    </script>

<?php
        require './headers_footers/admin_footer.php';
    }
?>