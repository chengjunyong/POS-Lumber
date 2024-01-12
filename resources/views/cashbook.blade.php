@include('header')
<div class="page-title">
  <h3>Report</h3>
  <p class="text-subtitle text-muted">Debtor Report</p>
</div>
<div class="row">
	<div class="col-md-12 col-12">
		<div class="card">
			<div class="card-header">
				<h4 style="float:left">Generate Debtor Report</h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<h5 align="center">Please Select Company Profile</h5>
					<div style="text-align: center">
						<form method="post" action="{{ route('postCashBook') }}" target="_blank" >
							@csrf
							<select class="form-control" name="id" style="width: 35%;margin: 0 auto;font-size: 15px;margin-bottom: 15px">
								@foreach($company as $result)
									<option value="{{$result->id}}">{{ $result->company_name }}</option>
								@endforeach
							</select>

							<select class="form-control" name="year" style="width: 35%;margin: 0 auto;font-size: 15px;margin-bottom: 15px" required>
                <option value="2025" {{ date("Y") == '2025' ? 'selected' : '' }}>2025</option>
                <option value="2024" {{ date("Y") == '2024' ? 'selected' : '' }}>2024</option>
                <option value="2023" {{ date("Y") == '2023' ? 'selected' : '' }}>2023</option>
                <option value="2022" {{ date("Y") == '2022' ? 'selected' : '' }}>2022</option>
                <option value="2021" {{ date("Y") == '2021' ? 'selected' : '' }}>2021</option>
              </select>

							<select class="form-control" name="issue_month" style="width: 35%;margin: 0 auto;font-size: 15px;margin-bottom: 15px" required>
								<option value="all">All</option>
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">Jun</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
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