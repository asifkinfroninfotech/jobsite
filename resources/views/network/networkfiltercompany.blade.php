 <div class="element-box-tp">
                    <div class="table-responsive">
                      <table class="table table-padded network-rows">
                        <thead id="companylist">
                          <tr>
                            <th>
                              {{trans('network.table_company_name_title')}}
                            </th>
                            <th>
                              {{trans('network.table_sector_title')}}
                            </th>                           
                            <th class="text-right">
                              {{trans('network.table_action_title')}}
                            </th>                            
                          </tr>
                        </thead>
                        
                         <thead id="userslist" style="display: none;">
                          <tr>
                            <th>
                              Company Name
                            </th>
                            <th>
                             Sector (s)
                            </th> 
                            <th>
                             UserName
                            </th> 
                            <th>
                             Position
                            </th> 
                            
                            <th class="text-right">
                              Action
                            </th>                            
                          </tr>
                        </thead>
                        
                        
                        
                        
                        <tbody>
                            
                            @foreach($company as $company1)
                            
                        <tr id='{{$company1->companyid}}'>
                            <td>
                                <div class="user-with-avatar  ">
                                <a href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype}}"> 
                            @if( (isset($company1->profileimage) && !empty($company1->profileimage) ) && File::exists(public_path('storage/company/profileimage/'.$company1->profileimage)))
                            <img alt="" src="storage\company\profileimage\{{$company1->profileimage}}" />
                            
                           
                               @else
                                <img alt="" src="{{ Avatar::create($company1->companyname)->toBase64() }}" />    
                              @endif
                                </a>
                              </span><span>{{$company1->companyname}}</span>
                              </div>
                            </td>
                            <td>
                              <span>{{$company1->sectors}} 
                                @if($company1->scount>1)
                              <span class="smaller lighter">more</span>
                                @endif
                              </span>
                            </td>
                            <td class="text-right">
                              <a class="btn btn-success btn-sm" href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype}}">View</a>
                            </td>                           
                          </tr>  
                          @endforeach
                         
                        </tbody>
                        
                       

                        
                        
                        
                      </table>
                    </div>
                  </div>
                   <!--START - next pagers-->
                   
                  {{ $company->links('network.network_pagination') }}
                   
                   
                   
                  