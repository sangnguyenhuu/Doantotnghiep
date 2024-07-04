


function get_users(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('users-data').innerHTML = this.responseText;
    }
        xhr.send('get_users');
}

function toggle_status(id,val)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        console.log(this.responseText);
        if(this.responseText==1)
        {
            alert('success','Chuyển đổi trạng thái thành công!');
            get_users();
          
        }else{
            alert('error','Server Down!');

        }
    }   
        xhr.send('toggle_status='+id+'&value='+val);
}


function remove_user(room_id)
{
    if(confirm("Bạn có chắc chắn bạn muốn xóa người dùng này không vậy?"))
    { 
        let data = new FormData();
        data.append('user_id', room_id);
        data.append('remove_user', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users.php", true);

        xhr.onload = function(){ 
          
            if(this.responseText == 1){
                alert('success', 'Người dùng được chọn đã được xóa thành công!');
                get_users();
            }else{
                alert('error','Người dùng được chọn xóa thất bại!');
                
            }
        }
        xhr.send(data);


    }
   

}

function search_user(username)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('users-data').innerHTML = this.responseText;
    }
        xhr.send('search_user&name='+username);
}


window.onload =function(){
    get_users();
}