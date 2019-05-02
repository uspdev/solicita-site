@extends('master')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
@parent

<h1><a href="http://{{ $site->dominio }}{{ config('sites.dnszone') }}" target="_blank">{{ $site->dominio }}{{ config('sites.dnszone') }}</a></h1>

<div>
    <a href="{{ url()->previous() }}" class="btn btn-primary">Voltar</a>
</div>

<br>

<div>
    <a href="{{action('SiteController@edit', $site->id)}}" class="btn btn-warning">Editar</a>
</div>

<br>

<form action="{{action('SiteController@destroy', $site->id)}}" method="post">
    {{csrf_field()}} {{ method_field('delete') }}
    <button class="delete-item btn btn-danger" type="submit">Deletar</button>
</form>

@stop
