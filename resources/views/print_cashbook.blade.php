<html>
<head>
	<title>Cashbook - {{$company->company_name}}</title>
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
			<h3>STATEMENT OF ACCOUNTS - {{$company->company_name}}</h3>

			<table>
				<thead>
					<th>Date</th>
					<th>Particular</th>
					<th>Debit</th>
					<th>Credit</th>
					<th>Balance</th>
				</thead>
				@foreach($cashbook as $result)
					<tr>
						<td style="text-align: center">{{$result->invoice_date}}</td>
						<td>
							@if($result->invoice_code != null)
								Sales - Invoice {{ $result->invoice_code }}
							@else
								Payment
							@endif
						</td>
						<td style="text-align: right">{{ ($result->type == "debit") ? number_format($result->amount,2) : '' }}</td>
						<td style="text-align: right">{{ ($result->type == "credit") ? number_format($result->amount,2) : '' }}</td>
						<td style="text-align: right">{{number_format($result->balance,2)}}</td>
					</tr>
				@endforeach
				<tfoot>
					<tr>
						<td colspan="2">Total</td>
						<td style="text-align: right">Rm {{number_format($debit,2)}}</td>
						<td style="text-align: right">Rm {{number_format($credit,2)}}</td>
					</tr>
				</tfoot>
			</table>

		<div>
	</div>
</body>
</html>