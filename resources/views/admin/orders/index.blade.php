@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('title_prefix', 'Narudžbine u obradi - ')

@section('content_header')
    <h1>Narudžbine u obradi</h1>
@stop



@section('content')

    <table id="datatable" class="table table-striped table-bordered"
           style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Korisnik</th>
            <th>Obroci</th>
            <th>Datum dostave</th>
            <th>Status</th>
            <th>Options</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)

            @php
                $totalPrice = 0;

                foreach ($order->meals as $meal) {
                    $totalPrice += $meal->price * $meal->pivot->quantity;
                }
            @endphp
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->user->first_name . " " . $order->user->last_name}}</td>
                <td >
                    <div>
                        <ul>
                            @foreach($order->meals as $meal)
                                <li>
                                    <a href="{{route('meals-show', $meal)}}">{{$meal->meal_name}}</a>
                                    <span>{{" ⨯" . $meal->pivot->quantity}}</span>
                                    <span>- {{$meal->price * $meal->pivot->quantity}}€</span>
                                </li>
                            @endforeach
                            <li>
                                <h6>
                                    <b>Total: {{$totalPrice}}€</b>
                                </h6>
                            </li>
                        </ul>

                    </div>
                </td>
                <td>{{\Illuminate\Support\Carbon::parse($order->delivery_date)->toDateString()}}</td>
                <td style="color: {{$order->status->color}}">{{$order->status->name}}</td>
                <td>
                    <div class="d-flex justify-content-center">

                        <form action="{{route('orders-update', $order)}}" method="post">
                            @csrf

                            <button type="submit" class="btn btn-outline-success ml-2 mr-2" {{$order->status->id === 2 ? "disabled" : null}}>
                                <i class="fas fa-check"></i>
                                <span>Gotovo</span>
                            </button>
                        </form>

                        <a href="{{route('orders-show', $order)}}"
                           class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>

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
            <th>Options</th>
        </tr>
        </tfoot>
    </table>
@stop

@section('js')
    <script>
        var table = $('#datatable').DataTable({
            responsive: true,
            autoWidth: true,
            columnDefs: [
                {targets: [0, 1, 3, 4], className: "text-center"},
                {targets: -1, searchable: false, orderable: false}
            ]
        });
    </script>
@stop
