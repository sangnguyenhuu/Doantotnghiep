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
        OR (bo.booking_status = 'booked' AND bo.arrival = 0)
        OR (bo.booking_status = 'cancelled' AND bo.refund = 0)
        OR (bo.booking_status = 'cancelled' AND bo.refund = 1)
        OR (bo.booking_status = 'payment failed'))
        AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
        AND (bo.check_in = CURRENT_DATE())
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
        $showButton = true; // Mặc định hiển thị nút button
        while($data = mysqli_fetch_assoc($limit_res))
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
             
             if($data['booking_status'] == 'booked' && $data['arrival'] == 1 && $data['is_additional_fee']==1){
                $booking_status = 'Đã đặt phòng và trả phòng';
            }
            else if($data['booking_status'] == 'booked' && $data['arrival'] == 1){
                $booking_status = 'Đã đặt phòng và nhận phòng';
                $showButton = false;
            }else if($data['booking_status'] == 'cancelled' && $data['refund'] == 0 ){
                $booking_status = 'Đã hủy phòng và đang chờ nhận tiền';
                $showButton = false;
            }else if($data['booking_status'] == 'cancelled' && $data['refund'] == 1 ){
                $booking_status = 'Đã hủy phòng và nhận tiền';
            }else if($data['booking_status'] == 'payment failed'){
                $booking_status = 'Thanh toán thất bại';
            }else if($data['booking_status'] == 'booked' && $data['arrival'] == 0){
                $booking_status = 'Đã đặt phòng nhưng chưa nhận phòng';
                $showButton = false;
            }

            if($data['booking_status']=='booked')
            {
                $status_bg = 'bg-success';
            }
           else if($data['booking_status']=='cancelled')
            {
                $status_bg = 'bg-danger';
            }
            else 
            {
                $status_bg = 'bg-warning text-dark';
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
                <b>Tổng tiền: </b>  $formatted_trans_amt VNĐ
                <br>
                <b>Đặt phòng ngày: </b> $checkin
                <br>
                <b>Trả phòng ngày: </b> $checkout
            </td>
            <td>
                <span class = 'badge $status_bg'> $booking_status</span>
            </td>
            <td>
              
                    <button type='button' onclick='download($data[booking_id])' class='btn btn-outline-success btn-sm fw-bold shadow-none' ".($showButton ? '' : 'style="display: none;"').">
                         <i class='bi bi-file-earmark-arrow-down-fill'></i>
                    </button>
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
    
  



?>
