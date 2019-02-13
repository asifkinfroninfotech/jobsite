<div class="table-responsive" style='overflow-x: scroll;'>

                                                        
<table  width="100%" class="table table-striped table-lightfont" id="dataTable1">
                        <thead>
                            <tr>
                                <th>Entity name</th>
                                <th>User First Name</th>
                                <th>User Last Name</th>
                                <th>User Email</th>
                                <th>Phone</th>
                                <th>Job Title</th>
                                <th>Website</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Address</th>
                                <th>State</th>
                                <th>Skype</th>
                                <th>Twitter</th>
                                <th>Zip</th>
                                <th>Status</th>
                                <th>Password</th>
                            </tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tbody>
                       
                        <?php for($i=0;$i<count($tablesuccess);$i++) {?>
                        <tr>
                            <?php for($j=0;$j<=15;$j++){?>
                            <td><span>{{$tablesuccess[$i][$j]}}</span></td>
                          <?php }?>
                         
                        </tr>
                        <?php }?>
                     </table>
                      </div>   
                        