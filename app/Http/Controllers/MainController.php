<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phospr\Fraction;
use App\company;
use App\product;
use App\variation;
class MainController extends Controller
{
    public function getIndex(){

    	return view('index')->with("current","index");
    }

    public function getCompany(){
    	$current = "company";
    	$allCompany = company::get();

    	return view('company',compact('allCompany','current'));

    }

    public function getAddProfile(){

    	return view("add_profile")->with("current","company");
    }

    public function postAddProfile(Request $request){
    	$current = "company";
    	$result = true;
    	company::create([
    		'company_name' => $request['company_name'],
    		'address' => $request['address'],
    		'contact' => $request['contact'],
    		'city' => $request['city'],
    		'state' => $request['state'],
    		'postcode' => $request['postcode']
    	]);

    	return view("add_profile",compact('current','result'));

    }

    public function editProfile(Request $request){
    	$current = "company";
    	$company = company::where('id',$request['id'])->first();
    	
    	return view('editprofile',compact('company','current'));
    }

    public function postEditProfile(Request $request){

    	company::where('id',$request['id'])
                ->update([
                  'company_name' => $request['company_name'],
                  'contact' => $request['contact'],
                  'city' => $request['city'],
                  'postcode' => $request['postcode'],
                  'state' => $request['state'],
                  'address' => $request['address']
                  ]);

        return redirect()->route('getCompany');
    }

    public function getProduct(){
        $current = "item";
        $product = product::get()->sortByDesc('id');

        return view('product',compact('product','current'));
    }

    public function ajaxDeleteProduct(Request $request){

      $result = product::where('id',$request['id'])->delete();
      
      return $result;
    }

    public function ajaxAddProduct(Request $request){

      $result = product::create(['name'=>$request['name']]);
      return $result;
    }

    public function getVariation(Request $request){
      $current = "item";
      $variation = variation::get()->sortByDesc('id');

      foreach($variation as $key => $result){
        if(strpos($result['first']," ") != null){
          $ans = explode(" ",$result['first']);
          $ans2 = explode("/",$ans[1]);
          $num = $ans[0]." <sup>".$ans2[0]."</sup>&frasl;<sub>".$ans2[1]."</sub>";
          $variation[$key]['first'] = $num;
        }else if(strpos($result['first'],"/") != null){
          $ans = explode("/",$result['first']);
          $num = "<sup>".$ans[0]."</sup>&frasl;<sub>".$ans[1]."</sub>";
          $variation[$key]['first'] = $num;
        }

        if(strpos($result['second']," ") != null){
          $ans = explode(" ",$result['second']);
          $ans2 = explode("/",$ans[1]);
          $num = $ans[0]." <sup>".$ans2[0]."</sup>&frasl;<sub>".$ans2[1]."</sub>";
          $variation[$key]['second'] = $num;
        }else if(strpos($result['second'],"/") != null){
          $ans = explode("/",$result['second']);
          $num = "<sup>".$ans[0]."</sup>&frasl;<sub>".$ans[1]."</sub>";
          $variation[$key]['second'] = $num;
        }
      }

      return view('variation',compact('variation','current'));

    }

    public function ajaxAddVariation(Request $request){
      $pro = str_replace(" ",'',$request['variation']);
      $pro = str_replace("."," ",$pro);
      $ans = explode("x",$pro);
      if($ans[0] != null && $ans[1] != null && is_numeric(floatval($ans[0])) && is_numeric(floatval($ans[1]))){

        $result = variation::create([
                'first' => $ans[0],
                'second' => $ans[1]
              ]);

        $response = new \stdClass;
        $response->id = $result['id'];

        if(strpos($result['first']," ") != null){
          $ans = explode(" ",$result['first']);
          $ans2 = explode("/",$ans[1]);
          $response->first = $ans[0]." <sup>".$ans2[0]."</sup>&frasl;<sub>".$ans2[1]."</sub>";
        }else if(strpos($result['first'],"/") != null){
          $ans = explode("/",$result['first']);
          $response->first = "<sup>".$ans[0]."</sup>&frasl;<sub>".$ans[1]."</sub>";
        }else{
          $response->first = $result['first'];
        }

        if(strpos($result['second']," ") != null){
          $ans = explode(" ",$result['second']);
          $ans2 = explode("/",$ans[1]);
          $response->second = $ans[0]." <sup>".$ans2[0]."</sup>&frasl;<sub>".$ans2[1]."</sub>";
        }else if(strpos($result['second'],"/") != null){
          $ans = explode("/",$result['second']);
          $response->second = "<sup>".$ans[0]."</sup>&frasl;<sub>".$ans[1]."</sub>";
        }else{
          $response->second = $result['second'];
        }

        return json_encode($response);
      }

      return 0;
    }

    public function ajaxDeleteVariation(Request $request){

      $result = variation::where('id',$request['id'])->delete();
      
      return $result;
    }
}
