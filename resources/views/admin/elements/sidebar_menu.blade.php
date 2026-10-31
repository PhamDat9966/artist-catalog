<!-- menu profile quick info -->
@php
    use Illuminate\Support\Facades\Session;
    use App\Helpers\Template as Template;
    use App\Models\PermissionModel;

    // $userInfo = $value = Session::get('userInfo');
    // $nameUser = ucfirst($userInfo['username']);
    // $avatar   = Template::showAvatar($userInfo['avatar'],$userInfo['username']);
    // $primeID  = config('zvn.config.lock.prime_id');

    // $permissionModel    = new PermissionModel();
    // $permissionsActive  = $permissionModel->getItem(null,['task'=>'get-item-name-and-id']);

    // $user_has_permission_names      = array_column($userInfo['has_permission'], "permission_name");
    // $all_permission_names_active    = array_column($permissionsActive, "name");

    //dd($user_has_permission_names,$all_permission_names_active);//word-wrap: break-word;white-space: pre-wrap;
@endphp
<div class="profile clearfix">
    <div class="profile_pic">
        {{-- <img src="{{asset('images/user/'.$userInfo['avatar'].'')}}" alt="..." class="img-circle profile_img"> --}}
    </div>
    <div class="profile_info">
        <span>Welcome,</span>
        <h2>PhamDat</h2>
    </div>
</div>
<!-- /menu profile quick info -->
<br/>
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Menu</h3>
        <ul class="nav side-menu">
            <li id="dashboard">
                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>
            </li>
            <li id='artist'>
                <a><i class="fa fa-music"></i> Quản lý Nghệ sĩ<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('artist')}}"> Nghệ sĩ</a></li>
                </ul>
            </li>
            <li id='album'>
                <a><i class="fa fa-book"></i> Quản lý Album<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('album')}}"> Album</a></li>
                </ul>
            </li>
            <li id='album'>
                <a><i class="fa fa-volume-up"></i> Quản lý Tracks<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('tracks')}}"> tracks</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->

