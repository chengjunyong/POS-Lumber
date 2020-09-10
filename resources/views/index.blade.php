@include('header')
<div class="page-title">
  <h3>Dashboard</h3>
  <p class="text-subtitle text-muted">Statistics</p>
</div>
<section class="section">
  <div class="row mb-2">
    <div class="col-12 col-md-3">
      <div class="card card-statistic">
        <div class="card-body p-0">
          <div class="d-flex flex-column">
            <div class='px-3 py-3 d-flex justify-content-between'>
              <h3 class='card-title'>Monthly Sales</h3>
              <div class="card-right d-flex align-items-center">
                <p>Rm 50</p>
              </div>
            </div>

            <div class="chart-wrapper">
              <canvas id="canvas1" style="height:100px !important"></canvas>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card card-statistic">
        <div class="card-body p-0">
          <div class="d-flex flex-column">
            <div class='px-3 py-3 d-flex justify-content-between'>
              <h3 class='card-title'>Revenue</h3>
              <div class="card-right d-flex align-items-center">
                <p>Rm 532,2 </p>
              </div>
            </div>

            <div class="chart-wrapper">
              <canvas id="canvas2" style="height:100px !important"></canvas>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card card-statistic">
        <div class="card-body p-0">
          <div class="d-flex flex-column">
            <div class='px-3 py-3 d-flex justify-content-between'>
              <h3 class='card-title'>ORDERS</h3>
              <div class="card-right d-flex align-items-center">
                <p>1,544</p>
              </div>
            </div>

            <div class="chart-wrapper">
              <canvas id="canvas3" style="height:100px !important"></canvas>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card card-statistic">
        <div class="card-body p-0">
          <div class="d-flex flex-column">
            <div class='px-3 py-3 d-flex justify-content-between'>
              <h3 class='card-title'>Sales Today</h3>
              <div class="card-right d-flex align-items-center">
                <p>Rm 423 </p>
              </div>
            </div>

            <div class="chart-wrapper">
              <canvas id="canvas4" style="height:100px !important"></canvas>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class='card-heading p-1 pl-3'>Sales</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 col-12">
              <div class="pl-3">
                <h1 class='mt-5'>Rm 210,102</h1>
                <p class='text-xs'><span class="text-green"><i data-feather="bar-chart" width="15"></i> +19%</span> than last month</p>
                <div class="legends">
                  <div class="legend d-flex flex-row align-items-center">
                    <div class='w-3 h-3 rounded-full bg-info mr-2'></div><span class='text-xs'>Last Month</span>
                  </div>
                  <div class="legend d-flex flex-row align-items-center">
                    <div class='w-3 h-3 rounded-full bg-blue mr-2'></div><span class='text-xs'>Current Month</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-8 col-12">
              <canvas id="bar"></canvas>
            </div>

          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Orders Today</h4>
        </div>
        <div class="card-body px-0 pb-0">
          <div class="table-responsive">
            <table class='table mb-0' id="table1">
              <thead>
                <tr>
                  <th>Company Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>City</th>
                  <th>Sales</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Graiden</td>
                  <td>vehicula.aliquet@gmail.com</td>
                  <td>09-5387725</td>
                  <td>Kuantan</td>
                  <td>Rm 3,900</td>
                </tr>
                <tr>
                  <td>VEM</td>
                  <td>vem@abc.com</td>
                  <td>03-5387725</td>
                  <td>Gambang</td>
                  <td>Rm 2,400</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card ">
        <div class="card-header">
          <h4>Your Earnings</h4>
        </div>
        <div class="card-body">
          <div id="radialBars"></div>
          <div class="text-center mb-5">
            <h6>From last month</h6>
            <h1 class='text-green'>+$2,134</h1>
          </div>
        </div>
      </div>
    </div>
</section>
@include('script')



@include('footer')
