@include('header')
<div class="page-title">
  <h3>Report</h3>
  <p class="text-subtitle text-muted">Company Based Report</p>
</div>
<div class="row">
	<div class="col-md-12 col-12">
		<div class="card">
			<div class="card-header">
				<h4 style="float:left">Generate Company Based Report</h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<h5 align="center">Please Select Company Profile & Date Range</h5>
					<div style="text-align: center">
						<form method="post" action="{{ route('postCompanyBasedReport') }}" target="_blank" >
							@csrf
							<div style="margin-bottom: 15px">
								<h4>Company Profile</h4>
								<select class="form-control" style="width: 25%;margin: 0 auto;" name="company_id">
									@foreach($company as $result)
										<option value="{{$result->id}}">{{$result->company_name}}</option>
									@endforeach
								</select>
							</div>
							<div style="margin-bottom: 15px">
								<h4>Date Start</h4>
								<input type="date" class="form-control" name="date_start" style="width:25%;margin: 0 auto;"/>
							</div>
							<div style="margin-bottom: 15px">
								<h4>Date End</h4>
								<input type="date" class="form-control" name="date_end" style="width:25%;margin: 0 auto;" />
							</div>
							<input type="submit" value="Submit" class="btn btn-primary" />
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