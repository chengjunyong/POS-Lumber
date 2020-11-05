<html>
<head>
	<title>Debtor Report - {{$company->company_name}}</title>
</head>
<style type="text/css">
	body{
		background-color: white;
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

	.bottom{
		text-align: center;
		border: 2px solid black;
		margin-top: 20px;
	}

	.bottom td{
		width:16.5%;
		border: 1px solid black;
		border-collapse: collapse;
	}

</style>
<body>
	<div class="frame">
		<div class="inner">
			<h3 align="center">VEGAVEST TRADING</h3>
			<h3 align="center">(CA 0088843-X)</h3>
			<h4 align="center">12 LORONG SERI KUANTAN 52</h4>
			<h4 align="center">JALAN GALING 25250 KUANTAN</h4>
			<h4 align="center">TEL: 012-9213373 FAX: 09-5366307</h4>
			<h4 align="center">EMAIL: tfhow@hotmail.com</h4>
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

			<table class="bottom">
				<tr>
					<td>January<br/>Rm {{ number_format($month[1],2) }}</td>
					<td>February<br/>Rm {{ number_format($month[2],2) }}</td>
					<td>March<br/>Rm {{ number_format($month[3],2) }}</td>
					<td>April<br/>Rm {{ number_format($month[4],2) }}</td>
					<td>May<br/>Rm {{ number_format($month[5],2) }}</td>
					<td>June<br/>Rm {{ number_format($month[6],2) }}</td>
				</tr>
				<tr>
					<td>July<br/>Rm {{ number_format($month[7],2) }}</td>
					<td>August<br/>Rm {{ number_format($month[8],2) }}</td>
					<td>September<br/>Rm {{ number_format($month[9],2) }}</td>
					<td>October<br/>Rm {{ number_format($month[10],2) }}</td>
					<td>November<br/>Rm {{ number_format($month[11],2) }}</td>
					<td>December<br/>Rm {{ number_format($month[12],2) }}</td>
				</tr>
			</table>

		<div>
	</div>
</body>
</html>