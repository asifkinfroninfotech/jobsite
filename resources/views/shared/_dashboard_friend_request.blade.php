              
                <script>
           function appendtodel(friendid)
        {
           $("#deleteme").val(friendid);
           
        }
        function deleterequest()
        {
            
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var v_token = encodeURIComponent(csrf_token); 
//        alert($("#deleteme").val());
            
            if($("#deleteme").val()!=null)
            {
            delindex=$("#deleteme").val();    
            $.post('deleterequest',{'delid':delindex,'_token':v_token},function(data){
              $('#messagegot').text(data);
              
              
              
              
              window.location.reload();
            });
            
            }
            
            
            
    }  
           
           
             function acceptfriend(friendid)
        {
            
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var v_token = encodeURIComponent(csrf_token); 
//        alert($("#deleteme").val());
            
            
           
            $.post('friendrequest',{'friendid':friendid,'_token':v_token},function(data){
              $('#messagegot').text(data);
              
              
              
              
              window.location.reload();
            });
            
            
            
            
            
    }        
                </script>
                
                
                
                
                <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
<!--          <h4 class="modal-title">Modal Header</h4>-->
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete friend request.</p>
          <input type="hidden" id="deleteme">
        </div>
        <div class="modal-footer">
<!--          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
          <label id="messagegot"></label>
          <button type="button" id="delme123" class="btn btn-secondary btn-sm" onclick="deleterequest();">Delete</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>
  </div>
                
                
           