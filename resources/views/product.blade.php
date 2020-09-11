@include('header')
<style>
	.text{
		font-size:18px !important;
	}

	button{
		float:right;
	}
</style>
<div class="page-title">
  <h3>Item</h3>
  <p class="text-subtitle text-muted">Product</p>
</div>
@csrf
<section class="product">
	<div class="row">
		<div class="col-md-6 col-12">
			<div class="card">
				<div class="card-header">
					<h4>Products List</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<span style="font-size: 18px">Product Name</span><hr/>
						<div class="list">
						@foreach($product as $result)
							<div style="margin:25px 0px 25px 0px"><label class="text">{{ $result['name'] }}</label><button class="btn btn-danger delete" variation_id="{{ $result['id'] }}">Delete</button><hr/></div>
						@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-12">
			<div class="card" style="padding-bottom: 35px">
				<div class="card-header">
					<h4>Add New Product</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<label class="text">Insert New Product Name</label><br/>
						<input style="font-size: 16px" type="text" id="new" class="form-control" placeholder="e.g Durians"><br/>
						<button class="btn btn-primary" id="add">Add</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('script')
<script>

product_delete();

function product_delete(){
	$(".delete").click(function(){
		let id = $(this).attr('product_id');
		let token = $('input[name=_token]').val();
		let target = $(this);
		$.post("{{ route('ajaxDeleteProduct') }}",
		{
			'id' : id,
			'_token' : token
		},function(data){
			if(data == 1){
				target.parents().eq(0).remove();
			}
		},"json");
	});
}
	$("#add").click(function(){
		let name = $("#new").val();
		let token = $('input[name=_token]').val();
		$.post("{{ route('ajaxAddProduct') }}",
		{
			'name' : name,
			'_token' : token
		},function(data){

			$(".list").prepend('<div style="margin:25px 0px 25px 0px"><label class="text">'+ data['name'] +'</label><button class="btn btn-danger delete" product_id="'+ data['id'] +'">Delete</button><hr/></div>');
			product_delete();
			
		},"json");

	});

</script>

@include('footer')