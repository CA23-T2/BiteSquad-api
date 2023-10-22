@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('title_prefix', 'Gotove narudžbine - ')

@section('content_header')
    <h1>Današnje narudžbine</h1>
@stop

@php
@endphp
@section('content')


    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Korisnik</th>
                <th>Obroci</th>
                <th>Datum dostave</th>
                <th>Status</th>
                <th>Opcije</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->first_name . ' ' . $order->user->last_name }}</td>
                    <td>
                        <ul>
                            @foreach ($order->meals as $meal)
                                <li>
                                    <a href="{{ route('meals-show', $meal) }}">{{ $meal->meal_name }}</a>
                                    <span>{{ ' ⨯' . $meal->pivot->quantity }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ \Illuminate\Support\Carbon::parse($order->delivery_date)->toDateString() }}</td>
                    <td>
                        <form action="{{ route('orders-update', $order) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input hidden value="today" name="fromWhere" type="text">
                            <select onchange="changeColor({{ $statuses }}, {{ $order->id }}), this.form.submit()" class="form-control "
                                style="color: {{ $order->status->color }}; border-Color: {{ $order->status->color }}" name="status_id" id="{{ $order->id }}">
                                <option value="" selected disabled hidden style="color: {{ $order->status->color }}" value="{{ $order->status->id }}">{{ $order->status->name }}
                                </option>
                                @foreach ($statuses as $status)
                                    <option style="color: {{ $status->color }}" value="{{ $status->id }}">{{ $status->name }} </option>
                                @endforeach
                            </select>
                        </form>

                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('orders-show', $order) }}" class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Korisnik</th>
                <th>Obroci</th>
                <th>Datum dostave</th>
                <th>Status</th>
                <th>Opcije</th>
            </tr>
        </tfoot>
    </table>
@stop

@section('js')
    <script>
        var table = $('#datatable').DataTable({
            responsive: true,
            autoWidth: true,
            columnDefs: [{
                    targets: [0, 1, 3, 4],
                    className: "text-center"
                },
                {
                    targets: -1,
                    searchable: false,
                    orderable: false
                }
            ]
        });

        function changeColor(statuses, orderId) {

            var index = document.getElementById(orderId).selectedIndex;
            console.log(index);
            document.getElementById(orderId).style.color = statuses[index - 1]['color'];
            document.getElementById(orderId).style.borderColor = statuses[index - 1]['color'];
        }
    </script>
@stop
