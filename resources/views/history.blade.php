@include('header')
<div class="page-title">
  <h3>Invoice</h3>
  <p class="text-subtitle text-muted">History</p>
</div>

<section class="section">
	<div class="col-12">
		<div class="table-responsive">
	    <table class='table mb-0' id="history">
	      <thead>
	        <tr>
	          <th>ID</th>
	          <th>Invoice ID</th>
	          <th>Company Name</th>
	          <th>Total Pieces</th>
	          <th>Total Tonnage</th>
	          <th>Total Amount</th>
	          <th>Invoice Created Date</th>
	          <th></th>
	          <th></th>
	        </tr>
	      </thead>
	      <tbody>
	        @foreach($invoice as $result)
	        <tr>
	        	<td>{{ $result['id'] }}</td>
	        	<td>{{ $result['invoice_code'] }}</td>
	        	<td>{{ $result['company_name'] }}</td>
	        	<td>{{ $result['pieces'] }}</td>
	        	<td>{{ $result['tonnage'] }}</td>
	        	<td>Rm {{ $result['amount'] }}</td>
	        	<td>{{ $result['created_at'] }}</td>
	        	<td style="padding: 0px 0px 0px 0px"><a href="{{ route('editHistory',$result['id']) }}"><button class="btn btn-secondary">Edit</button></a></td>
	        	<td style="padding: 0px 0px 0px 0px"><a href="{{ route('getPrintInvoice',$result['id']) }}" target="_blank"><button class="btn btn-success">Print</button></a></td>
	        </tr>
	        @endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
</section>
@include('script')
<script>
	$("#history").DataTable({
		"order":['desc']
	});
</script>
@include('footer')



