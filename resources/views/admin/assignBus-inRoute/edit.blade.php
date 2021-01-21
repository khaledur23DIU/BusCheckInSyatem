@extends('layouts.app', ['activePage' => 'editBusInRoute', 'titlePage' => __('Bus In Route Management')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <form id="busesInRouteValidation" action="{{ route('busInRoute.update',$busInRoute->id) }}" method="POST" enctype="multipart/form-data">
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
                <label class="col-sm-3 col-form-label">{{__('Bus *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker @error('bus') is-invalid @enderror" id="bus" name="bus" data-style="select-with-transition" title="{{__('Bus')}}" required="true">
                  <option disabled> {{__('Select One')}}</option>
                  @foreach ($buses as $bus)
                  <option {{$busInRoute->bus_id == $bus->id ? 'selected':''}} value="{{$bus->id}}">{{$bus->bus_no}} </option>
                  @endforeach
                </select>
                @error('bus')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Bus Route *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker @error('bus_route') is-invalid @enderror" id="bus_route" name="bus_route" data-style="select-with-transition" title="{{__('Bus Route')}}" required="true">
                  <option disabled> {{__('Select One')}}</option>
                  @foreach ($busRoutes as $route)
                  <option {{$busInRoute->bus_route_id == $route->id ? 'selected':''}} value="{{$route->id}}">{{$route->departure_starting_place.'-'.$route->departure_ending_place.'-'.$route->departure_starting_place}} </option>
                  @endforeach
                </select>
                @error('bus_route')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-success">{{__('Update')}}</button>
              <a href="{{ route('busInRoute.index') }}" class="btn btn-rose">{{__('Cancel')}}</a>
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
            <h4 class="card-title">{{ __('Buses In Route') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Bus Route') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Bus Route') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($busesInRoute as $key => $busInRoute)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $busInRoute->bus->bus_no !!}
                    </td>
                    <td>
                        {!! $busInRoute->busRoute->departure_starting_place.'-'.$busInRoute->busRoute->departure_ending_place.'&nbsp And &nbsp'.$busInRoute->busRoute->return_starting_place.'-'.$busInRoute->busRoute->return_ending_place !!}
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('busInRoute.edit',$busInRoute->id) }}">
                        <i class="material-icons">edit</i>
                      </a>
                      <a class="btn btn-danger btn-link btn-sm" onclick="deleteBusinRoute({{ $busInRoute->id }})">
                        <i class="danger material-icons">delete</i>
                      </a>
                        <form id="delete-form-{{ $busInRoute->id }}" action="{{ route('busInRoute.destroy',$busInRoute->id) }}" method="POST" style="display: none;">
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
        setFormValidation('#busesInRouteValidation');

      });
  </script>

  <script type="text/javascript">
      function deleteBusinRoute(id) {
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