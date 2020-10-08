@include('header')

<div class="modal fade text-left" id="dark" tabindex="-1" role="dialog" aria-labelledby="myModalLabel150" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
	  <div class="modal-content">
	      <div class="modal-header bg-dark white">
	      <span class="modal-title" id="myModalLabel150">Successful</span>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <i data-feather="x"></i>
	      </button>
	      </div>
	      <div class="modal-body" style="font-size:20px">Invoice Generate Successful, For more option, please visit history page.</div>
	      <div class="modal-footer">
	      <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
	          <i class="bx bx-x d-block d-sm-none"></i>
	          <span class="d-none d-sm-block">Close</span>
	      </button>
	      </div>
	  </div>
  </div>
</div>
<button id="dark_btn" type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#dark" hidden></button>

<style>
	.form-control{
		font-weight: 600;
		font-size: 19px;
	}

	td{
		padding : 1.15rem 5px !important;
		vertical-align: top !important;
	}

	.tonnage{
		cursor:pointer;
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
					<h4 style="float:left">Invoice Form</h4>
					<i id="max" data-feather="maximize" style="height:2rem;float:right" c="0"></i>
				</div>
				<form action="{{route('postInvoice')}}" method="post">
					<div class="row">
						<h5 style="margin-left: 30px">Invoice Number - ({{ $invoice_number }})</h5>
						<input type="text" hidden name="invoice_number" value="{{ $invoice_number }}" />
						<div style="margin-left: 30px" class="col-3">
							<h5>To Company</h5>
							<select name="company_id" class="form-control">
								@foreach($company as $result)
									<option value="{{$result['id']}}">{{$result['company_name']}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-3">
							<h5>DO Number</h5>
							<input type="text" class="form-control" name="do" required>
						</div>
						<div class="col-3">
							<h5>Date</h5>
							<input type="date" class="form-control" name="date" required>
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
									<tr>
										<td>
											<select name="product_id[]" class="form-control product">
												@foreach($product as $result)
													<option value="{{$result['id']}}">{{$result['name']}}</option>
												@endforeach
													<option value="transport">Transportation</option>
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
											<textarea rows="2" class="form-control pieces" name="piece[]" placeholder="Example: 80/20,15/18" required></textarea>
										</td>
										<td>
											<input type="number" name="total_piece[]" class="form-control" readonly>
										</td>
										<td>
											<input type="text" name="tonnage[]" class="form-control tonnage" readonly data-ref="ton">
										</td>
										<td>
											<input type="number" name="price[]" class="form-control price" required>
										</td>
										<td>
											<input type="number" name="cost[]" class="form-control cost">
										</td>
										<td>
											<input type="text" name="amount[]" class="form-control" readonly val="">
										</td>
									</tr>
								</tbody>
							</table>
							<button id="generate" class="btn btn-primary" style="float:right">Generate</button>
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
		let count = $("#append").children().length - 1;
		let a = $("#append").children().eq(count).clone().find("input,textarea").val("").end();
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

  $(".tonnage").click(function(){
  	if($(this).attr("data-ref") == "ton"){
  		$(this).css("background-color","#F2F4F4");
  		$(this).attr("data-ref","fr")
  	}else{
  		$(this).css("background-color","#1fed0d");
  		$(this).attr("data-ref","ton")
  	}
  })

</script>

@if(session()->has('success'))
<script>
	$("#dark_btn").click();
</script>
@endif

@include('footer')