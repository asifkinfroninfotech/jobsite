<!DOCTYPE html>
<html>

<head>
  <title>Artha</title>
  <meta content="Artha language" name="keywords">
  <meta content="Artha dashboard" name="description">

  @include('tenants.shared._html_header')

</head>

<body class="artha-landing-page">
  <section class="header-landing">
    <div class="top-bar">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <ul class="list-unstyled list-inline">
              <li>
                <p>
                  <i class="fa fa-envelope"></i>
                  <a href="mailto:{{isset($gettenant->email)?$gettenant->email:''}}">{{(isset($gettenant->email)&&!empty($gettenant->email))?$gettenant->email:''}}</a>
                </p>
              </li>
              <li>
                <p>

                  <i class="fa fa-phone"></i> Customer Care
                  {{isset($gettenantlandingpage[0]->telephone)?$gettenantlandingpage[0]->telephone:''}}</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <style>
      .logo {
        width: 162px;
      }
    </style>
    <div class="header-main">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 cntr col-lg-6 col-md-6">
            <div class="logo">

              <a href="index.html">
                {{-- @if( (isset($gettenant->logo) && !empty($gettenant->logo) ) &&
                File::exists(public_path('storage/tenant/logoimage/'.$gettenant->logo)))
                <img src="/storage/tenant/logoimage/{{$gettenant->logo}}" alt="Artha Logo" />
                @else
                <img alt="" src="{{ Avatar::create(strtoupper($gettenant->firstname) .' ' . strtoupper($gettenant->lastname))->toBase64() }}" />
                @endif --}}

                @if( (isset($gettenantlandingpage[0]->logo) && !empty($gettenantlandingpage[0]->logo) ) &&
                File::exists(public_path('/storage/tenant/logoimage/'.$gettenantlandingpage[0]->logo)))
                <img src="/storage/tenant/logoimage/{{$gettenantlandingpage[0]->logo}}" alt="Artha Logo" />
                @else
                <img alt="" src="{{ Avatar::create(strtoupper($gettenant->firstname) .' ' . strtoupper($gettenant->lastname))->toBase64() }}" />
                @endif

              </a>


            </div>
          </div>
          <div class="col-sm-6 cntr col-lg-6 col-md-6">
            <div class="topbuton right_button">
              <a class="landing-login" href="/login?tid={{$_GET['tid']}}" target="_blank">Login</a>
              <a class="btn btn-circle-red my-2 my-sm-0" href="/pre-register?tid={{$_GET['tid']}}" target="_blank">GET
                STARTED</a>


            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Home Slider Start -->
    @if(isset($gettenantslider) && !empty($gettenantslider) && count($gettenantslider)>0)
    <div class="home-slider-area">
      <ul class="recent-event-slider">

        @foreach($gettenantslider as $slider)

        <li>
          <div class="product-slider-img">
            <a href="#">


              <img src="/storage/tenant/slides/{{$slider->image}}" alt="Artha" />
            </a>
          </div>
          <div class="product-description-slider position-abso">
            <div class="product-description-inner">
              <h1>{!!$slider->title!!} </h1>
              <p>{!!$slider->description!!}</p>
              @if(isset($slider->button_text) && !empty($slider->button_text))
              <a href="{{$slider->button_link}}" class="btn" target="_blank">
                {!!$slider->button_text!!}</a>
              @endif
            </div>
          </div>
        </li>

        @endforeach
      </ul>
    </div>
    @endif
    <!--Home Slider End -->
    <!--Welcome to Expert Consulting -->
    @if(isset($gettenantlandingpage) && !empty($gettenantlandingpage) && count($gettenantlandingpage)>0 &&
    !empty($gettenantlandingpage[0]->block_section_heading))
    <div class="callouts-wrapper">
      <div class="container">
        <div class="title font-equl">
          <h2>{!!$gettenantlandingpage[0]->block_section_heading!!}</h2>
        </div>
      </div>
      @php
      $countblock=count($gettenantblock)
      @endphp

      @if($countblock>0)
      <div class="container">
        <div class="row  {{($countblock>3)?'welcom-hmslide':''}}">
          @foreach($gettenantblock as $tenantblock)
          <div class="col-sm-4">
            <div class="callouts">
              <div class="test-img">
                <img src="/storage/tenant/block/{{$tenantblock->blockimage}}" alt="">
              </div>
              <h3>
                <a href="{{$tenantblock->link}}">{!!$tenantblock->title!!}</a>
              </h3>
              <p>{!!$tenantblock->description!!}</p>
              <a href="{{$tenantblock->link}}" class="btnsm" target="_blank">Learn More</a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif
    </div>
    @endif
    <!--Welcome to Expert Consulting -->
    @if(isset($gettenantlandingpage) && !empty($gettenantlandingpage) && count($gettenantlandingpage)>0 &&
    !empty($gettenantlandingpage[0]->section_heading))
    <div class="home-about-wrapper">
      <div class="container">
        <div class="row">

          <div class="col-md-8 font-equl about-text">
            <h2>{!!$gettenantlandingpage[0]->section_heading!!}</h2>

            {!!$gettenantlandingpage[0]->section_text!!}

            <a href="{{$gettenantlandingpage[0]->section_button_link}}" class="btnsm" target="_blank">{!!$gettenantlandingpage[0]->section_button_text!!}</a>
          </div>
        </div>
      </div>
    </div>
    @endif
    <!--Welcome to Expert Consulting end -->
    <div class="clearfix"></div>
    <!--home Testimonial -->
    @if(isset($gettenanttestimonial) && !empty($gettenanttestimonial) && count($gettenanttestimonial)>0)
    <div class="home-testimonial-wrapper">
      <div class="container">
        <div class="title font-equl">
          <h2>{!!$gettenantlandingpage[0]->testimonial!!}</h2>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-8 testimonial-cnt">
            <!-- Testimonials slides -->
            <div class="carousel-inner-testimonials">

              @foreach($gettenanttestimonial as $testimonial)
              <div class="item">
                <div class="author">
                  <div class="test-img">
                    <img src="/storage/tenant/testimonials/{{$testimonial->image}}" alt="">
                  </div>
                </div>
                <p>{!!$testimonial->description_text!!}</p>
                <div class="author">
                  <div class="client-name">
                    <h3>{!!$testimonial->name!!}</h3>
                    <p>{!!$testimonial->companyandrank!!}</p>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            <!-- Testimonials slides end-->
          </div>
        </div>
      </div>
    </div>
    @endif
    <!--home Testimonial end -->

    <!--home faq start -->
    <div class="clearfix"></div>
    @if(isset($gettenantfaq) && !empty($gettenantfaq) && count($gettenantfaq)>0)
    <div class="home-faq-wrapper">
      <div class="container">
        <div class="title font-equl">
          <h2>{!!$gettenantlandingpage[0]->faq!!}</h2>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-8 faq-cnt">
            <div class="product-accordianvk accordion">
              @php
              $faqcount=0;
              $lastcount=count($gettenantfaq)-1;
              @endphp
              @foreach($gettenantfaq as $faq)
              <div class="accordion_head {{($faqcount==0)?'first-row-head':''}} {{($faqcount==$lastcount?'ac-last':'')}}">
                <span>{!!$faq->question!!}</span>
                <i class="plusminus plus">&nbsp;</i>
              </div>
              <div class="accordion_body {{($faqcount==$lastcount?'ac-last':'')}}" style='display:none;'>
                <p>{!!$faq->answer!!}</p>
              </div>
              @php
              $faqcount++;
              @endphp
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    <!--home faq end -->
    <!--footer section -->
    <footer class="fl-page-footer-wrap">
      <section class="footer footervk">
        <div class="container container-fluid">
          <div class="footer_row-logo row justify-content-center">
            <a class="navbar-brand" href="#">
              <a href="index.html">
                @if( (isset($gettenant->logo) && !empty($gettenant->logo) ) &&
                File::exists(public_path('storage/tenant/logoimage/'.$gettenant->logo)))
                <img src="/storage/tenant/logoimage/{{$gettenant->logo}}" alt="Artha Logo" />
                @else
                <img alt="" src="{{ Avatar::create(strtoupper($gettenant->firstname) .' ' . strtoupper($gettenant->lastname))->toBase64() }}" />
                @endif
              </a>
            </a>
          </div>
          <!-- <div class="col-12 footer-address-row">
            <p>
              300 E-Block, sydney, Uk <br/>
              Rianta Capital Zurich.
            </p>
          </div>-->

          <div class="footer_row-copyright row footer_social">
            <div class="col-12 text-center">
              <p>© Copyright {{date('Y')}} {{(isset($gettenant->company) &&
                !empty($gettenant->company))?$gettenant->company:''}}
              </p>
            </div>
          </div>
          <div class="footer_row-social row justify-content-center footer_social">
            <div class="col-12 text-center">
              @if(isset($gettenantlandingpage[0]->facebook) && !empty($gettenantlandingpage[0]->facebook))
              <a href="https://www.facebook.com/{{$gettenantlandingpage[0]->facebook}}" target="_blank">
                <img src="images/facebook.png" alt="facebook" />
              </a>
              @endif
              @if(isset($gettenantlandingpage[0]->twitter) && !empty($gettenantlandingpage[0]->twitter))
              <a href="https://twitter.com/{{$gettenantlandingpage[0]->twitter}}" target="_blank">
                <img src="images/twitter.png" alt="twitter" />
              </a>
              @endif
              @if(isset($gettenantlandingpage[0]->linkedin) && !empty($gettenantlandingpage[0]->linkedin))
              <a href="http://www.linkedin.com/in/{{$gettenantlandingpage[0]->linkedin}}" target="_blank">
                <img src="images/linkedin.png" alt="linkedin" />
              </a>
              @endif
            </div>
          </div>
        </div>
      </section>
    </footer>
    <!--footer section end-->
  </section>
  @include('tenants.shared._html_footer')
  @include('tenants.shared._footer')



  <script src="js/main-custom-landing.js"></script>
</body>

</html>