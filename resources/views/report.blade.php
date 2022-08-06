@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    
      <!-- STACKED BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Grafic Report Pitjarus</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">

                <form action="pitjarus" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Date From</label>
                        <input type="date" class="form-control" id="date-from" placeholder="date" name="date-from">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Date To</label>
                        <input type="date" class="form-control" id="date-to" placeholder="date" name="date-to">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Area</label>
                        <select class="select2 form-control" multiple="multiple" data-placeholder="Select a Area" style="width: 100%;" name="area[]">
                          @foreach ($storeAreas as $storeArea )
                          <option value="{{$storeArea->area_id}}">{{$storeArea->area_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>            
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1"> </label>
                        <button type="submit" name="submit" value="submit" class="form-control btn btn-primary">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
                
                <div class="chart">
                  <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Table Report Pitjarus</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              <table class="table table-hover">
  <thead>
    <tr>
      @foreach ($repotTables[0] as $value)
        <th scope="col">{{$value}}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach ($repotTables as $key => $values)
      @if ($key == 0)
        @continue
      @endif
    <tr>
      @foreach ($values as $value)
      <td>{{$value}}</td>
      @endforeach
    </tr>
    @endforeach
  </tbody>
</table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @stop
    
    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script> console.log('Hi!'); </script>
    <script type="text/javascript" src="/vendor/adminlte/dist/js/Chart.min.js"></script>
    <script>

// In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
    $('.select2').select2({
      tags: "true"
    });
});



var barChartData = {
      labels  : [@foreach ($reports as $report)
          "{{$report->area_name}}",
      @endforeach],
      datasets: [
        {
          label               : 'Percentage %',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [@foreach ($reports as $report)
          "{{$report->sum_compliance}}",
      @endforeach]
        },
      ]
    };

         //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    });

    </script>
@stop