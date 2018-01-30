<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class StorageController extends Controller
{
    public function index(Request $request)
    {
        // return app('filesystem')->read('text.txt');
        // app('filesystem')->put('file.txt', 'Contents yanun');
        // return app('filesystem')->read('file.txt');

        // $path = $request->file('avatar')->store('avatars');

        // return $path;

        $file = $request->all()['avatar'];
        $path = $file->hashName('avatars');

        app('filesystem')->put(
            $path, $this->resizeImage($file)
        );

        return $file;
    }

    protected function resizeImage($file)
    {
        return (string) Image::make($file->path())
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode();
    }
}
