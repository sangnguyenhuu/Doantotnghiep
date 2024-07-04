<!DOCTYPE html>
<html>
<head>
	
	<!-- CSS only -->
<?php require('inc/links.php'); ?>
<title><?php echo $settings_select['site_title'] ?> - Thông tin</title>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>
<style>
  .box{
    border-top-color: var(--teal) !important;
  }
</style>

</head>
<body>

<?php require('inc/header.php'); ?>

<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center">Thông tin chúng tôi</h2>

  <div class="h-line bg-dark"></div>
  <p class="text-center mt-3">
  
  </p>
</div>

<div class="container">
  <div class="row justify-content-between align-items-center">
    <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
      <h3 class="mb-3">Chủ tịch</h3>
      <p>
        ....
      </p>
    </div>
    <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
      <img src="images/about/IMG_50128.jpg" class="w-100">
    </div>
  </div>
</div>

<div class="container mt-5">
  <div class="row">
    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="images/about/hotel.svg" width="70px">
        <h4 class="mt-3">100+ Phòng</h4>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="images/about/customers.svg" width="70px">
        <h4 class="mt-3">200+ Khách Hàng</h4>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="images/about/rating.svg" width="70px">
        <h4 class="mt-3">150+ Đánh giá</h4>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4 px-4">
      <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="images/about/staff.svg" width="70px">
        <h4 class="mt-3">200+ Nhân viên</h4>
      </div>
    </div>
  
  </div>
</div>

<h3 class="my-5 fw-bold h-font text-center">NHÓM QUẢN LÝ</h3>

<div class="container px-4">
   <div class="swiper mySwiper">
      <div class="swiper-wrapper mb-5">
        <?php 
             $about_query = selectAll('team_details');
             $path = ABOUT_IMG_PATH;
             while($row = mysqli_fetch_assoc($about_query)){
              echo<<<data
                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                <img src="$path$row[picture]" class="w-100">
                <h5 class="mt-2">$row[name]</h5>
              </div>
              data;
             }
        ?>
       
      </div>
      <div class="swiper-pagination"></div>
    </div>
</div>



 <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
      var swiper = new Swiper(".mySwiper", {
        spaceBetween: 40,
        pagination: {
          el: ".swiper-pagination",
        },
        breakpoints: {
          320: {
            slidesPerView: 1,
          },
          640: {
            slidesPerView: 1,
          },
          768: {
            slidesPerView: 3,
          },
          1024: {
            slidesPerView: 3,
          },
        }
      });
    </script>
    <?php require('inc/footer.php'); ?>
</body>
</html>