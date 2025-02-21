@extends('layout')


@section('content')

@include('Customer.list')
@include('Customer.add')
@include('Customer.delete')

@endsection

