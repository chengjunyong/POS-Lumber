@include('header')
<div class="page-title">
  <h3>Invoice</h3>
  <p class="text-subtitle text-muted">Edit History</p>
</div>
<style>
	.form-control{
		font-weight: 600;
		font-size: 19px;
	}

	td{
		padding : 1.15rem 5px !important;
	}
	.cross{
		cursor: pointer;
	}

</style>
<section class="edit_history"> 
	<div class="row">
		<div class="col-md-12 col-12">
			<div class="card">
				<div class="card-header">
					<h4>Edit Invoice</h4>
				</div>
				<form method="post" action="{{ route('postHistory') }}">
					<div class="row">
						<h5 style="margin-left: 30px">Invoice Number - ({{ $invoice['invoice_code'] }})</h5>
						<div id="hidden_data">
							<input type="text" hidden name="invoice_number" value="{{ $invoice['invoice_code'] }}" />
							<input type="text" hidden name="invoice_id" value="{{ $invoice['id'] }}" />
						</div>
						<div style="margin-left: 30px" class="col-3">
							<h5>To Company</h5>
							<select name="company_id" class="form-control">
									@foreach($company as $result)
										<option value="{{ $result['id'] }}" {{ ($result['company_name'] == $invoice['company_name']) ? 'selected' : '' }}> {{$result['company_name']}}</option>
									@endforeach
							</select>
						</div>
						<div class="col-3">
							<h5>DO Number</h5>
							<input type="text" class="form-control" name="do" required value="{{ $invoice['do_number'] }}">
						</div>
						<div class="col-3">
							<h5>Date</h5>
							<input type="date" class="form-control" name="date" required value="{{ $invoice['invoice_date'] }}">
						</div>
					</div>
					@csrf
					<div class="card-content">
						<div class="card-body">
							<table class="table">
								<thead>
									<th style="width:12%">Product Name</th>
									<th style="width:12%">Specification</th>
									<th>Pieces <br/>1st value => pieces<br/>2nd value => inch</th>
									<th style="width:10%">Total Pieces</th>
									<th style="width:12%">Tonnage</th>
									<th style="width:12%">Price</th>
									<th style="width:12%">Cost</th>
									<th style="width:12%">Amount</th>
								</thead>
								<tbody id="append">
									@foreach($detail as $result)
									<tr>
										<td>
											<select name="product_id[]" class="form-control product">
												@foreach($product as $result2)
													<option value="{{$result2['id']}}" {{ ($result['product_name'] == $result2['name']) ? 'selected' : '' }}>{{$result2['name']}}</option>
												@endforeach
													<option value="transport">Transportation</option>
											</select>
										</td>
										<td>
											<select name="variation[]" class="form-control variation">
												@foreach($variation as $result2)
														<option value="{{$result2['id']}}" {{ ($result2['id'] == $result['display']) ? 'selected' : '' }}>{!!$result2['display']!!}</option>
												@endforeach
											</select>
										</td>
										<td>
											<input type="text" class="form-control pieces" name="piece[]" value="{{$result['piece_col']}}" required>
										</td>
										<td>
											<input type="number" name="total_piece[]" class="form-control" value="{{ $result['total_piece'] }}" readonly>
										</td>
										<td>
											<input type="text" name="tonnage[]" class="form-control tonnage" value="{{ $result['tonnage'] }}" readonly>
										</td>
										<td>
											<input type="number" name="invoice_detail_id[]" class="form-control" hidden value="{{ $result['id'] }}">
											<input style="font-size:18px" type="number" name="price[]" class="form-control price" value="{{ $result['price'] }}" step="0.01" required>
										</td>
										<td>
											<input type="number" name="cost[]" class="form-control cost" value="{{$result['cost']}}">
										</td>
										<td>
											<i class="cross" data-feather="x-circle" style="position:absolute;left:98.5%;height:2rem" data_id="{{$result['id']}}"></i> 
											<input type="text" name="amount[]" class="form-control" readonly val="" value="Rm {{ $result['amount'] }}">		
										</td>
									</tr>
								@endforeach

								@if($transport != null)
									<tr>
										<td>
											<select name="product_id[]" class="form-control product">
												<option value="transport" selected>Transportation</option>
											</select>
										</td>
										<td>
											<select name="variation[]" class="form-control variation">
												<option value="">Null</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control pieces" name="piece[]" value="Null" readonly>
										</td>
										<td>
											<input type="text" name="total_piece[]" class="form-control" value="Null" readonly>
										</td>
										<td>
											<input type="text" name="tonnage[]" class="form-control tonnage" value="Null" readonly>
										</td>
										<td>
											<input type="number" name="invoice_detail_id[]" class="form-control" hidden value="{{ $transport['id'] }}">
											<input style="font-size:18px" type="number" name="price[]" class="form-control price" value="{{ $transport['price'] }}" step="0.01" required>
										</td>
										<td>
											<input type="text" name="cost[]" class="form-control cost" value="Null" readonly>
										</td>
										<td>
											<i class="cross" data-feather="x-circle" style="position:absolute;left:98.5%;height:2rem" data_id="{{$transport['id']}}"></i> 
											<input type="text" name="amount[]" class="form-control" readonly val="" value="Null">		
										</td>
									</tr>
								@endif

								</tbody>
							</table>
							<button class="btn btn-primary" style="float:right;margin-bottom: 15px">Modify</button>
							<button type="button" id="add_p" class="btn btn-primary" style="border-radius: 100%;padding:3px 8px 7px; "><i data-feather="plus"></i></button></th>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@include('script')

<script>
	let num1 = 0;
	let num2 = 0;

	$(".pieces").on("keyup click",function(){
		cal1($(this));
	});

	$(".price").on("change keyup click",function(){
		cal2($(this));
	});

	$("#add_p").click(function(){
		let a = $("#append").children().eq(0).clone().find("input").val("").end();
		$("#append").append(a);

		$(".cross").click(function(){
	  	let id = $(this).attr('data_id');
	  	$(this).parents().eq(1).remove();
	  	$("#hidden_data").append("<input type='text' name='delete_invoice_detail_id[]' value='"+id+"' hidden />");
  	});

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

	 	target.parent().eq(0).siblings().eq(6).children().attr('val',amount);
	  target.parent().eq(0).siblings().eq(6).children().val("Rm "+display);
	}


	function cal3(target){

		let ton2 = parseFloat(target.parents().eq(0).siblings().eq(3).children().val());
		let price2 = parseFloat(target.parents().eq(0).siblings().eq(4).children().val());

		let amount2 = price2 * ton2;
		amount2 = amount2.toFixed(2);

		let display2 = new Intl.NumberFormat().format(amount2);

		target.parents().eq(0).siblings().eq(6).children().attr('val',amount2);
	 	target.parents().eq(0).siblings().eq(6).children().val("Rm "+display2);
	}

	$(".product").change(function(){
		$(this).children().attr('selected',false);
		$(this).children("option:selected").attr('selected',true);
	});

	var elem = document.documentElement;
  function openFullscreen() {
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen) { /* Firefox */
      elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
      elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { /* IE/Edge */
      elem.msRequestFullscreen();
    }
  }

  function closeFullscreen() {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
  }

  $("#max").click(function(){
  	if($(this).attr("c") == 0){
  		openFullscreen();
  		$(this).attr("c","1");
  		$(".navbar-toggler-icon").click();
  	}else{
  		closeFullscreen();
  		$(this).attr("c","0");
  		$(".navbar-toggler-icon").click();
  	}
  });

  // $("#generate").on("click",function(event){
  // 	event.preventDefault();
  // 	console.log($("form").serializeArray());
  // 	$("form").submit();
  // });

  $(".cross").click(function(){
  	let id = $(this).attr('data_id');
  	$(this).parents().eq(1).remove();
  	$("#hidden_data").append("<input type='text' name='delete_invoice_detail_id[]' value='"+id+"' hidden />");
  });

</script>

@if(session()->has('success'))
	<script>alert("{{session()->get('success')}}")</script>
@endif

@include('footer')