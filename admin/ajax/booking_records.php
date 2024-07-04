<?php 
    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();
    
    

    if(isset($_POST['get_bookings']))
    {
        $frm_data = filteration($_POST);

        $limit = 5;
        $page = $frm_data['page'];
        $start = ($page- 1) * $limit;

        // page 1 : 0, 10 , page 2: 

        // 0,1 , 1,1, 2,1 , 3,1 

       $query = "SELECT bo.*, bd.* FROM `booking_order` bo
        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
        WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
        OR (bo.booking_status = 'cancelled' AND bo.refund = 1)
        OR (bo.booking_status = 'payment failed'))
        AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
        ORDER BY bo.booking_id DESC";
        
        $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

        $limit_query = $query ." LIMIT $start,$limit";
        $limit_res = select($limit_query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

        

        $total_rows = mysqli_num_rows($res);

        if($total_rows ==0){
        $output = json_encode(["table_data"=>"<b>Không có dữ liệu cần tìm</b>", "pagination"=>'']);
            echo $output;
            exit;
        }
        
      
          
        $i = $start+1;
        $table_data = "";
        while($data = mysqli_fetch_assoc($limit_res))
        {
            
            $date = date("d-m-Y", strtotime($data['datentime']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));

             // Lấy giá trị p
             $total_pay = $data['total_pay'];
             $price = $data['price'];
             $trans_amt = $data['trans_amt'];
             $additional_fee = $data['additional_fee'];
             // Định dạng giá trị với dấu phẩy sau mỗi 3 số 0
             $formatted_total_pay = number_format($total_pay, 0, '.', ',');      
             $formatted_price = number_format($price, 0, '.', ',');  
             $formatted_trans_amt = number_format($trans_amt, 0, '.', ',');   
             $formatted_additional_fee = number_format($additional_fee, 0, '.', ',');   

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

            $status_bg = "";
            $btn = "";
            $chiphiphu = "";

            if($data['booking_status']=='booked')
            {
                $status_bg = 'bg-success';
                if($data['is_additional_fee'] == 0)
                {
                    $btn = "<button type='button' onclick = 'additional_fee($data[booking_id])' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#additional_costs'>
                    <i class='bi bi-check2-circle'>Chi phí phụ</i> 
                    </button>"; 
                    
                }else{
                    $btn = "<button type='button' onclick='download($data[booking_id])' class='btn btn-outline-success btn-sm fw-bold shadow-none'>
                    <i class='bi bi-file-earmark-arrow-down-fill'>Hóa đơn</i>
                    </button>";
                    $chiphiphu = " <br><b>Chi phí phụ : </b>  $formatted_additional_fee VNĐ
                                 <br><b>Tổng tiền :</b>  $formatted_total_pay VNĐ";
                    
                }
            }
           else if($data['booking_status']=='cancelled')
            {
                $status_bg = 'bg-danger';
                $btn = "<button type='button' onclick='download($data[booking_id])' class='btn btn-outline-success btn-sm fw-bold shadow-none'>
                <i class='bi bi-file-earmark-arrow-down-fill'>Hóa đơn</i>
                </button>";
            }
            else 
            {
                $status_bg = 'bg-warning text-dark';
                 $btn = "<button type='button' onclick='download($data[booking_id])' class='btn btn-outline-success btn-sm fw-bold shadow-none'>
                    <i class='bi bi-file-earmark-arrow-down-fill'>Hóa đơn</i>
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
                
                
                <b>Đã thanh toán đặt phòng  : </b>  $formatted_trans_amt VNĐ
                <br>
                <b>Số phòng  : </b>  $data[room_no]
                $chiphiphu
                <br>
                <b>Ngày đặt: </b> $date
                <br>
                <b>Ngày trả phòng</b> $checkout
            </td>
            <td>
                <span class = 'badge $status_bg'> $booking_status</span>
            </td>
            <td>
                $btn
            </td>

            </tr>

            ";
            $i++;
        }

        $pagination = "";

        if($total_rows > $limit)
        {
            $total_pages = ceil($total_rows/$limit);

            if($page!=1){
                $pagination .="  <li class='page-item'>
                <button onclick='change_page(1)' class='page-link shadow-none'>Đầu tiên</button>
                </li>";  
            }

            $disabled = ($page==1) ? "disabled" : "";
            $prev = $page-1;
            $pagination .="  <li class='page-item $disabled'>
            <button onclick='change_page($prev)' class='page-link shadow-none'>Trước</button>
            </li>";

            $disabled = ($page==$total_pages) ? "disabled" : "";
            $next = $page+1;
            $pagination .="  <li class='page-item $disabled'>
            <button onclick='change_page($next)' class='page-link shadow-none'>Sau</button>
            </li>";
            
            if($page!=$total_pages){
                $pagination .="  <li class='page-item'>
                <button onclick='change_page($total_pages)' class='page-link shadow-none'>Cuối</button>
                </li>";  
            }
        }


        $output = json_encode(["table_data"=>$table_data,"pagination" => $pagination]);

        echo $output;
       
    }  
    if(isset($_POST['additional_fee_booking']))
    {
        $frm_data = filteration($_POST);
       
        $query1 = "SELECT * from `booking_order` where `booking_id` = ?";
        $res1 = select($query1,[$frm_data['booking_id']],'i');

        $data = mysqli_fetch_assoc($res1);
        $trans_amt = $data['trans_amt'];
     
        $query2 = "UPDATE `booking_details` SET `total_pay` = ($trans_amt + ?), `additional_fee`=?, `info_fee`=? ,`is_additional_fee`=? WHERE `booking_id`=?";
         $res2 = update($query2,[$frm_data['additional_fee'],$frm_data['additional_fee'],$frm_data['info_fee'],1,$frm_data['booking_id']],'iisii');
        
         echo $res2;
    }
  



?>
