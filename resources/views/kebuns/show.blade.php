@extends('layouts.app')

@section('title', __('kebun.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('kebun.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('kebun.name') }}</td><td>{{ $kebun->name }}</td></tr>
                        <tr><td>{{ __('kebun.address') }}</td><td>{{ $kebun->address }}</td></tr>
                        <tr><td>{{ __('kebun.latitude') }}</td><td>{{ $kebun->latitude }}</td></tr>
                        <tr><td>{{ __('kebun.longitude') }}</td><td>{{ $kebun->longitude }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $kebun)
                    <a href="{{ route('kebuns.edit', $kebun) }}" id="edit-kebun-{{ $kebun->id }}" class="btn btn-warning">{{ __('kebun.edit') }}</a>
                @endcan
                @if(auth()->check())
                    <a href="{{ route('kebuns.index') }}" class="btn btn-link">{{ __('kebun.back_to_index') }}</a>
                @else
                    <a href="{{ route('kebun_map.index') }}" class="btn btn-link">{{ __('kebun.back_to_index') }}</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ trans('kebun.location') }}</div>
            @if ($kebun->coordinate)
            <div class="card-body" id="mapid"></div>
            @else
            <div class="card-body">{{ __('kebun.no_coordinate') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 400px; }
</style>
@endsection
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<script>
    var map = L.map('mapid').setView([{{ $kebun->latitude }}, {{ $kebun->longitude }}], {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([{{ $kebun->latitude }}, {{ $kebun->longitude }}]).addTo(map)
        .bindPopup('{!! $kebun->map_popup_content !!}');
</script>
@endpush
