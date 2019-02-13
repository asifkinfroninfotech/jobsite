<div class="element-wrapper">
                          @if(count($data['friend_requests'])>0)
                          
                            <h6 class="element-header">
                                Requests
                            </h6>
                          
                          @endif
                            <div class="element-box-tp">
                                @foreach ($data['friend_requests'] as $frequest)
                                <div class="profile-tile">
                                    <a class="profile-tile-box" href="#">
                                        <div class="pt-avatar-w">
                                              @if( (isset($frequest->profileimage) && !empty($frequest->profileimage) ) && File::exists(public_path('storage/user/profileimage/'.$frequest->profileimage)))
                                            <img alt="" src="/storage/user/profileimage/{{$frequest->profileimage}}">
                                            
                                            @else
                                             
                                              <img alt="" src="{{ Avatar::create(strtoupper($frequest->user_firstname) .' ' . strtoupper($frequest->user_lastname))->toBase64() }}" >
                                            @endif
                                            
                                        </div>
                                        <div class="pt-user-name">
                                            {{ $frequest->user_firstname .' ' . $frequest->user_lastname }}
                                        </div>
                                    </a>
                                    <div class="profile-tile-meta">
                                        <ul>
                                            <li>
                                                <span>Company:</span>
                                                <strong>{{ $frequest->companyname }}</strong>
                                            </li>
                                            <li>
                                                <span>Type:</span>
                                                <strong>{{ $frequest->companytype }}</strong>
                                            </li>
                                        </ul>
                                        <div class="pt-btn">
                                            <button type="button" class="btn btn-success btn-sm" onclick="acceptfriend('{{ $frequest->friendid }}');">Accept</button>
                                        </div>
                                        <div class="pt-btn">
                                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#myModal" onclick="appendtodel('{{ $frequest->friendid }}');">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>