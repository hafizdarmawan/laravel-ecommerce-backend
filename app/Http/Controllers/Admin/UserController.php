<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->when(request()->q, function($users){
            $users = $users->where('name','like','%'.request()->q.'%');
        })->paginate(10);

        return view('admin.user.index',compact('users'));
    }

    public function create(){
        return view('admin.user.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|confirmed'
        ]);
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        if($user){
            return redirect()->route('admin.user.index')->with('success','Berhasil Menambah User');
        }else{
            return redirect()->route('admin.user.index')->with('error','Gagal Menambah User');
        }
    }

    public function edit(User $user){
        return view('admin.user.edit',compact('user'));
    }

    public function update(Request $request, User $user){
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'.$user->id,
            'password'  => 'required|confirmed'
        ]);

        // cek password
        if($request->password == ""){
            // update tanpa password
            $user = User::findOrFail($user->id);
            $user->update([
                'name'      => $request->name,
                'email'     => $request->email
            ]);
        }else{
            $user = User::findOrFail($user->id);
            $user->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password)
            ]);
        }

        if($user){
            return redirect()->route('admin.user.index')->with('success','Berhasil Mengubah Data');
        }else{
            return redirect()->route('admin.user.index')->with('error','Gagal Mengubah Data');
        }
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        if($user){
            return response()->json([
                'status'    => 'success'
            ]);
        }else{
            return response()->json([
                'status'    =>  'error'
            ]);
        }
    }
}
