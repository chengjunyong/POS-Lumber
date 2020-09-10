<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\company;
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
    	
    }
}
