@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    <div class="card mb-5">
                        <div class="card-header">{{ __('Cost') }}</div>

                        <div class="card-body">

                            <div class="form-group row">
                                <label for="cost_less_10"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cost less than 10') }}</label>

                                <div class="col-md-6">
                                    <input id="cost_less_10" type="text" class="form-control" name="cost_less_10"
                                        value="{{ $settings->cost_less_10 }}" required autocomplete="cost_less_10"
                                        autofocus>

                                    @error('cost_less_10')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $settings->cost_less_10 }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cost_10_25"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cost between 10 and 25') }}</label>

                                <div class="col-md-6">
                                    <input id="cost_10_25" type="text" class="form-control" name="cost_10_25"
                                        value="{{ $settings->cost_10_25 }}" required autocomplete="cost_10_25" autofocus>

                                    @error('cost_10_25')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $settings->cost_10_25 }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cost_25_55"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cost between 25 and 55') }}</label>

                                <div class="col-md-6">
                                    <input id="cost_25_55" type="text" class="form-control" name="cost_25_55"
                                        value="{{ $settings->cost_25_55 }}" required autocomplete="cost_25_55" autofocus>

                                    @error('cost_25_55')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $settings->cost_25_55 }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cost_more_55"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Cost more than 55') }}</label>

                                <div class="col-md-6">
                                    <input id="cost_more_55" type="text" class="form-control" name="cost_more_55"
                                        value="{{ $settings->cost_more_55 }}" required autocomplete="cost_more_55"
                                        autofocus>

                                    @error('cost_more_55')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $settings->cost_more_55 }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card mb-5">
                        <div class="card-header">{{ __('General Settings') }}</div>

                        <div class="card-body">
                            <div class="form-group row">
                                <label for="another"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Another') }}</label>

                                <div class="col-md-6">
                                    <input id="another" type="text" class="form-control" name="another"
                                        value="{{ isset($settings->another) ? $settings->another : '' }}" required autocomplete="another"
                                        autofocus>

                                    @error('another')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $settings->another }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg">{{ __('Update site settings') }}</button>
                </form>

            </div>
        </div>
    </div>
@endsection
