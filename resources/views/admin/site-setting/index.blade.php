@extends('layouts.app', ['activePage' => 'siteSetting', 'titlePage' => __('Site Settings')])

@section('content')
  <div class="content">
  <div class="container-fluid">
      <div class="col-md-12 ml-auto mr-auto">
        <div class="page-categories">
          <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#general" role="tablist">
                <i class="material-icons">brightness_low</i> {{__('General')}}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#meta" role="tablist">
                <i class="material-icons">api</i> {{__('Meta Settings')}}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#mail-service" role="tablist">
                <i class="material-icons">alternate_email</i> {{__('Mail Settings')}}
              </a>
            </li>
          </ul>
          <div class="tab-content tab-space tab-subcategories">
            <div class="tab-pane active" id="general">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">{{__('All General Settings')}}</h4>
                </div>
                  <form class="formValidate" method="POST" action="{{ route('siteSetting.updateBasicInfo') }}" enctype="multipart/form-data">
                    <div class="card-body">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                          <label for="site_name">{{ __('Site Name') }}</label>
                          <input id="site_name" name="site_name" type="text" value="{{$settings->site_name}}" class="form-control @error('site_name') is-invalid @enderror">
                          @error('site_name')
                          <label class="error">{{ __($message) }}</label>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <label for="email">{{ __('Site Email Address') }}</label>
                          <input id="email" type="email" name="site_email" class="form-control @error('site_email') is-invalid @enderror" value="{{$settings->site_email}}">
                          @error('site_email')
                          <small class="red-text errorTxt2">{{ __($message) }}</small>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <input id="site_address" name="site_address" type="url" value="{{$settings->site_address}}" class="form-control @error('site_address') is-invalid @enderror">
                          <label for="site_address">{{ __('Site URL') }}</label>
                          @error('site_address')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      
                      <div class="form-group">
                          <label for="footer_text">{{ __('Footer Text') }}</label>
                          <input id="footer_text" name="footer_text" type="text" value="{!!$settings->footer_text!!}" class="form-control @error('footer_text') is-invalid @enderror" data-error=".errorTxt2">
                          <small class="red-text errorTxt2"></small>
                          @error('footer_text')
                          <small class="red-text errorTxt2">{{ __($message) }}</small>
                          @enderror
                      </div>
                      
                        <div class="form-group">
                          <label for="site_description">{{ __('Site Description') }}</label>
                          <textarea class="form-control @error('site_description') is-invalid @enderror" id="site_description" name="site_description"
                            placeholder="{{__('Site description here...')}}">{!! $settings->site_description !!}</textarea>
                          @error('site_description')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      <div class="ml-auto mr-auto">
                        <button type="submit" class="btn btn-success">{{__('Save changes')}}</button>
                        <button type="reset" class="btn btn-rose">{{__('Cancel')}}</button>
                      </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="tab-pane" id="meta">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">{{__('Site Meta Settings')}}</h4>
                </div>
                <div class="card-body">
                  <form class="paaswordvalidate" action="{{ route('siteSetting.updateMeta')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                      
                        <div class="form-group">
                          <label for="meta_title">{{ __('Site Meta Title') }}</label>
                          <input id="meta_title" name="meta_title" type="text" value="{{$settings->meta_title}}" class="form-control @error('meta_title') is-invalid @enderror" data-error=".errorTxt2">
                          <small class="red-text errorTxt2"></small>
                          @error('meta_title')
                          <small class="red-text errorTxt2">{{ __($message) }}</small>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <label for="meta_description">{{ __('Site Meta Description') }}</label>
                          <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description"
                            placeholder="{{__('Site meta description here...')}}">{!! $settings->meta_description !!}</textarea>
                          @error('meta_description')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      <div class="ml-auto mr-auto">
                        <button type="submit" class="btn btn-success">{{__('Save changes')}}</button>
                        <button type="reset" class="btn btn-rose">{{__('Cancel')}}</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="mail-service">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">{{__('Site Mail Service Settings')}}</h4>
                </div>
                <div class="card-body">
                  <form class="infovalidate" action="{{ route('siteSetting.updateMailService') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                      
                        <div class="form-group">
                          <label for="driver">{{__('Mail Driver')}}</label>
                          <input id="driver" name="driver" value="{{$mailSettings->driver}}" type="text" class="form-control @error('driver') is-invalid @enderror">
                          @error('driver')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <label for="host">{{__('Mail Host')}}</label>
                          <input id="host" name="host" value="{{$mailSettings->host}}" type="text" class="form-control @error('host') is-invalid @enderror">
                          @error('host')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <label for="port">{{__('Mail Port')}}</label>
                          <input id="port" name="port" value="{{$mailSettings->port}}" type="number" min="0" class="form-control @error('port') is-invalid @enderror">
                          @error('port')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <label for="username">{{__('User Name')}}</label>
                          <input id="username" name="username" value="{{$mailSettings->username}}" type="text" class="form-control @error('username') is-invalid @enderror">
                          @error('username')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <label for="password">{{__('Password')}}</label>
                          <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror">
                          @error('password')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <label for="mail_encryption">{{__('Encryption Type')}}</label>
                          <input id="mail_encryption" name="mail_encryption" value="{{$mailSettings->mail_encryption}}" type="text" class="form-control @error('mail_encryption') is-invalid @enderror">
                          @error('mail_encryption')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <label for="from_address">{{__('From Address')}}</label>
                          <input id="from_address" name="from_address" value="{{$mailSettings->from_address}}" type="text" class="form-control @error('from_address') is-invalid @enderror">
                          @error('from_address')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      
                        <div class="form-group">
                          <label for="from_name">{{__('From Name')}}</label>
                          <input id="from_name" name="from_name" value="{{$mailSettings->from_name}}" type="text" class="form-control @error('from_name') is-invalid @enderror">
                          @error('from_name')
                          <label class="error">{{__($message)}}</label>
                          @enderror
                        </div>
                      <div class=" ml-auto mr-auto">
                        <button type="submit" class="btn btn-success">{{__('Save changes')}}</button>
                        <button type="reset" class="btn btn-rose ">{{__('Cancel')}}</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@push('js')

@endpush