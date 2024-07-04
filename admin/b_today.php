<?php 
 require('inc/essentials.php');
 require('inc/db_config.php');

 adminLogin();

?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Hồ sơ đặt phòng</title>
    <?php require('inc/links.php'); ?>
    <?php require('inc/header.php');?>


</head>

<body class ="bg-light">

       

    <div class="container-fluild" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
               <h1 id="currentDate"></h1>

             <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                  
                <div class="text-end mb-4">
                       <input type="text" id="search_input" oninput="get_bookings(this.value)" class ="form-control shadow-none w-25 ms-auto" placeholder="Tìm kiếm">
                    </div>

                  <div class="table-responsive">
                  <table class="table table-hover border" style="min-width: 1200px;">
                    <thead>
                        <tr class ="bg-dark text-light">
                        <th scope="col">#</th>
                        <th scope="col">Chi tiết người dùng</th>
                        <th scope="col" >Chi tiết phòng</th>
                        <th scope="col" >Chi tiết đặt phòng</th>
                        <th scope="col" >Trạng thái</th>
                        <th scope="col" >Hành động</th>

                        </tr>
                    </thead>
                    <tbody id ="table-data">  
                    </tbody>
                    </table>
                  </div>
                  <nav>
                    <ul class="pagination mt-2" id="table-pagination">
                       
                    </ul>
                    </nav>     
                </div>
                </div>  

                
            </div>
        </div>
    </div>


    
    <script src ="scripts/b_today.js"></script>
    <?php require('inc/scripts.php'); ?>


</body>
</html>