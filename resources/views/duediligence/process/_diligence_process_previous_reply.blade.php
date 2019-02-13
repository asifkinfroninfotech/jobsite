 <?php
$helper=\App\Helpers\AppHelper::instance();
$AnswerDocumentPath=\App\Helpers\AppGlobal::fnGet_AnswerDocumentPath();
  $UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
  $CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();

?>
                      <div class="support-ticket-content-header diligence-process-spce">
                                  <h3 class="ticket-header process-hd">
                                    @if(isset($questiontext))
                                      {{$questiontext->questiontext}}
                                    @endif
                                  {{-- @if($data->count()>0)
                                 {{$data[0]->dd_question->questiontext}}
                                  @endif --}}
                                  </h3>
                                  <a class="back-to-index" href="#">
                                    <i class="os-icon os-icon-arrow-left5"></i>
                                    <span>Back</span>
                                  </a>
                                  <a class="show-ticket-info" href="#">
                                    <span>Show Details</span>
                                    <i class="os-icon os-icon-documents-03"></i>
                                  </a>
                      </div>

                      <div class="ticket-thread">
                             @foreach($data as $reply)
                              <div class="ticket-reply">
                                    <div class="ticket-reply-info">
                                        
                                      <a class="author with-avatar" href="/user/profile/view?user={{$reply->user->userid}}">
                                       
                                     @if($reply->user->profileimage==null)
                                        <img alt="" src="{{ Avatar::create($reply->user->firstname .' ' . $reply->user->lastname)->toBase64() }}">  
                                     @else
                                       <img alt="" src="{{$UserProfileImagePath . $reply->user->profileimage}}">

                                     @endif
                                        <span>{{ $reply->user->firstname .' ' . $reply->user->lastname }}</span>
                                      </a>
                                      <span class="info-data">
                                        <span class="label">{{trans('duediligenceprocess.lebel_repliedon')}}</span>
                                        <span class="value">{{$helper->dateconv_with_at($reply->updated)}}</span>
                                      </span>

                                      @if($is_parent[0]->Is_Parent=='Yes')
                                      <div class="actions" href="#">
                                        <i class="os-icon os-icon-ui-46"></i>
                                        <div class="actions-list">
                                          <a href="#" onclick="fnShowModalToEditPreviousReply('{{$reply->answerid}}');">
                                          <i class="os-icon os-icon-ui-49"></i>
                                            <span>Edit</span>
                                          </a>
                                          <a class="danger" href="#" onclick="fnSetAnswerIdToDelete('{{$reply->answerid}}');">
                                            <i class="os-icon os-icon-ui-15"></i>
                                            <span>Delete</span>
                                          </a>
                                        </div>
                                      </div>
                                      @endif

                                    </div>
                                    <div class="ticket-reply-content" id="ticket-reply-content_{{$reply->answerid}}">
                                      {!! str_replace('</p>', '',str_replace('<p>', '', $reply->answertext) )!!}
                                    </div>


                                    <div class="ticket-attachments">

                    @foreach($reply->dd_answers_documents as $doc)
                        @if($doc->documenttype === 'png' or $doc->documenttype === 'jpg' or $doc->documenttype === 'gif')
                                    <a class="attachment" href="{{$AnswerDocumentPath . $doc->document_application_name}}" target="_blank">
                              <i class="os-icon os-icon-documents-07"></i>
                               <span>{{$doc->documentname}}</span>
                            </a>
                        @endif
                       
                       @if($doc->documenttype === 'pdf' or $doc->documenttype === 'doc' or $doc->documenttype === 'docx' or $doc->documenttype === 'txt' or $doc->documenttype === 'csv' or $doc->documenttype === 'xls' or $doc->documenttype === 'xlsx')
                         <a class="attachment" href="{{$AnswerDocumentPath . $doc->document_application_name}}" target="_blank">
                             <i class="os-icon os-icon-ui-51"></i>
                             <span>{{$doc->documentname}}</span>
                        </a>
                        @endif

                    @endforeach
                                    </div>

                                  </div>

                             @endforeach


                                </div>




