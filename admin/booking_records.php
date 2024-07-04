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
               <h3 class="mb-4">Hồ sơ đặt phòng</h3>

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


     <!-- Phương thức của xác nhận chi phí phụ -->
     <div class="modal fade" id="additional_costs" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="additional_fee_form">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" >Xác nhận chi phí phụ</h5>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tổng số tiền</label>
                            <input type="text"  name ="additional_fee" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Chi phí phụ bao gồm</label>
                            <input type="text"  name ="info_fee" class="form-control shadow-none" >
                        </div>
                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
				    	Lưu ý: Chỉ xác nhận chi phí phụ khi mà khách hàng đến trả phòng
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
    
    <script src ="scripts/booking_records.js"></script>
    <?php require('inc/scripts.php'); ?>


</body>
</html>