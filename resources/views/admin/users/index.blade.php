@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('User Management')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <form id="userValidation" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="name" class="bmd-label-floating"> {{__('User Name')}} *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required="true" autofocus="name">
                @error('name')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="form-group">
                <label for="email" class="bmd-label-floating"> {{__('Email Address')}} *</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required="true">
                @error('email')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="form-group">
                <label for="password" class="bmd-label-floating"> {{__('Password')}} *</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" required="true" name="password">
                @error('password')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="form-group">
                <label for="confirm-password" class="bmd-label-floating"> {{__('Confirm Password')}} *</label>
                <input type="password" class="form-control @error('confirm-password') is-invalid @enderror" id="confirm-password" required="true" equalTo="#password" name="confirm-password">
                @error('confirm-password')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="row">
                <div class="col-md-6">
                <select class="bmd-label-floating selectpicker @error('roles') is-invalid @enderror" id="roles" name="roles[]" data-style="select-with-transition" multiple title="{{__('Choose Roles *')}}" data-size="5" required="true">
                  <option disabled> {{__('Select Roles')}}</option>
                  @foreach ($roles as $role)  
                    <option value="{{$role->id}}"> {!! ($role->name) !!} </option>
                  @endforeach
                </select>
                @error('roles')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
                <div class="col-md-6">
                <select class="bmd-label-floating selectpicker @error('status') is-invalid @enderror" id="status" name="status" data-style="select-with-transition" title="{{__('Choose Account Status *')}}" required="true">
                  <option disabled> {{__('Select One')}}</option>
                  <option value="1">{{('Active')}} </option>
                  <option value="0">{{('Close')}}</option>
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
            <h4 class="card-title">{{ __('Users') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Roles') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Roles') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($users as $key => $user)
                  <tr>
                    <td>
                        {!! $user->name !!}
                    </td>
                    <td>
                        {!! $user->email !!}
                    </td>
                    <td>
                      @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $role)
                        <span class="badge badge-pill badge-info">{!! $role !!}</span>
                        @endforeach
                      @endif
                    </td>
                    <td>
                      @if (!empty($user->profile))
                        @if ($user->profile->account_status == 1)
                        <span class="badge badge-pill badge-info">{{__("Active")}}</span>
                        @else
                        <span class="badge badge-pill badge-warning">{{__("Inactive")}}</span>
                        @endif
                      @else
                        <span class="badge badge-pill badge-rose">{{__("NA")}}</span>
                      @endif
                    </td>
                    <td class="td-actions text-right">
                      <a {{-- rel="tooltip" title="Edit" --}} class="btn btn-primary btn-link btn-sm" href="{{ route('users.edit',$user->id) }}">
                        <i class="material-icons">edit</i>
                      </a>
                      <a {{-- rel="tooltip" title="Delete" --}} class="btn btn-danger btn-link btn-sm" onclick="deleteUser({{ $user->id }})">
                        <i class="danger material-icons">delete</i>
                      </a>
                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy',$user->id) }}" method="POST" style="display: none;">
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
        setFormValidation('#userValidation');
      });
  </script>

  <script type="text/javascript">
      function deleteUser(id) {
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