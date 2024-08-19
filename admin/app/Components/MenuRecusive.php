<?php
namespace App\Components;
use App\Models\Menu;

class MenuRecusive{
    private $html;
    public function __construct(){
        $this->html='';
    }
    public function menuRecusiveADD($parent_id=0,$text=''){
        $data= Menu::where('parent_id',$parent_id)->get();
        foreach($data as $dataItem){
            $this->html .= '<option value="'. $dataItem->id. '">'. $text . $dataItem->name . '</option>';
            $this->menuRecusiveADD($dataItem->id,$text. '--');

        }
        return $this->html;
    }
    public function menuRecusiveEdit($parentIdEdit,$parent_id=0,$text=''){
        $data= Menu::where('parent_id',$parent_id)->get();
        foreach($data as $dataItem){
            
            if($parentIdEdit == $dataItem->id){
                $this->html .= '<option selected value="'. $dataItem->id. '">'. $text . $dataItem->name . '</option>';
            }
            else{
                $this->html .= '<option value="'. $dataItem->id. '">'. $text . $dataItem->name . '</option>';
            }
            $this->menuRecusiveEdit($parentIdEdit,$dataItem->id, $text. '--');

        }
        return $this->html;
    }
}