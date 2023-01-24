<?php

namespace App\Http\Controllers;

use App\Models\Classifications;
use App\Models\Letters;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function staffHome()
    {
        $letters = Letters::all();
        $data = [
            'klasifikasi' => Classifications::count(),
            'incomingLetter' => $letters->where('type', 'incoming')->count(),
            'outgoingLetter' => $letters->where('type', 'outgoing')->count(),
            'users' => User::where('type', 0)->count()
        ];
        return view('pages.staff.index', compact('data'));
    }

    public function adminHome()
    {
        $letters = Letters::all();
        $data = [
            'klasifikasi' => Classifications::count(),
            'incomingLetter' => $letters->where('type', 'incoming')->count(),
            'outgoingLetter' => $letters->where('type', 'outgoing')->count(),
            'users' => User::where('type', 0)->count()
        ];
        return view('pages.admin.index', compact('data'));
    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function kabidHome()
    {
        $letters = Letters::all();
        $data = [
            'klasifikasi' => Classifications::count(),
            'incomingLetter' => $letters->where('type', 'incoming')->count(),
            'outgoingLetter' => $letters->where('type', 'outgoing')->count(),
            'users' => User::where('type', 0)->count()
        ];
        return view('pages.kabid.index', compact('data'));
    }
}
