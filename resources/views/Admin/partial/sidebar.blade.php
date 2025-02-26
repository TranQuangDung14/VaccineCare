<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
        <div class="profile_pic">
            <img src="{{ asset('Admin/') }}/production/images/img.jpg" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
            <span>Hello doctor,</span>
            <h2>{{ info_user()['name'] }}</h2>
        </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Quản lý thống kê<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>

                    </ul>
                </li>
                <li><a><i class="fa fa-cube"></i> Quản lý thông tin bệnh<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('disease') }}">Danh sách bệnh</a></li>
                        <li><a href="{{ route('diseaseCreate') }}">Thêm mới loại bệnh</a></li>
                    </ul>
                </li>
                <li>
                    <a><i class="fa fa-eyedropper"></i> Quản lý Vaccines<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('vaccine') }}">Danh sách Vaccines</a></li>
                        <li><a href="{{ route('vaccineCreate') }}">Thêm mới Vaccines</a></li>
                    </ul>
                </li>
                <li>
                    <a><i class="fa fa-users"></i> Quản lý bệnh nhân<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('patient') }}">Danh sách bệnh nhân</a></li>
                        <li><a href="{{ route('patientCreate') }}">Thêm bệnh nhân</a></li>
                    </ul>      
                </li>
                <li><a><i class="fa fa-edit"></i> Quản lý lịch tiêm <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('vaccineschedule') }}">Danh sách lịch tiêm</a></li>
                    </ul>
                </li>
                {{-- <li><a><i class="fa fa-calendar"></i> Lịch nhắc nhở <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('calendarreminder') }}">Lịch nhắc nhở</a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>
