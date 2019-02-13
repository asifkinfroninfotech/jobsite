@extends('layouts.tenant_layout')

@section('content')

<style>
  @media screen and (max-width: 600px) {
      table[id="artha-f-rtble"] {
          width: 100% !important;
      }

      table[class="footer"] {
          width: 100% !important;
      }

          table[class="footer"] td {
              display: block;
              margin: 0 auto;
              text-align: center;
          }

      table[class="toptbl"] {
          width: 100% !important;
      }

      div[class="diveq"] {
          width: 100% !important;
      }
  }
</style>
               
                
    <div class="all-wrapper menu-side login-information">
      <div class="auth-box-w">
        @if(isset($tenantdetails) && !empty($tenantdetails))
        @if(isset($tenantdetails->logo) && !empty($tenantdetails->logo) && File::exists(public_path('/storage/tenant/logoimage/'.$tenantdetails->logo)))
        <div class="logo-w">
  
          <img alt="" src="{{'/storage/tenant/logoimage/'.$tenantdetails->logo}}">
  
        </div>
        @else    
        <div class="logo-w">
        <img alt="" src="/img/logo_desktop.png">
      </div>
        @endif
        @else
        <div class="logo-w">
          <img alt="" src="/img/logo_desktop.png">
        </div>
        @endif


         <!-- START - login info content area -->
                     <div class="col-sm-12 col-md-12">
                      <div class="element-wrapper">
                        <div class="login-info-hd text-center">
                            <h5 class="element-inner-header">
                              Thank You For Registration!
                            </h5> 
                              {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,  sed do eiusmod tempor <br/> incididunt ut labore et dolore magna aliqua.
                               </p>                         --}}
                        </div>
                        <div class="steps-w"> 
                          
                            <table cellpadding="0" cellspacing="0" align="center" width="100%" valign="top" border="0">
                                <tr>
                                    <td style="background:#fff; padding: 60px 70px;">
                                        <div>

                                            {!!$welcomenotes!!}

                                        </div>
                                    </td>
                                </tr>
                            </table>

   
                            
                          </div>                      
                      </div>                      
                    </div>
                          <!-- END - login info content area -->
        
      </div>
      <p class="copy-right text-center">
          &copy; Copyright {{date('Y')}} {{\App\Helpers\AppGlobal::$Artha_Company_Name}}. All rights reseved.
        </p>
    </div>
                
                @endsection


                @section('scripts')
                <script>

$(document).ready(function() {
    debugger;
                     var p_color='{{session('tenant_primary_color')}}';
           var s_color='{{session('tenant_secondary_color')}}';

         if(typeof p_color !='undefined' && p_color!='')
         {
            colorReplace("#3399ff", p_color);//"#f48220"
         }
                
         if(typeof s_color !='undefined' && s_color!='')
         {
            colorReplace("#b11f37", s_color);//"#000"
         }

});

                function colorReplace(findHexColor, replaceWith) {
                  // Convert rgb color strings to hex
                  function rgb2hex(rgb) {
                    if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;
                    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
                    function hex(x) {
                      return ("0" + parseInt(x).toString(16)).slice(-2);
                    }
                    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
                  }
      
                  // Select and run a map function on every tag
                  $('*').map(function(i, el) {
                    // Get the computed styles of each tag
                    var styles = window.getComputedStyle(el);
      
                    // Go through each computed style and search for "color"
                    Object.keys(styles).reduce(function(acc, k) {
                      var name = styles[k];
                      var value = styles.getPropertyValue(name);
                      if (typeof name === 'undefined' || name === null) {
                      } else {
                         if (name.indexOf("color") >= 0) {
                          // Convert the rgb color to hex and compare with the target color
                          if (value.indexOf("rgb(") >= 0 && rgb2hex(value) === findHexColor) {
                            // Replace the color on this found color attribute
                            $(el).css(name, replaceWith);
                          }
                        }
                      }
                    });
                  });
                }
                // Call like this for each color attribute you want to replace
             
                $('a').css('display','none');


                
                </script>
                
                
                @endsection
                
                
                
                


