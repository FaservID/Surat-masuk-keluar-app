<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* KELOLA USER */

    public function index()
    {
        return view('pages.admin.users.index', [
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'type' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'profile_picture' => 'avatar.png',
            'password' => bcrypt(123456)
        ];

        try {
            User::create($data);
            return redirect()->route('admin.userIndex')->with('success', 'Berhasil Menambahkan Pengguna!');
        } catch (\Throwable $exception) {
            return redirect()->route('admin.userIndex')->with('error', 'Gagal Menambahkan Pengguna');
        }
    }

    public function destroy($id)
    {
        try {
            User::where('id', $id)->delete();
            return redirect()->route('admin.userIndex')->with('success', 'Berhasil Menghapus Pengguna!');
        } catch (\Throwable $exception) {
            return redirect()->route('admin.userIndex')->with('error', 'Gagal Menghapus Pengguna!');
        }
    }

    public function edit($id)
    {
        return view('pages.admin.users.edit', [
            'user' => User::where('id', $id)->first()
        ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'type' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type
        ];

        try {
            User::where('id', $id)->update($data);
            return redirect()->route('admin.userIndex')->with('success', 'Berhasil Mengubah Data!');
        } catch (\Throwable $exception) {
            return redirect()->route('admin.userIndex')->with('error', 'Gagal Mengubah Data');
        }
    }

    public function resetPassword(Request $request)
    {
        $id = $request->id;
        try {
            User::where('id', $id)->update(['password' => bcrypt(123456)]);
            return redirect()->route('admin.userIndex')->with('success', 'Berhasil Mereset Password!');
        } catch (\Throwable $exception) {
            return redirect()->route('admin.userIndex')->with('error', 'Gagal Mereset Password');
        }
    }

    /* PROFILE */
    public function adminProfile()
    {
        return view('pages.profile.index');
    }

    public function adminUploadPicture(Request $request)
    {
        $id = $request->id;

        if (!$request->hasFile('picture')) {
            return redirect()->back()->with('error', 'Anda belum memilih foto');
        }

        $file = $request->file('picture');
        $extension = $file->getClientOriginalExtension();
        // if (!in_array($file, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
        $filename = time() . '-' . $file->getClientOriginalName();
        $filename = str_replace(' ', '-', $filename);
        $file->move('profile-picture', $filename);
        User::where('id', $id)->update(['profile_picture' => $filename]);

        return redirect()->route('admin.profileIndex')->with('success', 'Berhasil Mengubah Foto Profil');
    }

    public function adminDataUpdate($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ];

        try {
            User::where('id', $id)->update($data);
            return redirect()->route('admin.profileIndex')->with('success', 'Berhasil Mengubah Data');
        } catch (\Throwable $exception) {
            return redirect()->route('admin.profileIndex')->with('error', 'Gagal Mengubah Data');
        }
    }

    public function adminPasswordUpdate(Request $request)
    {
        $this->validate($request, [
            'password1' => 'required',
            'password2' => 'required',
        ]);
        $id = $request->id;
        $pass1 = $request->password1;
        $pass2 = $request->password2;
        try {
            if ($pass1 === $pass2) {
                $convPass = bcrypt($pass1);
                User::where('id', $id)->update(['password' => $convPass]);
                return redirect()->route('admin.profileIndex')->with('success', 'Password Berhasil diubah');
            } else {
                return redirect()->route('admin.profileIndex')->with('error', 'Password tidak sama');
            }
        } catch (\Throwable $exception) {
            return redirect()->route('admin.profileIndex')->with('error', 'Gagal mengubah password');
        }
    }
}
