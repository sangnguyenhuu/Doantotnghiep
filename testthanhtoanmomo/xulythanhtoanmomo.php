    <?php
    header('Content-type: text/html; charset=utf-8');
    require('../admin/inc/db_config.php'); 
    require('../admin/inc/essentials.php'); 
    date_default_timezone_set("Asia/Ho_Chi_Minh");

    session_start();

  if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
    redirect('index.php');
  }



      function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        // thực thi post
        $result = curl_exec($ch);
        // đóng kết nối
        curl_close($ch);
        return $result;
    }
    if(isset($_POST['pay_now']))
    {
      header('Content-type: text/html; charset=utf-8');
  
  
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    $orderInfo = "Thanh toán qua MoMo";
    $amount = $_SESSION['room']['payment'];
    $orderId = time() ."";
    $redirectUrl = "https://localhost/HotelBookingWebsite/saukhithanhtoanmomo.php";
    $ipnUrl = "https://localhost/HotelBookingWebsitetestthanhtoanmomo/saukhithanhtoanmomo.php";
    $extraData = "";
    $customer_id = $_SESSION['uId'];
    $requestId = time() . "";
    $requestType = "payWithATM";
    $extraData = isset($_POST["extraData"]) ? $_POST["extraData"] : "";
    // trước khi ký HMAC SHA256
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature);

        
        
        $frm_data = filteration($_POST);
        
       $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`order_id`) VALUES (?,?,?,?,?)";

        insert($query1,[$customer_id,$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout'],$orderId],'issss');

        $booking_id = mysqli_insert_id($con);

        $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`,
         `user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";

         insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$amount,$frm_data['name'],$frm_data['phonenum'],$frm_data['address']],'issssss');

        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

    
    }
    // Chỉ là một ví dụ, vui lòng kiểm tra thêm ở đó
    if (isset($jsonResult['payUrl'])) {
        header('Location: ' . $jsonResult['payUrl']);
    } else {
        // Xử lý trường hợp khi 'payUrl' không tồn tại trong $jsonResult
    }
    
    ?>