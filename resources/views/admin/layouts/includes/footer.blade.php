<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        تصميم وبرمجة أنس خفاجي
    </div>
    <!-- Default to the left -->
    <strong>&copy; 2020 <a href="#">{{config('app.name')}}</a>.</strong> جميع الحقوق محفوظة
</footer>
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!-- Pusher -->
<script src="{{asset('AdminLTE-2.3.0/plugins/pusher/pusher.min.js')}}"></script>
<!-- jQuery 2.1.4 -->
<script src="{{asset('AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE-2.3.0/dist/js/app.min.js')}}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<script src="{{asset('AdminLTE-2.3.0/plugins/jquery-confirm/jquery.confirm.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/select2/select2.full.min.js')}}"></script>
{{--<script src="{{asset('AdminLTE-2.3.0/plugins/datepicker/bootstrap-datepicker.js')}}"></script>--}}
<script src="{{asset('AdminLTE-2.3.0/plugins/jQueryUI/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places&key=AIzaSyAJDNGhvRiWXMvI7VjALT363E3QMOqp6j8'></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/locationpicker/dist/locationpicker.jquery.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('AdminLTE-2.3.0/plugins/bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/bootstrap-fileinput/js/fileinput_locale_ar.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/lightbox2/js/lightbox.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/wickedpicker/wickedpicker.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js  "></script>
<script src="{{asset('AdminLTE-2.3.0/summernote.min.js')}}"></script>
<script src="{{asset('js/anas.js')}}"></script>
<script>
    /**
     * summer note
     **/
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300
        });

        setInterval(get_notifications,3000);

         function get_notifications(){

                            $.ajax({
                            url: "{{ url('admin/notifications-ajax') }}" ,
                            type: "get",
                            dataType: "json",
                            global: false,
                            success: function(data){

                            console.log(data.notification);

                                  $(".new_orders_count").html(data.number);
                                  //<span  class="icon-shopping_cart"></span>
                                     if(data.number!=0){
                                              $(".notificationss-pop").html(data.notification+'<li class="footer"><a href="{{url('admin/notifications')}}">الذهاب لصفحة الطلبات</a></li>');
                                              //document.getElementById('notiaudio2').play();
                                          }
                                          },
                                            error:function(data)
                                          {
                                            console.log(data);
                                          }

                                          });

                                  }
    });

    $(".notification-read").on( "click", function() {

      var test = $(this).attr("data-target");

      var id = test.substring(8);


      $.ajax({
      url: "{{ url('admin/notification') }}"+"/"+id ,
      type: "get",
      dataType: "json",
      success: function(data)
      {

      console.log(data.status);

                    },
                    error:function(data)
                    {
                      console.log(0);
                    }
                    });

            });
</script>


</body>
</html>
