@include('header')

<div class="page-title">
  <h3>Payment History</h3>
  <p class="text-subtitle text-muted">Check Payment</p>
</div>
<div class="row">
  <div class="col-md-12 col-12">
    <div class="card">
      <div class="card-header">
        <h4 style="float:left">Payment Detail Infomation</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <h5 align="center">Please Select Company Profile</h5>
          <div style="text-align: center">
            <form method="get" action="{{route('getPaymentHistoryDetail')}}">
              <select class="form-control" name="company_id" style="width: 30%;margin: 0 auto;font-size: 15px">
                @foreach($company as $result)
                  <option value="{{$result->id}}">{{ $result->company_name }}</option>
                @endforeach
              </select>
              <h5 style="margin-top: 15px" >Payment Month</h5>
              <input type="month" class="form-control" name="payment_date" style="width:30%;margin: 0 auto;margin-bottom: 15px" required>
              <input type="submit" value="Submit" class="btn btn-primary" />
              <input type="reset" class="btn btn-secondary" value="Clear"/>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('script')
<script>

</script>



@include('footer')