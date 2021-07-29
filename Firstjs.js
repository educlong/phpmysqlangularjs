
/*    <!-- ajax  hỗ trợ gửi nhận data trực tiếp, k cần load lại page (phần này là xử lý jquery)-->*/

$(function () {
    
    /*===== XỬ LÝ ADD CATEGORY =======*/
    /*khi dùng ajax mặc định chỉ lắng nghe những phần tử nào có sẵn lúc load nội dung ban đầu. Nếu dùng jquery để vẽ phần tử khác, thì jquery k thể bắt đc sự kiện click của phần tử này. Muốn bắt đc sự kiện của các phần tử mới cần sử dụng $("body").on...*/
    $('body').on('click', '.btnInsertNewsCategory', function(event) {   /*$('body').on lắng nghe body xem có thay đổi zì k*/
        /*lắng nghe zì, lắng nghe click, lắng nghe tại phần tử nào, phần tử btnInsertNewsCategory*/
        /*PHẦN 1: PHẦN XỬ LÝ DỮ LIỆU BÊN TRONG (đưa dữ liệu đc add vào database)*/
        $.ajax({
            url: 'AttributeHomejson/insertNewsCategoryAjax',
            type: 'POST',
            dataType: 'json',
            data: {nameNewsCatAjax: $("#inputNameNewsCatAjax").val()},
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        /*PHẦN 2: PHẦN XỬ LÝ ZAO DIỆN BÊN NGOÀI (hiển thị data ra ngoài trên view)*/
        .always(function(res) { /*lấy res từ controller ra (tại json_encode($this->db->insert_id()); trong controller*/
            // console.log(res);   /*res là data nhận về từ controllers vs đkiện controller in ra nội dung trả về json như trên*/
            insertEmpCompleted = 
            '<li class="nav-item pr-2 dropdown" >'
            +        '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
            +            $("#inputNameNewsCatAjax").val()+'    <!-- nameNewsCat: cột nameNewsCat trong database -->'
            +        '</a>' /*res: thuộc tính ID (đc lấy từ controller tại dòng lệnh json_encode($this->db->insert_id());  */

            +        '<!-- Update theo cách php (thông thường) -->'
            +        '<a href="<?= base_url() ?>AttributeHomejson/updateNewsCategoryOpenning/'+res+'" class="btn btn-warning" ><i class="fas fa-pencil-alt"></i></a>'
            +        '<!-- Delete theo cách php (thông thường) -->'
            +        '<a href="<?= base_url() ?>AttributeHomejson/deleteNewsCategory/'+res+'" class="btn btn-danger" ><i class="fas fa-trash"></i></a>'

            +        '<!-- Update theo jquery (ajax) -->'
            +        '<a data-href="<?= base_url() ?>AttributeHomejson/updateNewsCategoryOpenning/'+res+'"  class="btn btn-warning btnUpdateCategoryByAjaxOpenning" >'
            +            '<div>Ajax</div>'
            +            '<i class="fas fa-pencil-alt"></i>'
            +        '</a>'
            +        '<!-- Delete theo jquery (ajax) -->'
            +        '<a data-href="'+res+'" class="btn btn-danger btnDeleteCategoryByAjax">'
            +            '<div>Ajax</div>'
            +            '<i class="fas fa-trash"></i>'
            +        '</a>  <!-- hidden-xs-up: từ màn hình mobile trở lên thì 2 input này sẽ bị ẩn đi -->'

            +        '<div class="row hidden-xs-up">'
            // +            '<form action="AttributeHomejson/insertNewsCategory" method="POST" enctype="multipart/form-data">'
            +                '<div class="form-group row text-center">'
            +                    '<div class="col-sm-6 push-sm-1">'
            +                        '<input type="hidden" class="form-control " name="updateIdNewsCatAjax" id="updateIdNewsCatAjax" value="'+res+'">'
            +                        '<input type="text" class="form-control" name="updateNameNewsCatAjax" id="updateNameNewsCatAjax" placeholder="Update" value="'+$("#inputNameNewsCatAjax").val()+'">'
            +                    '</div>'
            +                    '<div class="col-sm-5" style="margin-left: 5px;">'
            +                        '<div href="" class="btn btn-primary btnUpdateCategoryByAjax" >Update</div>'
            +                    '</div>'
            +                '</div>'
            // +            '</form>'
            +        '</div>'
            +        '<div class="dropdown-menu ml-3" aria-labelledby="navbarDropdown">'
            +            '<a class="dropdown-item" href="#">Action</a>'
            +            '<a class="dropdown-item" href="#">Another action</a>'
            +            '<div class="dropdown-divider"></div>'
            +            '<a class="dropdown-item" href="#">Something else here</a>'
            +        '</div>'
            +    '</li>'
            $(".navbar-nav.allCategories").append(insertEmpCompleted);
            $("#inputNameNewsCatAjax").val("");
        });
        
    });






    /*===== XỬ LÝ DELETE CATEGORY =======*/
    /*khi dùng ajax mặc định chỉ lắng nghe những phần tử nào có sẵn lúc load nội dung ban đầu. Nếu dùng jquery để vẽ phần tử khác, thì jquery k thể bắt đc sự kiện click của phần tử này. Muốn bắt đc sự kiện của các phần tử mới cần sử dụng $("body").on...*/
    $('body').on('click', '.btnDeleteCategoryByAjax', function(event) {    /*$('body').on lắng nghe body xem có thay đổi zì k*/
        /*tức là lắng nghe xem btnDeleteCategoryByAjax có phần tử nào mới k, nếu có thì add vào bộ nhớ đệm để xử lý luôn*/
        /*PHẦN 1: PHẦN XỬ LÝ DỮ LIỆU BÊN TRONG (đưa dữ liệu đc add vào database)*/
        var deleteObject = $(this).parent();    /*lấy parent của phần tử xóa: $(this): là .btnDeleteCategoryByAjax
                                                      .parent() thứ nhất: là <li class="nav-item pr-2 dropdown" >
                                                      .parent() thứ 2: là div cha của <li class="nav-item pr-2 dropdown" >
                                                      ...*/
        $.ajax({/*lấy thuộc tính data-href để delete, mỗi data-href có chữa mã  idNewsCat => chỉ cần truy xuất đển mã đó là lấy đc*/
            url: 'AttributeHomejson/deleteNewsCategory/'+ $(this).data('href'), /*data('href'):lấy thuộc tính data-hrefcủa button*/
            type: 'POST',   /*Phần này (url: 'Att...) là xóa trên dữ liệu*/
            dataType: 'json'

        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {    /*dùng jquery xóa luôn phần tử, ở trên dữ liệu đã đc xóa, phần này là xóa trên zao diện*/
        /*PHẦN 2: PHẦN XỬ LÝ ZAO DIỆN BÊN NGOÀI (hiển thị data ra ngoài trên view)*/
            deleteObject.remove();
            
        });
    });




    /*===== XỬ LÝ HIỂN THỊ CỬA SỔ UPDATE CATEGORY (UPDATE CATEGORY OPPENING)=======*/
    $("body").on('click', '.btnUpdateCategoryByAjaxOpenning', function(event) {
        /*BƯỚC 1: XỬ LÝ TRÊN ZAO DIỆN (ẨN CỬA SỔ HIỂN THỊ, HIỆN CỬA SỔ CHỈNH SỬA)*/
        $(this).parent().children('a').addClass('hidden-xs-up');/*parent():đến thẻ parent của a là thẻ li, và tìm (find) thẻ a. Sau đó*/
        $(this).next().next().removeClass('hidden-xs-up')   /*cho tất cả thẻ a addClass. Và ở đây cho thẻ 2 lần kế tiếp hiện lên*/
                      
    });


    /*===== XỬ LÝ UPDATE CATEGORY (UPDATE CATEGORY)=======*/
    $("body").on('click', '.btnUpdateCategoryByAjax', function(event) {
        // $(this).parent().parent().parent().parent().addClass('hidden-xs-up');
        // $(this).parent().parent().parent().parent().parent().children('a').removeClass('hidden-xs-up');
        var idUpdateAjax = $(this).parent().parent().children().children('#updateIdNewsCatAjax').val();
        var nameUpdateAjax = $(this).parent().parent().children().children('#updateNameNewsCatAjax').val();
        console.log(idUpdateAjax);  /*lấy id của phần tử đc click*/
        console.log(nameUpdateAjax);/*lấy name của phần tử đc click*/
        /*BƯỚC 2: XỬ LÝ DỮ LIỆU (SỬ DỤNG ajax để KẾT NỐI VS CONTROLLER ĐỂ CẬP NHẬT DATA*/
        $.ajax({
            url: 'AttributeHomejson/updateNewsCategoryAjax',    /*update đc truyền đến controller tại updateNewsCategoryAjax để update*/
            type: 'POST',
            dataType: 'json',
            data: {
                updateIdNewsCatAjax: idUpdateAjax,   /*id*/
                updateNameNewsCatAjax: nameUpdateAjax/*name*/
            },
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        /*BƯỚC 3: XỬ LÝ UPDATE DỮ LIỆU XONG THÌ HIỂN THỊ LẠI TRẠNG THÁI BAN ĐẦU*/
        $(this).parent().parent().parent().addClass('hidden-xs-up');                            /*thẻ row trong ul li bị ẩn đi*/
        $(this).parent().parent().parent().parent().children('a.nav-link').html(nameUpdateAjax);/*add lại tên cho thẻ a.nav-link*/
        $(this).parent().parent().parent().parent().children('a').removeClass('hidden-xs-up');  /*các thẻ a trong ul li hiện ra*/
    });







    /*PHẦN XỬ LÝ NEWS (BẢNG DATABASE: newscontent)*/
    /*XỬ LÝ ckeditor*/
    CKEDITOR.replace( 'newsCon', {
        filebrowserBrowseUrl: 'ckeditor/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckeditor/ckfinder/ckfinder.html?Type=Images',
        filebrowserUploadUrl: 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserWindowWidth : '1000',
        filebrowserWindowHeight : '700'
    });
    CKEDITOR.replace( 'summaryNews', {
        filebrowserBrowseUrl: 'ckeditor/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckeditor/ckfinder/ckfinder.html?Type=Images',
        filebrowserUploadUrl: 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserWindowWidth : '1000',
        filebrowserWindowHeight : '700'
    });
});


















