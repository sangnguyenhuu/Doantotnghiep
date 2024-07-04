<?php 
 require('inc/essentials.php');
 require('inc/db_config.php');

 adminLogin();

    if(isset($_GET['seen']))
    {
        $frm_data = filteration($_GET);

        if($frm_data['seen'] == 'all'){
            $query = "UPDATE `user_queries` SET `seen`=?";
            $values = [1];
            if(update($query,$values,'i')){
                alert('success','Đánh dấu đã đọc tất cả!');
            }else{
                alert('error','Có lỗi xảy ra');
            }
        }else{
            $query = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
            $values = [1,$frm_data['seen']];
            if(update($query,$values,'ii')){
                alert('success','Đánh dấu đã đọc!');
            }else{
                alert('error','Có lỗi xảy ra');
            }
        }
    }
    if(isset($_GET['del']))
    {
        $frm_data = filteration($_GET);

        if($frm_data['del'] == 'all'){
            $query = "DELETE FROM `user_queries`";
            if(mysqli_query($con,$query)){
                alert('success','Tất cả dữ liệu đã được xóa!');
            }else{
                alert('error','Có lỗi xảy ra');
            }
        }else{
            $query = "DELETE FROM `user_queries` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if(delete($query,$values,'i')){
                alert('success','Dữ liệu đã được xóa!');
            }else{
                alert('error','Có lỗi xảy ra');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cơ sở vật chất và thiết bị</title>
    <?php require('inc/links.php'); ?>
    <?php require('inc/header.php');?>


</head>

<body class ="bg-light">

       

    <div class="container-fluild" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
               <h3 class="mb-4">Cơ sở vật chất và thiết bị</h3>

             <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                  
                <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class = "class-title m-0">Cơ sở vật chất</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feature-s">
                        <i class="bi bi-plus-square-fill"></i> Thêm
                        </button>
                    </div>

                  <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                  <table class="table table-hover">
                    <thead>
                        <tr class ="bg-dark text-light">
                        <th scope="col">STT</th>
                        <th scope="col">Tên</th>
                        <th scope="col" >Hành động</th>
                        </tr>
                    </thead>
                    <tbody id = "features-data">  
                    </tbody>
                    </table>
                  </div>
                              
                </div>
                </div>  

                <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                  
                <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class = "class-title m-0">Thiết bị</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
                        <i class="bi bi-plus-square-fill"></i> Thêm
                        </button>
                    </div>

                  <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                  <table class="table table-hover">
                    <thead>
                        <tr class ="bg-dark text-light">
                        <th scope="col">STT</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Tên</th>
                        <th scope="col" width = "40%">Miêu tả</th>
                        <th scope="col" >Hành động</th>
                        </tr>
                    </thead>
                    <tbody id = "facilities-data">  
                    </tbody>
                    </table>
                  </div>
                              
                </div>
                </div> 

                
            </div>
        </div>
    </div>

     <!-- Phương thức của cơ sở vật chất khách sạn  -->
     <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="feature_s_form">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Thêm cơ sở vật chất</h5>
                    </div>
                    <div class="modal-body">
                    <div class="mb-3">
    					<label class="form-label fw-bold">Tên </label>
    					<input type="text"  name ="feature_name" class="form-control shadow-none" required>
    				</div>
                    
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                        <button type="submit" class="btn custom-bg text-black shadow-none">Đồng ý</button>
                    </div>
                    </div>
                    </form>
                </div>
                </div>

    <!-- Phương thức của thiết bị khách sạn  -->
    <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="facility_s_form">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Thêm thiết bị </h5>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Tên </label>
                <input type="text"  name ="facility_name" class="form-control shadow-none" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Icon</label>
                <input type="file"  name ="facility_icon"  accept=".svg" class="form-control shadow-none" required>
            </div>
                <div class="mb-3">
    					<label class="form-label">Miêu tả</label>
    					<textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
    				</div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn text-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="submit" class="btn custom-bg text-black shadow-none">Đồng ý</button>
            </div>
            </div>
            </form>
        </div>
        </div>

    <?php require('inc/scripts.php'); ?>
   <script src="scripts/features_facilities.js"></script>
    
</body>
</html>