<!DOCTYPE html>
<html>
<head>
	<!-- CSS only -->
<?php require('inc/links.php'); ?>
<title><?php echo $settings_select['site_title'] ?> - XÁC NHẬN ĐẶT PHÒNG</title>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>


</head>
<body>

    <?php require('inc/header.php'); ?>

    <?php

      /*
        kiểm tra id phòng từ url có tồn tại hay không
        Shutdown mode có hoạt động hay không
        Người dùng có đăng nhập hay không
      */

      if(!isset($_GET['id']) || $settings_select['shutdown'] == true)
      {
        redirect('rooms.php');
      }
      else if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
        redirect('rooms.php');
      }

      //lọc lấy phòng và dữ liệu người dùng

      $data = filteration($_GET);
      
      $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

      if(mysqli_num_rows($room_res)==0)
      {
        redirect('rooms.php');
      }

      $room_data = mysqli_fetch_assoc($room_res);

      $_SESSION['room'] = [
        "id" =>  $room_data['id'],
        "name" =>  $room_data['name'],
        "price" => $room_data['price'],
        "payment" => null,
        "available" => false,
      ];

      $user_res = select("SELECT * FROM `user_cred` WHERE `id` = ? LIMIT 1", [$_SESSION['uId']],"i");
      $user_data = mysqli_fetch_assoc($user_res)
    ?>

   
    <div class="container-fluid">
      <div class="row">
      <div class=" col-12 my-5 mb-4 px-4">
      <h2 class="fw-bold">Xác nhận đặt phòng </h2>
      <div style="font-size: 14px;">
        <a href="index.php" class="text-secondary text-decoration-none">Trang Chủ</a>
        <span class="text-secondary"> > </span>
        <a href="rooms.php" class="text-secondary text-decoration-none"> Phòng</a>
        <span class="text-secondary"> > </span>
        <a href="#" class="text-secondary text-decoration-none"> Xác nhận</a>
      </div>
    </div>
     
    <div class="col-lg-7 col-md-12 px-4">
          
    <?php 
        $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
        $thumb_q = mysqli_query($con,"SELECT * FROM `room_images` 
        WHERE `room_id`='$room_data[id]' AND `thumb`='1'");


        if(mysqli_num_rows($thumb_q)>0)
        {
          $thumb_res = mysqli_fetch_assoc($thumb_q);
          $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
        }
          // Lấy giá trị price từ $room_data
          $price = $room_data['price'];

          // Định dạng giá trị price với dấu phẩy sau mỗi 3 số 0
          $formatted_price = number_format($price, 0, '.', ',');

        echo<<<data
          <div class="card p-3 shadow-sm rounded">
          <img src="$room_thumb" class="img-fluid rounded mb-3">
          <h5>$room_data[name]</h5>
          <h6> $formatted_price VND mỗi đêm</h6>
          </div>

        data;
    ?>

    </div>

    <div class="col-lg-5 col-md-12 px-4">
      <div class="card mb-4 border-0 shadow-sm rounded-3">
          <div class="card-body">
              <form action="testthanhtoanmomo/xulythanhtoanmomo.php" method="POST" id="booking_form">
              <input type="hidden" name="payment_amount" value="<?php echo $_SESSION['room']['payment']; ?>">
                <h6 class="mb-3">CHI TIẾT ĐẶT PHÒNG</h6>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Tên</label>
    					      <input name="name" type="text" value="<?php echo $user_data['name'] ?>" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Số điện thoại</label>
    					      <input name="phonenum" type="number" value="<?php echo $user_data['phonenum'] ?>" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $user_data['address'] ?></textarea>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Nhận phòng : </label>
    					      <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                  </div>
                  <div class="col-md-6 mb-4">
                    <label class="form-label">Trả phòng : </label>
    					      <input name="checkout" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                  </div>
                  <div class="col-12">
                      <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                    <h6 class="mb-3 text-danger" id="pay_info">Cung cấp ngày đặt phòng & trả phòng !</h6>
                    <!-- <form action="inc/xulythanhtoanmomo.php" id="booking_form" method="POST" target="_blank" enctype="application/x-www-form-urlencoded">
                        <input type="submit" name="pay_now" value="Thanh toán Momo ATM" class="btn btn-danger">
                    </form> -->

                 <button name="pay_now" class="btn w-100 text-white custom-bg shadow-none mb-1" disabled >Thanh toán qua momo </button>  
                  </div>
                </div>
             </form>
          </div>
      </div> 
    </div>
 

        </div>
      </div>



      <?php require('inc/footer.php'); ?>
      <script>
        let booking_form =document.getElementById('booking_form');
        let info_loader =document.getElementById('info_loader');
        let pay_info =document.getElementById('pay_info');

        function check_availability()
        {
          let checkin_val = booking_form.elements['checkin'].value;
          let checkout_val = booking_form.elements['checkout'].value;

          booking_form.elements['pay_now'].setAttribute('disabled',true);

          if(checkin_val != '' && checkout_val !=''){

            pay_info.classList.add('d-none');
            pay_info.classList.replace('text-dark','text-danger');
            info_loader.classList.remove('d-none');


            let data = new FormData();

            data.append('check_availability','');
            data.append('check_in',checkin_val);
            data.append('check_out',checkout_val);

              let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/confirm_booking.php", true);

            xhr.onload = function(){
              let data = JSON.parse(this.responseText);
              
              if(data.status.trim() === 'check_in_out_equal')
              {
                pay_info.innerText = "Bạn không thể trả phòng trong cùng 1 ngày!";
              }
              else if(data.status.trim() === 'check_out_earlier')
              {
                pay_info.innerText = "Ngày trả phòng không được sớm hơn ngày đặt phòng!";
              } 
              else if(data.status.trim() === 'check_in_earlier')
              {
                pay_info.innerText = "Ngày đặt phòng không được sớm hơn ngày hôm nay!";
              } 
              else if(data.status.trim() == 'unavailable')
              {
                pay_info.innerText = "không còn phòng cho ngày nhận phòng này!";
              } 
              else{
                pay_info.innerHTML = "Tổng số ngày: "+data.days+"<br>Tổng số tiền phải trả: "+data.payment;
                pay_info.classList.replace('text-danger','text-dark');
                booking_form.elements['pay_now'].removeAttribute('disabled');
              }

              pay_info.classList.remove('d-none');
              info_loader.classList.add('d-none');

            }

                xhr.send(data);


            }
      }

      </script>
</body>
</html>
