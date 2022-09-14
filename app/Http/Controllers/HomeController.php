<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Room;
use App\Models\Device;
use App\Models\UserRoom;
use App\Models\UserRoomDevice;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session as FacadesSession;
use stdClass;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      return view('index');
    }
}
