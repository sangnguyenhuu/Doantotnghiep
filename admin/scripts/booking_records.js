


function get_bookings(search='',page=1){
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/booking_records.php", true);
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

    let additional_fee_form = document.getElementById('additional_fee_form')

    function additional_fee(id)
    {
        additional_fee_form.elements['booking_id'].value = id;
    }

    additional_fee_form.addEventListener('submit',function(e){
        e.preventDefault();

        let data = new FormData();
        data.append('additional_fee', additional_fee_form.elements['additional_fee'].value);
        data.append('info_fee', additional_fee_form.elements['info_fee'].value);
        data.append('booking_id', additional_fee_form.elements['booking_id'].value);
        data.append('additional_fee_booking','');


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/booking_records.php", true);

        xhr.onload = function(){
            var myModal =document.getElementById('additional_costs');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();
            console.log(this.responseText);
            if(this.responseText == 1){
                alert('success','Xác nhận chi phí phụ thành công! Trả phòng và thanh toán thành công');
                additional_fee_form.reset();
                get_bookings();
            }else{
                alert('error','Server Down')
            }

        }
        
            xhr.send(data);
    });


window.onload =function(){
    get_bookings();
}