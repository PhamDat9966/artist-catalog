$(document).ready(function() {

	// var ojbectURL	= window.location;
    // console.log(ojbectURL);
	// var searchParams = new URLSearchParams(window.location.search);
	// var paramsString	 = (searchParams.get('search_value').replace(/\s+/g,'+'));
	// console.log(paramsString);
    // end test

	let $btnSearch                  = $("button#btn-search");
	let $btnClearSearch	            = $("button#btn-clear-search");

	let $inputSearchField           = $("input[name  = search_field]");
	let $inputSearchValue           = $("input[name  = search_value]");

    let $selectFilter               = $("select[name =  select_filter]");
	let $selectChangeAttr           = $("select[name =  select_change_attr]");
	let $selectChangeAttrAjax       = $("select[name =  select_change_attr_ajax]");

    let $selectChangeDisplayFilter  = $("select[name =  select_change_display_filter]");
    let $selectChangeIsHomeFilter   = $("select[name =  select_change_is_home_filter]");

    let $selectChangeCategoryFilter = $("select[name =  select_change_is_category_filter]");
    let $selectChangeTypeFilter     = $("select[name =  select_change_type_filter]");
    let $selectChangeSexFilter      = $("select[name =  select_change_sex_filter]");
    let $selectChangeColorFilter    = $("select[name =  select_change_color_filter]");
    let $selectChangeMaterialFilter = $("select[name =  select_change_material_filter]");

    let $inputOrdering              = $("input.ordering");
    let $inputPrice                 = $("input.price-product");
    let $inputQuanity               = $("input.quantity-cart");
    let $btnStatus                  = $('.status-ajax');
    let $btnIsHome                  = $('.is-home-ajax');
    let $btnIsNew                   = $('.is-new-ajax');
    let $btnIsPhoneCategory         = $('.is-phone-category-ajax');


	//let searchParams= new URLSearchParams(window.location.search);
	let searchParams	= window.location.search;

	$("a.select-field").click(function(e) {
		e.preventDefault();

		let field 		= $(this).data('field');
		let fieldName 	= $(this).html();
		$("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
    	$inputSearchField.val(field);
	});

	// $btnSearch.click(function() {

	// 	var pathname	= window.location.pathname;
	// 	let searchParams= new URLSearchParams(window.location.search);
	// 	params 			= ['page', 'filter_status', 'select_field', 'select_value'];

	// 	let link		= "";
	// 	$.each( params, function( key, value ) {
	// 		if (searchParams.has(value) ) {
	// 			link += value + "=" + searchParams.get(value) + "&"
	// 		}
	// 	});

	// 	let search_field = $inputSearchField.val();
	// 	let search_value = $inputSearchValue.val();
    //     // test
	// 	// let hrefRam		 = pathname + "?" + link + 'search_field='+ search_field + '&search_value=' + search_value.replace(/\s+/g, '+').toLowerCase();// Khoảng trắng được thay bằng dấu cộng "+".
	// 	// console.log(hrefRam);
    //     // end test

    //     // Đẩy các giá trị được nhập tại các input lên url window
	// 	window.location.href = pathname + "?" + link + 'search_field='+ search_field + '&search_value=' + search_value.replace(/\s+/g, '+').toLowerCase();

	// });

    $btnSearch.click(function(){
        var pathname = window.location.pathname; //path hien tai không bao gồm param, tức là chỉ lấy đến hết dấu hỏi
        var search_field    = $inputSearchField.val();
        var search_value    = $inputSearchValue.val();

        let params          = ['filter_status','filter_is_home','filter_display','filter_category','filter_type','filter_date','filter_color','filter_material'];
        let link            = '';
        var searchParams    = new URLSearchParams(window.location.search);

        $.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&";
			}
		});

        window.location.href    = pathname + '?' + link + 'search_field=' + search_field + '&' + 'search_value=' + search_value.replace(/\s+/g, '+').toLowerCase();

    });

	// $btnClearSearch.click(function() {
	// 	var pathname	= window.location.pathname;
	// 	let searchParams= new URLSearchParams(window.location.search);

	// 	params 			= ['page', 'filter_status', 'select_filter'];

	// 	let link		= "";
	// 	$.each( params, function( key, value ) {
	// 		if (searchParams.has(value) ) {
	// 			link += value + "=" + searchParams.get(value) + "&"
	// 		}
	// 	});

	// 	window.location.href = pathname + "?" + link.slice(0,-1);
	// });
	$btnClearSearch.click(function() {
		let $path 	= window.location.pathname;
		let searchParams	= new URLSearchParams(window.location.search);

		let $filter = "filter_status";
		let link	= '';
		if(searchParams.has($filter)){
			link	+= $filter + "=" + searchParams.get($filter) + "&";
		}
		window.location.href	= $path + "?" +link.slice(0,-1);

	});

	//Event onchange select filter
	$selectFilter.on('change', function () {
		var pathname	= window.location.pathname;
		let searchParams= new URLSearchParams(window.location.search);

		params 			= ['page', 'filter_status', 'filter_display', 'filter_is_home' ,'search_field', 'search_value'];

		let link		= "";
		$.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});

		let select_field = $(this).data('field');
		let select_value = $(this).val();
		window.location.href = pathname + "?" + link.slice(0,-1) + 'select_field='+ select_field + '&select_value=' + select_value;
 	});

	// Change attributes with selectbox
	// $selectChangeAttr.on('change', function() {
	// 	let item_id = $(this).data('id');
	// 	let url = $(this).data('url');
	// 	let csrf_token = $("input[name=csrf-token]").val();
	// 	let select_field = $(this).data('field');
	// 	let select_value = $(this).val();
	//
	// 	$.ajax({
	// 		url : url,
	// 		type : "post",
	// 		dataType: "html",
	// 		headers: {'X-CSRF-TOKEN': csrf_token},
	// 		data : {
	// 			id : item_id,
	// 			field: select_field,
	// 			value: select_value
	// 		},
	// 		success : function (result){
	// 			if(result == 1)
	// 				alert('Bạn đã cập nhật giá trị thành công!');
	// 			else
	// 				console.log(result)
	//
	// 		}
	// 	});
	// });

	// $selectChangeAttr.on('change', function() {
    //     console.log(this.value);
	// 	let select_value = $(this).val();
	// 	let $url = $(this).data('url');
	// 	window.location.href = $url.replace('value_new', select_value);
	// });

    $selectChangeDisplayFilter.on('change',function(){
        var select_value  = $(this).val();
        var url           = $(this).attr('data-url');

        let searchParams = new URLSearchParams(window.location.search);

        params 			= ['page', 'filter_status', 'filter_is_home','search_field', 'search_value'];
        let link        = '';

        $.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});
        window.location.href    = url + '?' + link + 'filter_display=' + select_value;;

        // url = url+'?filter_display='+select_value;
        // console.log(url);
    });

    $selectChangeIsHomeFilter.on('change',function(){
        var select_value  = $(this).val();
        var url           = $(this).attr('data-url');

        let searchParams = new URLSearchParams(window.location.search);

        params 			= ['page', 'filter_status','filter_display', 'search_field', 'search_value'];
        let link        = '';

        $.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});
        window.location.href    = url + '?' + link + 'filter_is_home=' + select_value;

        // url = url+'?filter_display='+select_value;
        // console.log(url);
    });

	// $selectChangeAttrAjax.on('change', function() {
	// 	let select_value = $(this).val();
	// 	let $url = $(this).data('url');
	// 	let csrf_token = $("input[name=csrf-token]").val();

	// 	$.ajax({
	// 		url : $url.replace('value_new', select_value),
	// 		type : "GET",
	// 		dataType: "json",
	// 		headers: {'X-CSRF-TOKEN': csrf_token},
	// 		success : function (result){
	// 			if(result) {
	// 				$.notify({
	// 					message: "Cập nhật giá trị thành công!"
	// 				}, {
	// 					delay: 500,
	// 					allow_dismiss: false
	// 				});
	// 			}else {
	// 				console.log(result)
	// 			}
	// 		}
	// 	});

	// });

    /*article*/
    $selectChangeCategoryFilter.on('change',function(){
        var select_value  = $(this).val();
        var url           = $(this).attr('data-url');
        //var pathname	= window.location.pathname;

        let searchParams = new URLSearchParams(window.location.search);

        params 			= ['filter_status','search_field', 'search_value'];
        let link        = '';

        $.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});
        window.location.href    = url + '?' + link + 'filter_category=' + select_value;

        // url = url+'?filter_display='+select_value;
        // console.log(url);
    });

    $selectChangeTypeFilter.on('change',function(){
        var select_value  = $(this).val();
        var url           = $(this).attr('data-url');
        //var pathname	= window.location.pathname;

        let searchParams = new URLSearchParams(window.location.search);

        params 			= ['filter_status','filter_category','search_field', 'search_value'];
        let link        = '';

        $.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});
        window.location.href    = url + '?' + link + 'filter_type=' + select_value;

        // url = url+'?filter_display='+select_value;
        // console.log(url);
    });

    $selectChangeColorFilter.on('change',function(){
        var select_value  = $(this).val();
        var url           = $(this).attr('data-url');
        //var pathname	= window.location.pathname;

        let searchParams = new URLSearchParams(window.location.search);

        params 			= ['filter_material','search_field','search_value'];
        let link        = '';

        $.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});
        window.location.href    = url + '?' + link + 'filter_color=' + select_value;

        // url = url+'?filter_display='+select_value;
        // console.log(url);
    });

    $selectChangeMaterialFilter.on('change',function(){
        var select_value  = $(this).val();
        var url           = $(this).attr('data-url');
        //var pathname	= window.location.pathname;

        let searchParams = new URLSearchParams(window.location.search);

        params 			= ['filter_color','search_field','search_value'];
        let link        = '';

        $.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});
        window.location.href    = url + '?' + link + 'filter_material=' + select_value;

        // url = url+'?filter_display='+select_value;
        // console.log(url);
    });

    $selectChangeSexFilter.on('change',function(){
        var select_value  = $(this).val();
        var url           = $(this).attr('data-url');
        //var pathname	= window.location.pathname;

        let searchParams = new URLSearchParams(window.location.search);

        params 			= ['filter_status','filter_timeMeet','search_field', 'search_value'];
        let link        = '';

        $.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});
        window.location.href    = url + '?' + link + 'filter_sex=' + select_value;

        // url = url+'?filter_display='+select_value;
        // console.log(url);
    });

    //Confirm button delete item
	$('.btn-delete').on('click', function() {
		if(!confirm('Bạn có chắc muốn xóa phần tử?'))
			return false;
	});

	//Init datepicker
	// $('.datepicker').datepicker({
	// 	format: 'dd-mm-yyyy',
	// });

    // Change Ajax Category Display
    $selectChangeAttrAjax.on('change',function(){
        let element         = $(this);
        var selectValue     = $(this).val();
        var url             = $(this).data('url');
        var selectChangeID  = $(this).attr("id");
        var inputId         = selectChangeID.charAt(selectChangeID.length - 1);
        url                 = url.replace("value_new",selectValue)
        console.log(url);
        callAjax(element,url,inputId,'select-box');
        // $.ajax({
        //     type: "GET",
        //     url: url,
        //     success: function (response) {
        //         try {
        //             // Cho trường hợp có gắn modified và modified_by
        //             var modified    = response.modified;
        //             var modifiedBy  = response.modified_by;

        //             // Cập nhật html các phần tử của p gồm modified và modified_by
        //             $("p.modified-"+inputId).html(modified);
        //             $("p.modified-by-"+inputId).html(modifiedBy);

        //             // Hiển thị thông báo thành công
        //             element.notify("Cập nhật thành công!",
        //                 { className: "success", position: "top" }
        //             );
        //         } catch (error) {
        //             console.log(response);
        //             // Cho trường hợp không gắn modified và modified_by
        //             element.notify("Cập nhật thành công!",
        //                 { className: "success", position: "top" }
        //             );
        //         }
        //     }
        // });
    });

    $inputOrdering.on('change',function(){
        let element      = $(this);
        var selectValue  = $(this).val();
        var url          = $(this).data('url');
        var orderingId   = $(this).attr("id");
        var inputId      = orderingId.charAt(orderingId.length - 1);
        url              = url.replace("value_new",selectValue);

        callAjax(element,url,inputId,'ordering');
        // $.ajax({
        //     type: "GET",
        //     url: url,
        //     success: function (response) {
        //         try {
        //             // Cho trường hợp có gắn modified và modified_by
        //             console.log(response);
        //             var modified    = response.modified;
        //             var modifiedBy  = response.modified_by;

        //             // Cập nhật html các phần tử của p gồm modified và modified_by
        //             $("p.modified-"+inputId).html(modified);
        //             $("p.modified-by-"+inputId).html(modifiedBy);

        //             // Hiển thị thông báo thành công
        //             element.notify("Cập nhật thành công!",
        //                 { className: "success", position: "top" }
        //             );
        //         } catch (error) {
        //             // Cho trường hợp không gắn modified và modified_by
        //             element.notify(response,
        //                 { className: "success", position: "top" }
        //             );
        //         }
        //     }
        // });
    });

    $inputPrice.on('change',function(){
        let element      = $(this);
        var selectValue  = $(this).val();
        var url          = $(this).data('url');
        var orderingId   = $(this).attr("id");
        var inputId      = orderingId.charAt(orderingId.length - 1);
        url              = url.replace("value_new",selectValue);

        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                try {

                    // Hiển thị thông báo thành công
                    element.notify("Cập nhật thành công!",
                        { className: "success", position: "top" }
                    );
                } catch (error) {
                    // Cho trường hợp không gắn modified và modified_by
                    element.notify(response,
                        { className: "success", position: "top" }
                    );
                }
            }
        });

    });

    $inputQuanity.on('change',function(){
        let element      = $(this);
        var selectValue  = $(this).val();
        var url          = $(this).data('url');
        var orderingId   = $(this).attr("id");
        var inputId      = orderingId.charAt(orderingId.length - 1);
        url              = url.replace("value_new",selectValue);

        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                try {
                    console.log(response);
                    console.log(response.params.id);
                    // Hiển thị thông báo thành công
                    element.notify("Cập nhật thành công!",
                        { className: "success", position: "top" }
                    );
                    let price = response.price;

                    $('#price-'+response.params.id).html(price);
                } catch (error) {
                    // Cho trường hợp không gắn modified và modified_by
                    element.notify(response,
                        { className: "success", position: "top" }
                    );
                }
            }
        });

    });

    //$btnStatus = $('.status-ajax');
    $btnStatus.on('click', function() {
        let element         = $(this);
        let btn             = $(this);
        let currentClass    = $(this).data('class');
        var statusId        = $(this).attr("id");
        var inputId         = statusId.charAt(statusId.length - 1);
        let url             = $(this).data('url');
        callAjax(element,url,inputId,'status');
        // $.ajax({
        //     type: "GET",
        //     url: url,

        //     success: function (response) {
        //         try {
        //             // Trường hợp có thay đổi modified và modified_by
        //             var newClass = response.status.class;
        //             btn.removeClass();
        //             btn.addClass(newClass);

        //             btn.data("class", response.class);

        //             btn.attr('data-class',response.class)
        //             btn.html(response.status.name);

        //             btn.data("url", response.link);         // thay đổi `url` và  lưu trữ nó trong bộ nhớ của jQuery
        //             btn.attr('data-url',response.link)      // thay đổi `url` HTML

        //             var modified    = response.modified;
        //             var modifiedBy  = response.modified_by;

        //             // Cập nhật html các phần tử của p gồm modified và modified_by
        //             $("p.modified-"+inputId).html(modified);
        //             $("p.modified-by-"+inputId).html(modifiedBy);

        //             btn.notify("Cập nhật thành công!",
        //                 { className: "success" , position:"top"  }
        //             );

        //         } catch (error) {
        //             // Cho trường hợp không gắn modified và modified_by
        //             btn.notify("Cập nhật thành công!",
        //                 { className: "success" , position:"top"  }
        //             );
        //         }
        //     }
        // });
	});

    $btnIsHome.on('click', function() {
        let element         = $(this);
        let currentClass    = $(this).data('class');

        var isHomeId        = $(this).attr("id");
        var inputId         = isHomeId.charAt(isHomeId.length - 1);
        let url             = $(this).data('url');

        callAjax(element,url,inputId,'is-home');
        // $.ajax({
        //     type: "GET",
        //     url: url,

        //     success: function (response) {

        //         try {
        //             // Trường hợp có thay đổi modified và modified_by
        //             var newClass = response.isHome.class;
        //             btn.removeClass();
        //             btn.addClass(newClass);

        //             btn.data("class", response.class);

        //             btn.attr('data-class',response.class)
        //             btn.html(response.isHome.name);

        //             btn.data("url", response.link);         // thay đổi `url` và  lưu trữ nó trong bộ nhớ của jQuery
        //             btn.attr('data-url',response.link)      // thay đổi `url` HTML

        //             var modified    = response.modified;
        //             var modifiedBy  = response.modified_by;

        //             // Cập nhật html các phần tử của p gồm modified và modified_by
        //             $("p.modified-"+inputId).html(modified);
        //             $("p.modified-by-"+inputId).html(modifiedBy);

        //             btn.notify("Cập nhật thành công!",
        //                 { className: "success" , position:"top"  }
        //             );

        //         } catch (error) {
        //             // Cho trường hợp không gắn modified và modified_by
        //             btn.notify("Cập nhật thành công!",
        //                 { className: "success" , position:"top"  }
        //             );
        //         }
        //     }
        // });

	});

    $btnIsNew.on('click', function() {
        let element         = $(this);
        let currentClass    = $(this).data('class');

        var isHomeId        = $(this).attr("id");
        var inputId         = isHomeId.charAt(isHomeId.length - 1);
        let url             = $(this).data('url');
        console.log('is new ajax');

        callAjax(element,url,inputId,'is-new');

	});

    $btnIsPhoneCategory.on('click', function() {
        let element         = $(this);
        let currentClass    = $(this).data('class');

        var isPhoneCategoryId       = $(this).attr("id");
        var inputId                 = isPhoneCategoryId.charAt(isPhoneCategoryId.length - 1);
        let url                     = $(this).data('url');
        //console.log(element,url,inputId);
        callAjax(element,url,inputId,'is-phone-category');

	});

    function callAjax(element,url,inputId,type){
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                console.log(response);
                try {
                    // Trường hợp có thay đổi modified và modified_by
                    switch(type){
                        case 'ordering':
                            var modified    = response.modified;
                            var modifiedBy  = response.modified_by;

                            // Cập nhật html các phần tử của p gồm modified và modified_by
                            $("p.modified-"+inputId).html(modified);
                            $("p.modified-by-"+inputId).html(modifiedBy);

                            // Hiển thị thông báo thành công
                            element.notify("Cập nhật thành công!",
                                { className: "success", position: "top" }
                            );
                            break;
                        case 'status':
                            var newClass = response.status.class;
                            element.removeClass();
                            element.addClass(newClass);

                            element.data("class", response.class);

                            element.attr('data-class',response.class)
                            element.html(response.status.name);

                            element.data("url", response.link);         // thay đổi `url` và  lưu trữ nó trong bộ nhớ của jQuery
                            element.attr('data-url',response.link)      // thay đổi `url` HTML

                            var modified    = response.modified;
                            var modifiedBy  = response.modified_by;

                            // Cập nhật html các phần tử của p gồm modified và modified_by
                            $("p.modified-"+inputId).html(modified);
                            $("p.modified-by-"+inputId).html(modifiedBy);

                            element.notify("Cập nhật thành công!",
                                { className: "success" , position:"top"  }
                            );
                            break;
                        case 'is-home':
                            var newClass = response.isHome.class;
                            element.removeClass();
                            element.addClass(newClass);

                            element.data("class", response.class);

                            element.attr('data-class',response.class)
                            element.html(response.isHome.name);

                            element.data("url", response.link);         // thay đổi `url` và  lưu trữ nó trong bộ nhớ của jQuery
                            element.attr('data-url',response.link)      // thay đổi `url` HTML

                            var modified    = response.modified;
                            var modifiedBy  = response.modified_by;

                            // Cập nhật html các phần tử của p gồm modified và modified_by
                            $("p.modified-"+inputId).html(modified);
                            $("p.modified-by-"+inputId).html(modifiedBy);

                            element.notify("Cập nhật thành công!",
                                { className: "success" , position:"top"  }
                            );
                            break;
                        case 'is-new':
                            var newClass = response.isNew.class;
                            element.removeClass();
                            element.addClass(newClass);

                            element.data("class", response.class);

                            element.attr('data-class',response.class)
                            element.html(response.isNew.name);

                            element.data("url", response.link);         // thay đổi `url` và  lưu trữ nó trong bộ nhớ của jQuery
                            element.attr('data-url',response.link)      // thay đổi `url` HTML

                            var modified    = response.modified;
                            var modifiedBy  = response.modified_by;

                            // Cập nhật html các phần tử của p gồm modified và modified_by
                            $("p.modified-"+inputId).html(modified);
                            $("p.modified-by-"+inputId).html(modifiedBy);

                            element.notify("Cập nhật thành công!",
                                { className: "success" , position:"top"  }
                            );
                            break;
                        case 'is-phone-category':
                            var newClass = response.isPhoneCategory.class;
                            element.removeClass();
                            element.addClass(newClass);

                            element.data("class", response.class);

                            element.attr('data-class',response.class)
                            element.html(response.isPhoneCategory.name);

                            element.data("url", response.link);         // thay đổi `url` và  lưu trữ nó trong bộ nhớ của jQuery
                            element.attr('data-url',response.link)      // thay đổi `url` HTML

                            var modified    = response.modified;
                            var modifiedBy  = response.modified_by;

                            // Cập nhật html các phần tử của p gồm modified và modified_by
                            $("p.modified-"+inputId).html(modified);
                            $("p.modified-by-"+inputId).html(modifiedBy);

                            element.notify("Cập nhật thành công!",
                                { className: "success" , position:"top"  }
                            );
                            break;
                        case 'select-box':
                            var modified    = response.modified;
                            var modifiedBy  = response.modified_by;

                            // Cập nhật html các phần tử của p gồm modified và modified_by
                            if ($("p.modified-" + inputId).length > 0) {
                                $("p.modified-"+inputId).html(modified);
                            }
                            if ($("p.modified-by-" + inputId).length > 0) {
                                $("p.modified-by-"+inputId).html(modifiedBy);
                            }
                            // Hiển thị thông báo thành công
                            element.notify("Cập nhật thành công!",
                                { className: "success", position: "top" }
                            );
                            break;
                        }

                } catch (error) {
                    // Cho trường hợp không gắn modified và modified_by
                    element.notify("Cập nhật thành công!",
                        { className: "success" , position:"top"  }
                    );
                }
            }
        });
    }

});

// Button Logo at Setting-Controller
$(document).ready(function() {
    // $('#lfm').filemanager('image');

    // Nếu có thể tự config
    // var route_prefix = "laravel-filemanager?type=image";
    // $('#lfm').filemanager('file', {prefix: route_prefix});
});

// Menu click xuất ra menu con tại sidebar_menu
$(document).ready(function(){
    // Chọn phần tử <ul> có class là 'child_menu'
    $("ul.child_menu").css("display", "none");

    // Sự kiện click menu li id="setting" chạy kép dùng một lần, giữ lại class active cho 1 lần duy nhất
    $("li#setting").one("click", function(){
        $('li#setting ul').slideDown();
        $("li#setting").addClass("active");
    });

});

// View googleMap tại admin-branch-form
$(document).ready(function() {
    $('#googlemap').on('input', function() {
        // Lấy giá trị từ textarea
        var iframeContent = $(this).val();

        // Xác định phần tử đích
        var $mapView = $('#google-map-view');

        // Kiểm tra xem giá trị có phải là một iframe hợp lệ không
        if (iframeContent.includes('<iframe') && iframeContent.includes('</iframe>')) {
            // Chèn nội dung iframe vào phần tử đích
            $mapView.html(iframeContent);
        } else {
            // Nếu không hợp lệ, xóa nội dung của phần tử đích
            $mapView.html('');
        }
    });
});

// View Article Plus
$(document).ready(function() {
    $('#name_article-vi').on('input', function() {
        var nameArticle = $(this).val();
        var autoIncrementValue = $(this).data('auto-increment');
        // Convert to slug
        var slug = nameArticle.toLowerCase(); // Chuyển thành chữ thường
        slug = slug.replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/g, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y');
        slug = slug.replace(/đ/g, 'd');
        slug = slug.replace(/[^a-z0-9\s-]/g, ''); // Xóa các ký tự đặc biệt
        slug = slug.replace(/\s+/g, '-'); // Thay thế khoảng trắng bằng dấu gạch ngang
        slug = 'bv-' + slug + '-' + autoIncrementValue; // Thêm tiền tố 'bv-'

        $('#slug-vi').val(slug); // Gán giá trị đã xử lý vào input slug
    });

    $('#name_article-en').on('input', function() {
        var nameArticle = $(this).val();
        var autoIncrementValue = $(this).data('auto-increment');
        // Convert to slug
        var slug = nameArticle.toLowerCase(); // Chuyển thành chữ thường
        slug = slug.replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/g, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y');
        slug = slug.replace(/đ/g, 'd');
        slug = slug.replace(/[^a-z0-9\s-]/g, ''); // Xóa các ký tự đặc biệt
        slug = slug.replace(/\s+/g, '-'); // Thay thế khoảng trắng bằng dấu gạch ngang
        slug = 'bv-' + slug + '-' + autoIncrementValue; // Thêm tiền tố 'bv-'

        $('#slug-en').val(slug); // Gán giá trị đã xử lý vào input slug
    });
});

// View Category article Plus
$(document).ready(function() {
    $('#category_article_vi').on('input', function() {
        var nameCategory = $(this).val();
        var autoIncrementValue = $(this).data('auto-increment');
        // Convert to slug
        var slug = nameCategory.toLowerCase(); // Chuyển thành chữ thường
        slug = slug.replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/g, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y');
        slug = slug.replace(/đ/g, 'd');
        slug = slug.replace(/[^a-z0-9\s-]/g, ''); // Xóa các ký tự đặc biệt
        slug = slug.replace(/\s+/g, '-'); // Thay thế khoảng trắng bằng dấu gạch ngang
        slug = 'cm-' + slug + '-' + autoIncrementValue; // Thêm tiền tố 'bv-'

        $('#slug-vi').val(slug); // Gán giá trị đã xử lý vào input slug
    });

    $('#category_article_en').on('input', function() {
        var nameCategory = $(this).val();
        var autoIncrementValue = $(this).data('auto-increment');
        // Convert to slug
        var slug = nameCategory.toLowerCase(); // Chuyển thành chữ thường
        slug = slug.replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/g, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y');
        slug = slug.replace(/đ/g, 'd');
        slug = slug.replace(/[^a-z0-9\s-]/g, ''); // Xóa các ký tự đặc biệt
        slug = slug.replace(/\s+/g, '-'); // Thay thế khoảng trắng bằng dấu gạch ngang
        slug = 'ca-' + slug + '-' + autoIncrementValue; // Thêm tiền tố 'bv-'

        $('#slug-en').val(slug); // Gán giá trị đã xử lý vào input slug
    });
});

// View Category product Plus
$(document).ready(function() {
    $('#category_product').on('input', function() {
        var nameCategory = $(this).val();
        var autoIncrementValue = $(this).data('auto-increment');
        // Convert to slug
        var slug = nameCategory.toLowerCase(); // Chuyển thành chữ thường
        slug = slug.replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/g, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y');
        slug = slug.replace(/đ/g, 'd');
        slug = slug.replace(/[^a-z0-9\s-]/g, ''); // Xóa các ký tự đặc biệt
        slug = slug.replace(/\s+/g, '-'); // Thay thế khoảng trắng bằng dấu gạch ngang
        slug = 'cm-' + slug + '-' + autoIncrementValue; // Thêm tiền tố 'bv-'

        $('#slug').val(slug); // Gán giá trị đã xử lý vào input slug
    });

});

// -- Thumb Reviews Article Form: Hiện ảnh khi chọn ảnh ở thumb
$(document).ready(function() {
    $('#thumb').change(function(event) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#thumb-preview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(event.target.files[0]);
    });
});

//Audio: Hiện audio tại form
// $(document).ready(function () {
//     var audioUrl = null;

//     $('#audio').change(function (event) {
//         var file   = event.target.files[0];
//         var $audio = $('#audio-preview');

//         // Giải phóng link tạm của lần chọn trước
//         if (audioUrl) {
//             URL.revokeObjectURL(audioUrl);
//             audioUrl = null;
//         }

//         // Không chọn file, hoặc không phải audio
//         if (!file || file.type.indexOf('audio/') !== 0) {
//             $audio.hide().removeAttr('src');
//             if (file) {
//                 alert('Vui lòng chọn file audio.');
//                 $(this).val('');
//             }
//             return;
//         }

//         audioUrl = URL.createObjectURL(file);
//         $audio.attr('src', audioUrl).show();
//         $audio[0].load();   // nạp lại nguồn mới
//         $('#audio-current').hide();//Ẩn tracks cũ
//     });
// });

//Audio với javascript thuần:
document.addEventListener('DOMContentLoaded', function () {
    var input    = document.getElementById('audio');
    var preview  = document.getElementById('audio-preview');
    var current  = document.getElementById('audio-current');  // player của file đang lưu (có thể không tồn tại)
    var audioUrl = null;

    input.addEventListener('change', function (event) {
        var file = event.target.files[0];

        if (audioUrl) {
            URL.revokeObjectURL(audioUrl);
            audioUrl = null;
        }

        // Không chọn file hoặc file không hợp lệ: ẩn preview, hiện lại player cũ
        if (!file || file.type.indexOf('audio/') !== 0) {
            preview.style.display = 'none';
            preview.removeAttribute('src');
            if (current) current.style.display = '';
            if (file) {
                alert('Vui lòng chọn file audio.');
                input.value = '';
            }
            return;
        }

        // File hợp lệ: ẩn player cũ, hiện preview file mới
        if (current) current.style.display = 'none';
        audioUrl = URL.createObjectURL(file);
        preview.src = audioUrl;
        preview.style.display = 'block';
        preview.load();
    });
});

$(document).ready(function() {
    // Sử dụng id mới để không bị xung đột
    $('#thumb_slider').change(function(event) {
        var readerSlider = new FileReader();
        readerSlider.onload = function(e) {
            $('#thumb-slider-preview').attr('src', e.target.result).show();
        }
        readerSlider.readAsDataURL(event.target.files[0]);
    });
});



//Bootstrap tags input
// $(document).ready(function() {
//     console.log('abc');
//     // Khởi tạo với tùy chọn delimiter mới là dấu '$'
//     $('input[data-role="tagsinput"]').tagsinput({
//         delimiter: '$'  // Thay thế dấu phân cách bằng '$'
//     });
// });

/*product input*/
$(document).ready(function() {
    var priceChoose; //Biến toàn cục

    // Xác định price cho trường hợp default của product. Sau đó gán cho priceChoose.
    // Set price default cho product tại productAttributePrice module.
    var priceText   = $(".price").text().trim(); // Lấy nội dung và loại bỏ khoảng trắng
    var matchResult = priceText.match(/\d+/); // Tìm số trong chuỗi
    var priceNumber = matchResult ? matchResult[0] : null; // Kiểm tra nếu có số thì lấy, nếu không thì gán null

    if (priceNumber !== null) {
        priceChoose = priceNumber;
    }

    // Khi click vào color thì lặp lại quá trình chọn dung lượng
    $('input[name="color"]').on('click', function() {
        console.log('click color');
        $('.btn-material').removeClass('btn-primary');
        $('.btn-material').removeClass('selected');
        $(".price").html('Hãy chọn dung lượng');
    });

    // Gắn sự kiện click cho nút button
    $('.btn-material').on('click', function() {
        // Đánh dấu button 'material' dung lượng được chọn, vì button không phải là một input nên nó không có trạng thái checked để jquery lấy dữ liệu
        $('.btn-material').removeClass('selected'); // Bỏ class 'selected' khỏi các button khác
        $('.btn-material').removeClass('btn-primary');
        $(this).addClass('selected'); // Thêm class 'selected' cho button vừa click, đánh dấu đây là button được chọn
        $(this).addClass('btn-primary');

        // Lấy giá trị của radio button được chọn
        var selectedColor = $('input[name="color"]:checked').val();

        // Lấy ID của nút button vừa click
        var buttonId = $(this).data('id');

        // Lấy Id Item
        var itemId  = $(this).data('item');
        // Lấy url
        let url     = $(this).data('url');

        // Kiểm tra và hiển thị kết quả
        if (selectedColor !== undefined) {
            console.log('Radio được chọn có giá trị:', selectedColor);
        } else {
            console.log('Không có radio nào được chọn.');
        }

        console.log('ID của nút button vừa click:', buttonId, itemId, url);

        $.ajax({
            type: "GET",
            url: url,
            data: {
                    colorId: selectedColor,
                    materialId: buttonId,
                    itemId: itemId
                  },
            success: function (response) {
                console.log(response)
                var id    = response.id;
                var priceReturn = response.price;

                if(priceReturn == null){
                    priceChoose = 0;
                    $(".price").html('Giá chưa cập nhật');
                }else{
                    // Cập nhật giá Item
                    $(".price").html(priceReturn+' đồng');
                    priceChoose = priceReturn;
                }

            }
        });

    });


    // Sự kiện click vào button 'Add to Cart'
    $('#order-cart').on('click', function () {
        // Lấy giá trị của radio color đã chọn
        const selectedColor = $('input[name="color"]:checked').val();

        // Lấy ID của button material được chọn
        const selectedMaterial = $('.btn-material.selected').data('id');

        // Kiểm tra nếu người dùng chưa chọn màu sắc hoặc material
        if (!selectedColor || !selectedMaterial) {
            alert('Vui lòng chọn màu sắc và dung lượng trước khi thêm vào giỏ hàng!');
            return;
        }

        const itemID    = $(this).data('id');
        var name        = $(this).data('name');
        var url         = $(this).data('url');
        var price       = priceChoose;
        var thumb       = $(this).data('thumb');

        // In ra console
        console.log('Item Id:', itemID);
        console.log('Item Name:', name);
        console.log('Color Id:', selectedColor);
        console.log('Material ID:', selectedMaterial);
        console.log('Url:', url);
        console.log('Price Choose:', price);
        console.log('Thumb:', thumb);

        if(price == null || price == 0 || price == undefined){
            //popup
            $('.modal-body').html('Hãy cập nhật giá của sản phẩm trước khi \"Add to Cart\" !');
            $('#cartModal').modal('show');
            return;
        }

        // Việc còn lại là tạo Ajax, gọi route rồi đưa về controller để xử lý
        $.ajax({
            type: "GET",
            url: url,
            data: {
                    itemID: itemID,
                    name: name,
                    colorID: selectedColor,
                    materialID: selectedMaterial,
                    price:price,
                    thumb:thumb
                  },
            success: function (response) {
                console.log(response)
                console.log('Cart:',response.session.cart);
                var totalItem = response.totalItem;
                $('.badge').html(totalItem);
                //popup
                $('.modal-body').html("Sản phẩm đã được thêm vào giỏ hàng !");
                $('#cartModal').modal('show');
            }
        });

    });

    //cart List
    $('.cart-list').on('click', function () {
        var url         = $(this).data('url');
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                console.log(response)
                const xhtmlCart = response.xhtmlCart;
                $('.msg_list').find('li.item-cart').remove(); //Xóa danh sách các thẻ item cart trước đó
                $('.msg_list').prepend(xhtmlCart); // cập nhật lại các thẻ li trong ul

            }
        });
    });
});
/*PRODUCT ATTRIBUTE PRICE*/
//sortable: tính năng kéo thả vị trí cho danh sách product_attribute_price
$(document).ready(function() {
    $(function () {
        $("#sortable").sortable({

            update: function(event, ui) {
                // Lấy danh sách các id theo thứ tự sau khi kéo thả
                var ids         = $("#sortable").sortable("toArray",{attribute: 'data-id'}); //Danh sách vị trí id
                var orderings   = $(this).sortable('toArray', {attribute: 'value'});         //Danh sách vị trí ordering
                var url         = $(this).data('url');  //Lấy url từ views
                console.log(ids,orderings,url);
                //console.log(url);
                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        ids: ids,
                        orderings: orderings,
                    },
                    success: function(response) {
                        console.log(response);
                        // alert("Thứ tự đã được lưu lại!");
                        var orderingPosition = response.orderingsPosition;

                        $.each(orderingPosition, function(id, ordering) {
                            console.log("ID: " + id + " - Ordering: " + ordering);
                            // Tìm <li> cha có data-id. Đây là Target đối tượng
                            var parentLi = $('li[data-id="' + id + '"]');

                            // Tìm <ul> bên trong và cập nhật <li> con đầu tiên
                            parentLi.find('ul.row.double li:first').text(ordering);
                        });
                    },
                    error: function(xhr) {
                        alert("Có lỗi xảy ra: " + xhr.responseText);
                    }
                });
            }
        });

        $("#sortable").disableSelection();

        // Khi click vào checkbox, ngăn chặn kéo thả
        $(document).on("mousedown", ".tgl", function(event) {
            $("#sortable").sortable("disable");  // Tắt sortable khi bắt đầu click vào checkbox
        });

        $(document).on("mouseup", ".tgl", function(event) {
            setTimeout(function() {
                $("#sortable").sortable("enable");  // Bật lại sortable sau khi click checkbox
            }, 100); // Chờ 100ms để tránh lỗi
        });

    });


    // Sự kiện click vào button 'show popup price'
    $('#productModal').on('click', function () {
            $('#productModal').modal('show');
    });
});

$(document).ready(function() {
    $("#popupForm").on("shown.bs.modal", function () {
        var url         = $("#product-price").data('url');
        $("#product-price").select2({
            dropdownParent: $("#popupForm"),  // Giúp dropdown hiển thị đúng trong modal
            placeholder: "Nhập hoặc chọn sản phẩm...",
            allowClear: true,
            ajax: {
                url: url,  // API lấy danh sách sản phẩm từ Laravel
                dataType: "json",
                delay: 250,
                processResults: function (data) {
                    console.log(data);
                    return {
                        results: data.map(function (item) {
                            return { id: item.id, text: item.name };
                        })
                    };
                }
            }

        });
    });

});

$(document).ready(function() {
    $("button#btn-arrange-ordering").click(function(){
        var pathname = window.location.pathname; //path hien tai không bao gồm param, tức là chỉ lấy đến hết dấu hỏi
        var getRoute      = $(this).data('arrange');
        window.location.href    = pathname + '/' + getRoute;
    });

});
//default
$(document).ready(function () {
    $('.product-attribute-price-default input[type="checkbox"]').change(function () {
        var defaultAttr     = $(this).val();
        var url             = $(this).data('url');
        var id              = $(this).data('id');
        console.log(defaultAttr,id,url);
        if ($(this).is(':checked')) {
            console.log('Checkbox đã bật (ON)');
        } else {
            console.log('Checkbox đã tắt (OFF)');
        }

        $.ajax({
            url: url,
            method: "GET",
            data: {
                id: id,
                defaultAttr: defaultAttr,
            },
            success: function(response) {
                console.log(response);
                // alert("Thứ tự đã được lưu lại!");
            },
            error: function(xhr) {
                alert("Có lỗi xảy ra: " + xhr.responseText);
            }
        });

    });
});

$(document).ready(function () {
    $('.product-attribute-price-default-radio input[type="radio"]').change(function () {
        // var defaultAttr     = $(this).val();
        var url             = $(this).data('url');
        var id              = $(this).data('id');
        var productId       = $(this).data('product-id');
        console.log(id,url);
        if ($(this).is(':checked')) {
            console.log('Checkbox đã bật (ON)');
        } else {
            console.log('Checkbox đã tắt (OFF)');
        }

        $.ajax({
            url: url,
            method: "GET",
            data: {
                id: id,
                productId:productId
            },
            success: function(response) {
                console.log(response);
                // alert("Thứ tự đã được lưu lại!");
            },
            error: function(xhr) {
                alert("Có lỗi xảy ra: " + xhr.responseText);
            }
        });

    });
});

/* END PRODUCT ATTRIBUTE PRICE*/

/*MODUL HAS PERMISSION*/
$(document).ready(function() {
    $("#popupForm").on("shown.bs.modal", function () {
        // Khởi tạo Select2 cho user-search
        $("#user_search").select2({
            dropdownParent: $("#popupForm"),
            placeholder: "Nhập hoặc chọn tên User...",
            allowClear: true,
            ajax: {
                url: $("#user_search").data('url'),
                dataType: "json",
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return { id: item.id, text: item.username };
                        })
                    };
                }
            }
        });

        // Khởi tạo Select2 cho permission-search
        $url = $("#permission-search").data('url');
        console.log($url);
        $("#permission_search").select2({
            dropdownParent: $("#popupForm"),
            placeholder: "Nhập hoặc chọn quyền được gán...",
            allowClear: true,
            ajax: {
                url: $("#permission_search").data('url'),
                dataType: "json",
                delay: 250,
                processResults: function (data) {
                    console.log(data);
                    return {
                        results: data.map(function (item) {
                            return { id: item.id, text: item.name };
                        })
                    };
                }
            }
        });
    });
});
/*END MODUL HAS PERMISSION*/

/*PERMISSION CONTROLLER*/
$(document).ready(function() {
    $('#controllerSelect').select2({
        placeholder: "Chọn một Controller",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#popupForm')
    });
});
/*END PERMISSION CONTROLLER*/

/* multy langue */
$(document).ready(function() {
    $('.btn-merged-article').on('click', function () {
        //e.preventDefault(); // Chặn submit mặc định để xem log

        // Cập nhật nội dung CKEditor vào textarea thật
        for (const instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        const $mergedForm = $('#merged-form');

        // Copy CSRF token từ form gốc nếu cần
        const csrf = $('input[name="_token"]').first().clone();
        $mergedForm.append(csrf);

        // Duyệt qua tất cả input trong #form-vi rồi tích hợp các input đó vào #merged-form
        $('#form-vi').find('input, textarea, select').each(function () {
            const name = $(this).attr('name');
            const value = $(this).val();

            console.log(`VI: ${name} = ${value}`);

            const $input = $('<input>', {
                type: 'hidden',
                name: $(this).attr('name'),
                value: $(this).val()
            });
            $mergedForm.append($input);
        });

        // Duyệt qua tất cả input trong #form-en rồi tích hợp các input đó vào #merged-form
        $('#form-en').find('input, textarea, select').each(function () {
            const $input = $('<input>', {
                type: 'hidden',
                name: $(this).attr('name'),
                value: $(this).val()
            });
            $mergedForm.append($input);

        });

        // Submit form
        $mergedForm.submit();
    });

    $('.btn-merged-category-article').on('click', function () {
        //e.preventDefault(); // Chặn submit mặc định để xem log

        const $mergedForm = $('#merged-form');

        // Copy CSRF token từ form gốc nếu cần
        const csrf = $('input[name="_token"]').first().clone();
        $mergedForm.append(csrf);

        // Duyệt qua tất cả input trong #form-vi rồi tích hợp các input đó vào #merged-form
        $('#form-vi').find('input, textarea, select').each(function () {
            const name = $(this).attr('name');
            const value = $(this).val();

            console.log(`VI: ${name} = ${value}`);

            const $input = $('<input>', {
                type: 'hidden',
                name: $(this).attr('name'),
                value: $(this).val()
            });
            $mergedForm.append($input);
        });

        // Duyệt qua tất cả input trong #form-en rồi tích hợp các input đó vào #merged-form
        $('#form-en').find('input, textarea, select').each(function () {
            const $input = $('<input>', {
                type: 'hidden',
                name: $(this).attr('name'),
                value: $(this).val()
            });
            $mergedForm.append($input);

        });

        // Submit form
        $mergedForm.submit();
    });

    $('.btn-merged-slider').on('click', function () {
        //e.preventDefault(); // Chặn submit mặc định để xem log

        const $mergedForm = $('#merged-form');

        // Copy CSRF token từ form gốc nếu cần
        const csrf = $('input[name="_token"]').first().clone();
        $mergedForm.append(csrf);

        // Duyệt qua tất cả input trong #form-vi rồi tích hợp các input đó vào #merged-form
        $('#form-vi').find('input, textarea, select').each(function () {
            const name = $(this).attr('name');
            const value = $(this).val();

            console.log(`VI: ${name} = ${value}`);

            const $input = $('<input>', {
                type: 'hidden',
                name: $(this).attr('name'),
                value: $(this).val()
            });
            $mergedForm.append($input);
        });

        // Duyệt qua tất cả input trong #form-en rồi tích hợp các input đó vào #merged-form
        $('#form-en').find('input, textarea, select').each(function () {
            const $input = $('<input>', {
                type: 'hidden',
                name: $(this).attr('name'),
                value: $(this).val()
            });
            $mergedForm.append($input);

        });

        // Submit form
        $mergedForm.submit();
    });
});
/* end multy langue */

/* Product Media */
$(document).ready(function() {
    $('.product-thumb').on('click', function() {
        var fullImg = $(this).data('full');
        $('#modal-image').attr('src', fullImg);
        $('#imageModal').modal('show');
    });

    $("#searchPhone").select2({
        width:'75%',
        placeholder: "Nhập để lọc smart phone ...",
        allowClear: true,
        ajax: {
            url: $("#searchPhone").data('url'),
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                console.log(data);
                return {
                    results: data.map(function (item) {
                        return { id: item.id, text: item.name };
                    })
                };
            }
        }
    });

    $('#searchPhone').on('select2:select', function (e) {
        var data = e.params.data;
        var productID = data.id;
        var pathname = window.location.pathname;

        // data.id → giá trị id
        // data.text → nội dung hiển thị (ví dụ: tên sản phẩm)
        window.location.href    = pathname + '?' + 'filter_product_id=' + productID;
    });
});
/* End Product Media */
