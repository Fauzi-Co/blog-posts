<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
  public function index()
  {
    return view('register.index', [
      'title' => 'Register',
      'active' => 'register',
    ]);
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|max:100',
      'username' => ['required', 'min:3', 'max:100', 'unique:users'],
      'email' => ['required', 'email:dns', 'unique:users'],
      'password' => ['required', 'min:3', 'max:100'],
    ]);

    // enkripsi pswd
    // $validatedData['password'] = bcrypt($validatedData['password']);
    $validatedData['password'] = Hash::make($validatedData['password']);

    User::create($validatedData);

    // membuat pesan login
    // $request->session()->flash('success', 'Registration successfull! Please login');
    return redirect('/login')->with('success', 'Registration successfull! Please login');
  }
}
