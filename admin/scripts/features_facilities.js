
        let feature_s_form = document.getElementById('feature_s_form');
        let facility_s_form = document.getElementById('facility_s_form');

        feature_s_form.addEventListener('submit',function(e){
            e.preventDefault();
            add_feature();
        });

        function add_feature()
        {
            let data = new FormData();
            data.append('name', feature_s_form.elements['feature_name'].value);
            data.append('add_feature', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true);

            xhr.onload = function(){
                
                var myModal =document.getElementById('feature-s');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
                console.log(this.responseText);
                if(this.responseText == 1){
                    alert('success', 'Tiện ích mới được thêm vào thành công!');
                    feature_s_form.elements['feature_name'].value = '';
                    get_features();
            
                }else{
                    alert('error', 'Server lỗi!');

                }
            }
                xhr.send(data);
        }

        function get_features()
            {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/features_facilities.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function(){
                    document.getElementById('features-data').innerHTML = this.responseText;
                
                }

                xhr.send('get_features');
            }

        function remove_feature(val)
            {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/features_facilities.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                
                xhr.onload = function(){
                    if(this.responseText==1){
                        alert('success', ' Cơ sở vật chất đã được xóa!');
                        get_features();
                    
                    }else if(this.responseText.trim() === 'room_added'){
                        alert('error','Cơ sở vật chất đã được thêm vào phòng rồi')
                    }
                    else{
                        alert('error','Server ngừng hoạt động')
                    }
                }

                xhr.send('remove_feature=' + val);
            }

            facility_s_form.addEventListener('submit',function(e){
            e.preventDefault();
            add_facility();
        });

        function add_facility()
        {
            let data = new FormData();
            data.append('name', facility_s_form.elements['facility_name'].value);
            data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
            data.append('desc', facility_s_form.elements['facility_desc'].value);

            data.append('add_facility', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true);

            xhr.onload = function(){
                
                var myModal =document.getElementById('facility-s');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if(this.responseText.trim() === 'inv_size'){
                    alert('error','Hình ảnh chỉ có dung lượng dưới 1MB!');
                }else if(this.responseText.trim() === 'inv_img'){
                    alert('error','Chỉ hình ảnh đuôi SVG được cho phép');
                }else if(this.responseText.trim() === 'upd_failed'){
                    alert('error','Hình ảnh tải lên thất bại . Server lỗi!');
                }else{
            alert('success', 'Tiện ích mới đã được thêm vào thành công!');
            facility_s_form.reset();
            get_facilities();
        }
            }
                xhr.send(data);
            }
            
        function get_facilities()
        {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                document.getElementById('facilities-data').innerHTML = this.responseText;
            
            }

            xhr.send('get_facilities');
        }

                function remove_facility(val)
                {
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/features_facilities.php", true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function(){

                        if(this.responseText==1){
                            alert('success', ' Thiết bị đã được xóa!');
                            get_facilities();
                        
                        }else if(this.responseText.trim() ==='room_added'){
                            alert('error','Thiết bị đã được thêm vào trong phòng rồi')
                        }
                        else{
                            alert('error','Server ngừng hoạt động')
                        }
                    }

                    xhr.send('remove_facility=' + val);
                }
        

            window.onload =function()
            {
                get_features();
                get_facilities();
            }
   