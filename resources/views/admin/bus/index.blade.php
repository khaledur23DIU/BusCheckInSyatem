@extends('layouts.app', ['activePage' => 'bus', 'titlePage' => __('Bus Management')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <form id="busValidation" action="{{ route('bus.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="bus_no" class="bmd-label-floating"> {{__('Bus NO.')}} *</label>
                <input type="text" class="form-control @error('bus_no') is-invalid @enderror" id="bus_no" name="bus_no" value="{{old('bus_no')}}" required="true" autofocus="bus_no">
                @error('bus_no')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="row">
                <div class="col-md-6">
                <select class="bmd-label-floating selectpicker @error('status') is-invalid @enderror" id="status" name="status" data-style="select-with-transition" title="{{__('Is Bus Running? *')}}" required="true">
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
            <h4 class="card-title">{{ __('Buses') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Is Running?') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Is Running?') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($buses as $key => $bus)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $bus->bus_no !!}
                    </td>
                    <td>
                      @if (!empty($bus->is_running))
                        @if ($bus->is_running == 1)
                        <span class="badge badge-pill badge-info">{{__('Yes')}}</span>
                        @else
                        <span class="badge badge-pill badge-warning">{{__('No')}}</span>
                        @endif
                      @else
                        <span class="badge badge-pill badge-rose">{{__('NA')}}</span>
                      @endif
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('bus.edit',$bus->id) }}">
                        <i class="material-icons">edit</i>
                      </a>
                      <a class="btn btn-danger btn-link btn-sm" onclick="deleteBus({{ $bus->id }})">
                        <i class="danger material-icons">delete</i>
                      </a>
                        <form id="delete-form-{{ $bus->id }}" action="{{ route('bus.destroy',$bus->id) }}" method="POST" style="display: none;">
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
        setFormValidation('#busValidation');
      });
  </script>

  <script type="text/javascript">
      function deleteBus(id) {
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