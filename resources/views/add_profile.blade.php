@include('header')
<link rel="stylesheet" href="assets/css/choices.min.css">
<style>
	.title{
		font-size:14px !important;
	}
</style>
<div class="page-title">
  <h3>Company</h3>
  <p class="text-subtitle text-muted">Add Company Profile</p>
</div>
<section class="multiple-column-form">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Company Detail Form</h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<form class="form" action="{{route('postAddProfile')}}" method="post">
						@csrf
						<div class="row">
							<div class="col-md-6 col-12">
								<div class="form-group">
									<label class="title">Company Name</label>
									<input name="company_name" class="form-control" type="text" required>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="form-group">
									<label class="title">Contact</label>
									<input name="contact" class="form-control" type="text" required>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="form-group">
									<label class="title">City</label>
									<input name="city" class="form-control" type="text" required>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="form-group">
									<label class="title">Postcode</label>
									<input name="postcode" class="form-control" type="number" required>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="form-group">
									<label class="title">State</label>
									<select name="state" class="choices form-select" required>
					  				<option value="Johor">Johor</option>
					  				<option value="Kedah">Kedah</option>
					  				<option value="Kelantan">Kelantan</option>
					  				<option value="Kuala Lumpur">Kuala Lumpur</option>
					  				<option value="Malacca">Malacca</option>
					  				<option value="Negeri Sembilan">Negeri Sembilan</option>
					  				<option value="Pahang" selected>Pahang</option>
					  				<option value="Penang">Penang</option>
					  				<option value="Perak">Perak</option>
					  				<option value="Perlis">Perlis</option>
					  				<option value="Sabah">Sabah</option>
					  				<option value="Sarawak">Sarawak</option>
					  				<option value="Selangor">Selangor</option>
					  				<option value="Terengganu">Terengganu</option>
									</select>
								</div>
							</div>
							<div class="col-md-12 col-12">
								<div class="form-group">
									<label class="title">Address</label>
									<textarea name="address" class="form-control" rows="10" required></textarea>
								</div>
							</div>
							<div class="col-md-12 col-12">
								<div class="form-group" style="text-align: center">
									<input class="btn btn-primary" type="submit" value="Save">
									<input class="btn btn-secondary" type="reset" value="Reset">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<button id="modal_trigger" type="button" class="btn btn-outline-primary block" data-toggle="modal" data-target="#msg" hidden></button>
<div class="modal fade text-left" id="msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel1">Message</h5>
				<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<div class="modal-body" style="text-align: center;font-size:21px">
				<p>Company Detail Has Been Save Successful</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					<i class="bx bx-x d-block d-sm-none"></i>
					<span class="d-none d-sm-block">Close</span>
				</button>
			</div>
		</div>
	</div>
</div>

@include('script')

<script src="assets/js/choices.min.js"></script>
<script>

	@if(isset($result))

	$("#modal_trigger").click();

	@endif
	
</script>

@include('footer')