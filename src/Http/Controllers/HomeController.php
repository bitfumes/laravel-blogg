<?php

namespace Bitfumes\Blogg\Http\Controllers;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('blogg::layout', [
            'cssFile'  => 'app.css',
        ]);
    }
}
