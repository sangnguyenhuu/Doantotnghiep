function booking_analytics(period=1)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php",true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        document.getElementById('total_bookings').textContent = data.total_bookings;

        if (data.total_amt == null) {
            document.getElementById('total_amt').textContent =  ' 0 VNĐ';
        } else {
            document.getElementById('total_amt').textContent = addCommas(data.total_amt) + ' VNĐ';
        }

        document.getElementById('active_bookings').textContent = data.active_bookings;
        
        if (data.active_amt == null) {
            document.getElementById('active_amt').textContent =  ' 0 VNĐ';
        } else {
            document.getElementById('active_amt').textContent = addCommas(data.active_amt) + ' VNĐ';
        }

        document.getElementById('cancelled_bookings').textContent = data.cancelled_bookings;
        if (data.cancelled_amt == null) {
            document.getElementById('cancelled_amt').textContent =  ' 0 VNĐ';
        } else {
            document.getElementById('cancelled_amt').textContent = addCommas(data.cancelled_amt) + ' VNĐ';
        }
        
    }

    xhr.send('booking_analytics&period='+period);
}
// thêm 3 dấu phẩy sau 3 chữ số
function addCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function user_analytics(period=1)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php",true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);

        document.getElementById('total_new_reg').textContent = data.total_new_reg;
        document.getElementById('total_queries').textContent = data.total_queries;
        document.getElementById('total_reviews').textContent = data.total_reviews;

    }

    xhr.send('user_analytics&period='+period);
}
window.onload = function(){
    booking_analytics();
    user_analytics();
}