<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Support\Str;
use Gate;
use Illuminate\Http\Request;
use App\Components\Recusive;
class CategoryController extends Controller
{
    private $category;
    public function __construct(Category $category)
    {
     $this->category= $category;
    }

    public function create(){

        $htmlOption=$this->getCategory($parentid ="");
        return view('admin.category.add', compact('htmlOption'));
    }
    
    public function index(){
        if (Gate::allows('category-list')) {
            $categories =$this->category->latest()->paginate(5);
            return view('admin.category.index',compact('categories'));       
         } else {
            // Logic cho trường hợp người dùng không có quyền
            abort(403);
        }
       
    }
    public function store(Request $request){

        $this->category->create([
            'name' => $request->name,  // Access specific field from request
            'parent_id' => $request->parent_id , // Assuming $parent_id holds the field name
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('categories.index');
    }   
    public function getCategory($parent_id){
        $data= $this->category->all();
        $recusive = new Recusive($data);
        $htmlOption =    $recusive->dequy($parent_id);
        return $htmlOption;
    }
    public function edit($id){
        $category = $this->category->find($id);
        $htmlOption=$this->getCategory($category->parent_id);

        return view('admin.category.edit',compact('category','htmlOption'));
    }
    public function update(Request $request, $id)
    {
        $this->category->find($id)->update([
            'name' => $request->name,  // Access specific field from request
            'parent_id' => $request->parent_id, // Assuming $parent_id holds the field name
            'slug' => Str::slug($request->name)
        ]);
    
        return redirect()->route('admin.category.index');
    }
    
    public function delete($id){
        $this->category->find($id)->delete();
        return redirect()->route('categories.index');
    }
}
