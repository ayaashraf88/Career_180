@extends('components.layouts.app')
@section('content')
<div wire:lazy>
   @livewire('dashboard-suggested-courses')
</div>
@endsection