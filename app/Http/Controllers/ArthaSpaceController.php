<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use session;
use View;
use Carbon\Carbon;
use File;

class ArthaSpaceController extends Controller
{
    public function login()
    {
        return view('artha_space.login');
    }
}