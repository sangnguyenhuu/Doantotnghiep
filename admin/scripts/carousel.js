
let carousel_s_form =document.getElementById('carousel_s_form');
let carousel_picture_inp =document.getElementById('carousel_picture_inp');


carousel_s_form.addEventListener('submit',function(e){
    e.preventDefault();
    add_image();
});

function add_image()
{
    let data = new FormData();
    data.append('picture', carousel_picture_inp.files[0]);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);

    xhr.onload = function(){
        
        var myModal = document.getElementById('carousel-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        
       
        if(this.responseText.trim() === 'inv_img'){
            alert('error','Chỉ những bức ảnh JPG and PNG được cho phép!');
        }
        else if(this.responseText.trim() == 'inv_size'){
            alert('error','Hình ảnh nên có kích cỡ nhỏ hơn 2MB!');
        }else if(this.responseText.trim() == 'upd_failed'){
            alert('error', 'Hình ảnh tải lên thất bại . Server lỗi');
        }else{
            alert('success', ' Hình ảnh trang web trượt mới được thêm thành công!');
            carousel_picture_inp.value='';
            get_carousel();
        }
   
}

        xhr.send(data);   

}

function get_carousel()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
         document.getElementById('carousel-data').innerHTML = this.responseText;

       
    }

    xhr.send('get_carousel');
}

function remove_image(val)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.responseText==1){
            alert('success', ' Ảnh dã được xóa!');
            get_carousel();
        }else{
            alert('error','Server ngừng hoạt động')
        }
    }

    xhr.send('remove_image=' + val);
}


window.onload =function(){
    get_carousel();
}
