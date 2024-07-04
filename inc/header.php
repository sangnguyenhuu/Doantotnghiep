
<nav id="nav-bar" class="navbar navbar-expand-lg bg-light px-lg-3 py-lg-2 shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $settings_select['site_title'] ?></a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link me-2" aria-current="page" href="index.php">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="rooms.php">Phòng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="facilities.php">Thiết bị</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="contact.php">Liên hệ chúng tôi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="about.php">Thông tin</a>
        </li>
        
      </ul>
      <div class="d-flex" role="search">
		<?php 
			if(isset($_SESSION['login']) && $_SESSION['login'] == true )
			{
				$path = USERS_IMG_PATH;
				echo<<<data
				<div class="btn-group">
					<button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
					<img src="$path$_SESSION[uPic]" style="width: 25px; height = 25px;" class="me-1 rounded-circle">
					$_SESSION[uName]
					</button>
					<ul class="dropdown-menu dropdown-menu-lg-end">
						<li><a class="dropdown-item" href="profile.php">Hồ sơ</a></li>
						<li><a class="dropdown-item" href="bookings.php">Phòng đặt</a></li>
						<li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>

					</ul>
					</div>
				data;
			}else
			{
				echo<<<data
				<button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập	</button>
				<button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký	</button>
				data;
			}
		?>
       
      </div>
    </div>
  </div>
</nav>

	<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id = "login_form">
				<div class="modal-header">
				<h5 class="modal-title d-flex align-items-center">
				<i class="bi bi-person-circle fs-3 me-2">Đăng nhập</i>
				</h5>
				<button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
				<div class="mb-3">
					<label class="form-label">Dịa chỉ Email / Số điện thoại</label>
					<input type="text" name ="email_mob" required class="form-control shadow-none">
				</div>
				<div class="mb-4">
					<label class="form-label">Mật Khẩu</label>
					<input type="password" name ="pass" required class="form-control shadow-none">
				</div>
				<div class="d-flex align-items-center justify-content-between mb-2">
					<button type="submit" class="btn btn-dark shadow-none">Đăng nhập</button>
					<button type="button" class="btn text-secondary text-decoration-none shadow-none p-0" data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">
						Quên mật khẩu	</button>
					</div>
				</div>
			
		   </form>
		</div>
	</div>
	</div>

<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	
    	<form id="register_form">
    		<div class="modal-header">
        	<h5 class="modal-title d-flex align-items-center">
        	<i class="bi bi-person-lines-fill fs-3 me-2">Đăng ký</i>
        	</h5>
        	<button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
      			<span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
					Lưu ý: Thông tin chi tiết của bạn phải khớp với giấy tờ tùy thân (thẻ Aadhaar, hộ chiếu, giấy phép lái xe, v.v.) sẽ được yêu cầu khi nhận phòng.
    			</span>
    		<div class="container-fluid">
    			<div class="row">
    				<div class="col-md-6 ps-0 mb-3">
    					<label class="form-label">Tên</label>
    					<input name="name" type="text" class="form-control shadow-none" required>
    				</div>
    				<div class="col-md-6 p-0 mb-3">
    					<label class="form-label">Email</label>
    					<input name="email" type="email" class="form-control shadow-none" required>
    				</div>
    				<div class="col-md-6 ps-0 mb-3">
    					<label class="form-label">Số điện thoại</label>
    					<input name="phonenum" type="number" class="form-control shadow-none" required>
    				</div>
    				<div class="col-md-6 p-0 mb-3">
    					<label class="form-label">Hình ảnh</label>
    					<input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required> 
    				</div>
    				<div class="col-md-12 p-0 mb-3">
    					<label class="form-label">Địa chỉ</label>
    					<textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
    				</div>
    				<div class="col-md-6 ps-0 mb-3">
    					<label class="form-label">Mã pin</label>
    					<input name="pincode" type="number" class="form-control shadow-none" required>
    				</div>
    				<div class="col-md-6 p-0 mb-3">
    					<label class="form-label">Ngày sinh</label>
    					<input name="dob" type="date" class="form-control shadow-none" required>
    				</div>
    				<div class="col-md-6 ps-0 mb-3">
    					<label class="form-label">Mật khẩu</label>
    					<input name="pass" type="password" class="form-control shadow-none" required>
    				</div>
    				<div class="col-md-6 p-0 mb-3">
    					<label class="form-label">Xác nhận mật khẩu</label>
    					<input name="cpass" type="password" class="form-control shadow-none" required>
    					</div>
					</div>
				</div>
    				<div class="text-center my-1 mb-3">
    					<button type="submit" class="btn btn-dark shadow-none">Đăng ký</button>
    				</div>
    			
    		</div>	
        	
    	</form>
      
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="forgotModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form id = "forgot_form">
    		<div class="modal-header">
        	<h5 class="modal-title d-flex align-items-center">
        	<i class="bi bi-person-circle fs-3 me-2">Quên mật khẩu</i>
        	</h5>
        	<button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
        	<div class="mb-4">
			<span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
				Lưu ý: Chúng tôi sẽ gửi link tới email của bạn để cài đặt lại mật khẩu.
    			</span>
    			<label class="form-label">Dịa chỉ Email</label>
    			<input type="email" name ="email" required class="form-control shadow-none">
  			  </div>	
  			<div class="mb-2 text-end">
				  <button type="button" class="btn shadow-none p-0 me-2" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
					Hủy	</button>
				  <button type="submit" class="btn btn-dark shadow-none">Gửi link</button>
				</div>
      		</div>
      	
    </form>
      
    </div>
  </div>
</div>