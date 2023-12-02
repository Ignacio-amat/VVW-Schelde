<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        public function index()
    {
        $users = User::all();

        return view('users.home', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find(1); // Replace 1 with the appropriate user ID or retrieval logic

        // Delete previous profile picture if it exists
        if ($user && $user->profile_picture_path) {
            Storage::delete($user->profile_picture_path);
        }

        $path = $request->file('profile_picture')->store('public/profile_pictures');

        $user->profile_picture_path = $path;
        $user->save();



        return redirect()->route('users.index')->with('status', 'Profile picture updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
