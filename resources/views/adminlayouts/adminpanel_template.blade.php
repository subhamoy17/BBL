
<!-- include admin panel title -->
@include('adminpanel.admin_title')
 <!-- include admin panel sidebar -->
@include('adminpanel.admin_sidebar')

<div id="right-panel" class="right-panel">
<!-- include admin header  -->
@include('adminpanel.admin_header')
<!-- all pages content show here -->
@yield('content')
</div>
<!-- include adminpanel footer -->
@include('adminpanel.admin_footer')
