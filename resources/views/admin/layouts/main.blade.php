@include('admin.layouts.includes.header')
@include('admin.layouts.includes.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
    </section>

    <!-- Main content -->
    <section class="content">

        @yield('content')

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@include('admin.layouts.includes.footer')