<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $data = [
            'menu' => 'menu.v_menu_admin', // Pastikan menu ini ada di resources/views/menu/v_menu_admin.blade.php
            'content' => 'profile.index',   // View profile akan berada di resources/views/profile/index.blade.php
            'title' => 'My Profile',
            'user' => $user,
            'learningStyle' => \App\Helpers\LearningStyleHelper::getFormattedLearningStyle(),
        ];

        return view('layouts.v_template', $data);
    }

    public function upload(Request $request)
    {
        // Validasi server-side
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'profile_image.required' => 'Please select a profile image to upload',
            'profile_image.image' => 'The file must be an image',
            'profile_image.mimes' => 'Only JPEG, PNG, JPG, and GIF images are allowed',
            'profile_image.max' => 'The image may not be greater than 2MB'
        ]);

        // Proses upload file
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $filename = 'profile_'.Auth::id().'_'.time().'.'.$image->getClientOriginalExtension();

            // Simpan file baru
            $path = $image->storeAs('public/profile_images', $filename);

            // Update database
            $user = Auth::user();

            // Hapus file lama jika ada
            if ($user->image) {
                Storage::delete('public/profile_images/'.$user->image);
            }

            $user->image = $filename;
            $user->save();

            return back()->with('success', 'Profile photo uploaded successfully!');
        }

        return back()->with('error', 'Failed to upload profile photo.');
    }

    public function remove()
    {
        $user = Auth::user();

        if ($user->image) {
            // Hapus file dari storage
            Storage::delete('public/profile_images/'.$user->image);

            // Update database
            $user->image = '';
            $user->save();

            return back()->with('success', 'Profile photo removed successfully!');
        }

        return back()->with('error', 'No profile photo to remove.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();

        $data = [
            'count_user' => \App\Models\User::count(),
            'menu' => 'menu.v_menu_admin',
            'content' => 'profile.edit', // Pastikan file view ini ada
            'title' => 'Edit Profile',
            'user' => $user,
        ];

        return view('layouts.v_template', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('image')) {
            // Simpan dan update gambar
            $path = $request->file('image')->store('public/profile_images');
            $user->image = basename($path);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
