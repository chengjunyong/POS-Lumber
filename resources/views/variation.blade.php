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
  <p class="text-subtitle text-muted">Variation</p>
</div>
@csrf
<section class="variation">
	<div class="row">
		<div class="col-md-6 col-12">
			<div class="card">
				<div class="card-header">
					<h4>Variation List</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<span style="font-size: 18px">Variation</span><hr/>
						<div class="list">
						@foreach($variation as $result)
							<div style="margin:25px 0px 25px 0px">
								<label class="text">
									{!! $result['first'] !!}" x 
								</label>
								<label class="text">
									{!! $result['second'] !!}"
								</label>
								<button class="btn btn-danger delete" variation_id="{{ $result['id'] }}">Delete</button>
								<hr/>
							</div>
						@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-12">
			<div class="card" style="padding-bottom: 35px">
				<div class="card-header">
					<h4>Add Variation</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
						<label class="text">Insert Variation Value</label><br/>
						<span style="font-size:16px">Example : 1 <sup>5</sup>&frasl;<sub>8</sub>" x 3 <sup>7</sup>&frasl;<sub>8</sub>" write as (1.5/8x3.7/8)</span><br/>
						<input style="font-size: 16px;margin-bottom: 10px;margin-top: 15px" type="text" id="variation" class="form-control" placeholder="e.g : 1.5/8x3.7/8">
						<button class="btn btn-primary" id="add">Add</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('script')
<script>

	v_delete();

	$("#add").click(function(){
		let token = $('input[name=_token]').val();
		let variation = $("#variation").val();

		if(variation != ""){
			$.post("{{route('ajaxAddVariation')}}",
			{
				'_token' : token,
				'variation' : variation

			},function(data){

				if(data != 0){
					$(".list").prepend('<div style="margin:25px 0px 25px 0px"><label class="text">'+data['first']+'" x </label><label class="text">&nbsp;'+data['second']+'"</label><button class="btn btn-danger delete" variation_id="'+data['id']+'">Delete</button><hr/></div>');
				}

			},"json");
		}
	});

	function v_delete(){
			$(".delete").click(function(){
			let id = $(this).attr('variation_id');
			let token = $('input[name=_token]').val();
			let target = $(this);
			$.post("{{ route('ajaxDeleteVariation') }}",
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

</script>
@include('footer')