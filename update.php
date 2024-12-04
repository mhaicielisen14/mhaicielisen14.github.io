<?php
    session_start();

    $connection2 = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

    if (isset($_POST['delete']))
    {
        $id = $_POST['id'];

        $delete = "delete from tbl_item where id_no = '$id'";
        $query = @mysqli_query($connection2, $delete);

        if ($query)
        {
            echo "<script>
                    alert('Successfully Deleted Item');
                    window.location.href = 'update.php';
            </script>";
        }
    }

    if (isset($_POST['add']))
    {
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

                $allowTypes = array('jpg','png','jpeg','gif','webp');

                if (in_array($fileType, $allowTypes))
                {
                    $image = $_FILES['image']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($image));

                    $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

                    $insert = "insert into tbl_item (Itemname, Category, Price_Grande, Price_Venti, Image, Description) values ('$itemname', '$category', '$price_grande', '$price_venti', '$imgContent', '$description')";
                    $query = @mysqli_query($connection, $insert);

                    if ($query)
                    {
                        echo "<script>
                            alert('Successfully Added Item');
                            window.location.href = 'update.php';
                        </script>"; 
                    }

                    else
                    {
                        echo "<script>
                            alert('Error Adding Item');   
                            window.location.href = 'update.php'; 
                        </script>";
                    }
                }
            }

            else
            {
                $connection = @mysqli_connect('sql102.infinityfree.com', 'if0_37428363', 'T8jXqbRVME5dpTU', 'if0_37428363_db_hvcs') or die("no connection");

                $insert = "insert into tbl_item (Itemname, Category, Price_Grande, Price_Venti, Description) values ('$itemname', '$category', '$price_grande', '$price_venti', '$description')";
                $query = @mysqli_query($connection, $insert);

                if ($query)
                {
                    echo "<script>
                        alert('Successfully Added Item');
                        window.location.href = 'update.php';
                    </script>"; 
                }

                else
                {
                    echo "<script>
                        alert('Error Adding Item');   
                        window.location.href = 'update.php'; 
                    </script>";
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
            <div class="row">
                <div class="col-lg-4">
                    <h3><b>Update Menu Item List</b></h3>
                    <div class="form-group mt-3">
                        <label for="search">SEARCH</label>
                        <form action="" method="get">
                            <input type="text" name="search" id="search"  <?php if (isset($_GET['search'])){ ?> value="<?php echo $_GET['search']; ?>" <?php } else{ ?> placeholder="SEARCH" <?php } ?>  class="form-control">
                            <input type="submit" style="background-color: black; color: white;" class="btn mt-1" value="SEARCH"><br>
                            <a href="update.php" class="btn mt-1" style="background-color: black; color: white;">SEARCH ALL</a>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                </div>
                <div class="col-lg-2">
                </div>
                <div class="col-lg-2 mt-4">
                    <input type="button" data-toggle="modal" style="background-color: black; color: white;" data-target="#addModal" class="btn mt-5" value="ADD ITEM"></form>
                </div>
            </div>
            <center>
                <div class="mt-5 mb-5">
                    <table class="admin-menu-table table table-striped">
                        <thead>
                            <tr style="color: white; text-shadow: 1px 1px black; font-size: 1.8vw; text-align: center;">
                                <th style="border: 1px solid white; background-color: black;" class="p-2">ID NO</th>
                                <th style="border: 1px solid white; background-color: black;" class="p-2">ITEM</th>
                                <th style="border: 1px solid white; background-color: black;" class="p-2">CATEGORY</th>
                                <th style="border: 1px solid white; background-color: black;" class="p-2">PRICE<br>GRANDE/<br>REGULAR/<br>SLICE</th>
                                <th style="border: 1px solid white; background-color: black; display: none;" class="p-2">PRICE<br>GRANDE</th>
                                <th style="border: 1px solid white; background-color: black;" class="p-2">PRICE<br>VENTI<br>LARGE/<br>WHOLE</th>
                                <th style="border: 1px solid white; background-color: black; display: none;" class="p-2">PRICE<br>VENTI</th>
                                <th style="border: 1px solid white; background-color: black;" class="p-2">IMAGE</th>
                                <th style="border: 1px solid white; background-color: black; display: none;" class="p-2">IMAGE</th>
                                <th colspan="2" style="border: 1px solid white; background-color: black;" class="p-2">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (isset($_GET['search']))
                                {
                                    $selectitem = "select* from tbl_item where id_no like '%$_GET[search]%' or Itemname like '%$_GET[search]%' or Category like '%$_GET[search]%' or Price_Grande like '%$_GET[search]%' or Price_Venti like '%$_GET[search]%'";
                                }

                                else
                                {
                                    $selectitem = "select* from tbl_item";
                                }
                                
                                $query1 = @mysqli_query($connection2, $selectitem);

                                while ($get = @mysqli_fetch_array($query1))
                                {
                            ?>
                                    <tr style="color: black; font-size: 1.8vw;">
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['id_no']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Itemname']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><?php echo $get['Category']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center">P <?php echo $get['Price_Grande']; ?></td>
                                        <td style="border: 1px solid black; display: none;" class="p-2 text-center"><?php echo $get['Price_Grande']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center">P <?php echo $get['Price_Venti']; ?></td>
                                        <td style="border: 1px solid black; display: none;" class="p-2 text-center"><?php echo $get['Price_Venti']; ?></td>
                                        <td style="border: 1px solid black;" class="p-2 text-center"><a style="font-size: 1.1vw;" href="seeimage.php?id=<?php echo $get[0]; ?>&product_name=<?php echo $get[1]; ?>" target="_blank">CLICK SEE IMAGE</a></td>
                                        <td style="border: 1px solid black; display: none;" class="p-2 text-center"><?php echo $get['Image']; ?></td>
                                        <td style="border: 1px solid black;" class="p-1 text-center"><form action="edit_item.php?id=<?php echo $get[0]; ?>" method="post"><input type="submit" class="btn btn-sm border border-dark" style="font-size: 1.5vw; background-color: white; color: black;" value="Edit"></form></td>
                                <td style="border: 1px solid black;" class="p-1 text-center"><input type="button" style="font-size: 1.5vw; background-color: black; color: white;" class="btn btn-danger btn-sm deletebtn" data-toggle="modal" data-target="#deletemodal" value="Delete"></td>
                                    </tr>
                            <?php    
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </center>
        </div>

        <form action="" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="addModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black; color: white;">
                        <img src="/img/hv_logo.png" width="50">
                        <h4 class="modal-title ml-2" id="modalTitle">ADD ITEM</h4>
                        <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                    </div>
                        
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">ITEM NAME</label>
                            <input type="text" name="itemname" id="itemname"  placeholder="ITEM NAME" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username">CATEGORY</label>
                            <select id="inputState" name="category" class="form-control">
                                <option disabled selected>CHOOSE CATEGORY</option>
                                <option value="Coffee">COFFEE</option>
                                <option value="Iced Coffee">ICED COFFEE</option>
                                <option value="Frosted Hills">FROSTED HILLS</option>
                                <option value="Pastry">PASTRY</option>
                                <option value="Pasta">PASTA</option>
                                <option value="Custom">CUSTOM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">PRICE GRANDE/REGULAR/PC/SLICE/SINGLE SHOT</label>
                            <input type="number" id="price" name="price_grande" id="price_grande" class="form-control" min="1" max="10000" step="0.01" /> 
                        </div>
                        <div class="form-group">
                            <label for="price">PRICE VENTI/LARGE/WHOLE/DOUBLE SHOT</label>
                            <input type="number" id="price" name="price_venti" id="price_venti" class="form-control" min="1" max="10000" step="0.01" /> 
                        </div>
                        <div class="form-group">
                            <label for="description">DESCRIPTION</label><br>
                            <textarea rows="4" name="description" id="description" cols="37"></textarea>
                        </div>
                        <div>
                            <label for="profile-pic" class="form-label">Product Image</label><br>
                            <img src="/img/producct_icon.png" width="170" height="120" id="profile-pic"><br>
                            <input class="mt-2" type="file" name="image" value="Browse" onchange="loadFile(event)"> <br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="" data-toggle="modal" data-target="#confirmModal1" data-dismiss="modal" class="btn border border-dark" style="background-color: white; color: black;">ADD</a>
                        <input type="button" class="btn" style="background-color: black; color: white;" value="CLOSE" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmModal1" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: green; color: white;">
                        <img src="/img/hv_logo.png" width="50">
                        <h4 class="modal-title ml-2" id="modalTitle">Confirmation</h4>
                        <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                    </div>
                        
                    <div class="modal-body">
                        <div class="form-group">
                            Are you sure you want to add this item?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" name="add" value="YES">
                        <input type="button" class="btn btn-danger" value="NO" data-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="deletemodal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form action="" method="post">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <img src="/img/hv_logo.png" width="50">
                        <h4 class="modal-title ml-2" style="Color: white;">Delete Item</h4>
                        <button type="button" class="close" style="color: white;" data-dismiss="modal">&times;</button>
                    </div>
                                        
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                Are you sure you want to delete Item id no <p id="categoryID1"></p>
                                <input type="hidden" name="id" id="categoryID2">
                            </div>
                        </div>
                    </div>
                                    
                    <div class="modal-footer">
                        <input type="submit" class="btn border border-dark" style="background-color: white; color: black;" name="delete" value="YES">
                        <input type="button" class="btn" style="background-color: black; color: white;" value="NO" data-dismiss="modal">
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