<?php
    session_start();

    if (isset($_GET['id']) && isset($_GET['product_name']))
    {
        if ($_GET['id'] == "" || $_GET['product_name'] == "")
        {
            header("Location: update.php");
        }

        else
        {
            $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

            $id = $_GET['id'];
            $product_name = $_GET['product_name'];

            $selectProduct = "select* from tbl_item where id_no = '$id' and Itemname = '$product_name'";
            $query1 = @mysqli_query($connection, $selectProduct);
            
            $count = 0;

            while ($getCount = @mysqli_fetch_array($query1))
            {
                $count = $count + 1;
            }

            if ($count == 0)
            {
                header("Location: update.php");
            }

            else
            {
                $selectProduct1 = "select* from tbl_item where id_no = '$id' and Itemname = '$product_name'";
                $query2 = @mysqli_query($connection, $selectProduct1);
                $get = @mysqli_fetch_array($query2);
            }
        }
    }

    else 
    {
        header("Location: update.php");
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

    if (isset($_POST['logout']))
    {
        $_SESSION['username'] = "";
        $_SESSION['username2'] = "";
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

        <div class="container-fluid mt-2">
        <center><h5 class="mt-3" style="font-family: Arial Black; font-size: 20px;"><?php echo $get[1]; ?></h5></center>
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center p-5">
                    <?php if ($get['Image'] == "") { ?> <img id="profile-pic" src="/img/producct_icon.png"  class="img-fluid"> <?php } else { ?><img id="profile-pic" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($get['Image']); ?>" class="img-fluid"><?php } ?><br>
                </div>
            </div>
        </div>
    </div>      
<?php
        require './headers_footers/admin_footer.php';
    }
?>

