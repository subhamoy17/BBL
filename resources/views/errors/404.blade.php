
@extends('frontcustomerlayout.main') 
@section('content')
<audio controls autoplay loop hidden="hidden">
<source src="http://s0.vocaroo.com/media/download_temp/Vocaroo_s0Jz5C4gpgE0.mp3" type="audio/ogg">
</audio>
<div class="container">
  
 <!--  <div  class="error">
    <p class="p">4</p>
    <span class="dracula">      
      <div class="con">
        <div class="hair"></div>
        <div class="hair-r"></div>
        <div class="head"></div>
        <div class="eye"></div>
        <div class="eye eye-r"></div>
        <div class="mouth"></div>
        <div class="blod"></div>
        <div class="blod blod2"></div>
      </div>
    </span>
    <p class="p">4</p>
    
    <div class="page-ms">
      <p class="page-msg"> Oops, the page you're looking for Disappeared </p>
     <a href="/"> <button class="go-back">Go Back</button></a>
    </div>
</div> -->
  
<div class="gif" align="center"><img src="{{url('frontend/images/404.png')}}">
      <p class="nt-fnd-text text-center" style="margin-bottom: 20px;">
        <h3 align="center">Oops!!!</h3>
        <h3 align="center" style="margin-bottom: 20px;">Back to<a href="/"> Homepage </a>
        </h3>
      </p>

    </div>

<!--  <p>Auto back to home page</p> -->
  </div>
@endsection