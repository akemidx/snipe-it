<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function store(Request $request) {
        dd($request->all());
    }

}
