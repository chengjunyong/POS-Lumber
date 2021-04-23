<html>
<head>
	<title>Monthly Report</title>
</head>
<style type="text/css">
	body{
		background-color: black;
		color:black;
	}

	.frame{
		background-color: white;
		margin:0 auto;
		width:100%;
		padding-bottom: 10px
	}

	.inner{
		margin:0px 10px 0px 10px;
	}

	table{
		border: 1px solid black;
		width:100%;
		border-collapse: collapse;
	}

	thead,tfoot{
		text-align: center;
		border:1px solid black;
	}

	th,td{
		border-right:1px solid black;
	}

  th{
    font-weight: 100;
  }

  .header{
    font-size:16px;
    text-align: center;
    margin-bottom: 10px;
  }


</style>
<body>
	<div class="frame">
		<div class="inner">
      <div class="header">
  			<label>VEGAVEST TRADING</label><br/>
  			<label>(CA 0088843-X)</label><br/>
  			<label>Monthly Report</label><br/>
  			<label>Generate Date : {{date("Y-m-d")}}</label><br/>
      </div>
			<table style="width:100%">
				<thead>
					<th style="width:12%">Invoice Date</th>
					<th style="width:12%">Invoice Number</th>
					<th>Company Name</th>
					<th style="width:10%">Total Tonnage (TON)</th>
					<th style="width:10%">Total Cost (Rm)</th>
					<th style="width:10%">Total Amount (Rm)</th>
					<th style="width:10%">Total Profit (Rm)</th>
				</thead>
				@foreach($invoice as $result)
					<tr>
						<td style="text-align: center">{{$result->invoice_date}}</td>
						<td style="text-align: center">{{$result->invoice_code}}</td>
						<td style="text-align: left">{{$result->company_name}}</td>
						<td style="text-align: right;padding-right: 5px;">{{$result->tonnage}}</td>
						<td style="text-align: right;padding-right: 5px;">{{number_format($result->total_cost,2)}}</td>
						<td style="text-align: right;padding-right: 5px;">{{number_format($result->amount,2)}}</td>
						<td style="text-align: right;padding-right: 5px;">{{number_format($result->amount - $result->total_cost,2)}}</td>
					</tr>
				@endforeach
				<tfoot>
					<tr>
						<td colspan="3">Summary</td>
						<td style="text-align: right;padding-right: 5px;">{{$total->tonnage}}</td>
						<td style="text-align: right;padding-right: 5px;">{{number_format($total->cost,2)}}</td>
						<td style="text-align: right;padding-right: 5px;">{{number_format($total->amount,2)}}</td>
						<td style="text-align: right;padding-right: 5px;">{{number_format($total->profit,2)}}</td>
					</tr>
				</tfoot>

			</table>

		<div>
	</div>
</body>
</html>