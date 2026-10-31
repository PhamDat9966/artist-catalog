@php
    use Illuminate\Support\Facades\Session;
    use App\Helpers\Template as Template;
    $userInfo       = $value = Session::get('userInfo');
    $nameUser       = ucfirst($userInfo['username']);
    $avatar         = Template::showAvatar($userInfo['avatar'],$userInfo['username']);
    $totalItem      = '';
    $xhmlRemoveCart = '';
    $xhmlSeeAllCart = '';

    $urlRemoveCart  = Route('user/removeCart');
    $urlCartList    = Route('user/cartList');
    //$urlCartView    = Route('user/cartView');
    if(!empty(Session::get('cart'))){
        $cart       = Session::get('cart');
        $totalItem  = count($cart);

        //Ở đây list Item sẽ được ghi lại bằng jquery $('.cart-list')
        $xhmlRemoveCart = '<li class="nav-item">
                                <a class="dropdown-item" href="'.$urlRemoveCart.'">Remove cart</a>
                        </li>';
        $xhmlSeeAllCart = Template::showCartItem();
    }
@endphp
<div class="nav_menu">
    <nav>
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                   aria-expanded="false">
                    {!!$avatar!!}{{$nameUser}}
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{!!route('changePassword')!!}"> Change Password</a></li>
                    <li><a href="{!!route('auth/logout')!!}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
            </li>
            <li role="presentation" class="nav-item">
                <a href="javascript:;" class="dropdown-toggle info-number cart-list" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false" data-url="{!! $urlCartList !!}">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="badge bg-green">{!! $totalItem !!}</span>
                </a>
                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                    {!! $xhmlSeeAllCart !!}
                    {!! $xhmlRemoveCart !!}
                </ul>
            </li>
        </ul>
    </nav>
</div>
