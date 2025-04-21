<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use stdClass;

class BlogController extends Controller
{
    public function index()
    {
        $response = new stdClass();

        $blog = Blog::all();

        $response->success = true;
        $response->data = $blog;
        $response->errors = [];

        return response()
            ->json($response);
    }

    public function store(Request $request)
    {

    }
}
