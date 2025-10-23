@extends('components.layouts.app')
@section('content')
<div class="container">
    <h3>Your Logs</h3>
    <table class="table">
        <tr>
            <td>id</td>
            <td>content</td>
        </tr>
        @foreach($logs as $log)
        <tr>
            <td>{{$log->id}}</td>
            <td>{{$log->description}}</td>
        </tr>
        @endforeach
    </table>
</div>

@endsection