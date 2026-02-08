<!doctype html>
<html lang="en">

@include('layouts.component.head')

<body>
<!--wrapper-->
<div class="wrapper">
    <!--sidebar wrapper -->
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <img src="{{url('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
            </div>
            <div>
                <h4 class="logo-text">Rocker</h4>
            </div>
            <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{route('admin.report')}}">
                    <div class="parent-icon"><i class="bx bx-home"></i>
                    </div>
                    <div class="menu-title">report</div>
                </a>
            </li>

            <li>
                <a href="{{route('admin.article')}}">
                    <div class="parent-icon"><i class="bx bx-home"></i>
                    </div>
                    <div class="menu-title">Article</div>
                </a>
            </li>




        </ul>
        <!--end navigation-->
    </div>


    @include('layouts.component.header')

    <div class="page-wrapper">
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <div class="overlay toggle-icon"></div>

    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>


</div>
@include('layouts.component.js')
</body>

</html>
