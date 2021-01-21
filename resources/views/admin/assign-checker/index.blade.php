@extends('layouts.app', ['activePage' => 'assignChecker', 'titlePage' => __('Assign Checker Manageement')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <form id="assignCheckerValidation" action="{{ route('assignChecker.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card ">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">how_to_reg</i>
              </div>
              <h4 class="card-title">{{ __('Add New')}}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Bus Route *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker @error('bus_route') is-invalid @enderror" id="bus_route" name="bus_route" data-style="select-with-transition" title="{{__('Bus Route')}}" required="true">
                  <option disabled> {{__('Select One')}}</option>
                  @foreach ($busRoutes as $route)
                  <option value="{{$route->id}}">{{$route->departure_starting_place.'-'.$route->departure_ending_place.'-'.$route->departure_starting_place}} </option>
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
                  <option value="0" disabled> {{__('No Data Found')}} </option>
                </select>
                @error('bus_route_type')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Check In Place *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker checkInPlace @error('check_in_place') is-invalid @enderror" id="checkInPlace" name="check_in_place" data-style="select-with-transition" title="{{__('Select One')}}" required="true">
                  <option value="0" disabled> {{__('No Data Found')}} </option>
                </select>
                @error('check_in_place')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Bus *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker @error('checker') is-invalid @enderror" id="checker" name="checker" data-style="select-with-transition" title="{{__('Checker')}}" required="true">
                  <option disabled> {{__('Select One')}}</option>
                  @foreach ($checkers as $checker)
                  <option value="{{$checker->id}}">{{$checker->name}} </option>
                  @endforeach
                </select>
                @error('checker')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              
            </div>
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-success">{{__('Add')}}</button>
              <button type="reset" class="btn btn-rose">{{__('Reset')}}</button>
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
            <h4 class="card-title">{{ __('Checkes In Point') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Check In Place') }}</th>
                    <th>{{ __('Checker') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Check In Place') }}</th>
                    <th>{{ __('Checker') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($assignedCheckers as $key => $assignedChecker)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $assignedChecker->checkingPlace->bus_stop !!}
                    </td>
                    <td>
                        <a href="{{ route('checkInByChecker.checkIns',$assignedChecker->checker->id) }}">{!! $assignedChecker->checker->name !!}</a>
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('assignChecker.edit',$assignedChecker->id) }}">
                        <i class="material-icons">edit</i>
                      </a>
                      <a class="btn btn-danger btn-link btn-sm" onclick="deleteAssignChecker({{ $assignedChecker->id }})">
                        <i class="danger material-icons">delete</i>
                      </a>
                        <form id="delete-form-{{ $assignedChecker->id }}" action="{{ route('assignChecker.destroy',$assignedChecker->id) }}" method="POST" style="display: none;">
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
        setFormValidation('#assignCheckerValidation');

      });
  </script>

  <script type="text/javascript">
      function deleteAssignChecker(id) {
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

            $('#checkInPlace').empty();
            $('#checkInPlace').append(`<option value="0" disabled > {{__('No Data Found')}} </option>`);

            $('.busRouteType').selectpicker('refresh');
            $('.checkInPlace').selectpicker('refresh');
            
    
            
    });


            $('#busRouteType').on('change', function () {
            let busRouteType = $(this).val();
            var busRoute = $('#bus_route').val();
            $('#checkInPlace').empty();
            $('.checkInPlace').selectpicker('refresh');
            $('#checkInPlace').append(`<option disabled > {{__('Processing...')}} </option>`);
            if($('#busRouteType').val != '' && $('#bus_route').val != ''){
            $.ajax({
            type: 'GET',
            url: 'assign-checker/getCheckInPlace',
            data: { busRoute: busRoute, busRouteType: busRouteType },
            success: function (response) {
            var response = JSON.parse(response);
            $('#checkInPlace').empty();
            $('.checkInPlace').selectpicker('refresh');
            $('#checkInPlace').append(`<option value="0" disabled > {{__('Select')}} </option>`);
            response.forEach(element => {
                $('#checkInPlace').append(`<option value="${element['id']}">${element['bus_stop']}</option>`);
                });
            $('.checkInPlace').selectpicker('refresh');
            }
        });
            }
            else{
                $('.checkInPlace').selectpicker('refresh');
                $('#checkInPlace').append(`<option value="0" disabled > {{__('No Data Found')}} </option>`);  
            }
    });

  });
  </script>


@endpush