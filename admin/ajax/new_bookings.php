<?php 
    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();
    
    

    if(isset($_POST['get_bookings']))
    {
        $frm_data = filteration($_POST);

       $query = "SELECT bo.*, bd.* FROM `booking_order` bo
        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
        WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
        and (bo.booking_status = ? AND bo.arrival = ?) ORDER BY bo.booking_id ASC";
        
        $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","booked",0],'sssss');
        $i = 1;
        $table_data = "";

        if(mysqli_num_rows($res) ==0){
            echo "<b>Không có dữ liệu cần tìm</b>";
            exit;
        }

        while($data = mysqli_fetch_assoc($res))
        {
            
            $date = date("d-m-Y", strtotime($data['datentime']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));

            // Lấy giá trị price và trans_amt từ $data
            $trans_amt = $data['trans_amt'];
            $price = $data['price'];

            // Định dạng giá trị price và trans_amt với dấu phẩy sau mỗi 3 số 0
            $formatted_trans_amt = number_format($trans_amt, 0, '.', ',');      
            $formatted_price = number_format($price, 0, '.', ',');  

            //lấy ngày hôm nay
            $current_date = date("d-m-Y");
            $btn = "";
            if($current_date == $checkin){
                $btn = "<button type='button' onclick='assign_room($data[booking_id])' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
                <i class='bi bi-check2-circle'></i>  Xác nhận phòng
                </button>";
            }

            $table_data .="
            <tr>
                <td>$i</td>
            <td>
                <span class='badge bg-primary'>
                    Order ID: $data[order_id]
                </span>
                <br>
                <b> Tên: </b> $data[user_name]
                <br>
                <b> Số điện thoại: </b> $data[phonenum]
            </td>
            <td>
                <b>Phòng: </b> $data[room_name]
                <br>
                <b>Giá: </b> $formatted_price VNĐ
            </td>
            <td>
                <b>Đặt phòng: </b> $checkin
                <br>
                <b>Trả phòng: </b> $checkout
                <br>
                <b>Tiền thanh toán: </b> $formatted_trans_amt VNĐ
                <br>
                <b>Ngày: </b> $date
            </td>
            <td>
              
                $btn
                <br>
                <button type='button' onclick='cancel_booking($data[booking_id])' class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none'>
                <i class='bi bi-trash'></i>  Hủy đặt phòng
                </button>
            </td>

            </tr>

            ";
            $i++;
        }

        echo $table_data;
    }   
    
    if(isset($_POST['assign_room']))
    {
        $frm_data = filteration($_POST);

        $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
        ON bo.booking_id = bd.booking_id
        SET bo.arrival = ? , bo.rate_review =?, bd.room_no = ?
        WHERE bo.booking_id = ?";
        
        $values = [1,0,$frm_data['room_no'],$frm_data['booking_id']]; 
        $res = update($query,$values,'iisi'); // no se update 2 dong sau do no se tra lai 2

        echo ($res == 2) ? 1 : 0;
    }

    if(isset($_POST['cancel_booking'])) 
    {
        $frm_data = filteration($_POST);
       
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=?  WHERE `booking_id`=?";
        $values = ['cancelled',0,$frm_data['booking_id']];
        $res = update($query,$values,'sii');

        echo $res;
    }




?>
