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



    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card mb-4 shadow">
                <div class="card-body">
                    <h1>Order ID: #{{ $order->id }}</h1>
                    <hr>
                    <div class="mb-4">
                        <h5>Naručilac:</h5>
                        <h6>
                            <a href="{{ route('users-show', $order->user) }}">{{ $order->user->first_name . ' ' . $order->user->last_name }}</a>
                        </h6>
                    </div>
                    <div class="mb-4">
                        <h5 class="card-subtitle mb-2 font-weight-bold">Korpa:</h5>
                        <ul>
                            @foreach ($order->meals as $meal)
                                <li>
                                    <a href="{{ route('meals-show', $meal) }}">{{ $meal->meal_name }}</a>
                                    <span>{{ ' ⨯' . $meal->pivot->quantity }}</span>
                                    <span>- {{ $meal->price * $meal->pivot->quantity }}€</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h5 class="card-subtitle mb-2 font-weight-bold">Total:</h5>
                        <b class="card-text">{{ $totalPrice }}€</b>
                    </div>
                    <div class="mb-4">
                        <h5 class="card-subtitle mb-2 font-weight-bold">Stanje:</h5>
                        <form action="{{ route('orders-update', $order) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input hidden value="show" name="fromWhere" type="text">

                            <select onchange="changeColor({{ $statuses }}, {{ $order->id }}), this.form.submit()" class="form-control "
                                style="color: {{ $order->status->color }}; border-Color: {{ $order->status->color }}" name="status_id" id="{{ $order->id }}">
                                <option value="" selected disabled hidden style="color: {{ $order->status->color }}" value="{{ $order->status->id }}">{{ $order->status->name }}
                                </option>
                                @foreach ($statuses as $status)
                                    <option style="color: {{ $status->color }}" value="{{ $status->id }}">{{ $status->name }} </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')
    <script>
        function changeColor(statuses, orderId) {

            var index = document.getElementById(orderId).selectedIndex;
            console.log(index);
            document.getElementById(orderId).style.color = statuses[index - 1]['color'];
            document.getElementById(orderId).style.borderColor = statuses[index - 1]['color'];
        }

        function changeColor(statuses, orderId) {

            var index = document.getElementById(orderId).selectedIndex;
            console.log(index);
            document.getElementById(orderId).style.color = statuses[index - 1]['color'];
            document.getElementById(orderId).style.borderColor = statuses[index - 1]['color'];
        }
    </script>
@stop
