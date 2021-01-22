<html>
<head>
	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	<title></title>
</head>

<style>
	body{
		color: black;
		margin:5px 20px 5px 20px;
	}

	span{
		font-size:14px;
	}

	.header{
		text-align: center;
		font-weight: 700;
	}

	.sub_header{
		margin-top:20px;
		margin-bottom:20px;
	}

	.main{
		padding-top: 10%;
	}

	th{
		font-size:12px;
	}

	table > tbody {
		font-size:12px;
	}

	td{
		padding: 10px 0px 10px 0px;
		vertical-align: top;
	}

	.last > td{
		padding-bottom: 7%;
	}

	.footer{
		position:absolute;
		bottom:0;
		font-size:12px;
		width:97%;
	}

	@media print{
		.main{
			padding-top: 17.5%;
		}
		body{
			margin: 0px 0px 0px 0px;
		}
		.footer{
			width:100%;
		}

	}

</style>
<body>

	<div class="header">
		<span style="font-size: 23px">VEGAVEST TRADING</span><br/>
		<span>(CA 0088843-X)</span><br/>
		<span>12 LORONG SERI KUANTAN 52</span><br/>
		<span>JALAN GALING 25250 KUANTAN</span><br/>
		<span>TEL: 012-9213373 FAX: 09-5366307</span><br/>
		<span>EMAIL: tfhow@hotmail.com</span><br/>
	</div>

	<div class="sub_header">
		<h3 align="center" style="color:black">INVOICE</h3>
			<div style="float:left">
				<span>{{ $company->company_name }}</span><br/>
				<span>{{ $company->address }}</span>
				<span>{{ $company->postcode }}</span><span> {{ $company->city }}</span><br/><span> {{ ($company->state == 'null') ? '' : $company->state }}</span>
			</div>
			<div style="float:right">

				<table>
					<tr>
						<td style="padding: 0px 10px 0px 0px"><span>NO </span></td>
						<td style="padding: 0px 0px 0px 0px"> : </td>
						<td style="text-align: right;padding: 0px 0px 0px 10px"><span> {{ $invoice->invoice_code }}</span></td>
					</tr>
					<tr>
						<td style="padding: 0px 10px 0px 0px"><span>D/O NO </span></td>
						<td style="padding: 0px 0px 0px 0px"> : </td>
						<td style="text-align: right;padding: 0px 0px 0px 10px"><span> {{ $invoice->do_number }}</span></td>
					</tr>
					<tr>
						<td style="padding: 0px 10px 0px 0px"><span>DATE </span></td>
						<td style="padding: 0px 0px 0px 0px"> : </td>
						<td style="text-align: right;padding: 0px 0px 0px 10px"><span> {{ $invoice->invoice_date }}</span></td>
					</tr>
					<tr>
						<td style="padding: 0px 10px 0px 0px"><span>TERM </span></td>
						<td style="padding: 0px 0px 0px 0px"> : </td>
						<td style="text-align: right;padding: 0px 0px 0px 10px"><span> CASH</span></td>
					</tr>
				</table>

			</div>
	</div>

	<div class="main">
		<table align="center" style="width:100%;">
			<thead style="margin-bottom: 10px;border-top: 2px solid;border-bottom:2px solid">
				<th style="width:1%">NO</th>
				<th style="width:50%;text-align: center;">DESCRIPTION</th>
				<th style="width:10%;text-align: right;padding-right: 2%">PIECES</th>
				<th style="width:8%;text-align: right;padding-right: 2%">TONNAGE</th>
				<th style="width:7%;text-align: right;padding-right: 2%">RATE <br/>(RM)</th>
				<th style="width:5%;text-align: right">AMOUNT <br/>(RM)</th>
			</thead>
			<tbody style="">
				@foreach($invoice_detail as $key => $result)
					<tr>
						<td style="vertical-align: top;">{{ $a++ }}</td>
						<td>
							<div style="display:grid;grid-template-columns:5% 20% 75%;grid-gap: 10px;">
								<div>{{$result->product_name}}</div>
								<div>&nbsp;&nbsp;&nbsp;{!!$result->variation_display!!}</div>
								<!-- Description -->
								<div>
										@if($result->bundle == 1)
											@foreach($result->bundle_col as $output)
												{!! str_replace(',',' ',$output) !!}<br/>
											@endforeach
										@else
											{!! str_replace(',',' ',$result->piece_col) !!}
										@endif
								</div>
							</div>
						</td>

						<!-- Piece Output -->
						<td style="text-align: right;padding-right: 2%">
							@if($result->bundle == 1)
									@foreach($result->bundle_piece as $output)
										{!! $output !!}
									@endforeach
							@else
								{!! $result->total_piece !!}
							@endif
						</td>

						<!-- Tonnage Or Footrun Output -->
						<td style="text-align: right;padding-right: 2%">
							@if($result->cal_type == null)
							{{ number_format($result->tonnage,4) }}
							@else
							{{ $result->footrun }} (FR)
							@endif
						</td>

						<td style="text-align: right;padding-right: 2%">{{ $result->price }}/{{ ($result->cal_type == null) ? 'T' : 'FR' }}</td>
						<td style="text-align: right">{{ number_format($result->amount,2) }}</td>
					</tr>
				@endforeach

				@if($other != null)
					@foreach($other as $result)
						<tr>
							<td>{{ $a++ }}</td>
							<td>
								<div style="display:grid;grid-template-columns:5% 20% 75%;grid-gap: 10px;">
									<div>Other</div>
									<div></div>
									<div>{{$result->product_name}}</div>
								</div>
							</td>
							<td style="text-align: right;padding-right: 2%">{{$result->total_piece}}</td>
							<td></td>
							<td style="text-align: right;padding-right: 2%">
								@php
									if($result->total_piece != 0){
										$rate = $result->amount / $result->total_piece;
										echo number_format($rate,2);
									}
								@endphp
							</td>
							<td style="text-align: right">{{ number_format($result->amount,2) }}</td>
						</tr>
					@endforeach
				@endif

				@if($transport != null)
					<tr class="last">
						<td>{{ $a }}</td>
						<td>
							<div style="display:grid;grid-template-columns:5% 20% 75%;grid-gap: 10px;">
								<div>Transportation</div>
								<div></div>
								<div></div>
							</div>
						</td>
						<td></td>
						<td></td>
						<td style="text-align: right;padding-right: 2%">{{ number_format($transport->price,2) }}</td>
						<td style="text-align: right">{{ number_format($transport->amount,2) }}</td>
					</tr>
				@endif

			</tbody>
		</table>

		<div class="footer">
			<table style="width:100%;border-top: 2px solid;border-bottom:2px solid">
				<tr>
					<td style="width:1%"></td>
					<td style="text-align: left;width:50%"><b>Total :</b></td>
					<td style="text-align: center;width:10%"><b>{{ $sum['piece'] }}</b></td>
					<td style="width:8%"><b>{{ $sum['tonnage'] }}</b></td>
					<td style="width:7%"></td>
					<td style="width:5%;text-align: right"><b>{{ number_format($sum['amount'],2) }}</b></td>
				</tr>
			</table>
			<table align="center" style="width:100%;text-align: left;margin-top: 75px">
				<tr>
					<td><b>ISSUE BY:</b> _____________________________________ </td>
					<td><b>RECEIVED BY:</b> _____________________________________ </td>
				</tr>
			</table>
		</div>



	</div>
</body>

<script src="../assets/js/jquery.min.js"></script>
<script>
window.print();

</script>

</html>