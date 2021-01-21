@extends('layouts.app', ['activePage' => 'checkIn', 'titlePage' => __('Check In')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <form  action="{{ route('checkIn.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card ">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">how_to_reg</i>
              </div>
              <div>You Can Change Within <span id="time">05:00</span> minutes!</div>
              <h4 class="card-title">{{ __('Add New')}}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <label class="col-sm-3 col-form-label">{{__('Bus *')}}</label>
                <div class="col-sm-9">
                <select class="selectpicker @error('bus') is-invalid @enderror" id="bus" name="bus" data-style="select-with-transition" title="{{__('Bus')}}" required="true">
                  <option value disabled>{{__('Select One')}}</option>
                  @foreach ($buses as $bus)
                  <option value="{{$bus->id}}">{{$bus->bus_no}} </option>
                  @endforeach
                </select>
                @error('bus')
                <label class="error">{{ __($message) }}</label> 
                @enderror
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label" for="staff">{{__('Staff')}}</label>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="number" number="true" min="0" class="form-control @error('staff') is-invalid @enderror" placeholder="How much Staff" value="{{old('staff')}}" id="staff" name="staff">
                    @error('staff')
                    <label class="error">{{ __($message) }}</label> 
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label" for="student">{{__('Student')}}</label>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="number" number="true" min="0" class="form-control @error('student') is-invalid @enderror" placeholder="How much Student" value="{{old('student')}}" id="student" name="student" >
                    @error('student')
                    <label class="error">{{ __($message) }}</label> 
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label" for="physical">{{__('Physically Disabled')}}</label>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="number" number="true" min="0" class="form-control @error('physical') is-invalid @enderror" placeholder="How much Physically Disabled" value="{{old('physical')}}" id="physical" name="physical">
                    @error('physical')
                    <label class="error">{{ __($message) }}</label> 
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label" for="total">{{__('In Total *')}}</label>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="number" number="true" min="0" class="form-control @error('total') is-invalid @enderror" placeholder="How much in Total" value="{{old('total')}}" id="total" name="total" required="true">
                    @error('total')
                    <label class="error">{{ __($message) }}</label> 
                    @enderror
                  </div>
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
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Staff') }}</th>
                    <th>{{ __('Student') }}</th>
                    <th>{{ __('Physically Disabled') }}</th>
                    <th>{{ __('Check In At') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Bus No') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Staff') }}</th>
                    <th>{{ __('Student') }}</th>
                    <th>{{ __('Physically Disabled') }}</th>
                    <th>{{ __('Check In At') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($checkIns as $key => $checkIn)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $checkIn->bus->bus_no !!}
                    </td>
                    <td>
                        {!! $checkIn->checkInPassenger->total !!}
                    </td>
                    <td>
                        {!! $checkIn->checkInPassenger->staff !!}
                    </td>
                    <td>
                        {!! $checkIn->checkInPassenger->student !!}
                    </td>
                    <td>
                        {!! $checkIn->checkInPassenger->physically_disabled !!}
                    </td>
                    <td>{!! $checkIn->created_at->toFormattedDateString() !!}</td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('assignChecker.edit',$checkIn->id) }}">
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


@endpush