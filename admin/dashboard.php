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
    <title>Admin - Dashboard</title>
    <?php require('inc/links.php'); ?>



</head>

<body class ="bg-light">
    <?php require('inc/header.php');
    
        $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));
    
        $current_bookings = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
        COUNT(CASE WHEN booking_status = 'booked' AND arrival = 0 THEN 1 END) AS `new_bookings`,
        COUNT(CASE WHEN booking_status = 'cancelled' AND refund = 0 THEN 1 END) AS `refund_bookings`
        FROM `booking_order`"));
    
         $queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
           FROM `user_queries` "));

        $reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
        FROM `rating_review` "));

        $current_users = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
        COUNT(id) AS `total`,
        COUNT(CASE WHEN `status` = 1 THEN 1 END)  AS `active`,
        COUNT(CASE WHEN `status` = 0 THEN 1 END)  AS `inactive`,
        COUNT(CASE WHEN `is_verified` = 0 THEN 1 END)  AS `unverified`
        FROM `user_cred`"));
        
        ?>

       

    <div class="container-fluild" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 >Thống kê</h3>
                <?php 
                if($is_shutdown['shutdown']){
                    echo<<<shutdown
                    <h6 class="badge bg-danger py-2 px-3 rounded">Nút shutdown đang hoạt động!</h6>
                    shutdown;
                }
                ?>
            </div>

            <div class="row mb-4">
                <div class="class col-md-3 mb-4">
                    <a href="new_bookings.php" class="text-decoration-none ">
                        <div class="card text-center text-success p-3">
                            <h6>Phòng mới đặt</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_bookings['new_bookings']  ?></h1>
                        </div>
                    </a>
                </div>
                <div class="class col-md-3 mb-4">
                    <a href="refund_bookings.php" class="text-decoration-none ">
                        <div class="card text-center text-warning p-3">
                            <h6>Phòng hoàn tiền</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_bookings['refund_bookings']  ?></h1>
                        </div>
                    </a>
                </div>
                <div class="class col-md-3 mb-4">
                    <a href="user_queries.php" class="text-decoration-none ">
                        <div class="card text-center text-info p-3">
                            <h6>Phản hồi khách hàng</h6>
                            <h1 class="mt-2 mb-0"><?php echo $queries['count']  ?></h1>
                        </div>
                    </a>
                </div>
                <div class="class col-md-3 mb-4">
                    <a href="rate_review.php" class="text-decoration-none ">
                        <div class="card text-center text-danger p-3">
                            <h6>Đánh giá & nhận xét</h6>
                            <h1 class="mt-2 mb-0"><?php echo $reviews['count']  ?></h1>
                        </div>
                    </a>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 >Phân tích đặt phòng</h3>
                <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
                    <option value="1">30 ngày trước</option>
                    <option value="2">180 ngày trước</option>
                    <option value="3">1 năm trước</option>
                    <option value="4">Ngày hôm nay</option>
                    <option value="5">Mọi lúc</option>
                </select>
            </div>

            <div class="row mb-3">
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Tổng đặt phòng</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings">5</h1>
                            <h4 class="mt-2 mb-0" id="total_amt">5 VNĐ</h4>
                        </div>      
                </div>        
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Phòng đã hoạt động</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings">5</h1>
                            <h4 class="mt-2 mb-0" id="active_amt">5 VNĐ</h4>
                        </div>      
                </div>   
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Phòng đã hủy</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings">5</h1>
                            <h4 class="mt-2 mb-0" id="cancelled_amt">5 VNĐ</h4>
                        </div>      
                </div>   
                
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4" >
                <h3 >Phân tích người dùng , phản hồi , nhận xét </h3>
                <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
                    <option value="1">30 ngày trước</option>
                    <option value="2">180 ngày trước</option>
                    <option value="3">1 năm trước</option>
                    <option value="4">Ngày hôm nay</option>
                    <option value="5">Mọi lúc</option>
                </select>
            </div>

            <div class="row mb-3">
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Người dùng đăng ký mới</h6>
                            <h1 class="mt-2 mb-0" id="total_new_reg">5</h1>
                        </div>      
                </div>        
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Phản hồi</h6>
                            <h1 class="mt-2 mb-0" id="total_queries">5</h1>
                        </div>      
                </div>   
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>Nhận xét</h6>
                            <h1 class="mt-2 mb-0" id="total_reviews">5</h1>
                        </div>      
                </div>   
                
            </div>

            <h5>Người dùng</h5>
            <div class="row mb-3">
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-info p-3">
                            <h6>Tổng số</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['total']  ?></h1>
                        </div>      
                </div>        
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Đang hoạt động</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['active']  ?></h1>
                        </div>      
                </div>   
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>Không hoạt động</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['inactive']  ?></h1>
                        </div>      
                </div>   
                <div class="class col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Chưa xác thực</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['unverified']  ?></h1>
                        </div>      
                </div>  
            </div>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/dashboard.js"></script>
</body>
</html>