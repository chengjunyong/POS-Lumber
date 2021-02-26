@include('header')

<div class="modal fade text-left" id="dark" tabindex="-1" role="dialog" aria-labelledby="myModalLabel150" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
	  <div class="modal-content">
	      <div class="modal-header bg-dark white">
	      <span class="modal-title" id="myModalLabel150">Successful</span>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <i data-feather="x"></i>
	      </button>
	      </div>
	      <div class="modal-body" style="font-size:20px">Payment has been recorded.</div>
	      <div class="modal-footer">
	      <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
	          <i class="bx bx-x d-block d-sm-none"></i>
	          <span class="d-none d-sm-block">Close</span>
	      </button>
	      </div>
	  </div>
  </div>
</div>
<button id="dark_btn" type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#dark" hidden></button>
<div class="page-title">
  <h3>Payment</h3>
  <p class="text-subtitle text-muted">Issue Payment</p>
</div>
<div class="row">
	<div class="col-md-12 col-12">
		<div class="card">
			<div class="card-header">
				<h4 style="float:left">Payment Detail</h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<h5 align="center">Please Select Company Profile</h5>
					<div style="text-align: center">
						<form method="post" action="{{route('postIssuePayment')}}">
							@csrf
							<select class="form-control" name="id" style="width: 30%;margin: 0 auto;font-size: 15px">
								@foreach($company as $result)
									<option value="{{$result->id}}">{{ $result->company_name }}</option>
								@endforeach
							</select>
							<h5 style="margin-top: 15px" >Issue Date</h5>
							<input type="date" class="form-control" name="issue_date" style="width:30%;margin: 0 auto;margin-bottom: 15px" required>
							<h5 style="margin-top: 15px" >Payment Amount</h5>
							<input type="number" name="amount" step="0.01" class="form-control" style="width:30%;margin: 0 auto;margin-bottom: 15px" required>
							<br/>
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
	$("input[type=submit]").on("click",function(event){
	  event.preventDefault();

	  let name = $("select option:selected").text();
	  let amount = $("input[name=amount]").val();
	  let issue_date = $("input[name=issue_date]").val();
	  let target = $("input[name=amount]")[0];

	  amount = amount.replace(" ","");
	  amount = parseFloat(amount);
	  amount = amount.toFixed(2);
		amount = new Intl.NumberFormat().format(amount);

		let text = "Please confirm the information below\nCompany Name : "+name+"\nIssue Date : "+issue_date+"\nAmount : Rm "+amount;

	  if(amount == "NaN"){
	  	target.setCustomValidity('Please Fill An Amounts');
	  }else{
	  	target.setCustomValidity("");
	  	if(confirm(text)){
	  		$("form").submit();
			}
	  }

  });

</script>



@if(session()->has('success'))
<script>
	$("#dark_btn").click();
</script>
@endif

@include('footer')