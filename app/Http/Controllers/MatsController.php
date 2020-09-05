<?php

namespace App\Http\Controllers;

use App\Data;
use App\Grades;
use App\Groups;
use App\Mats;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;

class MatsController extends Controller
{
    //
    public function index(){
        return view('index');
    }
    public function get_data(){
        $Mats = Mats::all();
        $groups = Groups::all();
        $grades = Grades::all();
        $Rmat = array();
        $Rgroup = array();
        $Rgrade = array();
        foreach ($Mats as $index => $value){
            $Rmat[]=["id"=>$value['_id'],"name"=>$value['mat_name']];
        }
        foreach ($groups as $index => $value){
            $Rgroup[]=["id"=>$value['_id'],"name"=>$value['group_name']];
        }
        $Column[] = (object)["type"=> 'hidden',"name"=>'_id'];
        $Column[] = (object)["type"=> 'text',"name"=>'Name', "title"=>'سایز', "width"=>'150'];
        $Column[] = (object)["type"=> 'dropdown',"name"=>'mat', "title"=>'طرح', "width"=>'150', "source"=>$Rmat, "autocomplete"=>"true", "multiple"=>"true"];
        $Column[] = (object)["type"=> 'dropdown',"name"=>'group', "title"=>'گروه', "width"=>'150', "source"=>$Rgroup, "autocomplete"=>"true"];
        foreach ($grades as $index => $value){
            $Column[] = (object)["type"=> 'text',"name"=>'grade'.$index, "title"=>$value['grade_name'], "width"=>'150'];
        }
        return $Column;
    }
    public function save(Request $request){
        $requests = json_decode($request['Data'],true);
        $request = $requests[0];
        $S_DATE = $requests[1];
        $E_DATE = $requests[2];
        foreach ($request as $index => $value){
            $mats = explode(";",$value['mat']);
            $request[$index]['mat']=$mats;
            $request[$index]['sdate']=$S_DATE;
            $request[$index]['edate']=$E_DATE;
            if(isset($value['_id']) && !empty($value['_id']) && $value['_id'] != ""){
                unset($request[$index]['_id']);
                Data::where("_id",$value['_id'])
                ->update($request[$index]);
            }else{
                unset($request[$index]['_id']);
                Data::insert($request[$index]);
            }
        }
        return Data::all();
    }
    public function load(Request $request){
        $requests = json_decode($request['Data'],true);
        $sdate = $requests[0];
        $edate = $requests[1];
        $data = Data::where("sdate", '>=', $sdate)
            ->where("edate", '<=', $edate)->get();
        foreach ($data as $index => $value){
            $data[$index]['mat'] = implode(";",$value['mat']);
        }
        return $data;
    }
}
