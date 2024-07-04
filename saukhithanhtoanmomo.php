    <?php
      header('Content-type: text/html; charset=utf-8');
    require('inc/links.php');
    require('inc/header.php');


    unset($_SESSION['room']);


    function regenrate_session($uid){
      $user_q = select("SELECT * FROM `user_cred` WHERE `id` = ? LIMIT 1", [$uid],'i');
      $user_fetch = mysqli_fetch_assoc($user_q);

      $_SESSION['login'] = true;
      $_SESSION['uId']  = $user_fetch['id'];
      $_SESSION['uName']  = $user_fetch['name'];
      $_SESSION['uPic']  = $user_fetch['profile'];
      $_SESSION['phonenum']  = $user_fetch['phonenum'];

    }
   
    $slct_query = "SELECT `booking_id` ,`user_id` FROM `booking_order`
                  WHERE `order_id` = '$_GET[orderId]'";


    $slct_res = mysqli_query($con,$slct_query);
    if(mysqli_num_rows($slct_res) == 0){
      redirect('index.php');
    }

    $slct_fetch = mysqli_fetch_assoc($slct_res);

    if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
      regenrate_session($slct_fetch['user_id']);
      }

     if($_GET['message'] == "Successful."){
    
      $upd_query = "UPDATE `booking_order` SET `booking_status`='booked',`trans_id`='$_GET[transId]',`trans_amt`='$_GET[amount]',`trans_status`='$_GET[message]',`trans_signature`='$_GET[signature]' WHERE `booking_id`='$slct_fetch[booking_id]'";
      mysqli_query($con,$upd_query);
      alert('success',"Chúc mừng bạn đã thanh toán thành công");
      
    }else{
      
      $upd_query = "UPDATE `booking_order` SET `booking_status`='payment failed',`trans_id`='$_GET[transId]',`trans_amt`='$_GET[amount]',`trans_status`='$_GET[message]',`trans_signature`='$_GET[signature]' WHERE `booking_id`='$slct_fetch[booking_id]'";

      mysqli_query($con,$upd_query);
      alert('error',"Thanh toán thất bại vui lòng thanh toán lại");
     }
     
?>
<!DOCTYPE html>
<html>
<head>
	<!-- CSS only -->
<title><?php echo $settings_select['site_title'] ?> - Sau khi thanh toán</title>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>


</head>
<body>

   

   

   
<div class="container-fluid">
    <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
            <h2  class="fw-bold" style="font-size: 100px">Trạng thái thanh toán</h2>
            <div style="font-size: 14px;">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 col-md-12 px-4">
            <!-- Your content for the left side -->
        </div>
        <h1>CÁM ƠN BẠN ĐÃ ĐẶT PHÒNG TẠI KHÁCH SẠN CHÚNG TÔI ! CHÚC BẠN MỘT NGÀY TỐT LÀNH Ạ</h1>
        <a href = "bookings.php" style="font-size: 30px">Đi tới hồ sơ đặt phòng</a>

        <div class="col-lg-5 col-md-12 px-4">
            <div class=" ">
                <div class="card-body text-center"> <!-- Added text-center class here -->
                </div>
            </div>
        </div>
    </div>
</div>



      <?php require('inc/footer.php'); ?>
      
</body>
</html>
