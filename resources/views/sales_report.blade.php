@include('header')
<div class="page-title">
  <h3>Report</h3>
  <p class="text-subtitle text-muted">Sales Report</p>
</div>
<div class="row">
  <div class="col-md-12 col-12">
    <div class="card">
      <div class="card-header">
        <h4 style="float:left">Generate Sales Report</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <h5 align="center">Please Select Which Month To Generate Report</h5>
          <div style="text-align: center">
            <form method="post" action="{{ route('postSalesReport') }}" target="_blank" >
              @csrf
              <select name="month" class="form-control" style="width:25%;margin: 0 auto;margin-top: 10px;margin-bottom: 10px">
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
              <input type="submit" value="Submit" class="btn btn-primary" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('script')


@include('footer')