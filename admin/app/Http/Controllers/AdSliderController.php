<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Traits\StorageImageTraits;
use App\Traits\deleteTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
class AdSliderController extends Controller
{
    use StorageImageTraits;
    use deleteTrait;

    private $slider;
    public function __construct(Slider $slider){
        $this->slider=$slider;
    }
    public function index(){
        $sliders=$this->slider->latest()->paginate(5);
        return view('admin.slider.index',compact('sliders'));
    }


    public function create()
    {
        return view('admin.slider.add');
    }
    public function store(SliderRequest $request)
    {
        try {
            DB::beginTransaction();
            $dataInsert = [
                'name' => $request->name,
                'description' => $request->description,
            ];
            $dataSlider= $this->storageTraitUpload($request,'image_path','slider');
            if(!empty($dataSlider)){
                $dataInsert['image_name']=$dataSlider['file_name'];
                $dataInsert['image_path']=$dataSlider['file_path'];
            }
            $this->slider->create($dataInsert);
            DB::commit();
            return redirect()->route('sliders.index')->with('success', 'Slider created successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' Line :' . $exception->getLine());
            return redirect()->back()->with('error', 'Error creating slider!');
        }
      
    }
    public function edit($id){
        $slider=$this->slider->findOrFail($id);
        return view('admin.slider.edit',compact('slider'));
    }

    public function update(Request $request,$id){
        try {
            DB::beginTransaction();
            $dataInsert = [
                'name' => $request->name,
                'description' => $request->description
            ];
            $dataSlider= $this->storageTraitUpload($request,'image_path','slider');
            if(!empty($dataSlider)){
                $dataInsert['image_name']=$dataSlider['file_name'];
                $dataInsert['image_path']=$dataSlider['file_path'];
            }
            $this->slider->find($id)->update($dataInsert);
            DB::commit();
            return redirect()->route('sliders.index')->with('success', 'Slider created successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' Line :' . $exception->getLine());
            return redirect()->back()->with('error', 'Error creating slider!');
        }
    }
    public function delete($id)
    {
        return $this->deleteModel($id,$this->slider);
    }
}
