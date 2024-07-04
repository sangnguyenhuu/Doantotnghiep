<!DOCTYPE html>
<html>
<head>
	<!-- CSS only -->
<?php require('inc/links.php'); ?>
<title><?php echo $settings_select['site_title'] ?> - Đặt phòng</title>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>


</head>
<body>

    <?php require('inc/header.php');

      if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
        redirect('index.php');
      }

    ?>
    

  
    <div class="container-fluid">
      <div class="row">
      <div class=" col-12 my-5 px-4">
      <h2 class="fw-bold">Đặt phòng </h2>
      <div style="font-size: 14px;">
        <a href="index.php" class="text-secondary text-decoration-none">Trang Chủ</a>
        <span class="text-secondary"> > </span>
        <a href="#" class="text-secondary text-decoration-none">Phòng đã đặt</a>
      </div>
    </div>
    

    <?php 
       $query = "SELECT bo.*, bd.* FROM `booking_order` bo
       INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
       WHERE ((bo.booking_status = 'booked')
       OR (bo.booking_status = 'cancelled')
       OR (bo.booking_status = 'payment failed'))
       AND (bo.user_id=?)
       ORDER BY bo.booking_id DESC";

      $result = select($query,[$_SESSION['uId']],'i');

      while($data = mysqli_fetch_assoc($result))
      {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $status_bg = "";
        $btn = "";

        if($data['booking_status']=='booked')
        {
          $status_bg = 'bg-success';

          if($data['arrival']==1)
          {
            if($data['is_additional_fee']==1){
              $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>Hóa đơn </a>";
            }
            if($data['rate_review']==0){
              $btn .= "<button type='button' onclick='review_room($data[booking_id],$data[room_id])' data-bs-toggle='modal' data-bs-target='#reviewModal' class='btn btn-dark btn-sm shadow-none ms-2'>
                Đánh giá và nhận xét
                </button>";
            }
          }else {
            $btn = "<button onclick ='cancel_booking($data[booking_id])' type='button' class='btn btn-danger btn-sm shadow-none'>Hủy phòng </button>";
          }
        }
        else if($data['booking_status']=='cancelled')
        {
           $status_bg = "bg-danger";
           
           if($data['refund']==0){
            $btn = "<span class ='badge bg-primary'>Đang hoàn tiền và đang trong quá trình xử lý</span>";
           }else{
            $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>Hóa đơn </a>";
           }
          }else{
            $status_bg = "bg-warning";
            $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>Hóa đơn </a>";
           }
           

           if($data['booking_status'] == 'booked' && $data['is_additional_fee'] == 1){
            $booking_status = 'Đã đặt phòng và trả phòng';
          }else if($data['booking_status'] == 'booked' && $data['arrival'] == 1){
            $booking_status = 'Đã đặt phòng và nhận phòng';
          }else if($data['booking_status'] == 'booked'){
              $booking_status = 'Đã đặt phòng';
          }else if($data['booking_status'] == 'cancelled'){
              $booking_status = 'Đã hủy phòng';
          }else if($data['booking_status'] == 'payment failed'){
              $booking_status = 'Thanh toán thất bại';
          }

           // Lấy giá trị price và trans_amt từ $data
             $trans_amt = $data['trans_amt'];
             $price = $data['price'];

             // Định dạng giá trị price và trans_amt với dấu phẩy sau mỗi 3 số 0
             $formatted_trans_amt = number_format($trans_amt, 0, '.', ',');      
             $formatted_price = number_format($price, 0, '.', ',');  

           echo<<<bookings
            <div class = 'col-md-4 px-4 mb-4'>
            <div class = 'bg-white p-3 rounded shadow-sm'>
                <h5 class = 'fw-bold'>$data[room_name]</h5>
                <p>$formatted_price VNĐ mỗi đêm</p>
                <p>
                  <b>Đặt phòng: </b> $checkin <br>
                  <b>Trả phòng: </b> $checkout
                </p>
                <p>
                  <b>Tổng tiền: </b>  $formatted_trans_amt VNĐ<br>
                  <b>Order ID: </b> $data[order_id]<br>
                  <b>Ngày:  </b> $date
                </p>
                <p>
                    <span class='badge $status_bg'>$booking_status</span>
                </p>
                $btn
            </div>
             </div>


           bookings;

      }



           ?>

        </div>
      </div>


      <div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
         <div class="modal-content">
          <form id = "review_form">
            <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
            <i class="bi bi-chat-square-heart fs-3 me-2"> Đánh giá và nhận xét</i>
            </h5>
            <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Đánh giá</label>
              <select class="form-select shadow-none" name="rating">
                <option value="5">Xuất xắc,tuyệt vời</option>
                <option value="4">Rất tốt</option>
                <option value="3">Tốt</option>
                <option value="2">Bình thường</option>
                <option value="1">Tệ</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="form-label">Nhận xét</label>
              <textarea type="password" name ="review" rows="3" required class="form-control shadow-none"></textarea>
            </div>
            <input type="hidden" name="booking_id">
            <input type="hidden" name="room_id">

            <div class="text-end">
              <button type="submit" class="btn custom-bg text-white shadow-none">Đồng ý</button>
             
              </div>
            </div>
			
		   </form>
		</div>
	</div>
	</div>




<?php 
    if(isset($_GET['cancel_status'])){
      alert('success','Đặt phòng đã được hủy thành công!');
    }
    else if(isset($_GET['review_status'])){
      alert('success','Cám ơn bạn đã đánh giá & nhận xét!');
    }
?>

      <?php require('inc/footer.php'); ?>
      <script>
       function  cancel_booking(id)
       {
          if(confirm('Bạn có chắc chắn hủy đặt phòng này không ?'))
          {
              let xhr = new XMLHttpRequest();
              xhr.open("POST", "ajax/cancel_booking.php", true);
              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

              xhr.onload = function(){
                if(this.responseText == 1){
                  window.location.href="bookings.php?cancel_status=true";
                }else{
                    alert('error','Hủy phòng thất bại !');
                }
            }

              xhr.send('cancel_booking&id='+id);
          }
       }
       let review_form = document.getElementById('review_form');

       function review_room(bid,rid){
          review_form.elements['booking_id'].value = bid;
          review_form.elements['room_id'].value = rid;

        }

        review_form.addEventListener('submit',function(e){
            e.preventDefault();

            let data = new FormData();
            data.append('review_form','');
            data.append('rating',review_form.elements['rating'].value);
            data.append('review',review_form.elements['review'].value);
            data.append('booking_id',review_form.elements['booking_id'].value);
            data.append('room_id',review_form.elements['room_id'].value);
         

          let xhr = new XMLHttpRequest();
              xhr.open("POST", "ajax/review_room.php", true);

              xhr.onload = function()
              {


                if(this.responseText == 1){
                  window.location.href = "bookings.php?review_status=true";
                }
                
                else{
                  var myModal = document.getElementById('reviewModal');
                  var modal = bootstrap.Modal.getInstance(myModal);
                  modal.hide();

                  alert('error',"Đánh giá & nhận xét thất bại!");

                }
            }

              xhr.send(data);
        });
      </script>
</body>
</html>
