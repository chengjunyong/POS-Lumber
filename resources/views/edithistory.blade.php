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
		vertical-align: top !important; 
	}
	.cross{
		cursor: pointer;
	}

</style>
<div id="copy" hidden>
	<select name="variation[]" class="form-control variation">
		@foreach($variation as $result2)
				<option value="{{$result2['id']}}">{!!$result2['display']!!}</option>
		@endforeach
	</select>
</div>

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
									<th style="width:5%"></th>
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
													<option value="other">Other</option>
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
											<textarea rows="2" class="form-control pieces" name="piece[]" placeholder="Example: 80/20,15/18" required>{{$result['piece_col']}}</textarea>
										</td>

										<td>
											<input type="number" name="total_piece[]" class="form-control t_piece" value="{{ $result['total_piece'] }}" readonly>
										</td>
										<td>
											<input type="text" name="tonnage[]" class="form-control tonnage" value="{{ $result['tonnage'] }}" readonly>
										</td>
										<td>
											<input style="font-size:18px" type="number" name="price[]" class="form-control price" value="{{ $result['price'] }}" step="0.01" required>
											<input type="number" name="invoice_detail_id[]" class="form-control" hidden value="{{ $result['id'] }}">
										</td>
										<td>
											<input type="number" name="cost[]" class="form-control cost" value="{{$result['cost']}}">
										</td>
										<td style="text-align: center">
											<input type="hidden" name="cal_type[]" value="ton" {{ ($result->cal_type == 1) ? 'disabled' : ''}}/>
											<input type="checkbox" class="form-check-input cal_type" name="cal_type[]" value="fr"  {{ ($result->cal_type == 1) ? 'checked' : ''}} />
											<div>Footrun</div>
										</td>
										<td>
											<i class="cross" data-feather="x-circle" style="position:absolute;left:98.5%;height:2rem" data_id="{{$result['id']}}"></i> 
											<input type="text" name="amount[]" class="form-control" readonly val="" value="Rm {{ $result['amount'] }}">		
										</td>
									</tr>
								@endforeach

								@if($other != null)
									@foreach($other as $result)
										<tr>
											<td>
												<select name="product_id[]" class="form-control product">
													@foreach($product as $result2)
														<option value="{{$result2['id']}}">{{$result2['name']}}</option>
													@endforeach
														<option value="transport">Transportation</option>
														<option value="other" selected>Other</option>
												</select>
											</td>
											<td>
												<input type="text" name="variation[]" class="form-control variation" value="{{ $result['product_name'] }}" required>
											</td>
											<td>
												<input type="text" class="form-control pieces" name="piece[]" value="Null" readonly>
											</td>
											<td>
												<input type="text" name="total_piece[]" class="form-control" value="{{ $result['total_piece'] }}" required>
											</td>
											<td>
												<input type="text" name="tonnage[]" class="form-control tonnage" value="Null" readonly>
											</td>
											<td>
												<input style="font-size:18px" type="number" name="price[]" class="form-control price" value="{{ $result['price'] }}" step="0.01" required>
												<input type="number" name="invoice_detail_id[]" class="form-control" hidden value="{{ $result['id'] }}">
											</td>
											<td>
												<input type="text" name="cost[]" class="form-control cost" value="{{ $result['cost'] }}">
											</td>
											<td style="text-align: center">
												<input type="hidden" name="cal_type[]" value="ton" />
												<input type="checkbox" class="form-check-input cal_type" name="cal_type[]" value="fr" />
												<div>Footrun</div>
											</td>
											</td>
											<td>
												<i class="cross" data-feather="x-circle" style="position:absolute;left:98.5%;height:2rem" data_id="{{$result['id']}}"></i> 
												<input type="text" name="amount[]" class="form-control" readonly val="" value="NaN">		
											</td>
										</tr>
									@endforeach
								@endif

								@if($transport != null)
									<tr>
										<td>
											<select name="product_id[]" class="form-control product">
													@foreach($product as $result2)
														<option value="{{$result2['id']}}">{{$result2['name']}}</option>
													@endforeach
														<option value="transport" selected>Transportation</option>
														<option value="other">Other</option>
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
										<td style="text-align: center">
											<input type="hidden" name="cal_type[]" value="ton" />
											<input type="checkbox" class="form-check-input cal_type" name="cal_type[]" value="fr" />
											<div>Footrun</div>
										</td>
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
	var list;

	$(".pieces").on("keyup click",function(){
		cal1($(this));
	});

	$(".price").on("change keyup click",function(){
		cal2($(this));
	});

	//Start Here
	$("#add_p").click(function(){
		$(".cal_type").unbind();
		let count = $("#append").children().length - 1;
		let a = $("#append").children().eq(count).clone().find(".t_piece,.tonnage,.price,.cost,.amount,textarea").val("").end();
		$("#append").append(a);

		$(".product").change(function(){
			if(list == null){
				list = $("#copy").html();	
			}
			if($(this).val() == 'other'){
				$(this).parents().eq(0).siblings().eq(0).html("<input type='text' name=variation[] class='form-control' required='true'/>");
				$(this).parents().eq(0).siblings().eq(1).children().attr({required:false,readonly:true,placeholder:""});
				$(this).parents().eq(0).siblings().eq(2).children().attr({required:true,readonly:false});
			}else if($(this).val() == 'transport'){
				$(this).parents().eq(0).siblings().eq(1).children().attr({required:false,readonly:true,placeholder:""});
				$(this).parents().eq(0).siblings().eq(2).children().attr({required:false,readonly:true});
				$(this).parents().eq(0).siblings().eq(0).html(list);
			}else{
				$(this).parents().eq(0).siblings().eq(0).html(list);
				$(this).parents().eq(0).siblings().eq(1).children().attr({required:true,readonly:false,placeholder:"Example: 80/20,15/18"});
				$(this).parents().eq(0).siblings().eq(2).children().attr({required:false,readonly:true});
				$(this).children().attr('selected',false);
				$(this).children("option:selected").attr('selected',true);
			}
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
				
				//Piece Filter Start Here

				let total_piece = 0;
				let c;

				c = target.val().replace(/\n/g,",");

				if(!c.includes(",")){
						b = c.split('/');
						total_piece += parseInt(b[0]);
						ton += parseInt(b[0]) * parseInt(b[1]);
				}else{
					let a = c.split(",");
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

		$(".tonnage").unbind();
		
		$(".tonnage").click(function(){
	  	if($(this).attr("data-ref") == "ton"){
	  		$(this).css("background-color","#F2F4F4");
	  		$(this).attr("data-ref","fr")
	  	}else{
	  		$(this).css("background-color","#1fed0d");
	  		$(this).attr("data-ref","ton")
	  	}
	  });

		
		//Checkbox Button
		$(".cal_type").change(function(){
			let fr = 0;
			let price,total;
			let target = $(this).parents().eq(0).siblings().eq(2).children();

			if(this.checked){
				console.log("Yes 1");
				$(this).siblings().eq(0).prop("disabled",true);

				let total_piece = 0;
				let c;
				let fr = 0;
				c = target.val().replace(/\n/g,",");
				if(!c.includes(",")){
						b = c.split('/');
						fr += parseInt(b[0]) * parseInt(b[1]);
				}else{
					let a = c.split(",");
					a.forEach(function(index){
						b = index.split('/');
						fr += parseInt(b[0]) * parseInt(b[1]);
					});
				}	

				price = $(this).parent().eq(0).siblings().eq(5).children().eq(0).val();
				console.log($(this).parent().eq(0).siblings().eq(5).children());
				total = price * fr;
				total = total.toFixed(2);

				let display = new Intl.NumberFormat().format(total);

		 		$(this).parent().eq(0).siblings().eq(7).children().attr('val',total);
		  	$(this).parent().eq(0).siblings().eq(7).children().val("Rm "+display);

			}else{
				console.log("No 1");
				$(this).siblings().eq(0).prop("disabled",false);

				let ton3 = parseFloat($(this).parents().eq(0).siblings().eq(4).children().val());
				let price3 = parseFloat($(this).parents().eq(0).siblings().eq(5).children().val());

				let amount3 = price3 * ton3;
				amount3 = amount3.toFixed(2);

				let display3 = new Intl.NumberFormat().format(amount3);

				$(this).parents().eq(0).siblings().eq(7).children().attr('val',amount3);
			 	$(this).parents().eq(0).siblings().eq(7).children().val("Rm "+display3);
			}
		});

	});

	//End Here

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

			//Piece Filter Start Here

			let total_piece = 0;
			let c;

			c = target.val().replace(/\n/g,",");

			if(!c.includes(",")){
					b = c.split('/');
					total_piece += parseInt(b[0]);
					ton += parseInt(b[0]) * parseInt(b[1]);
			}else{
				let a = c.split(",");
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


	//Checkbox Button
	$(".cal_type").change(function(){
		let fr = 0;
		let price,total;
		let target = $(this).parents().eq(0).siblings().eq(2).children();

		if(this.checked){
			console.log("Yes 2");
			$(this).siblings().eq(0).prop("disabled",true);

			let total_piece = 0;
			let c;
			let fr = 0;
			c = target.val().replace(/\n/g,",");
			if(!c.includes(",")){
					b = c.split('/');
					fr += parseInt(b[0]) * parseInt(b[1]);
			}else{
				let a = c.split(",");
				a.forEach(function(index){
					b = index.split('/');
					fr += parseInt(b[0]) * parseInt(b[1]);
				});
			}	

			price = $(this).parent().eq(0).siblings().eq(5).children().eq(0).val();
			total = price * fr;
			total = total.toFixed(2);

			console.log(`Price -> ${price} , FR -> ${fr}`);

			let display = new Intl.NumberFormat().format(total);

	 		$(this).parent().eq(0).siblings().eq(7).children().attr('val',total);
	  	$(this).parent().eq(0).siblings().eq(7).children().val("Rm "+display);

		}else{
			console.log("No");
			$(this).siblings().eq(0).prop("disabled",false);

			let ton3 = parseFloat($(this).parents().eq(0).siblings().eq(4).children().val());
			let price3 = parseFloat($(this).parents().eq(0).siblings().eq(5).children().val());

			let amount3 = price3 * ton3;
			amount3 = amount3.toFixed(2);

			let display3 = new Intl.NumberFormat().format(amount3);

			$(this).parents().eq(0).siblings().eq(7).children().attr('val',amount3);
		 	$(this).parents().eq(0).siblings().eq(7).children().val("Rm "+display3);
		}
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

			//Piece Filter Start Here

			let total_piece = 0;
			let c;

			c = target.val().replace(/\n/g,",");

			if(!c.includes(",")){
					b = c.split('/');
					total_piece += parseInt(b[0]);
					ton += parseInt(b[0]) * parseInt(b[1]);
			}else{
				let a = c.split(",");
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
		let amount = 0;
		let display;
		if(target.parent().eq(0).siblings().eq(6).children().eq(1).prop("checked") == false){

			let price = parseFloat(target.val());
		 	let ton = parseFloat(target.parent().eq(0).siblings().eq(4).children().val());
		 	amount = price * ton;
		 	amount = amount.toFixed(2);
		 	display = new Intl.NumberFormat().format(amount);

		 }else{

		 	let price = parseFloat(target.val());
		 	let piece = target.parent().eq(0).siblings().eq(2).children().val();
			let c,ton=0;

			c = piece.replace(/\n/g,",");

			if(!c.includes(",")){
					b = c.split('/');
					ton += parseInt(b[0]) * parseInt(b[1]);
			}else{
				let a = c.split(",");
				a.forEach(function(index){
					b = index.split('/');
					ton += parseInt(b[0]) * parseInt(b[1]);
				});
			}	
		 	amount = price * ton;
		 	amount = amount.toFixed(2);
		 	display = new Intl.NumberFormat().format(amount);

		 }

	 	target.parent().eq(0).siblings().eq(7).children().attr('val',amount);
	  target.parent().eq(0).siblings().eq(7).children().val("Rm "+display);
	}


	function cal3(target){
		let amount2 = 0;
		let display2;
		if(target.parent().eq(0).siblings().eq(6).children().eq(1).prop("checked") == false){

			let ton2 = parseFloat(target.parents().eq(0).siblings().eq(3).children().val());
			let price2 = parseFloat(target.parents().eq(0).siblings().eq(4).children().val());

			amount2 = price2 * ton2;
			amount2 = amount2.toFixed(2);

			display2 = new Intl.NumberFormat().format(amount2);

		}else{

			let price2 = parseFloat(target.parents().eq(0).siblings().eq(4).children().val());
			let piece = target.parent().eq(0).siblings().eq(1).children().val();
			let c,ton2=0;
			c = piece.replace(/\n/g,",");

			if(!c.includes(",")){
					b = c.split('/');
					ton2 += parseInt(b[0]) * parseInt(b[1]);
			}else{
				let a = c.split(",");
				a.forEach(function(index){
					b = index.split('/');
					ton2 += parseInt(b[0]) * parseInt(b[1]);
				});
			}	
			
			amount2 = price2 * ton2;
			amount2 = amount2.toFixed(2);

			display2 = new Intl.NumberFormat().format(amount2);
		}

		target.parents().eq(0).siblings().eq(7).children().attr('val',amount2);
	 	target.parents().eq(0).siblings().eq(7).children().val("Rm "+display2);

	}

	$(".product").change(function(){
		if(list == null){
			list = $("#copy").html();	
		}
		if($(this).val() == 'other'){
			$(this).parents().eq(0).siblings().eq(0).html("<input type='text' name=variation[] class='form-control' required='true'/>");
			$(this).parents().eq(0).siblings().eq(1).children().attr({required:false,readonly:true,placeholder:""});
			$(this).parents().eq(0).siblings().eq(2).children().attr({required:true,readonly:false});
		}else if($(this).val() == 'transport'){
			$(this).parents().eq(0).siblings().eq(1).children().attr({required:false,readonly:true,placeholder:""});
			$(this).parents().eq(0).siblings().eq(2).children().attr({required:false,readonly:true});
			$(this).parents().eq(0).siblings().eq(0).html(list);
		}else{
			$(this).parents().eq(0).siblings().eq(0).html(list);
			$(this).parents().eq(0).siblings().eq(1).children().attr({required:true,readonly:false,placeholder:"Example: 80/20,15/18"});
			$(this).parents().eq(0).siblings().eq(2).children().attr({required:false,readonly:true});
			$(this).children().attr('selected',false);
			$(this).children("option:selected").attr('selected',true);
		}
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