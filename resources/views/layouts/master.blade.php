<!doctype html>
<html lang="en">

@include('layouts.component.head')

<body>
<!--wrapper-->
<div class="wrapper">
    <!--sidebar wrapper -->
    @include('layouts.component.sidebar')

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
