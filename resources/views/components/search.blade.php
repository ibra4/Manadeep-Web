@php
    $target_route = (isset($isFavorite) && $isFavorite) ? 'realestates.favorite' : 'realestates.index';
@endphp
<!-- ======= Property Search Section ======= -->
<div class="click-closed"></div>
<!--/ Form Search Star /-->
<div class="box-collapse">
    <div class="title-box-d">
        <h3 class="title-d">{{ __('Search Real Estate') }}</h3>
    </div>
    <span class="close-box-collapse right-boxed ion-ios-close"></span>
    <div class="box-collapse-wrap form">
        <form class="form-a">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        <input value="{{ request('title') }}" id="title" name="title" type="text"
                            class="form-control form-control-lg form-control-a" placeholder="{{ __('Keyword') }}">
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-group">
                        <label for="">{{ __('Offer Type') }}</label>
                        <select class="form-control form-control-lg form-control-a" id="offerType" name="offerType">
                            <option {{ !request('offerType') ? 'selected' : '' }} value="">{{ __('Any') }}
                            </option>
                            <option {{ request('offerType') == 'rent' ? 'selected' : '' }} value="rent">
                                {{ __('For rent') }}
                            </option>
                            <option {{ request('offerType') == 'sale' ? 'selected' : '' }} value="sale">
                                {{ __('For sale') }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-group">
                        <label for="">{{ __('Commision') }}</label>
                        <select class="form-control form-control-lg form-control-a" id="tax" name="tax">
                            <option {{ request('tax') == null ? 'selected' : '' }} value="">{{ __('Any') }}
                            </option>
                            <option {{ request('tax') == '1' ? 'selected' : '' }} value="1">
                                {{ __('With commision') }}
                            </option>
                            <option {{ request('tax') == '0' ? 'selected' : '' }} value="0">
                                {{ __('Without commision') }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-group">
                        <input value="{{ request('rooms') }}" id="rooms" name="rooms" type="number"
                            class="form-control form-control-lg form-control-a" placeholder="{{ __('Bedrooms') }}">
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-group">
                        <input value="{{ request('baths') }}" id="baths" name="baths" type="number"
                            class="form-control form-control-lg form-control-a" placeholder="{{ __('Bathrooms') }}">
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-group">
                        <input value="{{ request('parkings') }}" id="parkings" name="parkings" type="number"
                            class="form-control form-control-lg form-control-a" placeholder="{{ __('Garages') }}">
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-group">
                        <input value="{{ request('price') }}" id="price" name="price" type="number"
                            class="form-control form-control-lg form-control-a" placeholder="{{ __('Min Price') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <button id="search" class="btn btn-b">{{ __('Search') }}</button>
                    <a href="{{ route($target_route, app()->getLocale()) }}"
                        class="btn btn-b btn-danger">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>
    </div>
</div><!-- End Property Search Section -->
<script>
    $('#search').click(function(e) {
        e.preventDefault()
        let searchString = ''
        let filtersArray = ['offerType', 'tax', 'parkings', 'rooms', 'baths', 'price', 'title']
        filtersArray.map(function(item) {
            searchString += $('#' + item).val() ? '&' + item + '=' + $('#' + item).val() : ''
        })
        let route = ''
        if ("{{ isset($isFavorite) && $isFavorite }}") {
            route = "{{ route('realestates.favorite', app()->getLocale()) }}"
        } else {
            route = "{{ route('realestates.index', app()->getLocale()) }}"
        }
        window.location = route + "?" + searchString.substring(
            1)
    })

</script>
