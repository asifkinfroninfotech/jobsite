<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Session;

use View;

class HeaderController extends Controller
{
    public function getmessagecount()
    {
        
        $totalmessagescount=count(DB::select(DB::raw("select * from messages,message_recipients where messages.messageid=message_recipients.messageid and messages.userid in (select messages.userid from messages,message_recipients where messages.messageid=message_recipients.messageid and message_recipients.userid='".Session('userid')."') and message_recipients.userid='".Session('userid')."'")));
        $totalgetmessagesusers=DB::select(DB::raw("select distinct profileimage,firstname,lastname from messages,message_recipients,users where messages.messageid=message_recipients.messageid and messages.userid in (select messages.userid from messages,message_recipients where messages.messageid=message_recipients.messageid and message_recipients.userid='".Session('userid')."') and message_recipients.userid='".Session('userid')."' and messages.userid = users.userid"));
        $total=array('count'=>$totalmessagescount,'totalmessageusers'=>$totalgetmessagesusers);
        
        $view=View::make('shared.message_notification')->with('data',$total);

            return $view;
        
        
    }
}
