<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin|super_admin');
        $this->middleware('permission:read_users')->only('index');
        $this->middleware('permission:create_users')->only('create');
        $this->middleware('permission:update_users')->only('edit');
        $this->middleware('permission:delete_users')->only('destroy');

    }

    public function index(Request $request)
    {

        $users = User::whereRoleIs('admin')->when($request->search, function($q) use($request) {
            return $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')->whereRoleIs('admin');
        })->latest()->paginate(5);

        // $users = User::whereRoleIs('admin')->where( function($query) use($request){
        //     return  $query->when($request->search, function($q) use($request) {
        //         return $q->where('first_name', 'like', '%' . $request->search . '%')
        //                 ->orWhere('last_name', 'like', '%' . $request->search . '%');
        //     });
        // })->latest()->paginate(5);

        return view('dashboard.users.index', compact('users'));

    }

    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|min:2|max:15',
            'last_name' => 'required|min:2|max:15',
            'email' => 'required|email|max:60|unique:users',
            'password' => 'required|confirmed|max:60',
            'image' => 'image|max:1000|mimes:png,jpg,jpeg,gif',
            'permissions' => 'required|min:1'
        ]);

        $data['password'] = bcrypt($request->password);

        if($request->has('image')){

            // resize the image to a height of 200 and constrain aspect ratio (auto width)
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();
        }

        $user = User::create($data);

        $user->attachRole('admin');

        if($request->permissions != null) $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.users.index');
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => 'required|min:2|max:15',
            'last_name' => 'required|min:2|max:15',
            'email' => 'required|email|max:60|unique:users, email, ' . $user->id,
            'password' => 'nullable|confirmed|max:60',
            'image' => 'image|max:1000|mimes:png,jpg,jpeg,gif',
            'permissions' => 'required|min:1'
        ]);

        if( isset($request->password) ){
            $data['password'] = bcrypt($request->password);
        }else{
            $data['password'] = $user->password;
        }

        if( isset($request->image) ){

            // resize the image to a height of 200 and constrain aspect ratio (auto width)
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();

            Storage::disk('public_uploads')->delete('/users/' . $user->image);

        }

        $user->update($data);

        if($request->permissions != null){
            $user->syncPermissions($request->permissions);
        }else{
            $user->syncPermissions([]);
        }

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.users.index');

    }

    public function destroy(User $user)
    {

        if(! is_null($user->image)){
            Storage::disk('public_uploads')->delete('/users/' . $user->image);
        }

        $user->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
