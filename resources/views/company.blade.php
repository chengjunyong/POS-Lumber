@include('header')
<div class="page-title">
  <h3>Company</h3>
  <p class="text-subtitle text-muted">Company List</p>
</div>
@csrf
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
	        	<td>{{ ($result['state'] == 'null') ? '' : $result['state']}}</td>
	        	<td>{{ $result['updated_at'] }}</td>
	        	<td>
	        		<a href="{{ route('editProfile',$result['id']) }}"><button class="btn btn-primary">Edit</button></a>
	        		<button class="btn btn-secondary delete" onclick="deleteCompany({{$result->id}})">Delete</button>
	        	</td>
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

  function deleteCompany(company_id){

    if(confirm('Confirm to delete this company profile ?')){
      let token = $("input[name=_token]").val();
      let id = company_id;

      $.post('{{ route('ajaxDeleteCompany') }}',
        {
          '_token' : token,
          'id' : id
        },
        function(data){
          if(data){
            swal.fire({
              title:'Delete Successful',
              text: "Delete Successful, this page will refresh in a while",
              icon: 'success',
            }).then(()=>{
              window.location.reload();
            });
          }
        },'json');
    }
  }
</script>
@include('footer')



