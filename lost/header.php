<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>News Site</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->

<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">
    <img src="images/UITS_LOGO.png" width="40"  class="d-inline-block" alt="">
    <h2 class="d-inline-block">Lost and Found</h2> 
  </a>
</nav>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

<?php 
    include "admin/config.php";

    if(isset($_GET['cid'])){
        $cat_id = $_GET['cid'];
    }
    

    $query = "SELECT * FROM category WHERE post > 0";

    $result = mysqli_query($connection, $query) or die("Catergories query failed.");

    if(mysqli_num_rows($result)){

        $active = "";

 ?>

                <ul class='menu'>

                    <?php 
                    while($row = mysqli_fetch_assoc($result)){
                     if(isset($_GET['cid'])){   
                        if($row['category_id'] == $cat_id){
                            $active = 'active';
                        }else{
                             $active = '';
                        }
                    }
                    
                    echo "<li><a class='$active' href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";

                    }

                    ?>
                    


                </ul>



                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
