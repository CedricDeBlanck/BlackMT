@extends('layouts.app')
@routes()
@section('content')

    <strafblad-component :strafblad="{{ $straffen }}"></strafblad-component>

@endsection
