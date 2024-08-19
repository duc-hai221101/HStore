<?php

namespace App\Http\Controllers;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\deleteTrait;
use Illuminate\Http\Request;
use DB;
use Log;
class AdminRoleController extends Controller
{
   use deleteTrait;
   private $role;
   private $permission;

   public function __construct(Role $role,Permission $permission)
   {
       $this->role=$role;
       $this->permission=$permission;
   }

    public function index()
    {
        $roles = $this->role->latest()->paginate(5);
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
      $permissions=$this->permission->where('parent_id',0)->get();
        return view('admin.role.add',compact('permissions'));
    }

    public function store(Request $request)
    {
      try{
        DB::beginTransaction();
        $role=$this->role->create([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
        ]);
        $role->permissions()->attach($request->permission_id);
        DB::commit();
        return redirect()->route('roles.index');
      }
      catch(\Exception $e){
        DB::rollBack();
        Log::error('Message: ' . $e->getMessage() . ' Line :' . $e->getLine());
        return redirect()->back()->with('error', 'Them khong thanh cong!');
      }
    }

    public function edit($id)
    {
       $roles=$this->role->findOrFail($id);
       $permissions=$this->permission->where('parent_id',0)->get();
       $permissionCheck=$roles->permissions;
       return view('admin.role.edit',compact('roles','permissions','permissionCheck'));
    }

    public function update(Request $request,$id)
    {
      try{
        DB::beginTransaction();
        $role=$this->role->find($id)->update([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
        ]);
        $role=$this->role->findOrFail($id);
        $role->permissions()->sync($request->permission_id);
        DB::commit();
        return redirect()->route('roles.index');
      }
      catch(\Exception $e){
        DB::rollBack();
        Log::error('Message: ' . $e->getMessage() . ' Line :' . $e->getLine());
        return redirect()->back()->with('error', 'Them khong thanh cong!');
      }
    }
    public function delete($id)
    {
       return $this->deleteModel($id,$this->role);
    }
  
}
