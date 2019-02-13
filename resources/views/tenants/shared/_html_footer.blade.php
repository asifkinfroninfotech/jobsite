<script src="{{asset('js/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('js/bower_components/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('js/bower_components/moment/moment.js')}}"></script>
    <script src="{{asset('js/bower_components/chart.js/dist/Chart.min.js')}}"></script>
    <script src="{{asset('js/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('js/bower_components/jquery-bar-rating/dist/jquery.barrating.min.js')}}"></script>
    <script src="{{asset('js/bower_components/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap-validator/dist/validator.min.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('js/bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js')}}"></script>
    <script src="{{asset('js/bower_components/dropzone/dist/dropzone.js')}}"></script>
    <script src="{{asset('js/bower_components/custom/custom.js')}}"></script>
    <script src="{{asset('js/bower_components/editable-table/mindmup-editabletable.js')}}"></script>
    <script src="{{asset('js/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>
    <script src="{{asset('js/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('js/bower_components/tether/dist/js/tether.min.js')}}"></script>
    <script src="{{asset('js/bower_components/slick-carousel/slick/slick.min.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/util.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/alert.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/button.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/carousel.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/collapse.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/dropdown.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/modal.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/tab.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/tooltip.js')}}"></script>
    <script src="{{asset('js/bower_components/bootstrap/js/dist/popover.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/main.js?version=4.2.0')}}"></script>   
    <script src="{{asset('js/main-custom.js')}}"></script>

     
      
    <script>
    
            function hidehelp()
            {
                //$('#helpform').css('display','none');
                $.get('/hidehelpform',function(data){
                 location.reload();   
                });
                
            }
            function showhelp()
            {
                //$('#helpform').css('display','none');
                $.get('/showhelpform',function(data){
                 location.reload();   
                });
                
            }
            
            
            </script>