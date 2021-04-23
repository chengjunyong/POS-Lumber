@include('header')
<div class="page-title">
  <h3>Invoice</h3>
  <p class="text-subtitle text-muted">History</p>
</div>

<section class="section">
  <div class="col-12">
    <div class="table-responsive">
      <table class='table mb-0'>
        <thead>
          <tr>
            <th>No</th>
            <th>Payment Date</th>
            <th>Amount</th>
            <th>Created At</th>
            <th>Modify</th>
          </tr>
        </thead>
        <tbody>
          @foreach($history as $key => $result)
          <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $result->invoice_date }}</td>
            <td>{{ number_format($result->amount,2)}}</td>
            <td>{{ $result->created_at }}</td>
            <td><button class="btn btn-primary edit" type="button" value="{{$result->id}}">Edit</button></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@include('script')

<script>
$(document).ready(function(){

  $(".edit").click(function(){
    let id = $(this).val();
    Swal.fire({
      title: 'Enter Amount',
      input: 'number',
      inputLabel: 'Amount',
      inputPlaceholder: 'Enter amount',
      inputAttributes: {
        maxlength: 10,
        min: 0,
        step: 0.01,
      }
    }).then((result) => {
      if(result.value != 0 && result.value != null && result.value != ""){
        $.get('{{route('AjaxModifyAmount')}}',
        {
          'id': id,
          'amount' : result.value,
        },function(data){
          if(data){
            Swal.fire('Success','Modify Successfully','success').then(()=>{window.location.reload();});

          }else{
            Swal.fire('Modify Fail','Modify Amount Failure, Please Contact It Support','error');
          }
        },'json');
      }
    });

  });

});
</script>

@include('footer')



