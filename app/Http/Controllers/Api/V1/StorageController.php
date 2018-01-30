<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function index(Request $request)
    {
        // return app('filesystem')->read('text.txt');
        // app('filesystem')->put('file.txt', 'Contents yanun');
        // return app('filesystem')->read('file.txt');

        $path = $request->file('avatar')->store('avatars');

        return $path;
    }
}
