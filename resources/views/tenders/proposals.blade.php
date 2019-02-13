<div class="table-responsive">
                    <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Bid heading</th>
                                <th>Quote Amount</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Company Name</th>
                                <th>Bid heading</th>
                                <th>Quote Amount</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($proposals as $company1)    
                        <tr>

                        <td>
                                <div class="user-with-avatar  ">
                                <a href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytypeid.'&calledfrom='}}" target="_blank"> 
                            @if( (isset($company1->profileimage) && !empty($company1->profileimage) ) && File::exists(public_path('/storage/company/profileimage/'.$company1->profileimage)))
                            <img alt="" src="/storage/company/profileimage/{{$company1->profileimage}}" />
                            
                           
                               @else
                                <img alt="" src="{{ Avatar::create($company1->name)->toBase64() }}" />    
                              @endif
                                </a>
                              <span>{{$company1->name}}</span>
                              </div>
                                
                            </td>
                       <td><span>{{$company1->proposal_heading}}</span></td>
                       <td>
                          <span>{{$company1->quoteamount}}</span>
                       </td>
                       <td>
                         {{-- <span>{{($company1->is_submitted==0)?'No':'Yes'}}</span> --}}
                         <span>{{$company1->proposalstate}}</span>
                        </td>
                       <td>
                            <div class="btn-group mr-1 mb-1">
                                <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>
                                <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                  <a class="dropdown-item" href="javascript:void(0);" onclick="viewproposal('{{$company1->proposalid}}','{{$company1->name}}')">View</a>

                                  @if(isset($company1->proposalstate) && !empty($company1->proposalstate) && $company1->proposalstate=='Submitted')
                                  <a class="dropdown-item" href="javascript:void(0);" onclick="acceptbid('{{$company1->proposalid}}')"> Accept</a>
                                  <a class="dropdown-item" href="javascript:void(0);" onclick="rejectbid('{{$company1->proposalid}}')"> Reject</a>
                                  @endif

                                </div>
                              </div>
                            
                        
                        
                        
                        
                       
                       
                       </td>
                        </tr>
                        @endforeach
                        </tbody></table>
                  </div>

