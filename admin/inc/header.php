<div class=" container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
            <h3 class="mb-0 h-front">NHS HOTEL</h3>
            <a href="logout.php" class="btn btn-light btn-sm">Đăng Xuất</a>
        </div>


    <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
     <nav class="navbar navbar-expand-lg navbar-dark">
  <div class="navbar-contain container-fluid flex-lg-column align-items-stretch">
    <h4 class="mt-2 text-light">TRANG ADMIN</h4>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
    <ul class="nav nav-pills flex-column">
    <li class="nav-item">
            <a class="nav-link text-light" href="b_today.php">Thống kê hôm nay</a></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="dashboard.php">Thống kê</a>
        </li>
        <li class="nav-item">
        <button class="btn btn-dark text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse"  data-bs-target="#bookingLinks">
            <span>Đặt phòng</span>
            <span><i class="bi bi-caret-down-fill"></i> </span>
        </button> 
        <div class="collapse show px-3 small mb-1" id="bookingLinks">
        <ul class="nav nav-pills flex-column rounded border border-secondary ">
                <li class="nav-item">
                    <a class="nav-link text-white" href="new_bookings.php">Phòng mới đặt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="refund_bookings.php">Hoàn tiền phòng đặt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="booking_records.php">Hồ sơ đặt phòng</a></a>
                </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="users.php">Người dùng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="user_queries.php">Phản hồi Khách Hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="rate_review.php">Đánh giá và nhận xét</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="rooms.php">Các phòng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="features_facilities.php">Cơ sở vật chất và thiết bị</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-light" href="carousel.php">Carousel</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="settings.php">Thiết lập</a>
        </li>
        
        
</ul>
    </div>
  </div>
</nav>
    </div>