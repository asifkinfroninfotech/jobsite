   <!--START - Network table -->
                  <div class="element-box-tp">
                    <div class="table-responsive">
                      <table class="table table-padded" id="table">
                        <thead>
                          <tr>
                            <th>
                              Company Name
                            </th>
                            <th>
                             Sector (s)
                            </th>                           
                            <th class="text-right">
                              Action
                            </th>                            
                          </tr>
                        </thead>
                        <tbody >
                         
                          
                          <div id="enterprises" >
                            @if(isset($networks['Enterprises']))
                                  @foreach($networks['Enterprises'] as $name => $sector)
                                  <tr>
                                    <td>
                                      <img alt="" src="img/rianta-small.jpg" />                                
                                      </span><span>{{$name}}</span>
                                    </td>
                                     <td><span>
                                    @foreach($sector as $sectors)
                                       @foreach($sectors as $companysector)
                                          @if(isset($companysector) && !empty($companysector))
                                           {{ $companysector->name }}
                                         @else
                                           {{ "No Sector Found" }}
                                         @endif
                                       @endforeach
                                    @endforeach 
                                     </span>
                                  </td>
                                  <td class="text-right">
                                     <a class="btn btn-success btn-sm" href="#">Connect</a>
                                  </td>  
                                  </tr>    
                                @endforeach
                              @endif
                              {{-- $companies->links() --}}
                              {{-- $companies->render() --}}
                          </div>


                                                                                                                 
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                   <!--START - next pagers-->
                   <div class="controls-below-table controls-pagination-cnt row">
                        
                    <!-- <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="table-records-info">
                        Showing records 1 - 5
                      </div>
                   </div> -->

                   <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="table-records-info">
                        
                        Showing records 1 - 5 {{-- $companies->render() --}}
                      </div>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="table-records-pages align-rit">
                      <!-- <ul>
                        <li>
                          <a href="#">Previous</a>
                        </li>
                        <li>
                          <a class="current" href="#">1</a>
                        </li>
                        <li>
                          <a href="#">2</a>
                        </li>
                        <li>
                          <a href="#">3</a>
                        </li>
                        <li>
                          <a href="#">4</a>
                        </li>
                        <li>
                          <a href="#">Next</a>
                        </li>
                      </ul> -->

                      {{-- $companies->links() --}}
                    </div>
                    </div>
                  
                  </div>
                  <!--END - next pagers-->
                  <!--END - Network table -->