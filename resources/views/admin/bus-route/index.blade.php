@extends('layouts.app', ['activePage' => 'busRoute', 'titlePage' => __('Bus Route Management')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <form id="busRouteValidation" action="{{ route('busRoute.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card ">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">how_to_reg</i>
              </div>
              <h4 class="card-title">{{ __('Add New')}}</h4>
            </div>
            <div class="card-body ">
              <div class="form-group">
                <label for="departure_starting_place" class="bmd-label-floating"> {{__('Departure Starting Place')}} *</label>
                <input type="text" class="form-control @error('departure_starting_place') is-invalid @enderror" maxLength="20" id="departure_starting_place" name="departure_starting_place" value="{{old('departure_starting_place')}}" required="true" autofocus="departure_starting_place">
                @error('departure_starting_place')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="form-group">
                <label for="departure_ending_place" class="bmd-label-floating"> {{__('Departure Ending Place')}} *</label>
                <input type="text" class="form-control @error('departure_ending_place') is-invalid @enderror" maxLength="20" id="departure_ending_place" name="departure_ending_place" value="{{old('departure_ending_place')}}" required="true" autofocus="departure_ending_place">
                @error('departure_ending_place')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="form-group">
                <label for="return_starting_place" class="bmd-label-floating"> {{__('Return Starting Place')}} *</label>
                <input type="text" class="form-control" maxLength="20" readonly="true" disabled="true" id="return_starting_place" name="return_starting_place" value="{{old('return_starting_place')}}" autofocus="return_starting_place">
              </div>
              <div class="form-group">
                <label for="return_ending_place" class="bmd-label-floating"> {{__('Return Ending Place')}} *</label>
                <input type="text" class="form-control" maxLength="20" readonly="true" disabled="true" id="return_ending_place" name="return_ending_place" value="{{old('return_ending_place')}}" autofocus="return_ending_place">
              </div>
              <div class="row">
                <div class="col-md-6">
                <select class="bmd-label-floating selectpicker @error('status') is-invalid @enderror" id="status" name="status" data-style="select-with-transition" title="{{__('Is Route Active? *')}}" required="true">
                  <option disabled> {{__('Select One')}}</option>
                  <option value="1">{{('Yes')}} </option>
                  <option value="0">{{('No')}}</option>
                </select>
                @error('status')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
            </div>
            <div class="card-footer ml-auto mr">
              <button type="submit" class="btn btn-success">{{__('Add')}}</button>
              <button type="reset" class="btn btn-rose">{{__('Reset')}}</button>
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
            <h4 class="card-title">{{ __('Bus Routes') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Departure Route') }}</th>
                    <th>{{ __('Return Route') }}</th>
                    <th>{{ __('Is Route Active?') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Departure Route') }}</th>
                    <th>{{ __('Return Route') }}</th>
                    <th>{{ __('Is Route Active?') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($busRoutes as $key => $busRoute)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $busRoute->departure_starting_place.'&nbsp - &nbsp'.$busRoute->departure_ending_place !!}
                    </td>
                    <td>
                        {!! $busRoute->return_starting_place.'&nbsp - &nbsp'.$busRoute->return_ending_place !!}
                    </td>
                    <td>
                      @if (!empty($busRoute->is_active))
                        @if ($busRoute->is_active == 1)
                        <span class="badge badge-pill badge-info">{{__('Yes')}}</span>
                        @else
                        <span class="badge badge-pill badge-warning">{{__('No')}}</span>
                        @endif
                      @else
                        <span class="badge badge-pill badge-rose">{{__('NA')}}</span>
                      @endif
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('busRoute.edit',$busRoute->id) }}">
                        <i class="material-icons">edit</i>
                      </a>
                      <a class="btn btn-danger btn-link btn-sm" onclick="deleteBusRoute({{ $busRoute->id }})">
                        <i class="danger material-icons">delete</i>
                      </a>
                        <form id="delete-form-{{ $busRoute->id }}" action="{{ route('busRoute.destroy',$busRoute->id) }}" method="POST" style="display: none;">
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
        setFormValidation('#busRouteValidation');

        $('input[name="departure_starting_place"]').change(function() {
          $('input[name="return_ending_place"]').val($(this).val());
        });

        $('input[name="departure_ending_place"]').change(function() {
          $('input[name="return_starting_place"]').val($(this).val());
        });

      });
  </script>

  <script type="text/javascript">
      function deleteBusRoute(id) {
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