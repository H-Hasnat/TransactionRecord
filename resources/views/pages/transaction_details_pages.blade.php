@extends('layout')


@section('content')


@include('transaction.list')
@include('transaction.add')

{{-- @include('transaction.view') --}}

@include('transaction.delete')


@endsection
