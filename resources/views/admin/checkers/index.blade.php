@extends('layouts.app', ['activePage' => 'checkerCheckIn', 'titlePage' => __('Checker Check In')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">supervisor_account</i>
            </div>
            <h4 class="card-title">{{ __('Check In By ').$checker->name }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Check In Route') }}</th>
                    <th>{{ __('Check In Route Type') }}</th>
                    <th>{{ __('Check In Place') }}</th>
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Staff') }}</th>
                    <th>{{ __('Student') }}</th>
                    <th>{{ __('Physically Disabled') }}</th>
                    <th>{{ __('Income') }}</th>
                    <th>{{ __('Check In At') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Check In Route') }}</th>
                    <th>{{ __('Check In Route Type') }}</th>
                    <th>{{ __('Check In Place') }}</th>
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Staff') }}</th>
                    <th>{{ __('Student') }}</th>
                    <th>{{ __('Physically Disabled') }}</th>
                    <th>{{ __('Income') }}</th>
                    <th>{{ __('Check In At') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($checkIns as $key => $checkIn)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                      @if ($checkIn->busStop->bus_route_type_name == 'departure')
                        {!! ucFirst($checkIn->busStop->busRoute->departure_starting_place).' - '.ucFirst($checkIn->busStop->busRoute->departure_ending_place) !!}
                      @else
                      {!! ucFirst($checkIn->busStop->busRoute->return_starting_place).' - '.ucFirst($checkIn->busStop->busRoute->return_ending_place) !!}
                      @endif
                        
                    </td>
                    <td>
                        {!! ucFirst($checkIn->busStop->bus_route_type_name) !!}
                    </td>
                    <td>
                        {!! $checkIn->busStop->bus_stop !!}
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
                    <td>
                        {!! $checkIn->checkInPassenger->checkInIncome->income.' BDT' !!}
                    </td>
                    <td>{!! $checkIn->created_at->toFormattedDateString() !!}</td>
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

@endpush