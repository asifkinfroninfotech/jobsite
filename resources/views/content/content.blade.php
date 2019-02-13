@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@include('shared._top_menu')
@section('content')

<div class="content-w portfolio-custom-vk">
        <!--------------------
          START - Secondary Top Menu
          -------------------->
        
        <!--------------------
            END - Secondary Top Menu
            -------------------->

        <div class="content-panel-toggler">
          <i class="os-icon os-icon-grid-squares-22"></i>
          <span>Sidebar</span>
        </div>
            
           
            
            
        <div class="content-i about-artha">
          <div class="content-box">
            <!--------------------
              start - content
              -------------------->
            <div class="row">
              <div class="col-sm-12">
                <div class="element-wrapper">
                  <h6 class="element-header">
<!--                   About Artha-->
<?php if(isset($data['content1'])){?>
                  
               <?php $title1=$data['content1'][0]->title;echo  $data['content1'][0]->title;?>
            
                  </h6>                  
                  <!--START - Projects list-->
                  <div class="element-box">
                  <div class="projects-list projects-list-vk">
                      
                      
                     <?php echo $data['content1'][0]->contenthtml;?>
                      
                      
                      <?php if($data['content1'][0]->slug=='report-bugs'){?>
                      
                      <h5 class="element-inner-header">
                     {{trans('content.content_title_report_problem')}}
                    </h5>
                    <p>{{trans('content.content_title_report_problem_description')}}</p>                    
                    <div class="border-custm"></div>  
         @if(session('response'))
                    <div class='alert alert-success'>{{session('response')}}</div>
                    
                    @endif

                                     
                    <form id="formValidate" method="post" action="report-bugs">
                         {{csrf_field()}}
                      <div class="row">
                          <div class="col-sm-12">  
                            <div class="form-group">
                              <label for="">{{trans('content.content_label_email')}}</label>
                              <input class="form-control" data-error="Your Email address" name="email" required="required" type="text">
                              <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label for="">{{trans('content.content_label_page_url')}}</label>
                              <input class="form-control" data-error="Page URL" required="required" name="pageurl" type="text">
                              <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                          </div>                          
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="">{{trans('content.content_label_name')}}</label>
                              <input class="form-control" data-error="Please enter your name" name="name" required="required" type="text">
                              <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for=""> {{trans('content.content_label_country')}}</label>
                               <select class="form-control" name="country">
                                  
                               @foreach($data['country'] as $country)   
                                  
                                <option>
                                  Select Country
                                </option>
                                <option value='{{$country->countryid}}'>
                                 {{$country->name}}
                                </option>
<!--                                <option value='2'>
                                  California
                                </option>
                                <option value='3'>
                                  Boston
                                </option>
                                <option value='4'>
                                  Texas
                                </option>
                                <option value='5'>
                                  Colorado
                                </option>-->
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label for="">{{trans('content.content_label_problem_description')}}</label>
                          <textarea class="form-control" name="descrition" rows="3"></textarea>
                        </div>
                     
                        <div class="form-buttons-w">
                          <button class="btn btn-primary" type="submit">{{trans('content.content_button_submit')}}</button>
                        </div>
                        </form>
                      
                      
                      
                      
                      <?php }?>
                      
                      
                      <?php }?> 
                      
                      
                      
                      
                      <?php if(isset($content)){?>

               <?php echo  $content[0]->title;?>
            
                  </h6>                  
                  <!--START - Projects list-->
                  <div class="element-box">
                  <div class="projects-list projects-list-vk">
                      
                      
                     
                      <?php echo $content[0]->contenthtml;?>
                      
                      
                      
<!--                    <h5 class="element-inner-header">
                      How the Artha platform works
                    </h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <div class="border-custm"></div>
                    <h5 class="element-inner-header">
                      How the Artha platform works
                    </h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <div class="border-custm"></div>
                    <h5 class="element-inner-header">
                      How the Artha platform works
                    </h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>-->
                      <?php }?> 
                       
                      

                  </div>
                </div>
                  <!--END - Projects list-->
                </div>
              </div>
            </div>
            <!--------------------
              END - content
              -------------------->


            <!--------------------
              START - Color Scheme Toggler
              -------------------->
            <div class="floated-colors-btn second-floated-btn">
              <div class="os-toggler-w">
                <div class="os-toggler-i">
                  <div class="os-toggler-pill"></div>
                </div>
              </div>
              <span>Dark </span>
              <span>Colors</span>
            </div>
            <!--------------------
              END - Color Scheme Toggler
              -------------------->
            <!--------------------
              START - Chat Popup Box
              -------------------->
            <div class="floated-chat-btn">
              <i class="os-icon os-icon-mail-07"></i>
              <span>Demo Chat</span>
            </div>
            <div class="floated-chat-w">
              <div class="floated-chat-i">
                <div class="chat-close">
                  <i class="os-icon os-icon-close"></i>
                </div>
                <div class="chat-head">
                  <div class="user-w with-status status-green">
                    <div class="user-avatar-w">
                      <div class="user-avatar">
                        <img alt="" src="img/avatar1.jpg">
                      </div>
                    </div>
                    <div class="user-name">
                      <h6 class="user-title">
                        John Bloggs
                      </h6>
                      <div class="user-role">
                        Director
                      </div>
                    </div>
                  </div>
                </div>
                <div class="chat-messages">
                  <div class="message">
                    <div class="message-content">
                      Hi, how can I help you?
                    </div>
                  </div>
                  <div class="date-break">
                    Mon 10:20am
                  </div>
                  <div class="message">
                    <div class="message-content">
                      Hi, my name is Mike, I will be happy to assist you
                    </div>
                  </div>
                  <div class="message self">
                    <div class="message-content">
                      Hi, I tried ordering this product and it keeps showing me error code.
                    </div>
                  </div>
                </div>
                <div class="chat-controls">
                  <input class="message-input" placeholder="Type your message here..." type="text">
                  <div class="chat-extra">
                    <a href="#">
                      <span class="extra-tooltip">Attach Document</span>
                      <i class="os-icon os-icon-documents-07"></i>
                    </a>
                    <a href="#">
                      <span class="extra-tooltip">Insert Photo</span>
                      <i class="os-icon os-icon-others-29"></i>
                    </a>
                    <a href="#">
                      <span class="extra-tooltip">Upload Video</span>
                      <i class="os-icon os-icon-ui-51"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!--------------------
              END - Chat Popup Box
              -------------------->
          </div>
          <!--------------------
            START - Sidebar
            -------------------->
          <div class="content-panel">
            <div class="content-panel-close">
              <i class="os-icon os-icon-close"></i>
            </div>            
            <div class="element-wrapper">
              <h6 class="element-header">
                Useful Links
              </h6>

              <!--START - To Do SIDEBAR-->
              <div class="todo-app-w">
                <div class="todo-sidebar">
                  <div class="todo-sidebar-section">
                    <div class="todo-sidebar-section-contents">
                      <ul class="projects-list">  
                         

                                  <?php $count=0; if(isset($content)){?>
                        <?php foreach($content as $content) {?>

                          
                          <li>
                              
                              
                              
                              <a href="content/<?php echo $content->slug;?>" class="<?php if($count==0){echo 'active';}?>">{{$content->title}}</a>
                        </li>
                        
                          
                          
<!--                        <li>
                          <a href="#" class="active">About Artha  </a>
                        </li>
                        <li>
                          <a href="#">FAQ’s</a>
                        </li>
                        <li>
                          <a href="#">Terms of Service</a>
                        </li>
                        <li>
                          <a href="#">Privacy Policy</a>
                        </li>
                        <li>
                          <a href="#">Report Bugs</a>
                        </li>-->
                         <?php $count++; }}?>
                        
                              <?php if(isset($data['content2'])){?>
                        <?php foreach($data['content2'] as $content) {?>

                          
                          <li>
                              
                              
                              
                              <a href="<?php echo "".$content->slug;?>" class="<?php if($title1==$content->title ){echo 'active';}  ?>">{{$content->title}}</a>
                        </li>
                          
                          
<!--                        <li>
                          <a href="#" class="active">About Artha  </a>
                        </li>
                        <li>
                          <a href="#">FAQ’s</a>
                        </li>
                        <li>
                          <a href="#">Terms of Service</a>
                        </li>
                        <li>
                          <a href="#">Privacy Policy</a>
                        </li>
                        <li>
                          <a href="#">Report Bugs</a>
                        </li>-->
                         <?php }}?>

                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!--END - To Do SIDEBAR-->

            </div>
          </div>
          <!--------------------
            END - Sidebar
            -------------------->
        </div>
      </div>
    


@endsection

