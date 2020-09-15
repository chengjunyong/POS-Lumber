@include('header')
<div class="page-title">
  <h3>Invoice</h3>
  <p class="text-subtitle text-muted">Edit History</p>
</div>
<style>
	td{
		font-size:18px;
	}
</style>
<section class="edit_history"> 
	<div class="row">
		<div class="col-md-12 col-12">
			<div class="card">
				<div class="card-header">
					<h4 style="float:left">Invoice-{{$invoice['invoice_code']}}</h4>
				</div>
				<form method="post">
					<div style="margin-left: 30px">
						<h5>Company - {{$invoice['company_name']}} </h5>
					</div>
					@csrf
					<div class="card-content">
						<div class="card-body">
							<table class="table">
								<thead>
									<th>Product Name</th>
									<th>Specification</th>
									<th>Pieces</th>
									<th>Total Pieces</th>
									<th>Tonnage</th>
									<th style="width:15%">Price</th>
									<th style="width:15%">Amount</th>
								</thead>
								<tbody id="append">
									@foreach($detail as $result)

									<tr>
										<td>
											{{ $result['product_name'] }}
										</td>
										<td>
											{!! $result['display'] !!}
										</td>
										<td>
											{{ $result['piece_col'] }}
										</td>
										<td>
											{{ $result['total_piece'] }}
										</td>
										<td>
											{{ $result['tonnage'] }}
										</td>
										<td>
											<input type="number" name="invoice_detail_id[]" class="form-control" hidden value="{{ $result['id'] }}">
											<input style="font-size:18px" type="number" name="price[]" class="form-control price" required value="{{ $result['price'] }}">
										</td>
										<td>
											<input style="font-size:18px;" type="number" name="amount[]" class="form-control amount" required value="{{ $result['amount'] }}" readonly>
										</td>
									</tr>

								@endforeach
								</tbody>
							</table>
							<button class="btn btn-primary" style="float:right;margin-bottom: 15px">Modify</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@include('script')

<script>
	$(".price").on("change keyup",function(){
		let price = parseFloat($(this).val());
		let tonnage = parseFloat($(this).parents().eq(0).siblings().eq(4).text());
		let total = tonnage * price;
		total = total.toFixed(2);
		$(this).parents().eq(0).siblings().eq(5).children().val(total);
	});

</script>

@include('footer')