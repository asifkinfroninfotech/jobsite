@foreach($data as $data)

<tr>
                     
                            <td>
                                {{$data->title}}
                            </td>
                            {{-- <td>
                                {{$data->description}}
                            </td> --}}
                            <td>
                                {{$data->button_text}}
                            </td>
                            <td>
                                {{$data->button_link}}
                            </td>
                                       <td>
                
                              <div class="user-with-avatar company-name-img">
                                
                                
                                <img src="/storage/tenant/slides/{{$data->image}}"></div>
                              
                            </td>                    
                            <td class="text-center">
                              
                              <div class="btn-group mr-1 mb-1">
                                  <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>
                                  <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                      <a class="dropdown-item" onclick="editslide('{{$data->slideid}}')">Edit</a>
                                       <a class="dropdown-item" onclick="deleteslide('{{$data->slideid}}')">Delete</a>
                                  </div>
                              </div>
                            </td>
                          </tr> 
@endforeach                          