<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        //dd($users);
        $roles = Role::all()->pluck('name');
        return view('back.users.index',compact('roles','users'));
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
        $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users,user_email',
            'password' => 'required'
        ]);
        
        $data = [
            'user_name' => $request->name,
            'user_email' => $request->email,
            'user_password' => bcrypt($request->password),
            'user_status' => $request->status == true ? 1 : 0,
        ];
        // echo 'user_status = '. ($data['user_status']);
        // die;
        $createUser = User::create($data);
        
        ($createUser instanceof User)
            ? toastr('User Successfuly Created.','success','success') :'';
        
        $user = User::orderBy('user_id','DESC')->first();
        
        $user->assignRole($request->roles);

        return redirect(route('admin.users.index'));
    }

    public function changeStatus($id)
    {
        $user = User::where('user_id',$id)->first();

        $user->where('user_id',$id)->update([
            'user_status' => ($user->user_status == 1 ? 0 : 1)
        ]);
        
        toastr('User status changed.','success','Success!');

        return redirect(route('admin.users.index'));
    }

    public function getData(Request $request)
    {
        $user = User::where('user_id',$request->id)->with('roles')->first();
        $user->allRoles = Role::all()->pluck('name');
        return response()->json($user);
    }

    public function trashUser($id)
    {
        if($id == 1)
        {
            toastr('This user can NOT be deleted!.','error','Error!');

            return redirect(route('admin.users.index'));
        }
        User::whereNot('user_id',1)->where('user_id',$id)->delete();
        
        toastr('User successfuly TRASHED.','success','Success!');

        return redirect(route('admin.users.index'));
    }

    public function getTrashedusers()
    {
        $users = User::onlyTrashed()->orderBy('deleted_at','DESC')->get();
        return view('back.users.trashed',compact('users'));
    }

    public function recoverUser($id)
    {
        $user = User::onlyTrashed()->where('user_id',$id)->restore();
        
        toastr('User successfuly RECOVERED.','success','Success!');

        return redirect(route('admin.users.getTrashedUsers'));
    }

    public function hardDeleteUser($id)
    {
        $user = User::onlyTrashed()
                    ->where('user_id',$id)
                    ->first()
                    ->forceDelete();
        
        
        //$user->where('user_id',$id)->forceDelete();
        toastr('User successfuly DELETED.','success','Success!');

        return redirect(route('admin.users.getTrashedUsers'));
    }

    public function updateUser(Request $request)
    {
        //dd($request->post());

        $request->validate([
            'modalName' => 'required',
            'modalEmail' => [
                'required',
                'email',
                Rule::unique('users', 'user_email')->ignore($request->id,'user_id'),
            ],
        ]);
        
        
        $data = [
            'user_name' => $request->modalName,
            'user_email' => $request->modalEmail,
        ];
        
        $updateUser = User::where('user_id',$request->id)->update($data);
        
        ($updateUser instanceof User)
            ? toastr('User Successfuly Updated.','success','success') :'';
        
        $user = User::where('user_id',$request->id)->first();
        
        $user->syncRoles($request->modalRoles);
        $user->user_id == 1 ? $user->assignRole('Admin') :'';

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        dd($request->post());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
