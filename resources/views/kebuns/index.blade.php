@extends('layouts.app')

@section('title', __('kebun.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Kebun)
            <a href="{{ route('kebuns.create') }}" class="btn btn-success">{{ __('kebun.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('kebun.list') }} <small>{{ __('app.total') }} : {{ $kebuns->total() }} {{ __('kebun.kebun') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="control-label">{{ __('kebun.search') }}</label>
                        <input placeholder="{{ __('kebun.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('kebun.search') }}" class="btn btn-secondary">
                    <a href="{{ route('kebuns.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('kebun.name') }}</th>
                        <th>{{ __('kebun.address') }}</th>
                        <th>{{ __('kebun.latitude') }}</th>
                        <th>{{ __('kebun.longitude') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kebuns as $key => $kebun)
                    <tr>
                        <td class="text-center">{{ $kebuns->firstItem() + $key }}</td>
                        <td>{!! $kebun->name_link !!}</td>
                        <td>{{ $kebun->address }}</td>
                        <td>{{ $kebun->latitude }}</td>
                        <td>{{ $kebun->longitude }}</td>
                        <td class="text-center">
                            <a href="{{ route('kebuns.show', $kebun) }}" id="show-kebun-{{ $kebun->id }}">{{ __('app.show') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $kebuns->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
