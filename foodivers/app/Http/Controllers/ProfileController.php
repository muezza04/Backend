<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // membuat function index untuk profile
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();

        return view('profile.index', compact('user'));
    }

    // membuat function edit untuk edit profile
    public function edit(Request $request)
    {
        $this->validate($request, [
            'password' => 'confirmed',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);
        }
        $user->update();

        Alert::success('Profile sudah di update');
        return redirect('profile');
    }
}
