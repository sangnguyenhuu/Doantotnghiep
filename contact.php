<!DOCTYPE html>
<html>
<head>
	<!-- CSS only -->
  <?php require('inc/links.php'); ?>
  <title><?php echo $settings_select['site_title'] ?> - Liên hệ</title>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>


</head>
<body>


<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center">HÃY LIÊN LẠC CHO CHÚNG TÔI QUA</h2></h2>

  <div class="h-line bg-dark"></div>
  <p class="text-center mt-3">
   
  </p>
</div>


<div class="container">
  <div class="row">
    <div class="col-lg-6 col-md-6 mb-5 px-4">

      <div class="bg-white rounded shadow p-4">
        <iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $contact_select['iframe'] ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        
        <h5>Địa chỉ</h5>
        <a href="<?php echo $contact_select['gmap'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
          <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_select['address'] ?>
        </a>
        
        <h5 class="mt-4">Liên hệ số điện thoại cho chúng tôi</h5>
        <a href="tel: +<?php echo $contact_select['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +<?php echo $contact_select['pn1'] ?></a>
        <br>
        <!-- Kiểm tra nếu sdt thứ 2 của trang web mà không rỗng thì cho hiện mà rỗng thì vẫn cho để-->

			<?php
			if($contact_select['pn2'] != '')
			{
				echo<<<data
				<a href="tel: +$contact_select[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark">
				<i class="bi bi-telephone-fill"></i> +$contact_select[pn2]</a>
				data;
			} 
			?>
        <h5 class="mt-4">Email</h5>
        <a href="email: <?php echo $contact_select['email'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-fill"></i> <?php echo $contact_select['email'] ?></a>

        <h5 class="mt-4">Follow us</h5>
        <?php 
				if($contact_select['tw'] != ''){
					echo<<<data
					<a href="$contact_select[tw]" class="d-inline-block text-dark fs-5 me-2">
							<i class="bi bi-twitter me-1"></i>
					</a>	
					data;
				}
				?>
       
        
        <a href="<?php echo $contact_select['fb'] ?>" class="d-inline-block text-dark fs-5 me-2">
            <i class="bi bi-facebook me-1"></i>
        </a>
        
        <a href="<?php echo $contact_select['insta'] ?>" class="d-inline-block text-dark fs-5">
          <i class="bi bi-instagram me-1"></i>
          
        </a>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 mb-5 px-4">
      <div class="bg-white rounded shadow p-4">
        <form method="POST">
          <h5>Gửi tin nhắn cho chúng tôi</h5>
          <div class="mb-3">
          <label class="form-label" style="font-weight: 500;">Họ Tên :</label>
          <input name="name" required type="text" class="form-control shadow-none">
          </div>
          <div class="mb-3">
          <label class="form-label" style="font-weight: 500;">Email</label>
          <input name="email" required type="email" class="form-control shadow-none">
          </div>
          <div class="mb-3">
          <label class="form-label" style="font-weight: 500;">Tiêu đề :</label>
          <input name="subject" required type="text" class="form-control shadow-none">
          </div>
          <div class="mb-3">
          <label class="form-label" style="font-weight: 500;">Tin Nhắn</label>
          <textarea name="message" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
          <button type="submit" name="send" id="submitButton" class="btn text-white custom-bg mt-3">Gửi</button>
        </div>
        </form>
      </div>
    </div>
</div>
    
  </div>
</div>

<?php
    if(isset($_POST['send']))
    {
      $frm_data = filteration($_POST);

      $query = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
      $values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];

      $res = insert($query,$values,'ssss');
      if($res==1){
        alert('success','Bạn đã gửi mail cho chúng tôi . Chúc bạn ngày mới tốt lành nha');
      }else{
        alert('error', 'server web của bạn không chạy hoặc đang chặn yêu cầu!Bạn vui lòng thử lại');
      }
    }

 ?>
  
<?php require('inc/footer.php'); ?>
</body>
</html>
