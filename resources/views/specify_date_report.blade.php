@include('header')
<div class="page-title">
  <h3>Report</h3>
  <p class="text-subtitle text-muted">Specify Date Report</p>
</div>
<div class="row">
	<div class="col-md-12 col-12">
		<div class="card">
			<div class="card-header">
				<h4 style="float:left">Generate Specify Date Report</h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<h5 align="center" style="margin-bottom: 15px">Please Input The Range Of Date</h5>
					<div style="text-align: center">
						<form method="post" action="{{ route('postSpecifyDateReport') }}" target="_blank" >
							@csrf
							<div style="margin-bottom: 15px">
								<h5>Date Start</h4>
								<input type="date" class="form-control" name="date_start" style="width:25%;margin: 0 auto;"/>
							</div>
							<div style="margin-bottom: 15px">
								<h5>Date End</h4>
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