<?php

return [
    'url'       =>[
        'prefix_admin'      =>'admin96',
        'prefix_news'       =>'',
        'prefix_bookstore'  =>'bookstore',
        'prefix_phone'      =>'phone'
    ],
    'format'    =>[
        'short_time'        =>'d/m/Y',
        'long_time'         =>'H:m:s d/m/Y'
    ],
    'path'       =>[
        'gallery'           =>'images/shares'
    ],
    'template'  =>[
        'font_awesome'=>[
            'user'          =>'<i class="fa fa-user"></i>',
            'clock'         =>'<i class="fa fa-clock-o"></i>'
        ],
        'form_label'=>[
            'class'         => 'control-label col-md-3 col-sm-3 col-xs-12',
        ],
        'form_label_02'=>[
            'class'         => 'control-label col-md-2 col-sm-3 col-xs-12',
        ],
        'form_label_edit'=>[
            'class'         => 'control-label col-md-4 col-sm-3 col-xs-12',
        ],
        'form_input'=>[
            'class'         => 'form-control col-md-6 col-xs-12',
        ],
        'form_input_10'=>[
            'class'         => 'form-control col-md-10 col-xs-12',
        ],
        'form_ckeditor'=>[
            'class'         => 'form-control col-md-6 col-xs-12 ckeditor',
        ],
        'form_area'=>[
            'class'         => 'form-control col-md-6 col-xs-12',
        ],
        'status'=>[
            'all'           =>  ['name'=>'Tất cả',          'class'=>'btn-info'],
            'active'        =>  ['name'=>'Kích hoạt',       'class'=>'btn-success'],
            'inactive'      =>  ['name'=>'Chưa kích hoạt',  'class'=>'btn-info'],
            'block'         =>  ['name'=>'Bị khóa',         'class'=>'btn-info'],
            'default'       =>  ['name'=>'Chưa xác định',   'class'=>'btn-info']
        ],
        'statusAppointment'=>[
            'all'           =>  ['name'=>'Tất cả',          'class'=>'btn-info'],
            'active'        =>  ['name'=>'Đã liên hệ',      'class'=>'btn-info'],
            'inactive'      =>  ['name'=>'Chưa liên hệ',    'class'=>'btn-danger'],
            'default'       =>  ['name'=>'Chưa xác định',   'class'=>'btn-info']
        ],
        'contact'=>[
            'active'        =>  ['name'=>'Đã liên hệ',      'class'=>'btn-success'],
            'inactive'      =>  ['name'=>'Chưa liên hệ',    'class'=>'btn-danger'],
            'default'       =>  ['name'=>'Chưa xác định',   'class'=>'btn-info']
        ],
        'is_home'=>[
            1               =>  ['name'=>'Hiển thị',          'class'=>'btn-primary'],
            0               =>  ['name'=>'Không hiển thị',    'class'=>'btn-warning'],
        ],
        'is_new'=>[
            1               =>  ['name'=>'Sản phẩm mới',      'class'=>'btn-primary'],
            0               =>  ['name'=>'Bình thường',       'class'=>'btn-warning'],
        ],
        'is_phone_category'=>[
            1               =>  ['name'=>'Đây là danh mục điện thoại', 'class'=>'btn-primary'],
            0               =>  ['name'=>'Đây không phải là danh mục điện thoại', 'class'=>'btn-warning'],
        ],
        'is_phone_category_feature'=>[
            1               =>  ['name'=>'Hiển thị danh mục', 'class'=>'btn-primary'],
            0               =>  ['name'=>'Không hiển thị danh mục', 'class'=>'btn-warning'],
        ],
        'type'=>[
            'feature'       =>  ['name'=>'Nổi bật'],
            'normal'        =>  ['name'=>'Bình thường'],
        ],
        'default'=>[
            'select'            =>  ['name'=>'Hãy chọn trạng thái'],
            'default'           =>  ['name'=>'Mặc định'],
            'normal'            =>  ['name'=>'Bình thường'],
        ],
        'type_filter'=>[
            'all'           =>  ['name'=>'Tất cả'],
            'feature'       =>  ['name'=>'Nổi bật'],
            'normal'        =>  ['name'=>'Bình thường'],
        ],
        'type_coupon_filter'=>[
            'all'           =>  ['name'=>'Tất cả'],
            'percent'       =>  ['name'=>'Lọc theo %'],
            'price'         =>  ['name'=>'Lọc theo giảm giá trực tiếp'],
        ],
        'type_sex'=>[
            'all'           =>  ['name'=>'Giới tính'],
            'nam'           =>  ['name'=>'Nam'],
            'nu'            =>  ['name'=>'Nữ'],
            'other'         =>  ['name'=>'Khác'],
        ],
        'is_home_filter'=>[
            'all'           =>  ['name'=>'Tất cả'],
            1               =>  ['name'=>'Hiển thị'],
            0               =>  ['name'=>'Không hiển thị'],
        ],
        'display_filter'=>[
            'all'           =>  ['name'=>'Tất cả'],
            'list'          =>  ['name'=>'Danh sánh'],
            'grid'          =>  ['name'=>'Lưới'],
        ],
        'display'=>[
            'list'          =>  ['name'=>'Danh sánh'],
            'grid'          =>  ['name'=>'Lưới'],
        ],
        'search'=>[
            'all'           =>  ['name'=>'Search by All'],
            'id'            =>  ['name'=>'Search by ID'],
            'name'          =>  ['name'=>'Search by Name'],
            'username'      =>  ['name'=>'Search by Username'],
            'fullname'      =>  ['name'=>'Search by Fullname'],
            'email'         =>  ['name'=>'Search by Email'],
            'description'   =>  ['name'=>'Search by Description'],
            'link'          =>  ['name'=>'Search by Link'],
            'content'       =>  ['name'=>'Search by Content'],
            'phonenumber'   =>  ['name'=>'Search by Phonenumber'],
            'address'       =>  ['name'=>'Search by Address'],
            'phone'         =>  ['name'=>'Search by Phone'],
            'slug'          =>  ['name'=>'Search by Slug'],
            'code'          =>  ['name'=>'Search by Code'],
            'value'         =>  ['name'=>'Search by Value'],
            'cost'          =>  ['name'=>'Search by Cost'],
            'product_name'  =>  ['name'=>"Search by Product's name"],
            'namePhone'     =>  ['name'=>"Search by Phone name"],
            'nameMedia'     =>  ['name'=>"Search by Media name"],
        ],
        'button'            =>[
            'edit'      =>  ['class'=>'btn-success',            'title'=>'Edit',    'icon'=>'fa-pencil',    'route-name'=> '/form'],
            'delete'    =>  ['class'=>'btn-danger btn-delete',  'title'=>'Delete',  'icon'=>'fa-trash',     'route-name'=> '/delete'],
            'info'      =>  ['class'=>'btn-info',               'title'=>'View',    'icon'=>'fa-info',      'route-name'=> '/info'],
        ],
        'buttonAppointment' =>[
            'edit'      =>  ['class'=>'btn-success',            'title'=>'Edit',    'icon'=>'fa-pencil',    'route-name'=> '/form'],
            'delete'    =>  ['class'=>'btn-danger btn-delete',  'title'=>'Delete',  'icon'=>'fa-trash',     'route-name'=> '/delete'],
            'info'      =>  ['class'=>'btn-info',               'title'=>'View',    'icon'=>'fa-info',      'route-name'=> '/info'],
        ],
        'role'=>[
            'admin'         =>  ['name'=>'Quản trị hệ thống - Admin'],
            'member'        =>  ['name'=>'Thành viên - Member'],
            'guest'         =>  ['name'=>'Khách hàng - Guest'],
        ],
        'type_open'=>[
            'current'    => ['name'=>'Mở tại cửa sổ hiện hành'],
            '_new'       => ['name'=>'Mở cửa sổ mới'],
            '_blank'     => ['name'=>'Mở một tab mới']
        ],
        'type_menu'=>[
            'link'              => ['name'=>'Kiểu đường Link'],
            'category_product'  => ['name'=>'Kiểu Category Product'],
            'category_article'  => ['name'=>'Kiểu Category Article']
        ],
        'container'=>[
            'none'          => 'Không chứa container',
            'category'      => 'Category',
            'article'       => 'Article'
        ],
        'sex'=>[
            'nam'           => 'Nam',
            'nu'            => 'Nữ',
            'other'         => 'Khác'
        ],
        'service'=>[
            'science'       => 'Khóa học',
            'book'          => 'Sách',
            'internship'    => 'Thực tập'
        ],
        'type_coupon_discount'=>[
            'percent'       => ['name'=>'Giảm theo %'],
            'price'         => ['name'=>'Giảm trực tiếp']
        ],
        'type_price_discount'=>[
            'percent'       => ['name'=>'Price_discount_percent - Giảm giá theo %'],
            'value'         => ['name'=>'Price_discount_value - Giảm giá trực tiếp']
        ],
        'smart_phone_category_sort' =>[
            'default'       => '- Sắp Xếp -',
            'price_asc'     => 'Giá tăng dần',
            'price_desc'    => 'Giá giảm dần',
            'latest'        => 'Mới nhất'
        ],
        'invoiceStatus'=>[
            'processing'    => ['name'=>'Đang xử lý'],
            'packing'       => ['name'=>'Đóng gói'],
            'shipping'      => ['name'=>'Vận chuyển'],
            'complete'      => ['name'=>'Hoàn thành'],
        ]
    ],
    'config'    =>[
        'search'    =>[
            'default'               =>  ['all','id','fullname'],
            'artist'                =>  ['all','id','name'],
            'album'                 =>  ['all','id','name'],
            'tracks'                =>  ['all','id','name'],
        ],
        'button'    =>[
            'default'               =>  ['edit','delete'],
            'artist'                =>  ['edit','delete'],
            'album'                 =>  ['edit','delete'],
            'tracks'                =>  ['edit','delete'],
        ],
        'lock'   =>[
            'attribute_main_id'     =>  [1,2,3],
            'prime_id'              =>  1,
            'prime_name'            => 'founder',
            'prime_name_trans'      => 'Người sáng lập',
            'permission_id'         =>  [2,3]
        ],
        'roles_admin_controller_access' => [1,2,3], //Đây là các roles_id lần lượt là 1,2,3 tương ứng với founder, admin, member được phép hoạt động trong admin controller
        'roles_name_admin_controller_access' => ['founder','admin','member'],
        'permission_action' =>[
            'access'    => 'Truy cập vào index (access)',
            'create'    => 'Tạo bài nội dung mới (create)',
            'edit'      => 'Chỉnh sửa nội dung (edit)',
            'delete'    => 'Xóa nội dung (delete)'
        ]
    ],
    'youtube_api_key'   => 'AIzaSyBwv99Jc3ed39eSllnB77cZksyN10oZT2M',
    'getGold'   => [
        'keyMap'        => [
            'pnj'       => [
                'buy_nhan_24k'  => 'Mua nhẫn 24K',
                'sell_nhan_24k' => 'Bán nhẫn 24K',
                'buy_nt_24k'    => 'Mua nữ trang 24K',
                'sell_nt_24k'   => 'Bán nữ trang 24K',
                'buy_nt_18k'    => 'Mua nữ trang 18K',
                'sell_nt_18k'   => 'Bán nữ trang 18K',
                'buy_nt_14k'    => 'Mua nữ trang 14K',
                'sell_nt_14k'   => 'Bán nữ trang 14K',
                'buy_nt_10k'    => 'Mua nữ trang 10K',
                'sell_nt_10k'   => 'Bán nữ trang 10K'
            ]
        ]
    ]
];
