@extends('layouts.app', ['activePage' => 'checkerComplain', 'titlePage' => __('My Complains')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <form id="checkInValidation" action="{{ route('checkerComplain.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">how_to_reg</i>
              </div>
              <h4 class="card-title">{{ __('Add New')}}</h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="title">{{__('Title')}}</label>
                <input type="text" minLength="5" maxLength="255" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}" placeholder="Your Complain Title Here..." id="title" name="title">
                @error('title')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>
              <div class="form-group">
                <label for="body">{{__('Complain')}}</label>
                <textarea class="form-control @error('body') is-invalid @enderror" minLength="5" id="body" placeholder="Your Complain Here..." name="body" rows="6">{{old('body')}}</textarea>
                @error('body')
                <label class="error">{{ __($message) }}</label> 
                @enderror
              </div>       
            </div>
            <div class="card-footer ml-auto mr-auto">
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
            <h4 class="card-title">{{ __('My Complains') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('Title') }}</th>
                    <th class="disabled text-right">{{ __('Is Active?') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('Title') }}</th>
                    <th class="text-right">{{ __('Is Active?') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($complains as $complain)
                  <tr>
                    <td>
                        {!! Str::words($complain->title, 9, ' ...') !!}
                    </td>
                    <td class="text-right">
                      @if ($complain->is_seen == 0)
                      <span class="badge badge-pill badge-info">{{__("Active")}}</span>
                      @else
                      <span class="badge badge-pill badge-success">{{__("Seen")}}</span>
                      @endif
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('checkerComplain.show',$complain->id) }}">
                        <i class="material-icons">remove_red_eye</i>
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
        setFormValidation('#checkInValidation');

      });
  </script>

@endpush