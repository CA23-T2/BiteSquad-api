@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('title_prefix', 'Narudžbine u obradi - ')

@section('content_header')
    <h1>Narudžbina</h1>
@stop

@php

    $totalPrice = 0;

    foreach ($order->meals as $meal) {
        $totalPrice += $meal->price * $meal->pivot->quantity;
    }
@endphp

@section('content')

    <div class="d-flex pt-3">
        <form action="{{route('orders-update', $order)}}" method="post">
            @csrf

            <button type="submit" class="btn btn-outline-success ml-2 mr-2" {{$order->status->id === 2 ? "disabled" : null}}>
                <i class="fas fa-check"></i>
                <span>Gotovo</span>
            </button>
        </form>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card mb-4 shadow">
                <div class="card-body">
                    <h1>Order ID: #{{$order->id}}</h1>
                    <hr>
                    <div class="mb-4">
                        <h5>Naručilac:</h5>
                        <h6>
                            <a href="{{route('users-show', $order->user)}}">{{$order->user->first_name . ' ' . $order->user->last_name}}</a>
                        </h6>
                    </div>
                    <div class="mb-4">
                        <h5 class="card-subtitle mb-2 font-weight-bold">Korpa:</h5>
                        <ul>
                            @foreach($order->meals as $meal)
                                <li>
                                    <a href="{{route('meals-show', $meal)}}">{{$meal->meal_name}}</a>
                                    <span>{{" ⨯" . $meal->pivot->quantity}}</span>
                                    <span>- {{$meal->price * $meal->pivot->quantity}}€</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h5 class="card-subtitle mb-2 font-weight-bold">Total:</h5>
                        <b class="card-text">{{$totalPrice}}€</b>
                    </div>
                    <div class="mb-4">
                        <h5 class="card-subtitle mb-2 font-weight-bold">Stanje:</h5>
                        <p class="card-text" style="color: {{$order->status->color}}">{{$order->status->name}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
