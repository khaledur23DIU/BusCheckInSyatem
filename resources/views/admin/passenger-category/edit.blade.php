@extends('layouts.app', ['activePage' => 'editPassengerCat', 'titlePage' => __('Passenger Category Management')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <form id="passengerValidation" action="{{ route('passengerCategory.update',$passCategory->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card ">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">how_to_reg</i>
              </div>
              <h4 class="card-title">{{ __('Edit')}}</h4>
            </div>
            <div class="card-body ">
              <div class="form-group">
                <label for="passenger_category" class="bmd-label-floating"> {{__('Passenger Category Name')}} *</label>
                <input type="text" class="form-control @error('passenger_category') is-invalid @enderror" id="passenger_category" name="passenger_category" readonly="true" disabled="true" value="{{$passCategory->passenger_category}}" required="true" autofocus="passenger_category">
                @error('passenger_category')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                  <label for="cost_in_percentage" class="bmd-label-floating"> {{__('Cost In Percentage')}} *</label>
                  <input type="number" class="form-control @error('cost_in_percentage') is-invalid @enderror" range="[0,100]" number="true" id="cost_in_percentage" name="cost_in_percentage" value="{{$passCategory->cost_in_percentage}}" placeholder="e.g. 50" required="true" autofocus="cost_in_percentage">
                  @error('cost_in_percentage')
                  <label class="error">{{ __($message) }}</label> 
                  @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer ml-auto mr">
              <button type="submit" class="btn btn-success">{{__('Update')}}</button>
              <a href="{{ route('passengerCategory.index') }}" class="btn btn-rose">{{__('Cancel')}}</a>
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
            <h4 class="card-title">{{ __('Passengers Categories') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Passenger Category') }}</th>
                    <th>{{ __('Cost In Percentage') }}</th>
                    <th>{{ __('Updated At') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Passenger Category') }}</th>
                    <th>{{ __('Cost In Percentage') }}</th>
                    <th>{{ __('Updated At') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($passCategories as $key => $category)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $category->passenger_category !!}
                    </td>
                    <td>
                        {!! $category->cost_in_percentage.' %' !!}
                    </td>
                    <td>{!! $category->updated_at->toFormattedDateString() !!}</td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('passengerCategory.edit',$category->id) }}">
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
        setFormValidation('#passengerValidation');
      });
  </script>

  <script type="text/javascript">
      function deletePassCategory(id) {
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