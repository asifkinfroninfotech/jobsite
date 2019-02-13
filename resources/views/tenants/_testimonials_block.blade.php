@foreach($data as $data)

<tr>
                     
                            <td class="text">
                                {{$data->name}}
                            </td>
                            <td class="text">
                                {{$data->companyandrank}}
                            </td>
                            <td>
                
                              <div class="user-with-avatar company-name-img">
                                
                                
                                <img src="/storage/tenant/testimonials/{{$data->image}}"></div>
                              
                            </td>   
                            {{-- <td>
                                {{$data->description_text}}
                            </td> --}}
                           
                                                        
                            <td class="text-center">
                              
                              <div class="btn-group mr-1 mb-1">
                                  <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>
                                  <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                      <a class="dropdown-item" onclick="edittestimonial('{{$data->testimonialid}}')">Edit</a>
                                      <a class="dropdown-item" onclick="deletetestimonial('{{$data->testimonialid}}')">Delete</a>
                                                                      </div>
                              </div>
                            </td>
                          </tr> 
@endforeach                          