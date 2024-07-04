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
    <title>Admin - Người dùng</title>
    <?php require('inc/links.php'); ?>
    <?php require('inc/header.php');?>


</head>

<body class ="bg-light">

       

    <div class="container-fluild" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
               <h3 class="mb-4">Người dùng</h3>

             <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                  
                <div class="text-end mb-4">
                       <input type="text" oninput="search_user(this.value)" class ="form-control shadow-none w-25 ms-auto" placeholder="Tìm kiếm">
                    </div>

                  <div class="table-responsive">
                  <table class="table table-hover text-center" style="min-width: 1300px;">
                    <thead>
                        <tr class ="bg-dark text-light">
                        <th scope="col">#</th>
                        <th scope="col">Tên</th>
                        <th scope="col" >Email</th>
                        <th scope="col" >Số điện thoại</th>
                        <th scope="col" >Địa chỉ - mã pin</th>
                        <th scope="col" >Ngày tháng năm sinh</th>
                        <th scope="col" >Xác minh</th>
                        <th scope="col" >Trạng thái</th>
                        <th scope="col" >Ngày đăng ký</th>
                        <th scope="col" >Hành động</th>

                        </tr>
                    </thead>
                    <tbody id ="users-data">  
                    </tbody>
                    </table>
                  </div>
                              
                </div>
                </div>  

                
            </div>
        </div>
    </div>


    
    <script src ="scripts/users.js"></script>
    <?php require('inc/scripts.php'); ?>


</body>
</html>