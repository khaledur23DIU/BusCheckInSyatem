@extends('layouts.app', ['activePage' => 'editTicketPrice', 'titlePage' => __('Ticket Price Management')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <form id="ticketPriceValidation" action="{{ route('ticketPrice.update',$ticketPrice) }}" method="POST" enctype="multipart/form-data">
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
                  <option {{$ticketPrice->bus_route_id == $route->id ? 'selected':''}} value="{{$route->id}}">{{$route->departure_starting_place.'-'.$route->departure_ending_place.'-'.$route->departure_starting_place}} </option>
                  @endforeach
                </select>
                @error('bus_route')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Departure / Return Route *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker busRouteType @error('bus_route_type') is-invalid @enderror" id="busRouteType" name="bus_route_type" data-style="select-with-transition" title="{{__('Select One')}}" required="true">
                  <option {{$ticketPrice->fromWhere->bus_route_type == 1 ? 'selected' :''}} value="1"> {{__('Departure')}} </option>
                  <option {{$ticketPrice->fromWhere->bus_route_type == 2 ? 'selected' :''}} value="2"> {{__('Return')}} </option>
                </select>
                @error('bus_route_type')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('From Where *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker fromWhere @error('from_where') is-invalid @enderror" id="fromWhere" name="from_where" data-style="select-with-transition" title="{{__('Select One')}}" required="true">
                  @foreach ($ticketPrice->busRoute->busStops->where('bus_route_type',$ticketPrice->fromWhere->bus_route_type) as $busStop)
                  <option {{$ticketPrice->from_where == $busStop->id ?'selected':''}} value="{{$busStop->id}}">{{$busStop->bus_stop}}</option>
                  @endforeach
                </select>
                @error('from_where')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('To Where *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker toWhere @error('to_where') is-invalid @enderror" id="toWhere" name="to_where" data-style="select-with-transition" title="{{__('Select One')}}" required="true">
                  @foreach ($ticketPrice->busRoute->busStops->where('id','!=',$ticketPrice->from_where)->where('bus_route_type',$ticketPrice->fromWhere->bus_route_type) as $busStop)
                  <option {{$ticketPrice->to_where == $busStop->id ?'selected':''}} value="{{$busStop->id}}">{{$busStop->bus_stop}}</option>
                  @endforeach
                </select>
                @error('to_where')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Ticket Price *')}}</label>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="number" number="true" min="1" class="form-control @error('price') is-invalid @enderror" placeholder="e.g. 50" id="price" name="price" value="{{$ticketPrice->price}}" required="true">
                    @error('price')
                    <label class="error">{{ __($message) }}</label> 
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-success">{{__('Update')}}</button>
              <a href="{{ route('ticketPrice.index') }}" class="btn btn-rose">{{__('Cancel')}}</a>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">supervisor_account</i>
            </div>
            <h4 class="card-title">{{ __('Ticket Prices') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Route') }}</th>
                    <th>{{ __('From-To') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Route') }}</th>
                    <th>{{ __('From-To') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($ticketPrices as $key => $price)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $price->busRoute->departure_starting_place.'-'.$price->busRoute->departure_ending_place.'-'.$price->busRoute->departure_starting_place !!}
                    </td>
                    <td>
                        {!! $price->fromWhere->bus_stop.'&nbsp - &nbsp'.$price->toWhere->bus_stop !!}
                    </td>
                    <td>
                        {!! $price->price !!}
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('ticketPrice.edit',$price->id) }}">
                        <i class="material-icons">edit</i>
                      </a>
                      <a class="btn btn-danger btn-link btn-sm" onclick="deleteTicketPrice({{ $price->id }})">
                        <i class="danger material-icons">delete</i>
                      </a>
                        <form id="delete-form-{{ $price->id }}" action="{{ route('ticketPrice.destroy',$price->id) }}" method="POST" style="display: none;">
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
        setFormValidation('#ticketPriceValidation');

      });
  </script>

  <script type="text/javascript">
      function deleteTicketPrice(id) {
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
  <script>
    $(document).ready(function () {


          $('#bus_route').on('change', function () {
            
            $('#busRouteType').empty();
            $('#busRouteType').append(`<option value="1"> {{__('Departure')}} </option>`);
            $('#busRouteType').append(`<option value="2"> {{__('Return')}} </option>`);
            
            $('#fromWhere').empty();
            $('#fromWhere').append(`<option value="0" disabled > {{__('No Data Found')}} </option>`);
            $('#toWhere').empty();
            $('#toWhere').append(`<option value="0" disabled > {{__('No Data Found')}} </option>`);

            $('.busRouteType').selectpicker('refresh');
            $('.fromWhere').selectpicker('refresh');
            $('.toWhere').selectpicker('refresh');
            
    
            
    });


            $('#busRouteType').on('change', function () {
            let busRouteType = $(this).val();
            var busRoute = $('#bus_route').val();
            $('#fromWhere').empty();
            $('#fromWhere').append(`<option disabled > {{__('Processing...')}} </option>`);
            $('.fromWhere').selectpicker('refresh');
            if($('#busRouteType').val != ''){
            $.ajax({
            type: 'GET',
            url: 'ticket-price/getBusStopFromWhere',
            data: { busRoute: busRoute, busRouteType: busRouteType},
            success: function (response) {
            var response = JSON.parse(response); 
            
            $('#fromWhere').empty();
            $('.fromWhere').selectpicker('refresh');
            $('#fromWhere').append(`<option value="0" disabled > {{__('Select')}} </option>`);
            response.forEach(element => {
                $('#fromWhere').append(`<option value="${element['id']}">${element['bus_stop']}</option>`);
                });
            $('.fromWhere').selectpicker('refresh');
            }
        });
            }
            else{
                $('.fromWhere').selectpicker('refresh');
                $('#fromWhere').append(`<option value="0" disabled > {{__('No Data Found')}} </option>`);  
            }
    });

            $('#fromWhere').on('change', function () {
            let fromWhere = $(this).val();
            var busRoute = $('#bus_route').val();
            var busRouteType = $('#busRouteType').val();
            $('#toWhere').empty();
            $('#toWhere').append(`<option value="0" disabled > {{__('Processing...')}} </option>`);
            $('.toWhere').selectpicker('refresh');
            if($('#fromWhere').val != ''){
            $.ajax({
            type: 'GET',
            url: 'ticket-price/getBusStopToWhere',
            data: { busRoute: busRoute, fromWhere: fromWhere, busRouteType: busRouteType },
            success: function (response) {
            var response = JSON.parse(response); 
            
            $('#toWhere').empty();
            $('.toWhere').selectpicker('refresh');
            $('#toWhere').append(`<option value="0" disabled > {{__('Select')}} </option>`);
            response.forEach(element => {
                $('#toWhere').append(`<option value="${element['id']}">${element['bus_stop']}</option>`);
                });
            $('.toWhere').selectpicker('refresh');
            }
        });
            }
            else{
                $('.toWhere').selectpicker('refresh');
                $('#toWhere').append(`<option value="0" disabled > {{__('No Data Found')}} </option>`);  
            }
    });

  });
  </script>
  <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
@endpush