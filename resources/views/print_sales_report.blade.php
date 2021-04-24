<html>
<head>
  <title>Sales Report</title>
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
      <label>VEGAVEST TRADING</label><br/>
      <label>(CA 0088843-X)</label><br/>
      <label>Sales Report</label><br/>
      <label>Generate Date : {{date("Y-m-d")}}</label><br/>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <table style="width:100%;margin-top: 5px;">
      <tr>
        <td style="width:10%">Invoice Date</td>
        <td style="width:10%">Invoice Number</td>
        <td>Company Name</td>
        <td style="width:8%;text-align: center;">Total Tonnage (TON)</td>
        <td style="width:10%;text-align: center;">Total Sales (Rm)</td>
      </tr>
      @foreach($invoice as $result)
        <tr>
          <td style="text-align: center">{{$result->invoice_date}}</td>
          <td style="text-align: center">{{$result->invoice_code}}</td>
          <td style="text-align: left">{{$result->company_name}}</td>
          <td style="text-align: right;padding-right: 5px;">{{$result->tonnage}}</td>
          <td style="text-align: right;padding-right: 5px;">{{number_format($result->amount,2)}}</td>
        </tr>
      @endforeach
      <tfoot>
        <tr>
          <td colspan="3" style="text-align: center">Summary</td>
          <td style="text-align: right;padding-right: 5px;">{{$total->tonnage}}</td>
          <td style="text-align: right;padding-right: 5px;">{{number_format($total->amount,2)}}</td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

</body>
</html>