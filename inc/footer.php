<div class="container-fluid bg-white mt-5">
 	<div class="row">
 		<div class="col-lg-4 p-4">
 			<h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_select['site_title'] ?></h3>
 			<p><?php echo $settings_select['site_about'] ?></p>
 		</div>
 		<div class="col-lg-4 p-4">
 			<h5 class="mb-3">Link</h5>
 			<a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Trang chủ</a><br>
 			<a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Phòng</a><br>
 			<a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Thiết bị</a><br>
 			<a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Liên hệ</a><br>
 			<a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">Thông tin</a>
 		</div>
		
 		<div class="col-lg-4 p-4">
 			<h5 class="mb-3">Theo dõi chúng tôi </h5>
 			<?php
			if($contact_select['tw']){
				echo<<<data
				<a href="<?php echo $contact_select[tw] ?>" class="d-inline-block text-dark text-decoration-none mb-2">
					<i class="bi bi-twitter me-1"></i>Twitter
				</a><br>
				data;
			}
		?>
 			<a href="<?php echo $contact_select['fb'] ?>" class="d-inline-block text-dark text-decoration-none mb-2">
 				<i class="bi bi-facebook me-1"></i>facebook
 			</a><br> 
 			<a href="<?php echo $contact_select['fb'] ?>" class="d-inline-block text-dark text-decoration-none">
 				<i class="bi bi-instagram me-1"></i>instagram
 			</a><br>  
 		</div>
 	</div>
 </div>

<h6 class="text-center bg-dark text-white p-3 m-0">Thiết kế và phát triển bởi Sáng Nguyễn Hữu @CNTT6K61</h6>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
	  function alert(type,msg,position ='body'){
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
        <div class="alert ${bs_class} alert-dismissible fade show " role="alert">
            <strong class ="me-3">${msg}</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        `;

        if(position == 'body')
        {
            document.body.append(element);
            element.classList.add('custom-alert');
        }else{
            document.getElementById(position).appendChild(element);
        }
        
        setTimeout(removeAlert,2000);
    }   
   	
	function removeAlert(){
        document.getElementsByClassName('alert')[0].remove();
    }
	


	function setActive(){
		navbar =document.getElementById('nav-bar');
		let a_tags =navbar.getElementsByTagName('a');

		for (i=0 ; i<a_tags.length; i++)
		{
			let file =a_tags[i].href.split('/').pop();
			let file_name = file.split('.')[0];

			if(document.location.href.indexOf(file_name) >=0){
				a_tags[i].classList.add('active');
			}
		}
	}
	
	let register_form = document.getElementById('register_form');

	register_form.addEventListener('submit', (e)=>{
		
		e.preventDefault();

		let data = new FormData();

		data.append('name',register_form.elements['name'].value)
		data.append('email',register_form.elements['email'].value)
		data.append('phonenum',register_form.elements['phonenum'].value)
		data.append('address',register_form.elements['address'].value)
		data.append('pincode',register_form.elements['pincode'].value)
		data.append('dob',register_form.elements['dob'].value)
		data.append('pass',register_form.elements['pass'].value)
		data.append('cpass',register_form.elements['cpass'].value)
		data.append('profile',register_form.elements['profile'].files[0]);
		data.append('register','')

		var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

		let xhr = new XMLHttpRequest();
		xhr.open("POST", "ajax/login_register.php", true);

		xhr.onload = function(){
			if(this.responseText.trim() === 'pass_mismatch')
			{
				alert('error',"Mật khẩu không khớp!");
			}else if(this.responseText.trim() === 'email_already'){
				alert('error',"Email này đã có người đăng ký!");
			}else if(this.responseText.trim() === 'invalid_email'){
				alert('error',"Bạn vui lòng gõ đúng định dạng email! Ví dụ abc@gmail.com");
			}else if(this.responseText.trim() === 'invalid_phone'){
				alert('error',"Bạn vui lòng gõ đúng định dạng số điện thoại! Gồm 10 số bắt đầu bằng số 0 . Ví dụ 0346123423");
			}else if(this.responseText.trim() === 'phone_already'){
				alert('error',"Số điện thoại này đã có người đăng ký!");
			}else if(this.responseText.trim() === 'imv_img'){
				alert('error',"Chỉ có JPG , WEBP & PNG định dạng ảnh mới được cho phép!");
			}else if(this.responseText.trim() === 'upd_failed'){
				alert('error',"Hình ảnh tải lên thất bại!")
			}else if(this.responseText.trim() === 'mail_failed'){
				alert('error',"Không thể gửi link xác nhận email! Server lỗi")
			}else if(this.responseText.trim() === 'ins_failed'){
				alert('error',"Đăng ký thất bại!Server lỗi");
			}else{
				alert('success',"Đăng ký tài khoản thành công. Vui lòng xác nhận link đã gửi tới email của bạn");
				register_form.reset();
			}
    }
        xhr.send(data);
	});

	let login_form = document.getElementById('login_form');

	login_form.addEventListener('submit', (e)=>{
		
		e.preventDefault();

		let data = new FormData();

		data.append('email_mob',login_form.elements['email_mob'].value)
		data.append('pass',login_form.elements['pass'].value)
		data.append('login','')

		var myModal = document.getElementById('loginModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

		let xhr = new XMLHttpRequest();
		xhr.open("POST", "ajax/login_register.php", true);

		xhr.onload = function(){
			if(this.responseText.trim() === 'inv_email_mob')
			{
				alert('error',"Email hoặc số điện thoại không chính xác!");
			}
			else if(this.responseText.trim() === 'not_verified'){
				alert('error',"Email này chưa được kích hoạt!");
			}
			else if(this.responseText.trim() === 'inactive'){
			 	alert('error',"Tài khoản này đã bị cấm! Vui lòng liên hệ admin");
			 }
			 else if(this.responseText.trim() === 'invalid_pass'){
				alert('error',"Mật khẩu không chính xác");
			}
			
			 else{
				let fileurl = window.location.href.split('/').pop().split('?').shift();
				if(fileurl == 'room_details.php')
				{
					window.location = window.location.href;
				}else{
					window.location = window.location.pathname;
				}
			 }
    }
        xhr.send(data);
	});

	
	let forgot_form = document.getElementById('forgot_form');
	
	forgot_form.addEventListener('submit', (e)=>{
		
		e.preventDefault();

		let data = new FormData();

		data.append('email',forgot_form.elements['email'].value)
		data.append('forgot_pass','')

		var myModal = document.getElementById('forgotModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

		let xhr = new XMLHttpRequest();
		xhr.open("POST", "ajax/login_register.php", true);

		

		xhr.onload = function(){
			if(this.responseText.trim() === 'inv_email')
			{
				alert('error',"Email không chính xác!");
			}
			else if(this.responseText.trim() === 'not_verified'){
				alert('error',"Email này chưa được kích hoạt! Liên hệ với quản trị viên");
			}
			else if(this.responseText.trim() === 'inactive'){
			 	alert('error',"Tài khoản này đã bị cấm! Vui lòng liên hệ admin");
			 }
			 else if(this.responseText.trim() === 'mail_failed'){
				alert('error',"Gửi mail thất bại ! Server lỗi");
			}
			else if(this.responseText.trim() === 'upd_failed'){
				alert('error',"Tài khoản khôi phục thất bại ! Server lỗi");
			}
			
			 else{
				alert('success',"Link cài đặt mật khẩu lại đã gửi tới email của bạn");
				forgot_form.reset();
			 }
    }
        xhr.send(data);
	});

	function checkLoginToBook(status,room_id){
		if(status){
			window.location.href='confirm_booking.php?id='+room_id;
		}
		else{
			alert('error','Vui lòng đăng nhập để đặt phòng! Cám ơn ');
		}
	}
	setActive();

</script>
