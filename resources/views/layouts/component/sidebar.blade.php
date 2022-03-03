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
            <a href="{{url('/')}}">
                <div class="parent-icon"><i class="bx bx-home"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li>
            <a href="{{route('report.create')}}">
                <div class="parent-icon"><i class="bx bx-plus"></i>
                </div>
                <div class="menu-title">Create Report</div>
            </a>
        </li>


        <li>
            <a href="{{route('report.index')}}">
                <div class="parent-icon"><i class="bx bx-history"></i>
                </div>
                <div class="menu-title">History Report</div>
            </a>
        </li>




    </ul>
    <!--end navigation-->
</div>
