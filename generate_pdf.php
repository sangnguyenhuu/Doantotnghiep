<?php 
    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');
    require('admin/inc/mpdf/vendor/autoload.php');

    date_default_timezone_set("Asia/Ho_Chi_Minh");
    session_start();
    if(isset($_GET['gen_pdf']) && isset($_GET['id']))
    {
        $frm_data = filteration($_GET);

        $query = "SELECT bo.*, bd.*, uc.email  FROM `booking_order` bo
        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
        INNER JOIN `user_cred` uc ON bo.user_id = uc.id
        WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
        OR (bo.booking_status = 'cancelled' AND bo.refund = 1)
        OR (bo.booking_status = 'payment failed'))
        AND bo.booking_id = '$frm_data[id]'";
       

       $res = mysqli_query($con,$query);

       $total_rows = mysqli_num_rows($res);

       if($total_rows ==0){
        header('location : dashboard.php');
        exit;
        }
    
        $data = mysqli_fetch_assoc($res);  
        $date = date("h:i a | d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));
        $ngay_gio_hien_tai = date("Y-m-d H:i:s");

       
       
        $table_data = "
       
        <h2>BIÊN LAI ĐẶT PHÒNG</h2>
        <table border = '1'>
        <tr>
            <td>Order ID: $data[order_id]</td>
            <td>Đặt phòng ngày: $date</td>
        </tr>
        <tr>
            <td colspan='2'> Trạng thái : $booking_status</td>
        </tr>
        <tr>
            <td>Tên: $data[user_name]</td>
            <td>Email: $data[email]</td>
        </tr>
        <tr>
            <td>Số điện thoại: $data[phonenum]</td>
            <td>Địa chỉ: $data[address]</td>
        </tr>
        <tr>
            <td>Tên phòng: $data[room_name]</td>
            <td>Giá: $formatted_price VNĐ mỗi đêm</td>
        </tr>
        <tr>
            <td>Đặt phòng: $checkin</td>
            <td>Trả phòng: $checkout</td>
        </tr>
        
       ";

     // Lấy giá trị 
     $total_pay = $data['total_pay'];
     $trans_amt = $data['trans_amt'];
     $additional_fee = $data['additional_fee'];

     // Định dạng giá trị với dấu phẩy sau mỗi 3 số 0
     $formatted_total_pay = number_format($total_pay, 0, '.', ',');
     $formatted_trans_amt =  number_format($trans_amt, 0, '.', ',');
     $formatted_additional_fee = number_format($additional_fee, 0, '.', ',');   

    
     
    if($data['booking_status'] == 'cancelled'){
        $refund = ($data['refund']) ? "Đã hoàn tiền" : "Vẫn chưa hoàn tiền";

        $table_data.="<tr>
        <td>Tổng tiền thanh toán: $formatted_trans_amt  VNĐ</td>
        <td>Hoàn tiền : $refund</td>
        </tr>
        <tr>
        <td>Ngày lập hóa đơn : $ngay_gio_hien_tai</td>
         </tr>";
    }
    else if($data['booking_status'] == 'payment failed')
    {   
        $table_data.="<tr>
        <td>Số tiền giao dịch : $formatted_trans_amt VNĐ</td>
        <td>Lý do : $data[trans_status]</td>
        </tr>
        <tr>
        <td>Ngày lập hóa đơn : $ngay_gio_hien_tai</td>
         </tr>";
        
    }else{
        $table_data.="<tr>
        <td>Số phòng : $data[room_no]</td>
        <td>Thanh toán đặt phòng : $formatted_trans_amt VNĐ</td>
        </tr>
        <tr>
        <td>Ngày lập hóa đơn : $ngay_gio_hien_tai</td>
        <td>Chi phí phụ : $formatted_additional_fee VNĐ </td>
        </tr>
        <tr>
        <td> Thông tin chi phí phụ : $data[info_fee] </td>
        <td>Tổng tiền : $formatted_total_pay VNĐ </td>
         </tr>";
        
    }

        $table_data.="</table>";
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($table_data);
        $mpdf->Output($data['order_id'].'.pdf','D');
        
     

      
    }else{
        header('location: dashboard.php');
    }
    

?>