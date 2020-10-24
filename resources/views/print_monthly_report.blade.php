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
		width:95%;
		padding-bottom: 10px
	}

	.inner{
		margin:0px 10px 0px 10px;
	}

	table{
		border: 2px solid black;
		width:100%;
		border-collapse: collapse;
	}

	thead,tfoot{
		font-weight: bold;
		text-align: center;
		border:2px solid black;
	}

	th,td{
		border-right:2px solid black;
		margin-left:5px;
	}

	td{
		padding-top: 5px;
		padding-bottom: 5px;
		padding-left: 5px;
		padding-right:5px;
	}


</style>
<body>
	<div class="frame">
		<div class="inner">
			<h3 align="center">VEGAVEST TRADING</h3>
			<h3 align="center">(CA 0088843-X)</h3>
			<h3 align="center">Monthly Report</h3>
			<h3 align="center">Generate Date : {{date("Y-m-d")}}</h3>
			<table>
				<thead>
					<th>Invoice Date</th>
					<th>Invoice Number</th>
					<th>Company Name</th>
					<th>Total Tonnage</th>
					<th>Total Cost</th>
					<th>Total Amount</th>
					<th>Total Profit</th>
				</thead>
				@foreach($invoice as $result)
					<tr>
						<td style="text-align: center">{{$result->invoice_date}}</td>
						<td style="text-align: center">{{$result->invoice_code}}</td>
						<td style="text-align: center">{{$result->company_name}}</td>
						<td style="text-align: right;padding-right: 5px;">{{$result->tonnage}} <b>TON</b></td>
						<td style="text-align: right;padding-right: 5px;">Rm {{number_format($result->total_cost,2)}}</td>
						<td style="text-align: right;padding-right: 5px;">Rm {{number_format($result->amount,2)}}</td>
						<td style="text-align: right;padding-right: 5px;">Rm {{number_format($result->amount - $result->total_cost,2)}}</td>
					</tr>
				@endforeach
				<tfoot>
					<tr>
						<td colspan="3">Summary</td>
						<td style="text-align: right;padding-right: 5px;">{{$total->tonnage}} <b>TON</b></td>
						<td style="text-align: right;padding-right: 5px;">Rm {{number_format($total->cost,2)}}</td>
						<td style="text-align: right;padding-right: 5px;">Rm {{number_format($total->amount,2)}}</td>
						<td style="text-align: right;padding-right: 5px;">Rm {{number_format($total->profit,2)}}</td>
					</tr>
				</tfoot>

			</table>

		<div>
	</div>
</body>
</html>