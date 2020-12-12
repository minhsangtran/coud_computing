$(document).ready(function() {

 
    $('.summernote').summernote({

        height: 150,
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '20', '24', '28', '30', '32', '36', '40'],
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            // ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            // ['fontname', ['fontname']],
            // ['style', ['style']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            // ['height', ['height']],
            ['insert', ['table', 'link', 'image', 'doc', 'video', 'picture']], // image and doc are customized buttons
        ],
        callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            },
            onMediaDelete: function($target, $editable) {
                // console.log();   // get image url
                deleteImage($target.attr('src'));

            },
            onPaste: function(e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                setTimeout(function() {
                    document.execCommand('insertText', false, bufferText);
                }, 10);
            }
        }
    });

    function deleteImage(url) {
        var data = new FormData();
        data.append("url", url);
        var token = $('input[name=_token]').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $.ajax({
            url: '/admin-image/delete-img',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "post",

            success: function(data) {
                console.log(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function uploadImage(image) {
        var data = new FormData();
        data.append("image", image);
        var token = $('input[name=_token]').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $.ajax({
            url: '/admin-image/create-img-url',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "post",
            success: function(data) {

                var url = data['url'];
                var image = $('<img>').attr({ src: url, width: '100%' });
                $('.summernote').summernote("insertNode", image[0]);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    $('.dropdown-toggle').dropdown();
});