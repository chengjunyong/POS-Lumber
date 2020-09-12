@include('header')
<style>
	.form-control{
		font-weight: 600;
		font-size: 19px;
	}


</style>
<div class="page-title">
  <h3>Invoice</h3>
  <p class="text-subtitle text-muted">Generate Invoice</p>
</div>
@csrf
<section class="invoice">
	<div class="row">
		<div class="col-md-12 col-12">
			<div class="card">
				<div class="card-header">
					<h4>Invoice Form</h4>
				</div>
				<div style="margin-left: 30px">
					<h5>To Company</h5>
					<select name="company_id" class="form-control" style="width:25%">
						@foreach($company as $result)
							<option value="{{$result['id']}}">{{$result['company_name']}}</option>
						@endforeach
					</select>
				</div>
				<div class="card-content">
					<div class="card-body">
						<table class="table">
							<thead>
								<th style="width:10%">Product Name</th>
								<th style="width:12%">Specification</th>
								<th>Pieces</th>
								<th style="width:10%">Total Pieces</th>
								<th style="width:12%">Tonnage</th>
								<th style="width:15%">Price</th>
								<th style="width:15%">Amount</th>
							</thead>
							<tbody id="append">
								<tr>
									<td>
										<select name="product_id[]" class="form-control product">
											@foreach($product as $result)
												<option value="{{$result['id']}}">{{$result['name']}}</option>
											@endforeach
										</select>
									</td>
									<td>
										<select name="variation[]" class="form-control variation">
											@foreach($variation as $result)
												<option value="{{$result['id']}}">{!!$result['display']!!}</option>
											@endforeach
										</select>
									</td>
									<td>
										<input type="text" class="form-control pieces" name="piece[]">
									</td>
									<td>
										<input type="number" name="total_piece[]" class="form-control" readonly>
									</td>
									<td>
										<input type="text" name="tonnage[]" class="form-control tonnage" readonly>
									</td>
									<td>
										<input type="number" name="price[]" class="form-control price">
									</td>
									<td>
										<input type="text" name="amount[]" class="form-control" readonly val="">
									</td>
								</tr>
							</tbody>
						</table>
						<button id="add_p" class="btn btn-primary" style="border-radius: 100%;padding:8px 12px; "><i data-feather="plus"></i></button></th>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>
@include('script')

<script>
	let num1 = 0;
	let num2 = 0;

	$(".pieces").keyup(function(){
		cal1($(this));
	});

	$(".price").on("change keyup click",function(){
		cal2($(this));
	});

	$("#add_p").click(function(){
		let count = $("#append").children().length - 1;
		let a = $("#append").children().eq(count).clone();
		$("#append").append(a);

		$(".product").change(function(){
			$(this).children().attr('selected',false);
			$(this).children("option:selected").attr('selected',true);
		});

		$(".pieces").keyup(function(){
			cal1($(this));
		});

		$(".price").on("change keyup click",function(){
			cal2($(this));
		});

		$(".variation").change(function(){
			let target = $(this).parents().eq(0).siblings().eq(1).children();
			let target2 = $(this);
			let ton = 0;
			let id = target.parents().eq(0).siblings().eq(1).children().val();
			let token = $("input[name=_token]").val();
			$.post("{{route('ajaxgetValue')}}",
			{
				'_token' : token,
				'id' : id
			},function(data){

				if(data['first'].includes(" ")){
					let dum = data['first'].split(" ");
					let dum2 = dum[1].split("/");
					num1 = parseFloat(dum[0]) + (parseFloat(dum2[0]) / parseFloat(dum2[1]));

				}else if(data['first'].includes("/")){
					let dum = data['first'].split("/");
					num1 = parseFloat(dum[0]) / parseFloat(dum[1]);
				}else{
					num1 = parseFloat(data['first']);
				}
				if(data['second'].includes(" ")){
					let dum = data['second'].split(" ");
					let dum2 = dum[1].split("/");
					num2 = parseFloat(dum[0]) + (parseFloat(dum2[0]) / parseFloat(dum2[1]));
				}else if(data['second'].includes("/")){
					let dum = data['second'].split("/");
					num2 = parseFloat(dum[0]) / parseFloat(dum[1]);
				}else{
					num2 = parseFloat(data['second']);
				}
				let total_piece = 0;
				if(!target.val().includes(",")){
						b = target.val().split('/');
						total_piece += parseInt(b[0]);
						ton += parseInt(b[0]) * parseInt(b[1]);
				}else{
					let a = target.val().split(",");
					a.forEach(function(index){
						b = index.split('/');
						total_piece += parseInt(b[0]);
						ton += parseInt(b[0]) * parseInt(b[1]);
					});
				}

				ton = (ton * num1 * num2) / 7200;
				ton = ton.toFixed(4);

				target.parent().eq(0).siblings().eq(3).children().val(ton);
				target.parent().eq(0).siblings().eq(2).children().val(total_piece);

				cal3(target2);

			},"json");
		});

	})


	$(".variation").change(function(){
		let target = $(this).parents().eq(0).siblings().eq(1).children();
		let target2 = $(this);
		let ton = 0;
		let id = target.parents().eq(0).siblings().eq(1).children().val();
		let token = $("input[name=_token]").val();
		$.post("{{route('ajaxgetValue')}}",
		{
			'_token' : token,
			'id' : id
		},function(data){

			if(data['first'].includes(" ")){
				let dum = data['first'].split(" ");
				let dum2 = dum[1].split("/");
				num1 = parseFloat(dum[0]) + (parseFloat(dum2[0]) / parseFloat(dum2[1]));

			}else if(data['first'].includes("/")){
				let dum = data['first'].split("/");
				num1 = parseFloat(dum[0]) / parseFloat(dum[1]);
			}else{
				num1 = parseFloat(data['first']);
			}
			if(data['second'].includes(" ")){
				let dum = data['second'].split(" ");
				let dum2 = dum[1].split("/");
				num2 = parseFloat(dum[0]) + (parseFloat(dum2[0]) / parseFloat(dum2[1]));
			}else if(data['second'].includes("/")){
				let dum = data['second'].split("/");
				num2 = parseFloat(dum[0]) / parseFloat(dum[1]);
			}else{
				num2 = parseFloat(data['second']);
			}
			let total_piece = 0;
			if(!target.val().includes(",")){
					b = target.val().split('/');
					total_piece += parseInt(b[0]);
					ton += parseInt(b[0]) * parseInt(b[1]);
			}else{
				let a = target.val().split(",");
				a.forEach(function(index){
					b = index.split('/');
					total_piece += parseInt(b[0]);
					ton += parseInt(b[0]) * parseInt(b[1]);
				});
			}
			ton = (ton * num1 * num2) / 7200;
			ton = ton.toFixed(4);
			target.parent().eq(0).siblings().eq(3).children().val(ton);
			target.parent().eq(0).siblings().eq(2).children().val(total_piece);
			cal3(target2);
		},"json");
	});

	function cal1(target){

	// if(e.keyCode == 13){
		let ton = 0;
		let id = target.parents().eq(0).siblings().eq(1).children().val();
		let token = $("input[name=_token]").val();
		$.post("{{route('ajaxgetValue')}}",
		{
			'_token' : token,
			'id' : id
		},function(data){

			if(data['first'].includes(" ")){
				let dum = data['first'].split(" ");
				let dum2 = dum[1].split("/");
				num1 = parseFloat(dum[0]) + (parseFloat(dum2[0]) / parseFloat(dum2[1]));

			}else if(data['first'].includes("/")){
				let dum = data['first'].split("/");
				num1 = parseFloat(dum[0]) / parseFloat(dum[1]);

			}else{
				num1 = parseFloat(data['first']);

			}

			if(data['second'].includes(" ")){
				let dum = data['second'].split(" ");
				let dum2 = dum[1].split("/");
				num2 = parseFloat(dum[0]) + (parseFloat(dum2[0]) / parseFloat(dum2[1]));


			}else if(data['second'].includes("/")){
				let dum = data['second'].split("/");
				num2 = parseFloat(dum[0]) / parseFloat(dum[1]);

			}else{
				num2 = parseFloat(data['second']);
			}

			let total_piece = 0;

			if(!target.val().includes(",")){
					b = target.val().split('/');
					total_piece += parseInt(b[0]);
					ton += parseInt(b[0]) * parseInt(b[1]);
			}else{
				let a = target.val().split(",");
				a.forEach(function(index){
					b = index.split('/');
					total_piece += parseInt(b[0]);
					ton += parseInt(b[0]) * parseInt(b[1]);
				});
			}

			ton = (ton * num1 * num2) / 7200;
			ton = ton.toFixed(4);

			target.parent().eq(0).siblings().eq(3).children().val(ton);
			target.parent().eq(0).siblings().eq(2).children().val(total_piece);

		},"json");
	// }
	}

	function cal2(target){
		let price = parseFloat(target.val());
	 	let ton = parseFloat(target.parent().eq(0).siblings().eq(4).children().val());

	 	let amount = price * ton;
	 	amount = amount.toFixed(2);

	 	let display = new Intl.NumberFormat().format(amount);

	 	target.parent().eq(0).siblings().eq(5).children().attr('val',amount);
	  target.parent().eq(0).siblings().eq(5).children().val("Rm "+display);
	}


	function cal3(target){

		let ton2 = parseFloat(target.parents().eq(0).siblings().eq(3).children().val());
		let price2 = parseFloat(target.parents().eq(0).siblings().eq(4).children().val());

		console.log(ton2,price2);

		let amount2 = price2 * ton2;
		amount2 = amount2.toFixed(2);

		let display2 = new Intl.NumberFormat().format(amount2);

		target.parents().eq(0).siblings().eq(5).children().attr('val',amount2);
	 	target.parents().eq(0).siblings().eq(5).children().val("Rm "+display2);
	}

	$(".product").change(function(){
		$(this).children().attr('selected',false);
		$(this).children("option:selected").attr('selected',true);
	});

</script>

@include('footer')