@foreach($team_members as $team_member)
@if(isset($team_member[0]))
    <span>

        <div class="user-w   {{($team_member[0]->is_online == 0)?'with-status status-red':'with-status status-green'}}">


            <div class="user-avatar-w">
                <div class="user-avatar">
                    <a href="/user/profile/view?user={{$team_member[0]->userid}}">
                        @if(isset($team_member[0]->profileimage)&&!empty($team_member[0]->profileimage))
                        <img alt="" src="/storage/user/profileimage/{{$team_member[0]->profileimage}}">
                        @else
                       <img alt="" src=" {{ Avatar::create(strtoupper($team_member[0]->firstname).' '.strtoupper($team_member[0]->lastname))->toBase64() }}">
                        @endif
                    </a>

                </div>
            </div>
            <div class="user-name">
                <h6 class="user-title">
                    <a> {{($team_member[0]->firstname.' '.$team_member[0]->lastname)}}</a>
                </h6>
                <div class="user-role">

                    {{($team_member[0]->userposition)}}
                </div>
            </div>
<!--            <div class="user-action">
                <a href="">
                    <div class="os-icon os-icon-link-3"></div>
                </a>
            </div>-->

          
                                                     @php
                                    $helper=\App\Helpers\AppHelper::instance();
                                  
                                    if(isset($qcompanyid) && !empty($qcompanyid))
                                    {
                                    $connect=$helper->companymessagingandconnect($qcompanyid,$team_member[0]->userid,$getfriend);
                                    }
                                    else
                                    {
                                     $connect=$helper->companymessagingandconnect('',$team_member[0]->userid,$getfriend);
                                    }
                                  
                                    @endphp
                                   
                                    @if($connect == "connect")
                   <div class="user-action">
                      <a href="/companymessaging">
                           <div class="os-icon os-icon-link-3">&nbsp;</div>
                        
                      </a>
                    </div>
                                    @elseif($connect == "messaging")
                  <div class="user-action">
                      <a href="/companymessaging?userid={{$team_member[0]->userid}}">
                       <div class="os-icon os-icon-email-forward"></div>
                      </a>
                    </div>
                                   
                                    
                                    @elseif($connect == "approval")
                  <div class="user-action">
                     
                    </div>
                                    @endif  




        </div>
    </span>
@endif
   @endforeach
