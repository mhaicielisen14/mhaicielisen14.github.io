<?php
    session_start();

    $connection2 = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

    if (isset($_POST['edit']))
    {
        $id = $_GET['id'];
        $itemname = $_POST['itemname'];
        $category = $_POST['category'];
        $price_grande = $_POST['price_grande'];
        $price_venti = $_POST['price_venti'];
        $description = $_POST['description'];

        if ($itemname == "" || $category == "" || $price_grande < 1 || $price_venti < 1)
        {
            echo "<script>
                    alert('Please fill up item name, category and the price of the item');
            </script>";    
        }

        else
        {
            if (!empty($_FILES["image"]["name"])) 
            {
                $fileName = basename($_FILES["image"]["name"]); 
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                $allowTypes = array('jpg','png','jpeg','gif');

                if (in_array($fileType, $allowTypes))
                {
                    $image = $_FILES['image']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($image));

                    $update = "update tbl_item set Itemname = '$itemname', Category = '$category', Price_Grande = '$price_grande', Price_Venti = '$price_venti', Image = '$imgContent', Description = '$description' where id_no = '$id'";
                    $query99 = @mysqli_query($connection2, $update);

                    if ($query99)
                    {
                        echo "<script>
                            alert('Successfully EditingItem');
                            window.location.href = 'update.php';
                        </script>"; 
                    }

                    else
                    {
                        echo "<script>
                            alert('Error Editing Item');   
                            window.location.href = 'update.php'; 
                        </script>";
                    }
                }
            }

            else
            {
                $update = "update tbl_item set Itemname = '$itemname', Category = '$category', Price_Grande = '$price_grande', Price_Venti = '$price_venti', Description = '$description' where id_no = '$id'";
                $query99 = @mysqli_query($connection2, $update);

                if ($query99)
                {
                    echo "<script>
                        alert('Successfully EditingItem');
                        window.location.href = 'update.php';
                    </script>"; 
                }

                else
                {
                    echo "<script>
                        alert('Error Editing Item');   
                        window.location.href = 'update.php'; 
                    </script>";
                }    
            }
        }
    }

    if (isset($_GET['id']))
    {
        $id = $_GET['id'];

        if ($id == "")
        {
            header("Location: update.php");    
        }

        else
        {
            $filter = "select* from tbl_item where id_no = '$id'";
            $query1 = @mysqli_query($connection2, $filter);

            $count = 0;
            while ($get1 = @mysqli_fetch_array($query1))
            {
                $count = $count + 1;
            }

            if ($count > 0)
            {
                $filter2 = "select* from tbl_item where id_no = '$id'";
                $query2 = @mysqli_query($connection2, $filter);

                $get2 = @mysqli_fetch_array($query2);
            }

            else
            {
                header("Location: update.php");
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
        <div class="container mt-5 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black; color: white;">
                        <img src="/img/hv_logo.png" width="50">
                        <h4 class="modal-title ml-2" id="modalTitle">EDIT ITEM</h4>
                    </div>
                        
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">ITEM NAME</label>
                            <input type="text" name="itemname" id="itemname" value="<?php echo $get2['Itemname']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username">CATEGORY</label>
                            <select id="inputState" name="category" class="form-control">
                                <option disabled selected>CHOOSE CATEGORY</option>
                                <option value="Coffee" <?php if($get2['Category'] == "Coffee"){?> selected <?php } else{ } ?>>COFFEE</option>
                                <option value="Iced Coffee" <?php if($get2['Category'] == "Iced Coffee"){?> selected <?php } else{ } ?>>ICED COFFEE</option>
                                <option value="Frosted Hills" <?php if($get2['Category'] == "Frosted Hills"){?> selected <?php } else{ } ?>>FROSTED HILLS</option>
                                <option value="Pastry" <?php if($get2['Category'] == "Pastry"){?> selected <?php } else{ } ?>>PASTRY</option>
                                <option value="Pasta" <?php if($get2['Category'] == "Pasta"){?> selected <?php } else{ } ?>>PASTA</option>
                                <option value="Custom" <?php if($get2['Category'] == "Custom"){?> selected <?php } else{ } ?>>CUSTOM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">PRICE GRANDE/REGULAR/PC/SLICE/SINGLE SHOT</label>
                            <input type="number" id="price" name="price_grande" value="<?php echo $get2['Price_Grande']; ?>" id="price_grande" class="form-control" min="1" max="10000" step="0.01" /> 
                        </div>
                        <div class="form-group">
                            <label for="price">PRICE VENTI/LARGE/WHOLE/DOUBLE SHOT</label>
                            <input type="number" id="price" name="price_venti" value="<?php echo $get2['Price_Venti']; ?>" id="price_venti" class="form-control" min="1" max="10000" step="0.01" /> 
                        </div>
                        <div class="form-group">
                            <label for="description">DESCRIPTION</label><br>
                            <textarea id="description" name="description" rows="4" cols="37"><?php echo $get2['Description']; ?></textarea>
                        </div>
                        <div>
                            <label for="profile-pic" class="form-label">Product Image</label><br>
                            <?php if ($get2['Image'] == ""){  ?> <img src="/img/producct_icon.png" style="width: 150px;" id="profile-pic"><br> <?php } else { ?><img id="profile-pic" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($get2['Image']); ?>" style="width: 150px;" id="profile-pic"><?php } ?><br>  
                            <input class="mt-2" type="file" name="image" value="Browse" onchange="loadFile(event)"> <br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="" data-toggle="modal" data-target="#confirmModal1" data-dismiss="modal" class="btn border border-dark" style="background-color: white; color: black;">EDIT</a>
                        <a href="update.php" class="btn" style="background-color: black; color: white;">BACK</a>
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
                                    Are you sure you want to edit this item?
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="edit" value="YES">
                                <input type="button" class="btn" value="NO" data-dismiss="modal" style="background-color: black; color: white;">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
<?php
        require './headers_footers/admin_footer.php';
    }
?>

<script>
    var loadFile = function(event) {
	    var image = document.getElementById('profile-pic');
	    image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>

