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
        and (bo.booking_status = ? AND bo.refund = ?) ORDER BY bo.booking_id ASC";
        
        $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","cancelled",0],'sssss');
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

            // Lấy giá trị trans_amt từ $data
            $trans_amt = $data['trans_amt'];
           

            // Định dạng giá trị trans_amt với dấu phẩy sau mỗi 3 số 0
            $formatted_trans_amt = number_format($trans_amt, 0, '.', ',');      
            

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
                <b>Đặt phòng: </b> $checkin
                <br>
                <b>Trả phòng: </b> $checkout
                <br>
                <b>Ngày: </b> $date
                <td>
                <b>$formatted_trans_amt VNĐ </b> 
                </td>
            </td>
            <td>
              
              

                <button type='button' onclick='refund_booking($data[booking_id])' class='btn btn-success btn-sm fw-bold shadow-none'>
                <i class='bi bi-cash-stack'></i>  Hoàn tiền
                </button>
            </td>

            </tr>

            ";
            $i++;
        }

        echo $table_data;
    }   
    

    if(isset($_POST['refund_booking'])) 
    {
        $frm_data = filteration($_POST);
       
        $query = "UPDATE `booking_order` SET `refund`= ?  WHERE `booking_id`=?";
        $values = [1,$frm_data['booking_id']];
        $res = update($query,$values,'ii');

        echo $res;
    }




?>
