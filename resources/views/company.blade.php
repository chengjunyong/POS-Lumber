@include('header')
<div class="page-title">
  <h3>Company</h3>
  <p class="text-subtitle text-muted">Company List</p>
</div>

<a href="{{ route('getAddProfile') }}"><button class="btn btn-primary" style="margin:10px 0px 25px 0px">Add Company Profile</button></a>
<section class="section">
	<div class="col-12">
		<div class="table-responsive">
	    <table class='table mb-0' id="profile">
	      <thead>
	        <tr>
	          <th>ID</th>
	          <th>Company Name</th>
	          <th>Contact</th>
	          <th>City</th>
	          <th>State</th>
	          <th>Last Update</th>
	          <th>#</th>
	        </tr>
	      </thead>
	      <tbody>
	        @foreach($allCompany as $result)
	        <tr>
	        	<td>{{ $result['id'] }}</td>
	        	<td>{{ $result['company_name'] }}</td>
	        	<td>{{ $result['contact'] }}</td>
	        	<td>{{ $result['city'] }}</td>
	        	<td>{{ $result['state'] }}</td>
	        	<td>{{ $result['updated_at'] }}</td>
	        	<td><a href="{{ route('editProfile',$result['id']) }}"><button class="btn btn-secondary">Edit</button></a></td>
	        </tr>
	        @endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
</section>
@include('script')
<script>
	$("#profile").DataTable();
</script>
@include('footer')



