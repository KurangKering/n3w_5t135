<?php

namespace App\Http\Controllers;

use App\User;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class ProfilController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        $user = \Auth::check() ? \Auth::user() : '';
        return view('profil.index', compact('user'));
    }

    public function update(Request $request)
    {

        $user = User::find(\Auth::user()->id);
        $this->validate($request, [
            'name'       => 'required',
            'username'   => 'required||unique:users,username,' . $user->id,
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'password'   => 'same:confirm-password',
            'file_photo' => 'sometimes|nullable|max:1500|mimes:jpg,jpeg,png',

        ]);

        $input = ($request->all());
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        if (!empty($request->file('file_photo'))) {

            $photoLama        = $user->file_photo;
            $oldDir           = File::dirName($photoLama);
            $oldName          = File::name($photoLama);
            $oldExt           = File::extension($photoLama);
            $delPhotoLama     = Storage::delete($photoLama);
            $fullPathOldThumb = "$oldDir/$oldName-small.$oldExt";
            $delOldThumb      = Storage::delete($fullPathOldThumb);

            $dirPhoto      = 'photo-profil';
            $photoBaru     = $request->file('file_photo');
            $pathPhotoBaru = $photoBaru->store($dirPhoto);
            $filename      = File::name($pathPhotoBaru);
            $fileExt       = File::extension($pathPhotoBaru);
            $fullPathThumb = storage_path("app/public/$dirPhoto/$filename-small.$fileExt");

            $realPath            = $photoBaru->getRealPath();
            $thumbnail           = Image::make($realPath)->resize(48, 48)->save($fullPathThumb);
            $input['file_photo'] = $pathPhotoBaru;
        }

        $user->update($input);
        return back();

    }
}
