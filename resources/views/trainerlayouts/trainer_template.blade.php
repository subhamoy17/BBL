<!-- include trainer panel title -->
@include('trainer.trainer_title')
 <!-- include trainer panel sidebar -->
@include('trainer.trainer_sidebar')
<div id="right-panel" class="right-panel">
<!-- include trainer header  -->
@include('trainer.trainer_header')
<!-- all pages content show here -->
@yield('content')
</div>

<!-- include trainerpanel footer -->
@include('trainer.trainer_footer')
