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
    <title>Admin - Phòng mới đặt</title>
    <?php require('inc/links.php'); ?>
    <?php require('inc/header.php');?>


</head>

<body class ="bg-light">

       

    <div class="container-fluild" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
               <h3 class="mb-4">Phòng mới đặt</h3>

             <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                  
                <div class="text-end mb-4">
                       <input type="text" oninput="get_bookings(this.value)" class ="form-control shadow-none w-25 ms-auto" placeholder="Tìm kiếm">
                    </div>

                  <div class="table-responsive">
                  <table class="table table-hover border" style="min-width: 1200px;">
                    <thead>
                        <tr class ="bg-dark text-light">
                        <th scope="col">#</th>
                        <th scope="col">Chi tiết người dùng</th>
                        <th scope="col" >Chi tiết phòng</th>
                        <th scope="col" >Chi tiết đặt phòng</th>
                        <th scope="col" >Hành động</th>

                        </tr>
                    </thead>
                    <tbody id ="table-data">  
                    </tbody>
                    </table>
                  </div>
                              
                </div>
                </div>  

                
            </div>
        </div>
    </div>

    <!-- Phương thức của xác nhận số phòng -->
    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="assign_room_form">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" >Xác nhận phòng</h5>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Số phòng</label>
                            <input type="text"  name ="room_no" class="form-control shadow-none" required>
                        </div>
                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
				    	Lưu ý: Chỉ xác nhận số phòng khi mà khách hàng đến 
    			        </span>
                        <input type="hidden" name="booking_id">
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn text-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                            <button type="submit" class="btn custom-bg text-black shadow-none">Đồng ý</button>
                        </div>
                        </div>
                        </form>
                    </div>
                    </div>

    
    <script src ="scripts/new_bookings.js"></script>
    <?php require('inc/scripts.php'); ?>


</body>
</html>