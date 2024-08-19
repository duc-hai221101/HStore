<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Role;
use App\Traits\deleteTrait;
use Hash;
use Illuminate\Http\Request;
use DB;
use Log;
class AdminUserController extends Controller
{
    private $user;
    private $role;
    use deleteTrait;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;

    }



    public function index()
    {
        $users = $this->user->latest()->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->role->all();
        return view('admin.user.add', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $user->role_user()->attach($request->role_id);
            DB::commit();
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Message: ' . $e->getMessage() . ' Line :' . $e->getLine());
            return redirect()->back()->with('error', 'Them khong thanh cong!');

        }
    }

    public function edit($id)
    {
        $user=$this->user->findOrFail($id);
        $roles = $this->role->all();
        $roleUser=$user->role_user;
        return view('admin.user.edit',compact('user','roles','roleUser'));
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
           $this->user->findOrFail($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $user=$this->user->findOrFail($id);
            $user->role_user()->sync($request->role_id);
            DB::commit();
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Message: ' . $e->getMessage() . ' Line :' . $e->getLine());
            return redirect()->back()->with('error', 'Them khong thanh cong!');

        }
    }
    public function delete($id)
    {
       return $this->deleteModel($id,$this->user);
    }

}
