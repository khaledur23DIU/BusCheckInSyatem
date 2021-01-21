@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">directions_bus</i>
              </div>
              <p class="card-category">{{__('Todays Total Check In')}}</p>
              <h3 class="card-title">{{$todaysTotalCheckIn}}
              </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> {{__('Just Updated')}}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">account_balance</i>
              </div>
              <p class="card-category">Check In Place</p>
              <h3 class="card-title">{{ $checkerBusStop->bus_stop }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> Bus Stop
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">directions_run</i>
              </div>
              <p class="card-category">{{__('Check In Place Route')}}</p>
              <h3 class="card-title">
                @if ($checkerBusStop->bus_route_type_name == 'departure')
                  {!! ucFirst($checkerBusRoute->departure_starting_place).' - '.ucFirst($checkerBusRoute->departure_ending_place) !!}
                @else
                {!! ucFirst($checkerBusRoute->return_starting_place).' - '.ucFirst($checkerBusRoute->return_ending_place) !!}
                @endif
              </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">local_offer</i> Route
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">supervisor_account</i>
            </div>
            <h4 class="card-title">{{ __('All Check In') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Staff') }}</th>
                    <th>{{ __('Student') }}</th>
                    <th>{{ __('Physically Disabled') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Action') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Staff') }}</th>
                    <th>{{ __('Student') }}</th>
                    <th>{{ __('Physically Disabled') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Action') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($checkIns as $key => $checkIn)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $checkIn->bus->bus_no !!}
                    </td>
                    <td>
                        {!! $checkIn->checkInPassenger->total !!}
                    </td>
                    <td>
                        {!! $checkIn->checkInPassenger->staff !!}
                    </td>
                    <td>
                        {!! $checkIn->checkInPassenger->student !!}
                    </td>
                    <td>
                        {!! $checkIn->checkInPassenger->physically_disabled !!}
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('checkIn.edit',$checkIn->id) }}">
                        <i class="material-icons">edit</i>
                      </a>                      
                    </td>
                  </tr>
                   @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush