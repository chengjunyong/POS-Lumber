<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phospr\Fraction;
use App\company;
use App\product;
use App\variation;
use App\invoice;
use App\invoice_detail;
use App\cashbook;
use App\credit;
use App\credit_detail;


class MainController extends Controller
{
    public function getIndex(){
      $current = "index";
      $first = new \stdClass;
      $second = new \stdClass;
      $third = new \stdClass;
      $fourth = new \stdClass;

      //First
      $month_days = cal_days_in_month(CAL_GREGORIAN,date('n'),date('Y'));
      $total_days = array();
      for($a=1;$a<=$month_days;$a++){
        array_push($total_days,$a);
      }
      $total_days = implode(",",$total_days);

      $monthly_sales = array();
      $b = date('Y')."-".date('n')."-";
      for($a=1;$a<=$month_days;$a++){
        $c = invoice::where('invoice_date','=',$b.$a)->sum('amount');
        array_push($monthly_sales,$c);
      }
      $total_monthly_sales = 0; 
      foreach($monthly_sales as $result){
        $total_monthly_sales += $result;
      }
      $monthly_sales = implode(",",$monthly_sales);
      $first->total_days = $total_days;
      $first->monthly_sales = $monthly_sales;
      $first->total_monthly_sales = $total_monthly_sales;
      //End First

      //Second
      $year = date("Y");
      $revenue = array(); 
      for($a=1;$a<=12;$a++){
        $b = invoice::whereRaw('YEAR(invoice_date) = "'.$year.'" AND MONTH(invoice_date) = "'.$a.'"')->sum('amount');
        array_push($revenue,$b);
      }
      $total_revenue = 0; 
      foreach($revenue as $result){
        $total_revenue += $result;
      }
      $revenue = implode(",",$revenue);
      $second->revenue = $revenue;
      $second->total_revenue = $total_revenue;
      //End Second

      //Third
      $year = date("Y");
      $order = array();
      for($a=1;$a<=12;$a++){
        $b = invoice::whereRaw('YEAR(invoice_date) = "'.$year.'" AND MONTH(invoice_date) = "'.$a.'"')->count('id');
        array_push($order,$b);
      }
      $total_order = 0; 
      foreach($order as $result){
        $total_order += $result;
      }
      $order = implode(",",$order);
      $third->order = $order;
      $third->total_order = $total_order;
      //End Third

      //Fourth
      $year = date("Y");
      $profit = array();
      for($a=1;$a<=12;$a++){
        $b = invoice::whereRaw('YEAR(invoice_date) = "'.$year.'" AND MONTH(invoice_date) = "'.$a.'"')->sum('amount');
        $c = invoice::whereRaw('YEAR(invoice_date) = "'.$year.'" AND MONTH(invoice_date) = "'.$a.'"')->sum('total_cost');
        $d = $b - $c;
        array_push($profit,$d);
      }

      $total_profit = 0;
      foreach($profit as $result){
        $total_profit += $result;
      }

      $profit = implode(",",$profit);
      $fourth->profit = $profit;
      $fourth->total_profit = $total_profit;
      //End Fourth

      $graph = new \stdClass;
      $last_month_date = date('m', strtotime('-1 month'));

      $this_month = invoice::whereRaw('YEAR(invoice_date) = "'.date("Y").'" AND MONTH(invoice_date) = "'.date("m").'"')->sum('amount');
      $last_month = invoice::whereRaw('YEAR(invoice_date) = "'.date("Y").'" AND MONTH(invoice_date) = "'.date('m', strtotime('-1 month')).'"')->sum('amount');

      if($last_month == 0){
        $charge = $this_month / 1;
      }else{
        $charge = $this_month / $last_month;
      }

      if($charge > 1)
        $graph->type = "+";
      else
        $graph->type = "-";

      $graph->charge = $charge * 100;
      $graph->this_month = $this_month;

      //Ratio Chart
      $ratio = new \stdClass;

      $this_month_profit = invoice::whereRaw('YEAR(invoice_date) = "'.date("Y").'" AND MONTH(invoice_date) = "'.date("m").'"')->selectRaw('SUM(amount-total_cost) as profit')->first();
      $last_month_profit = invoice::whereRaw('YEAR(invoice_date) = "'.date("Y").'" AND MONTH(invoice_date) = "'.date('m', strtotime('-1 month')).'"')->selectRaw('SUM(amount-total_cost) as profit')->first();
      $total_profit = floatval($this_month_profit->profit) - floatval($last_month_profit->profit);
      $ratio->earn = $this_month_profit->profit;
      if($total_profit >= 0)
        $ratio->profit = "+".number_format($total_profit,2);
      else
        $ratio->profit = number_format($total_profit,2);

      if($last_month_profit->profit == 0){
        $percent = $this_month_profit->profit / 1;
      }else{
        $percent = $this_month_profit->profit / $last_month_profit->profit;
      }
      
      if($percent > 1)
        $ratio->type = "+";
      else
        $ratio->type = "-";

      $ratio->percent = $percent * 100;
      //End Ratio

      //Weekly Sales
      $today = date("Y-m-d");
      $last_week = date("Y-m-d",strtotime('-1 week'));

      $sales = invoice::join('company','company.id','=','invoice.company_id')
                        ->where('invoice.invoice_date','>=',$last_week)
                        ->where('invoice.invoice_date','<=',$today)
                        ->get();

      //End Weekly Sales

    	return view('index',compact('current','first','second','third','fourth','graph','ratio','sales'));
    }

    public function getCompany(){
    	$current = "company";
    	$allCompany = company::where('active','1')->get();

    	return view('company',compact('allCompany','current'));

    }

    public function getAddProfile(){

    	return view("add_profile")->with("current","company");
    }

    public function postAddProfile(Request $request){
    	$current = "company";
    	$result = true;

      if($request['address'] === null){
        $address = "";
      }else{
        $address = $request['address'];
      }

      if($request['contact'] === null){
        $contact = "";
      }else{
        $contact = $request['contact'];
      }

      if($request['city'] === null){
        $city = "";
      }else{
        $city = $request['city'];
      }

      if($request['state'] === null){
        $state = "";
      }else{
        $state = $request['state'];
      }

      if($request['postcode'] === null){
        $postcode = "";
      }else{
        $postcode = $request['postcode'];
      }

    	company::create([
    		'company_name' => $request['company_name'],
    		'address' => $address,
    		'contact' => $contact,
    		'city' => $city,
    		'state' => $state,
    		'postcode' => $postcode,
        'active' => 1,
    	]);

    	return view("add_profile",compact('current','result'));

    }

    public function ajaxDeleteCompany(Request $request)
    {
      $result = company::where('id',$request->id)->update(['active' => 0]);

      return $result;
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
      $company = company::where('active','1')->get();
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
      $total_cost = 0;

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] == "transport"){
          $total_cost += floatval($request['price'][$a]);
        }else if($request['product_id'][$a] == "other"){
          $total_cost += floatval($request['cost'][$a]);
        }else{
          if($request->cal_type[$a] != "fr"){
            $total_cost += floatval($request['tonnage'][$a]) * floatval($request['cost'][$a]); 
          }else{
            $target = preg_replace("/[^0-9\/]/",",",$request['piece'][$a]);
            $target = str_replace(",,",",",$target);
            if(!str_contains($target,',')){
              $b = explode("/",$target);
              $total_cost += (intval($b[0]) * intval($b[1])) * $request->cost[$a];
            }else{
              $array = explode(",",$target);
              foreach($array as $result){
                $b = explode("/",$result);
                $total_cost += (intval($b[0]) * intval($b[1])) * $request->cost[$a]; 
              }
            }
          }
        }
      }
      
      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] == "transport"){
          $total_amount += $request['price'][$a]; 

        }else if($request['product_id'][$a] == "other"){
          $total_amount += $request['price'][$a]; 

        }else{
          $total_piece += floatval($request['total_piece'][$a]); 
          $total_tonnage += floatval($request['tonnage'][$a]);

          $tmp = $request['amount'][$a];
          $tmp = str_replace("Rm ","",$tmp);
          $tmp = str_replace(",","",$tmp);
          $tmp = floatval($tmp);
          $total_amount += $tmp; 
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
        'total_cost' => $total_cost,
        'amount' => $total_amount
      ]);

      $company_name = company::where('id',$request['company_id'])->first();

      cashbook::create([
        'company_id' => $request['company_id'],
        'company_name' => $company_name['company_name'],
        'invoice_id' => $invoice->id,
        'invoice_code' => $request['invoice_number'],
        'invoice_date' => $request['date'],
        'type' => 'debit',
        'amount' => $total_amount
      ]);

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] != "other"){
          $variation = variation::where('id',$request['variation'][$a])->first();
          if($request['cal_type'][$a] == "fr"){
            $cal_type = 1;
          }else{
            $cal_type = null;
          }
        }

        if($request['product_id'][$a] == "transport"){

          invoice_detail::create([
            'invoice_id' => $invoice['id'],
            'product_id' => "Transportation",
            'product_name' => "Transportation",
            'variation_id' => null,
            'variation_display' => null,
            'piece_col' => null,
            'total_piece' => null,
            'price' => $request['price'][$a],
            'cost' => null,
            'amount' => $request['price'][$a],
            'tonnage' => null,
            'footrun' => null,
            'cal_type' => null
          ]);
          
        }else if($request['product_id'][$a] == "other"){

          invoice_detail::create([
            'invoice_id' => $invoice['id'],
            'product_id' => "Other",
            'product_name' => $request['variation'][$a],
            'variation_id' => null,
            'variation_display' => null,
            'piece_col' => null,
            'total_piece' => $request['total_piece'][$a],
            'price' => $request['price'][$a],
            'cost' => $request['cost'][$a],
            'amount' => $request['price'][$a],
            'tonnage' => null,
            'footrun' => null,
            'cal_type' => null
          ]);

        }else{

          $amount = $request['amount'][$a];
          $amount = str_replace("Rm ","",$amount);
          $amount = str_replace(",","",$amount);

          $ton = 0;
          $fr = preg_replace("/[^0-9\/]/",",",$request['piece'][$a]);
          $fr = str_replace(",,",",",$fr);

          if(!str_contains($fr,',')){
            $b = explode("/",$fr);
            $ton += intval($b[0]) * intval($b[1]);
          }else{
            $array = explode(",",$fr);
            foreach($array as $result){
              $b = explode("/",$result);
              $ton += intval($b[0]) * intval($b[1]); 
            }
          }
          
          $product_name = product::where('id',$request['product_id'][$a])->first();
          invoice_detail::create([
            'invoice_id' => $invoice['id'],
            'product_id' => $request['product_id'][$a],
            'product_name' => $product_name['name'],
            'variation_id' => $request['variation'][$a],
            'variation_display' => $variation['display'],
            'piece_col' => $request['piece'][$a],
            'total_piece' => $request['total_piece'][$a],
            'price' => $request['price'][$a],
            'cost' => $request['cost'][$a],
            'amount' => $amount,
            'tonnage' => $request['tonnage'][$a],
            'footrun' => $ton,
            'cal_type' => $cal_type
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
      $other = invoice_detail::where([['product_id','LIKE','Other'],['invoice_id',$invoice_id]])->get();
      $product = product::get();
      $variation = variation::get();
      $company = company::where('active','1')->get();


      return view('edithistory',compact('current','detail','invoice','transport','product','variation','company','other'));

    }

    public function postHistory(Request $request){

      invoice_detail::whereIn('id',$request->invoice_detail_id)->delete();

      $count = count($request['product_id']);
      $total_cost = 0;
      $total_amount = 0;
      $total_tonnage = 0;
      $total_piece = 0;
      $total_cost = 0;

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] == "transport"){
          $total_cost += floatval($request['price'][$a]);
        }else if($request['product_id'][$a] == "other"){
          $total_cost += floatval($request['cost'][$a]);
        }else{
          if($request->cal_type[$a] != "fr"){
            $total_cost += floatval($request['tonnage'][$a]) * floatval($request['cost'][$a]); 
          }else{
            $target = preg_replace("/[^0-9\/]/",",",$request['piece'][$a]);
            $target = str_replace(",,",",",$target);
            if(!str_contains($target,',')){
              $b = explode("/",$target);
              $total_cost += (intval($b[0]) * intval($b[1])) * $request->cost[$a];
            }else{
              $array = explode(",",$target);
              foreach($array as $result){
                $b = explode("/",$result);
                $total_cost += (intval($b[0]) * intval($b[1])) * $request->cost[$a]; 
              }
            }
          }
        }
      }

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] == "transport"){
          $total_amount += $request['price'][$a]; 

        }else if($request['product_id'][$a] == "other"){
          $total_amount += $request['price'][$a]; 

        }else{
          $total_piece += floatval($request['total_piece'][$a]); 
          $total_tonnage += floatval($request['tonnage'][$a]);

          $tmp = $request['amount'][$a];
          $tmp = str_replace("Rm ","",$tmp);
          $tmp = str_replace(",","",$tmp);
          $tmp = floatval($tmp);
          $total_amount += $tmp; 
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
        'total_cost' => $total_cost,
        'amount' => $total_amount
      ]);

      $company_name = company::where('id',$request['company_id'])->first();

      cashbook::where('invoice_id',$request->invoice_id)->update([
        'company_id' => $request['company_id'],
        'company_name' => $company_name['company_name'],
        'invoice_date' => $request['date'],
        'type' => 'debit',
        'amount' => $total_amount
      ]);

      $invoice = $request->invoice_id;

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] != "other"){
          $variation = variation::where('id',$request['variation'][$a])->first();
          if($request['cal_type'][$a] == "fr"){
            $cal_type = 1;
          }else{
            $cal_type = null;
          }
        }

        if($request['product_id'][$a] == "transport"){

          invoice_detail::create([
            'invoice_id' => $request->invoice_id,
            'product_id' => "Transportation",
            'product_name' => "Transportation",
            'variation_id' => null,
            'variation_display' => null,
            'piece_col' => null,
            'total_piece' => null,
            'price' => $request['price'][$a],
            'cost' => null,
            'amount' => $request['price'][$a],
            'tonnage' => null,
            'footrun' => null,
            'cal_type' => null
          ]);
          
        }else if($request['product_id'][$a] == "other"){

          invoice_detail::create([
            'invoice_id' => $request->invoice_id,
            'product_id' => "Other",
            'product_name' => $request['variation'][$a],
            'variation_id' => null,
            'variation_display' => null,
            'piece_col' => null,
            'total_piece' => $request['total_piece'][$a],
            'price' => $request['price'][$a],
            'cost' => $request['cost'][$a],
            'amount' => $request['price'][$a],
            'tonnage' => null,
            'footrun' => null,
            'cal_type' => null
          ]);

        }else{

          $amount = $request['amount'][$a];
          $amount = str_replace("Rm ","",$amount);
          $amount = str_replace(",","",$amount);

          $ton = 0;
          $fr = preg_replace("/[^0-9\/]/",",",$request['piece'][$a]);
          $fr = str_replace(",,",",",$fr);

          if(!str_contains($fr,',')){
            $b = explode("/",$fr);
            $ton += intval($b[0]) * intval($b[1]);
          }else{
            $array = explode(",",$fr);
            foreach($array as $result){
              $b = explode("/",$result);
              $ton += intval($b[0]) * intval($b[1]); 
            }
          }
          
          $product_name = product::where('id',$request['product_id'][$a])->first();
          invoice_detail::create([
            'invoice_id' => $request->invoice_id,
            'product_id' => $request['product_id'][$a],
            'product_name' => $product_name['name'],
            'variation_id' => $request['variation'][$a],
            'variation_display' => $variation['display'],
            'piece_col' => $request['piece'][$a],
            'total_piece' => $request['total_piece'][$a],
            'price' => $request['price'][$a],
            'cost' => $request['cost'][$a],
            'amount' => $amount,
            'tonnage' => $request['tonnage'][$a],
            'footrun' => $ton,
            'cal_type' => $cal_type
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
                                ->select('invoice_detail.*')
                                ->get();

      $piece = array();
      $bundle_piece = array();
      $bundle_col = array();
      foreach($invoice_detail as $key => $result){
        if(preg_match("/[\r|\n]+/",$result->piece_col) == 1){
          $piece = preg_split("/[\r|\n]+/",$result->piece_col);
          $invoice_detail[$key]->setAttribute("bundle",1);

          foreach($piece as $data1){
            $sum = 0;
            $data2 = explode(",",$data1);

            foreach($data2 as $data3){
              $data4 = explode("/",$data3);
              $sum += intval($data4[0]);
            }

            $text = $data1;
            if(strlen($data1)>=48){
              $total_break = "";
              $line = intval(floatval(strlen($data1)) / 47);

              if($line == 1){
                $total_break = $total_break."<br/><br/>";
              }else{
                for($a=0;$a<$line;$a++){
                  $total_break = $total_break."<br/>";
                }
              }

              $sum = $sum.$total_break;
              $text = $data1;

            }else{
              $text = $data1;
              $sum .= "<br/>";
            }

            array_push($bundle_col,$text);
            array_push($bundle_piece,$sum);
          }

          $invoice_detail[$key]->setAttribute("bundle_piece",$bundle_piece);
          $invoice_detail[$key]->setAttribute("bundle_col",$bundle_col);
          unset($bundle_col,$bundle_piece);
          $bundle_col = array();
          $bundle_piece = array();

        }else{
          $invoice_detail[$key]->setAttribute("bundle_col",null);
          $invoice_detail[$key]->setAttribute("bundle",0);
          unset($bundle_col,$bundle_piece);
          $bundle_col = array();
          $bundle_piece = array();
        }
      }

      $sum = array();
      $sum['piece'] = invoice_detail::where('invoice_id',$request->id)->sum('total_piece');
      $sum['tonnage'] = invoice_detail::where('invoice_id',$request->id)->where('cal_type',null)->sum('tonnage');
      $sum['amount'] = invoice_detail::where('invoice_id',$request->id)->sum('amount');

      $transport = invoice_detail::where([['product_id','LIKE','Transportation'],['invoice_id',$request->id]])->first(); 

      $other = invoice_detail::where([['product_id','LIKE','Other'],['invoice_id',$request->id]])->get();

      $company = company::where('id',$invoice->company_id)->first();

      $a=1;

      return view('print_invoice',compact('invoice','invoice_detail','transport','company','a','sum','other'));
    }

    public function getCashBook()
    {
      $current = "report";
      $company = company::where('active','1')->get();

      return view('cashbook',compact('current','company'));
    }

    public function postCashBook(Request $request)
    {
      //Main Part
      $debit = 0;
      $credit = 0;
      $company = company::where('id',$request->id)->first();
      $forward = new \stdClass();

      if($request->issue_month == "all"){
        $balance_forward = 0;
        $cashbook = cashbook::where('company_id',$request->id)
                          ->orderBy('invoice_date')
                          ->get();

        $forward->type = null;
        $forward->balance = null;
        $forward->count = null;
        $forward->date = null;

      }else{
        $month = intval($request->issue_month) - 1;
        $cashbook = cashbook::whereRaw("company_id = '".$request->id."' AND MONTH(invoice_date) = ".$request->issue_month)
                          ->orderBy('invoice_date')
                          ->get();

        $forward = cashbook::whereRaw("company_id = '".$request->id."' AND MONTH(invoice_date) <= ".$month)
                          ->orderBy('invoice_date')
                          ->get();

        $balance_forward = 0;
        foreach($forward as $key => $result){
          if($result->type == "debit"){
            $balance_forward += floatval($result->amount);
          }else{
            $balance_forward -= floatval($result->amount);
          }
        }

        $forward->type = "forward";
        $forward->balance = $balance_forward;
        $forward->count = 2;
        $forward->month = $request->issue_month;

      }

      $balance = $balance_forward;
      foreach($cashbook as $key => $result){
        if($result->type == "debit"){
          $balance += floatval($result->amount);
          $debit += floatval($result->amount);
          $cashbook[$key]->setAttribute("balance",$balance);
        }else{
          $balance -= floatval($result->amount);
          $credit += floatval($result->amount);
          $cashbook[$key]->setAttribute("balance",$balance);
        }
      }

      //Part Footer
      $total_payment = cashbook::where('company_id',$request->id)
                                ->where('type','credit')
                                ->sum('amount');
      $current_total = 0;
      $month = array();
      $each = array();
      $a = 0;
      $con = true;
      for($i=1;$i<=12;$i++){
        $each[$i] = invoice::whereRaw("company_id = '".$request->id."' AND MONTH(invoice_date) = '".$i."' AND YEAR(invoice_date) = '".date("Y")."'")->get();
        foreach($each[$i] as $result){
          $a += $result->amount;
        }
        if($a != 0){
          if($con){
            $total_payment = $total_payment - $a;
            if($total_payment <= 0){
              $month[$i] = abs($total_payment);
              $con = false;
            }else{
              $month[$i] = 0;
            }
          }else{
            $month[$i] = $a;
          }
        }else{
          $month[$i] = null;        
        }
        $a = 0;

        $current_total += $month[$i];
      }


      return view("print_cashbook",compact('cashbook','company','debit','credit','month','current_total','forward'));
    }

    public function getPayment()
    {
      $current = "payment";
      $company = company::where('active','1')->get();

      return view('payment',compact('current','company'));
    }

    public function postIssuePayment(Request $request)
    {
      // $date = getdate();
      // $today = $date['year']."-".$date['mon']."-".$date['mday'];

      $company_name = company::where('id',$request->id)->first();

      cashbook::create([
        'company_id' => $request->id,
        'company_name' => $company_name['company_name'],
        'invoice_id' => null,
        'invoice_code' => null,
        'invoice_date' => $request->issue_date,
        'type' => 'credit',
        'amount' => $request->amount
      ]);


      return back()->with('success','Payment has been recorded');
    }

    public function getMonthlyReport(){
      $current = "report";

      return view('monthly_report',compact('current'));
    }

    public function postMonthlyReport(Request $request){
      $total = new \stdClass;
      $invoice = invoice::join('company','company.id','=','invoice.company_id')
                          ->whereRaw('MONTH(invoice.invoice_date) = "'.$request->month.'"')
                          ->orderBy('invoice.invoice_date')
                          ->get();

      $total_tonnage = 0;
      $total_amount = 0;
      $total_cost = 0;
      $total_profit = 0;
      foreach($invoice as $result){
        $total_tonnage += $result->tonnage;
        $total_amount += $result->amount;
        $total_cost += $result->total_cost;
        $total_profit += $result->amount - $result->total_cost;
      }

      $total->tonnage = $total_tonnage;
      $total->amount = $total_amount;
      $total->cost = $total_cost;
      $total->profit = $total_profit;

      return view('print_monthly_report',compact('invoice','total'));
    }

    public function getSpecifyDateReport(){
        $current = "report";

      return view('specify_date_report',compact('current'));
    }

    public function postSpecifyDateReport(Request $request){

      $total = new \stdClass;
      $invoice = invoice::join('company','company.id','=','invoice.company_id')
                          ->whereRaw('invoice.invoice_date >= "'.$request->date_start.'" AND invoice.invoice_date <= "'.$request->date_end.'"')
                          ->orderBy('invoice.invoice_date')
                          ->get();

      $total_tonnage = 0;
      $total_amount = 0;
      $total_cost = 0;
      $total_profit = 0;
      foreach($invoice as $result){
        $total_tonnage += $result->tonnage;
        $total_amount += $result->amount;
        $total_cost += $result->total_cost;
        $total_profit += $result->amount - $result->total_cost;
      }

      $total->tonnage = $total_tonnage;
      $total->amount = $total_amount;
      $total->cost = $total_cost;
      $total->profit = $total_profit;


      return view('print_specify_date_report',compact('total','invoice'));
    }

    public function getCompanyBasedReport(){

      $current = "report";

      $company = company::where('active','1')->get();

      return view('company_based_report',compact('current','company'));
    }

    public function postCompanyBasedReport(Request $request){

      $total = new \stdClass;
      $invoice = invoice::join('company','company.id','=','invoice.company_id')
                          ->whereRaw('invoice.invoice_date >= "'.$request->date_start.'" AND invoice.invoice_date <= "'.$request->date_end.'" AND invoice.company_id ='.$request->company_id)
                          ->orderBy('invoice.invoice_date')
                          ->get();

      $total_tonnage = 0;
      $total_amount = 0;
      $total_cost = 0;
      $total_profit = 0;
      foreach($invoice as $result){
        $total_tonnage += $result->tonnage;
        $total_amount += $result->amount;
        $total_cost += $result->total_cost;
        $total_profit += $result->amount - $result->total_cost;
      }

      $total->tonnage = $total_tonnage;
      $total->amount = $total_amount;
      $total->cost = $total_cost;
      $total->profit = $total_profit;

      return view('print_company_based_report',compact('total','invoice'));
    }


    public function getCreditNote(){

      $current = "credit_note";
      $company = company::where('active','1')->get();
      $product = product::get();
      $variation = variation::get();

      $result = credit::latest()->first();
      $year = date("Y");

      if($result == null){
        $credit_note_number = "CN".$year."/0001";

      }else if($result['year'] == $year){
        $index = intval($result['index']) + 1;
        $index = sprintf("%'.04d", $index);
        $credit_note_number = "CN".$year."/".$index;

      }else{
        $credit_note_number = "CN".$year."/0001";
      }

      return view('credit_note',compact('current','company','product','variation','credit_note_number'));
    }

    public function postCreditNote(Request $request){

      $count = count($request['product_id']);
      $total_cost = 0;
      $total_amount = 0;
      $total_tonnage = 0;
      $total_piece = 0;
      $total_cost = 0;

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] == "transport"){
          $total_cost += floatval($request['price'][$a]);
        }else if($request['product_id'][$a] == "other"){
          $total_cost += floatval($request['cost'][$a]);
        }else{
          $total_cost += floatval($request['tonnage'][$a]) * floatval($request['cost'][$a]); 
        }
      }

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] == "transport"){
          $total_amount += $request['price'][$a]; 

        }else if($request['product_id'][$a] == "other"){
          $total_amount += $request['price'][$a]; 

        }else{
          $total_piece += floatval($request['total_piece'][$a]); 
          $total_tonnage += floatval($request['tonnage'][$a]);

          $tmp = $request['amount'][$a];
          $tmp = str_replace("Rm ","",$tmp);
          $tmp = str_replace(",","",$tmp);
          $tmp = floatval($tmp);
          $total_amount += $tmp; 
        }
      }

      $result = explode("/",$request['credit_note_number']);
      $index = intval($result[1]);
      $year = str_replace('CN','',$result[0]);

      $credit = credit::create([
        'credit_note_code' => $request['credit_note_number'],
        'do_number' => $request['do'],
        'credit_note_date' => $request['date'],
        'year' => $year,
        'index' => $index,
        'company_id' => $request['company_id'],
        'pieces' => $total_piece,
        'tonnage' => $total_tonnage,
        'total_cost' => $total_cost,
        'amount' => $total_amount
      ]);

      $company_name = company::where('id',$request['company_id'])->first();

      cashbook::create([
        'company_id' => $request['company_id'],
        'company_name' => $company_name['company_name'],
        'invoice_id' => $credit->id,
        'invoice_code' => $request['credit_note_number'],
        'invoice_date' => $request['date'],
        'type' => 'credit',
        'amount' => $total_amount
      ]);

      for($a=0;$a<$count;$a++){
        if($request['product_id'][$a] != "other"){
          $variation = variation::where('id',$request['variation'][$a])->first();
          if($request['cal_type'][$a] == "fr"){
            $cal_type = 1;
          }else{
            $cal_type = null;
          }
        }

        if($request['product_id'][$a] == "transport"){

          credit_detail::create([
            'credit_note_id' => $credit['id'],
            'product_id' => "Transportation",
            'product_name' => "Transportation",
            'variation_id' => null,
            'variation_display' => null,
            'piece_col' => null,
            'total_piece' => null,
            'price' => $request['price'][$a],
            'cost' => null,
            'amount' => $request['price'][$a],
            'tonnage' => null,
            'footrun' => null,
            'cal_type' => null
          ]);
          
        }else if($request['product_id'][$a] == "other"){

          credit_detail::create([
            'invoice_id' => $credit['id'],
            'product_id' => "Other",
            'product_name' => $request['variation'][$a],
            'variation_id' => null,
            'variation_display' => null,
            'piece_col' => null,
            'total_piece' => $request['total_piece'][$a],
            'price' => $request['price'][$a],
            'cost' => $request['cost'][$a],
            'amount' => $request['price'][$a],
            'tonnage' => null,
            'footrun' => null,
            'cal_type' => null
          ]);

        }else{

          $amount = $request['amount'][$a];
          $amount = str_replace("Rm ","",$amount);
          $amount = str_replace(",","",$amount);
          
          $product_name = product::where('id',$request['product_id'][$a])->first();
          credit_detail::create([
            'invoice_id' => $credit['id'],
            'product_id' => $request['product_id'][$a],
            'product_name' => $product_name['name'],
            'variation_id' => $request['variation'][$a],
            'variation_display' => $variation['display'],
            'piece_col' => $request['piece'][$a],
            'total_piece' => $request['total_piece'][$a],
            'price' => $request['price'][$a],
            'cost' => $request['cost'][$a],
            'amount' => $amount,
            'tonnage' => $request['tonnage'][$a],
            'footrun' => $request['tonnage'][$a] * 7200,
            'cal_type' => $cal_type
          ]);

        }

      }

      return back()->with('success',"success"); 
    }

}


