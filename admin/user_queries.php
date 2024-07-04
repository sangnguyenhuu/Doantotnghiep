<?php

use Mpdf\Tag\Strong;

 require('inc/essentials.php');
 require('inc/db_config.php');

 adminLogin();

    if(isset($_GET['seen']))
    {
        $frm_data = filteration($_GET);

        if($frm_data['seen'] == 'all'){
            $query = "UPDATE `user_queries` SET `seen`=?";
            $values = [1];
            if(update($query,$values,'i')){
                alert('success','Đánh dấu đã đọc tất cả!');
            }else{
                alert('error','Có lỗi xảy ra');
            }
        }else{
            $query = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
            $values = [1,$frm_data['seen']];
            if(update($query,$values,'ii')){
                alert('success','Đánh dấu đã đọc!');
            }else{
                alert('error','Có lỗi xảy ra');
            }
        }
    }
    if(isset($_GET['del']))
    {
        $frm_data = filteration($_GET);

        if($frm_data['del'] == 'all'){
            $query = "DELETE FROM `user_queries`";
            if(mysqli_query($con,$query)){
                alert('success','Tất cả dữ liệu đã được xóa!');
            }else{
                alert('error','Có lỗi xảy ra');
            }
        }else{
            $query = "DELETE FROM `user_queries` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if(delete($query,$values,'i')){
                alert('success','Dữ liệu đã được xóa!');
            }else{
                alert('error','Có lỗi xảy ra');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Phản hồi khách hàng thông qua liên hệ</title>
    <?php require('inc/links.php'); ?>
    <?php require('inc/header.php');?>


</head>

<body class ="bg-light">

       

    <div class="container-fluild" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
               <h3 class="mb-4">Phản Hồi Khách Hàng</h3>

             <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                  <div class ="text-end mb-4">
                
                  <a href="?seen=all" class ="btn btn-dark rounder-pill shadow-none btn-sm"><i class="bi bi-check-circle"></i> Đánh dấu đọc tất cả</a><br>
                  <a href="?del=all" class ="btn btn-danger rounder-pill shadow-none btn-sm mt-2"><i class="bi bi-trash3-fill"></i> Xóa tất cả dữ liệu</a>

                </div>
                  <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                  <table class="table table-hover">
                    <thead class="sticky-top">
                        <tr class ="bg-dark text-light">
                        <th scope="col">#</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Email</th>
                        <th scope="col" width = 20%>Tiêu đề</th>
                        <th scope="col" width = 35%>Tin nhắn</th>
                        <th scope="col" >Ngày-tháng-năm</th>
                        <th scope="col" >Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                       $query = "SELECT * FROM `user_queries` ORDER BY `sr_no` DESC";
                       $data = mysqli_query($con,$query);
                       $i=1;
                       
                       while($row = mysqli_fetch_assoc($data))
                       {
                            $date = date('d-m-Y',strtotime($row['datentime']));
                            $seen='';
                            if($row['seen']!=1){
                                $seen = "<a href='?seen=$row[sr_no]' class='btn btn-sm rounder-pill btn-primary'> Đánh dấu đã đọc</a> <br>";
                            }
                            $seen.= "<a href='?del=$row[sr_no]' class='btn btn-sm rounder-pill btn-danger mt-2'> Xóa</a>";

                        echo<<<query
                        
                        <tr>
                        <td>$i</td>
                        <td>$row[name]</td>
                        <td>$row[email]</td>
                        <td>$row[subject]</td>
                        <td>$row[message]</td>
                        <td>$date</td>
                        <td>$seen</td>
                        </tr>

                        query;
                        $i++;
                       }
                       ?>
                    </tbody>
                    </table>
                  </div>
                              
                </div>
                </div>  

               

                
            </div>
        </div>
    </div>
        
    <?php require('inc/scripts.php'); ?>
   
</body>
</html>