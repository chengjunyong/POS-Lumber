<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phospr\Fraction;
use App\company;
use App\product;
use App\variation;
use App\invoice;
use App\invoice_detail;
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

        $text = $response->first.'" x '.$response->second.'"';

        variation::where('id',$result['id'])->update(['display' => $text]);

        return json_encode($response);
      }

      return 0;
    }

    public function ajaxDeleteVariation(Request $request){

      $result = variation::where('id',$request['id'])->delete();
      
      return $result;
    }

    public function getInvoice(){
      $current = "invoice"; 
      $company = company::get();
      $product = product::get();
      $variation = variation::get();

      $result = invoice::latest()->first();
      $year = date("Y");

      if($result == null){
        $invoice_number = $year."/0001";

      }else if($result['year'] == $year){
        $index = intval($result['index']) + 1;
        $index = sprintf("%'.04d", $index);
        $invoice_number = $year."/".$index;

      }else{
        $invoice_number = $year."/0001";
      }


      return view('generate_invoice',compact('product','variation','current','company','invoice_number'));
    }

    public function ajaxgetValue(Request $request){
      $variation = variation::where('id',$request['id'])->first();

      return json_encode($variation);
    }

    public function postInvoice(Request $request){
      
      $count = count($request['product_id']);
      $total_cost = 0;
      $total_amount = 0;
      $total_tonnage = 0;
      $total_piece = 0;

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] != "transport"){
          $total_piece += floatval($request['total_piece'][$a]); 
          $total_tonnage += floatval($request['tonnage'][$a]);

          $tmp = $request['amount'][$a];
          $tmp = str_replace("Rm ","",$tmp);
          $tmp = str_replace(",","",$tmp);

          $total_amount += floatval($tmp); 

        }else{

          $total_amount += floatval($request['price'][$a]);

        }
      }

      $result = explode("/",$request['invoice_number']);
      $index = intval($result[1]);
      $year = $result[0];

      $invoice = invoice::create([
        'invoice_code' => $request['invoice_number'],
        'do_number' => $request['do'],
        'invoice_date' => $request['date'],
        'year' => $year,
        'index' => $index,
        'company_id' => $request['company_id'],
        'pieces' => $total_piece,
        'tonnage' => $total_tonnage,
        'amount' => $total_amount
      ]);

      for($a=0;$a<$count;$a++){
        $variation = variation::where('id',$request['variation'][$a])->first();

        if($request['product_id'][$a] != "transport"){
          $amount = $request['amount'][$a];
          $amount = str_replace("Rm ","",$amount);
          $amount = str_replace(",","",$amount);

          invoice_detail::create([
            'invoice_id' => $invoice['id'],
            'product_id' => $request['product_id'][$a],
            'variation_id' => $request['variation'][$a],
            'variation_display' => $variation['display'],
            'piece_col' => $request['piece'][$a],
            'total_piece' => $request['total_piece'][$a],
            'price' => $request['price'][$a],
            'cost' => $request['cost'][$a],
            'amount' => $amount,
            'tonnage' => $request['tonnage'][$a],
            'footrun' => $request['tonnage'][$a] * 7200,
          ]);

        }else{

          invoice_detail::create([
            'invoice_id' => $invoice['id'],
            'product_id' => "Transportation",
            'variation_id' => null,
            'variation_display' => null,
            'piece_col' => null,
            'total_piece' => null,
            'price' => $request['price'][$a],
            'cost' => null,
            'amount' => $request['price'][$a],
            'tonnage' => null,
            'footrun' => null,
          ]);

        }

      }  
      return back()->with('success',"success");
    }

    public function getHistory(){

      $current = "invoice";
      $invoice = invoice::join("company","invoice.company_id","=","company.id")
                          ->select("invoice.*","company.company_name")
                          ->orderBy('id','desc')
                          ->get();

      return view('history',compact('current','invoice'));
    }

    public function editHistory(Request $request){

      $current = "invoice";
      $invoice_id = $request['id'];

      $invoice = invoice::join('company','invoice.company_id','=','company.id')
                          ->where('invoice.id',$invoice_id)
                          ->select('invoice.*','company.company_name')
                          ->first();

      $detail = invoice_detail::join('variation','invoice_detail.variation_id','=','variation.id')
                                ->join('product','invoice_detail.product_id','=','product.id')
                                ->where('invoice_detail.invoice_id',$invoice_id)
                                ->select('invoice_detail.*','variation.id as display','product.name as product_name')
                                ->get();

      $transport = invoice_detail::where([['product_id','LIKE','Transportation'],['invoice_id',$invoice_id]])->first();
      $product = product::get();
      $variation = variation::get();
      $company = company::get();


      return view('edithistory',compact('current','detail','invoice','transport','product','variation','company'));

    }

    public function postHistory(Request $request){

      $count = count($request['product_id']);
      $total_cost = 0;
      $total_amount = 0;
      $total_tonnage = 0;
      $total_piece = 0;

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] != "transport"){
          $total_piece += floatval($request['total_piece'][$a]); 
          $total_tonnage += floatval($request['tonnage'][$a]);

          $tmp = $request['amount'][$a];
          $tmp = str_replace("Rm ","",$tmp);
          $tmp = str_replace(",","",$tmp);

          $total_amount += floatval($tmp); 

        }else{

          $total_amount += floatval($request['price'][$a]);

        }
      }

      $result = explode("/",$request['invoice_number']);
      $index = intval($result[1]);
      $year = $result[0];

      $invoice = invoice::where('id',$request->invoice_id)->update([
        'invoice_code' => $request['invoice_number'],
        'do_number' => $request['do'],
        'invoice_date' => $request['date'],
        'year' => $year,
        'index' => $index,
        'company_id' => $request['company_id'],
        'pieces' => $total_piece,
        'tonnage' => $total_tonnage,
        'amount' => $total_amount
      ]);

      $invoice = $request->invoice_id;

      for($a=0;$a<$count;$a++){ 
        $variation = variation::where('id',$request['variation'][$a])->first();

        if($request['product_id'][$a] != "transport"){
          $amount = $request['amount'][$a];
          $amount = str_replace("Rm ","",$amount);
          $amount = str_replace(",","",$amount);

          invoice_detail::updateOrCreate(['id'=>$request['invoice_detail_id'][$a]],[
            'invoice_id' => $invoice,
            'product_id' => $request['product_id'][$a],
            'variation_id' => $request['variation'][$a],
            'variation_display' => $variation['display'],
            'piece_col' => $request['piece'][$a],
            'total_piece' => $request['total_piece'][$a],
            'price' => $request['price'][$a],
            'cost' => $request['cost'][$a],
            'amount' => $amount,
            'tonnage' => $request['tonnage'][$a],
            'footrun' => $request['tonnage'][$a] * 7200,
          ]);

        }else{

          invoice_detail::updateOrCreate(['id'=>$request['invoice_detail_id'][$a]],[
            'invoice_id' => $invoice,
            'product_id' => "Transportation",
            'variation_id' => null,
            'variation_display' => null,
            'piece_col' => null,
            'total_piece' => null,
            'price' => $request['price'][$a],
            'cost' => null,
            'amount' => $request['price'][$a],
            'tonnage' => null,
            'footrun' => null,
          ]);

        }

      }

      if($request->delete_invoice_detail_id != null){
        invoice_detail::whereIn('id',$request->delete_invoice_detail_id)->delete();
      }

      return back()->with('success','Data has been successful modify');

    }

    public function getPrintInvoice(Request $request){

      $invoice = invoice::where('id',$request->id)->first();

      $invoice_detail = invoice_detail::join('variation','invoice_detail.variation_id','=','variation.id')
                                ->join('product','invoice_detail.product_id','=','product.id')
                                ->where('invoice_detail.invoice_id',$request->id)
                                ->select('invoice_detail.*','product.name as product_name')
                                ->orderBy('name','asc')
                                ->get();
      $sum = array();
      $sum['piece'] = invoice_detail::where('invoice_id',$request->id)->sum('total_piece');
      $sum['tonnage'] = invoice_detail::where('invoice_id',$request->id)->sum('tonnage');
      $sum['amount'] = invoice_detail::where('invoice_id',$request->id)->sum('amount');

      $transport = invoice_detail::where([['product_id','LIKE','Transportation'],['invoice_id',$request->id]])->first(); 

      $company = company::where('id',$invoice->company_id)->first();

      $a=1;


      return view('print_invoice',compact('invoice','invoice_detail','transport','company','a','sum'));

    }
}

