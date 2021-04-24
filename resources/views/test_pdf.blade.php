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
    <table style="width:100%">
      <tr>
        <td style="width:13%">Invoice Date</td>
        <td style="width:13%">Invoice Number</td>
        <td>Company Name</td>
        <td style="text-align: center;width:10%">Total Tonnage (TON)</td>
        <td style="text-align: center;width:10%">Total Sales (Rm)</td>
      </tr>
      @foreach($invoice as $result)
        <tr>
          <td style="">{{$result->invoice_date}}</td>
          <td style="">{{$result->invoice_code}}</td>
          <td style="text-align: left">{{$result->company_name}}</td>
          <td style="text-align: right;padding-right: 3px">{{$result->tonnage}}</td>
          <td style="text-align: right;padding-right: 3px">{{number_format($result->amount,2)}}</td>
        </tr>
      @endforeach
      <tfoot>
        <tr>
          <td colspan="3" style="text-align: center">Summary</td>
          <td style="text-align: right;padding-right: 3px">{{$total->tonnage}}</td>
          <td style="text-align: right;padding-right: 3px">{{number_format($total->amount,2)}}</td>
          <
      </tfoot>
    </table>
  </div>
</div>

<!-- <div class="row">
  <div class="col-12">
    <footer>
      <table style="width:100%;text-align: center">
        <tr>
          <td>1</td>
          <td>2</td>
          <td>3</td>
        </tr>
        <tr>
          <td>4</td>
          <td>5</td>
          <td>6</td>
        </tr>
      </table>
    </footer>
  </div>
</div> -->

</body>
</html>