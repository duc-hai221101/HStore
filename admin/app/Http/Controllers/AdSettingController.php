<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use App\Traits\deleteTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SettingRequestAdd;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class AdSettingController extends Controller
{
    private $setting;
    use deleteTrait;
    public function __construct(Setting $setting){
        $this->setting=$setting;
    }
    public function index()
    {
        $settings = $this->setting->latest()->paginate(5);
        return view('admin.setting.index',compact('settings'));
    }

    public function create()
    {
        
        return view('admin.setting.add');
    }
    public function store(SettingRequestAdd $request){
        try{
            $dataInsert=[
                'config_key'=>$request->config_key,
                'config_value'=>$request->config_value,
                'type'=>$request->type,
            ];
            $this->setting->create($dataInsert);
            DB::commit();
            return redirect()->route('settings.index');
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error('Message: ' . $e->getMessage() . ' Line :' . $e->getLine());
            return redirect()->back()->with('error', 'Error creating setting!');
        }
    }
    public function edit($id)
    {
        $setting= $this->setting->find($id);
        return view('admin.setting.edit',compact('setting'));
    }
    public function update(Request $request,$id)
    {

        try{
            DB::beginTransaction();

            $this->setting->findOrFail($id)->update([
                'config_key' => $request->config_key, // Update other fields as needed
                'config_value' => $request->config_value,
            ]);    
            DB::commit();

            return redirect()->route('settings.index');
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error('Message: ' . $e->getMessage() . ' Line :' . $e->getLine());
            return redirect()->back()->with('error', 'Error creating setting!');
        }
    }
    public function delete($id)
    {
        return $this->deleteModel($id,$this->setting);

    }
}
