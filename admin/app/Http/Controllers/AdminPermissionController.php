<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use DB;
use Log;
class AdminPermissionController extends Controller
{

    public function index(){

    }
    public function create(){
      return view('admin.permission.add');
    }
    public function store(Request $request){
        try{
            $permissions = Permission::create([
                'name'=>$request->module_parent,
                'display_name'=>$request->module_parent,
                'parent_id'=> 0
            ]);
            foreach ($request->module_child  as $value){
                Permission::create([
                    'name'=>$value,
                    'display_name'=>$value,
                    'parent_id'=>$permissions->id,
                    'key_code'=> $request->module_parent .'_'. $value,
                ]);
            }
            return redirect()->route('permissions.add')        ;
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error('Message: ' . $e->getMessage() . ' Line :' . $e->getLine());
            return redirect()->back()->with('error', 'Them khong thanh cong!');
        }
    }
}
