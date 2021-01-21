@extends('layouts.app', ['activePage' => 'roles', 'titlePage' => __('Roles And Permissions')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <form id="roleValidation" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="name" class="bmd-label-floating"> {{__('Role')}} *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" maxLength="20" id="name" name="name" value="{{old('name')}}" required="true">
                @error('name')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="form-group">
                <label for="permissions">{{__('Permissions')}} *</label>
                @error('permissions')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>{{__('Module Permission')}}</th>
                      <th>{{__('Create')}}</th>
                      <th>{{__('Read')}}</th>
                      <th>{{__('Update')}}</th>
                      <th>{{__('Delete')}}</th>
                    </tr>
                  </thead>
                  <tbody >
                    @foreach ($permissions as $module => $permissions)
                    <tr>
                      <td>{!! $module !!}</td>
                        <td>
                      @foreach ($permissions as $permission)
                      @if ($module.'-create' == $permission->name)
                        <label>
                          <input class="@error('permissions') is-invalid @enderror" type="checkbox" name="permissions[]" value="{{$permission->id}}" />
                          <span></span>
                        </label>
                      @endif
                      @endforeach
                      </td>
                      <td>
                      @foreach ($permissions as $permission)
                      @if ($module.'-list' == $permission->name)
                        <label>
                          <input class="@error('permissions') is-invalid @enderror" type="checkbox" name="permissions[]" value="{{$permission->id}}" />
                          <span></span>
                        </label>
                      @endif
                      @endforeach
                      </td>
                      <td>
                      @foreach ($permissions as $permission)
                      @if ($module.'-edit' == $permission->name)
                        <label>
                          <input class="@error('permissions') is-invalid @enderror" type="checkbox" name="permissions[]" value="{{$permission->id}}" />
                          <span></span>
                        </label>
                      @endif
                      @endforeach
                      </td>
                      <td>
                      @foreach ($permissions as $permission)
                      @if ($module.'-delete' == $permission->name)
                        <label>
                          <input class="@error('permissions') is-invalid @enderror" type="checkbox" name="permissions[]" value="{{$permission->id}}" />
                          <span></span>
                        </label>
                      @endif
                      @endforeach
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
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
            <h4 class="card-title">{{ __('Roles') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Guard') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Guard') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($roles as $key => $role)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $role->name !!}
                    </td>
                    <td>
                        {!! $role->guard_name !!}
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('roles.edit',$role->id) }}">
                        <i class="material-icons">edit</i>
                      </a>
                      <a class="btn btn-danger btn-link btn-sm" onclick="deleteRole({{ $role->id }})">
                        <i class="danger material-icons">delete</i>
                      </a>
                        <form id="delete-form-{{ $role->id }}" action="{{ route('roles.destroy',$role->id) }}" method="POST" style="display: none;">
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
          setFormValidation('#roleValidation');
        });
  </script>

  <script type="text/javascript">
      function deleteRole(id) {
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