@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($data as $list)
                <div class="card">
                    <div class="card-header">{{$list->name}}</div>
                    <div class="card-body">
                        Hey
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
