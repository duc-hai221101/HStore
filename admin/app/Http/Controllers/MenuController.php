<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Support\Str;
use Livewire\WithPagination;

use App\Components\MenuRecusive;
use Illuminate\Http\Request;


class MenuController extends Controller
{
    private $menuRecusive;
    private $menu;
    public function __construct(MenuRecusive $menuRecusive, Menu $menu){
        $this->menuRecusive = $menuRecusive;
        $this->menu=$menu;
    }
    public function index(){
        $menus =Menu::paginate(10)->fragment('users');
        return view('admin.menus.index',compact('menus'));
    }
    public function create(){
        $optionSelect = $this->menuRecusive->menuRecusiveADD();
        return view('admin.menus.add', compact('optionSelect'));
    }
    public function store(Request $request){
        $this->menu->create([
            'name'=>$request->name,
            'parent_id'=>$request->parent_id,
            'slug'=>Str::slug($request->name)
        ]);

        return redirect()->route('menus.index');
        
    }
    public function edit($id,Request $request){
        $menuEditId = $this->menu->find($id);
        $optionSelect = $this->menuRecusive->menuRecusiveEdit($menuEditId->parent_id);
        return view('admin.menus.edit', compact('optionSelect','menuEditId'));
    }
    public function update($id,Request $request){
         $this->menu->find($id)->update([
            'name'=>$request->name,
            'parent_id'=>$request->parent_id,
            'slub'=>Str::slug($request->name)
         ]);
         return redirect()->route('menus.index');
    }
    public function delete($id){
        $this->menu->find($id)->delete();
        return redirect()->route('menus.index');
    }
}
