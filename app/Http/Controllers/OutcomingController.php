<?php

namespace App\Http\Controllers;

use App\Models\Letters;
use Illuminate\Http\Request;

class OutcomingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function outLetterIndex()
    {
        return view('pages.admin.transactions.outcoming.index', [
            'letters' => Letters::with('classification')->get(),
        ]);
    }
}
