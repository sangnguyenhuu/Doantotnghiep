


function get_bookings(search='',page=1){
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/b_today.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        document.getElementById('table-data').innerHTML = data.table_data;
        document.getElementById('table-pagination').innerHTML = data.pagination;

    }
        xhr.send('get_bookings&search='+search+'&page='+page);
}

    function change_page(page){
        get_bookings(document.getElementById('search_input').value,page);
    }

    function download(id){
        window.location.href = 'generate_pdf.php?gen_pdf&id='+id;
    }
    function updateCurrentDate() {
        // Tạo một đối tượng Date mới để lấy ngày hôm nay
        var today = new Date();
        
        // Lấy các thành phần ngày, tháng, năm từ đối tượng Date
        var day = today.getDate();
        var month = today.getMonth() + 1; // Tháng bắt đầu từ 0, nên cần cộng thêm 1
        var year = today.getFullYear();
        
        // Hiển thị ngày hôm nay trong thẻ có id là "currentDate"
        document.getElementById("currentDate").innerHTML = "Hồ sơ đặt phòng ngày hôm nay " + day + "/" + month + "/" + year ;
    }


window.onload = function(){
    get_bookings();
    updateCurrentDate();
}