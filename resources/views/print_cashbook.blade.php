<html>
<head>
	<link rel="stylesheet" href="assets/css/bootstrap.css">
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
		border: 1px solid black;
		width:100%;
		border-collapse: collapse;
		font-size:12px;
	}

	thead{
		text-align: center;
		border:1px solid black;
	}

	tfoot{
		text-align: center;
		border:1px solid black;
	}

	th,td{
		border-right:1px solid black;
		margin-left:5px;
	}

	.bottom{
		text-align: center;
		border: 1px solid black;
		margin-top: 20px;
		position: relative;
		bottom:3px;
		width:100%;

	}

	.bottom td{
		width:16.5%;
		border: 1px solid black;
		border-collapse: collapse;
		text-align: right;
	}

	.header{
		text-align: center;
		font-size:12px;
		margin-bottom: 5px;
	}

	th{
		font-weight: 100;
	}

</style>
<body>
	<div class="frame">
		<div class="inner">
			<div class="header">
				<label>VEGAVEST TRADING</label><br/>
				<label>(CA 0088843-X)</label><br/>
				<label>12 LORONG SERI KUANTAN 52</label><br/>
				<label>JALAN GALING 25250 KUANTAN</label><br/>
				<label>TEL: 012-9213373 FAX: 09-5366307</label><br/>
				<label>EMAIL: tfhow@hotmail.com</label><br/>
				<label style="margin-top: 10px;color: black;">STATEMENT OF ACCOUNTS - {{$company->company_name}}</label><br/>
			</div>

			<table>
				<thead>
					<th style="width:10%">Date</th>
					<th>Particular</th>
					<th style="width:15%">Debit</th>
					<th style="width:15%">Credit</th>
					<th>Balance</th>
				</thead>

				@if($forward->type != null && $forward->type == "forward" && $forward->balance != 0)
					<tr>
						<td style="text-align: center">2021-{{ (strlen($forward->month) == 1) ? '0'.$forward->month : $forward->month}}-01</td>
						<td>Balance Brought Forward</td>
						<td style="text-align: right">{{ number_format($forward->balance,2) }}</td>
						<td style="text-align: right"></td>
						<td style="text-align: right">{{ number_format($forward->balance,2) }}</td>
					</tr>
				@endif

				@foreach($cashbook as $key => $result)
					<tr>
						<td style="text-align: center">{{$result->invoice_date}}</td>
						<td>
							@if($result->invoice_code != null)
								Sales - Invoice {{ $result->invoice_code }}
							@else
								Payment
							@endif
						</td>
						<td style="text-align: right;padding-right: 4px;">{{ ($result->type == "debit") ? number_format($result->amount,2) : '' }}</td>
						<td style="text-align: right;padding-right: 4px;">{{ ($result->type == "credit") ? number_format($result->amount,2) : '' }}</td>
						<td style="text-align: right;padding-right: 4px;">{{number_format($result->balance,2)}}</td>
					</tr>
				@endforeach
<!-- 				<tr style="border-top: 2px black solid">
					<td colspan="2">Total</td>
					<td style="text-align: right">Rm {{number_format($debit,2)}}</td>
					<td style="text-align: right">Rm {{number_format($credit,2)}}</td>
					<td></td>
				</tr> -->
			</table>
			<br/>
			@if(count($cashbook) == null || count($cashbook) < 10)
				 @for($a=0;$a< (30 - $forward->count) -(count($cashbook) * 2);$a++)
						<br/>
				@endfor
			@else
				@for($a=0;$a< (40 - $forward->count) -(count($cashbook) * 2);$a++)
						<br/>
				@endfor
			@endif

			<!-- Previous function -->
<!-- 			 				@if(count($cashbook) > 24)
					@for($a=0;$a<72 -(count($cashbook) * 1.5);$a++)
						<br/>
					@endfor
				@else
					@for($a=0;$a<75-(count($cashbook) * 1.5);$a++)
						<br/>
					@endfor
				@endif -->
			
			<table class="bottom">
				<tr>
					<td>January<br/>{{ number_format($month[1],2) }}</td>
					<td>February<br/>{{ number_format($month[2],2) }}</td>
					<td>March<br/>{{ number_format($month[3],2) }}</td>
					<td>April<br/>{{ number_format($month[4],2) }}</td>
					<td>May<br/>{{ number_format($month[5],2) }}</td>
					<td>June<br/>{{ number_format($month[6],2) }}</td>
				</tr>
				<tr>
					<td>July<br/>{{ number_format($month[7],2) }}</td>
					<td>August<br/>{{ number_format($month[8],2) }}</td>
					<td>September<br/>{{ number_format($month[9],2) }}</td>
					<td>October<br/>{{ number_format($month[10],2) }}</td>
					<td>November<br/>{{ number_format($month[11],2) }}</td>
					<td>December<br/>{{ number_format($month[12],2) }}</td>
				</tr>
				<tr>
					<td colspan="6" style="text-align: center">Current Total Balance : Rm {{number_format($current_total,2)}}</td>
				</tr>
			</table>

		<div>
	</div>
</body>
<script>
	// window.print();
</script>
</html>