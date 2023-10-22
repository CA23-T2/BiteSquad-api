<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {

        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }
    public function store(Request $request)
    {
        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('photos');
            $user = new User($request->all());
            $user->password = bcrypt($request->password);
            $user->profile_picture = $path;
            $user->role_id = $request->role_id;
            $user->save();

        } elseif ($request->photo_url) {

            $url = $request->photo_url;
            $client = new Client();
            $fileContents = $client->get($url)->getBody();
            $path = '/photos/'.Str::uuid().'.png';
            Storage::put($path, $fileContents);
            $user = new User($request->all());
            $user->profile_picture = $path;
            $user->password = bcrypt($request->password);
            $user->role_id = $request->role_id;
            $user->save();

        } else {
            User::create($request->all());
        }

        return redirect()->route('users-index');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        $data['user'] = $user;
        $data['roles'] = $roles;

        return view('admin.users.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('photos');
            Storage::delete($user->profile_picture);

            $user->profile_picture = $path;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->role_id = $request->role_id; 
            $user->update();

        } elseif ($request->photo_url) {
            $url = $request->photo_url;
            $client = new Client();
            $fileContents = $client->get($url)->getBody();
            $path = 'photos/'.Str::uuid().'.png';

            Storage::delete($user->profile_picture);
            Storage::put($path, $fileContents);

            $user->profile_picture = $path;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->update();

        } else {
            $user->update($request->all());
        }

        return redirect()->route('users-index', $id);
    }
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        Storage::delete($user->profile_picture);
        $user->delete();
        return redirect()->route('users-index');
    }
}
