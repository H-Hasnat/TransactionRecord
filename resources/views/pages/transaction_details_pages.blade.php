@extends('layout')


@section('content')


@include('transaction.list')

@include('transaction.view')

@include('transaction.add')
@include('transaction.delete')


@endsection
