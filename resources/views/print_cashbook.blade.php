<html>
<head>
	<title>Debtor Report - {{$company->company_name}}</title>
</head>
<style>
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
    position:fixed;
    bottom: 100;
    left:0
  }

  td{
    font-size:13px;
    padding: 2px;
  }

  label{
    font-size:12px;
    padding:0px;
    margin: 0px;
  }

</style>
<body>
<div class="header">
	<label>VEGAVEST TRADING</label><br/>
	<label>(CA 0088843-X)</label><br/>
	<label>12 LORONG SERI KUANTAN 52</label><br/>
	<label>JALAN GALING 25250 KUANTAN</label><br/>
	<label>TEL: 012-9213373 FAX: 09-5366307</label><br/>
	<label>EMAIL: tfhow@hotmail.com</label><br/>
	<label style="margin-top: 10px;color: black;">STATEMENT OF ACCOUNTS - {{$company->company_name}}</label><br/>
</div>

<table style="width:100%;margin-top: 5px;">
	<tr>
		<td style="width:10%">Date</td>
		<td>Particular</td>
		<td style="width:15%">Debit</td>
		<td style="width:15%">Credit</td>
		<td>Balance</td>
	</tr>

	@if($forward->type != null && $forward->type == "forward" && $forward->balance != 0)
		<tr>
			<td style="text-align: center">{{date("Y")}}-{{ (strlen($forward->month) == 1) ? '0'.$forward->month : $forward->month}}-01</td>
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
</table>

<div class="row">
  <div class="col-12">
    <footer>		
      <table style="width:100%;text-align: center">
        <tr>
          <td colspan="6"><b>Previous Year</b></td>
        </tr>
        <tr>
          <td>July<br/>{{ number_format($pre_month[7],2) }}</td>
          <td>August<br/>{{ number_format($pre_month[8],2) }}</td>
          <td>September<br/>{{ number_format($pre_month[9],2) }}</td>
          <td>October<br/>{{ number_format($pre_month[10],2) }}</td>
          <td>November<br/>{{ number_format($pre_month[11],2) }}</td>
          <td>December<br/>{{ number_format($pre_month[12],2) }}</td>
        </tr>
        <tr>
          <td colspan="6"><b>Current Year</b></td>
        </tr>
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
    </footer>
  </div>
</div>

</body>

</html>