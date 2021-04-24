<html>
<head>
	<title>Company Based Report</title>
</head>
<style type="text/css">
.header{
  text-align: center;
  display: block;
}

table,tr,td{
  border:1px solid black;
  border-collapse: collapse;
}

footer{
  text-align: center;
  position: fixed;
  bottom: 10;
  left:0
}

td{
  font-size:13px;
  padding: 2px;
}
</style>
<body>
<div class="row">
  <div class="col-12">
    <div class="header">
      <label align="center">VEGAVEST TRADING</label><br/>
      <label align="center">(CA 0088843-X)</label><br/>
      <label align="center">Monthly Report</label><Br/>
      <label align="center">Generate Date : {{date("Y-m-d")}}</label>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <table style="width:100%;margin-top: 10px;">
			<tr>
				<td>Invoice Date</td>
				<td>Invoice Number</td>
				<td>Company Name</td>
				<td>Total Tonnage (TON)</td>
				<td>Total Cost</td>
				<td>Total Amount</td>
				<td>Total Profit</td>
			</tr>
			@foreach($invoice as $result)
				<tr>
					<td style="text-align: center;width:10%">{{$result->invoice_date}}</td>
					<td style="text-align: center;width:10%">{{$result->invoice_code}}</td>
					<td style="text-align: left">{{$result->company_name}}</td>
					<td style="text-align: right;padding-right: 5px;;width:10%">{{$result->tonnage}}</td>
					<td style="text-align: right;padding-right: 5px;;width:10%">{{number_format($result->total_cost,2)}}</td>
					<td style="text-align: right;padding-right: 5px;;width:10%">{{number_format($result->amount,2)}}</td>
					<td style="text-align: right;padding-right: 5px;;width:10%">{{number_format($result->amount - $result->total_cost,2)}}</td>
				</tr>
			@endforeach
			<tfoot>
				<tr>
					<td colspan="3" style="text-align: center">Summary</td>
					<td style="text-align: right;padding-right: 5px;">{{$total->tonnage}}</td>
					<td style="text-align: right;padding-right: 5px;">{{number_format($total->cost,2)}}</td>
					<td style="text-align: right;padding-right: 5px;">{{number_format($total->amount,2)}}</td>
					<td style="text-align: right;padding-right: 5px;">{{number_format($total->profit,2)}}</td>
				</tr>
			</tfoot>
		</table>
  </div>
</div>


</body>
</html>