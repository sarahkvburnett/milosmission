if (document.querySelector('#img-uploader input')){
    document.querySelector('#img-uploader input').onchange = function(e){
        document.querySelector('#img-uploader img').src = window.URL.createObjectURL(e.target.files[0]);
    }
}
