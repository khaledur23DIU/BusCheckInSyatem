@extends('layouts.app', ['activePage' => 'editBusStop', 'titlePage' => __('Bus Stops Management')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <form id="busStopsValidation" action="{{ route('busStop.update',$busStop->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card ">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">how_to_reg</i>
              </div>
              <h4 class="card-title">{{ __('Edit')}}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Bus Route *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker @error('bus_route') is-invalid @enderror" id="bus_route" name="bus_route" data-style="select-with-transition" title="{{__('Bus Route')}}" required="true">
                  <option disabled> {{__('Select One')}}</option>
                  @foreach ($busRoutes as $route)
                  <option {{$busStop->bus_route_id == $route->id ? 'selected':''}} value="{{$route->id}}">{{$route->departure_starting_place.'-'.$route->departure_ending_place.'-'.$route->departure_starting_place}} </option>
                  @endforeach
                </select>
                @error('bus_route')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Bus Route Type*')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker @error('bus_route_type') is-invalid @enderror" id="bus_route_type" name="bus_route_type" data-style="select-with-transition" title="{{__('Bus Route Type')}}" required="true">
                  <option disabled> {{__('Select One')}}</option>
                  <option {{$busStop->bus_route_type == 1 ? 'selected' :''}} value="1">{{__('Departure')}}</option>
                  <option {{$busStop->bus_route_type == 2 ? 'selected' :''}} value="2">{{__('Return')}}</option>
                </select>
                @error('bus_route_type')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Bus Stop *')}}</label>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="text" class="form-control @error('bus_stop') is-invalid @enderror" placeholder="Bus Stop" id="bus_stop" name="bus_stop" required="true" value="{{$busStop->bus_stop}}">
                    @error('bus_stop')
                    <label class="error">{{ __($message) }}</label> 
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-success">{{__('Update')}}</button>
              <a href="{{ route('busStop.index') }}" class="btn btn-rose">{{__('Cancel')}}</a>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-7">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">supervisor_account</i>
            </div>
            <h4 class="card-title">{{ __('Bus Stops') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Bus Route') }}</th>
                    <th>{{ __('Bus Stop') }}</th>
                    <th>{{ __('Bus Route Type') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Bus Route') }}</th>
                    <th>{{ __('Bus Stop') }}</th>
                    <th>{{ __('Bus Route Type') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($busStops as $key => $busStop)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $busStop->busRoute->departure_starting_place.'-'.$busStop->busRoute->departure_ending_place.'-'.$busStop->busRoute->departure_starting_place !!}
                    </td>
                    <td>
                        {!! $busStop->bus_stop !!}
                    </td>
                    <td>
                        {!! ucfirst($busStop->bus_route_type_name) !!}
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('busStop.edit',$busStop->id) }}">
                        <i class="material-icons">edit</i>
                      </a>
                      <a class="btn btn-danger btn-link btn-sm" onclick="deleteBusStop({{ $busStop->id }})">
                        <i class="danger material-icons">delete</i>
                      </a>
                        <form id="delete-form-{{ $busStop->id }}" action="{{ route('busStop.destroy',$busStop->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
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
        setFormValidation('#busStopsValidation');
      });
  </script>
  <script type="text/javascript">
      function deleteBusStop(id) {
          swal({
              title: "{{__('Are you sure?')}}",
              text: "{{__('You wont be able to revert this!')}}",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: "{{('Yes, delete it!')}}",
              cancelButtonText: "{{('No, cancel!')}}",
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
              reverseButtons: false
          }).then((result) => {
              if (result.value) {
                  event.preventDefault();
                  document.getElementById('delete-form-'+id).submit();
              } else if (
                  result.dismiss === swal.DismissReason.cancel
              ) {
                  swal(
                      "{{__('Cancelled')}}",
                      "{{__('Your data is safe :)')}}",
                      "{{__('error')}}"
                  )
              }
          })
      }
  </script>
@endpush