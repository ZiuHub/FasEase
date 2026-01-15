<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class InfoUserController extends Controller
{

    public function create()
    {
        $user = auth()->user();
        return view('user/user-profile', compact('user'));
    }

    public function store(Request $request)
    {

        $user = Auth::user();
        $data = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'max:15'],
            'location' => ['nullable', 'max:100'],
            'about_me' => ['nullable', 'max:500'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'notes' => $data['about_me']
        ]);

        if($user->organization){
            $user->organization->update([
                'location' => $data['location'] ?? $user->organization->location,
            ]);
        }


        return redirect('/user-profile')->with('success','Profile updated successfully');
    }
}
