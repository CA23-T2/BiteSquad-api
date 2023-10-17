@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('title_prefix', 'Meals - ')

@section('content_header')
    <h1>Meals</h1>
@stop


@section('content')
    <form id="sumbitDelete" action="" method="post" hidden="">
        @csrf
        @method('DELETE')
    </form>
    <table id="datatable" class="table table-striped table-bordered"
           style="width:100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Opis</th>
            <th>Cijena</th>
            <th>Karakteristike</th>
            <th>Options</th>
        </tr>
        </thead>
        <tbody>
        @foreach($meals as $meal)
            <tr>
                <td>{{$meal->meal_name}}</td>
                <td>{{$meal->description}}</td>
                <td>{{$meal->price}}</td>
                <td>{{$meal->dietary_restrictions}}</td>
                <td>
                    <div class="d-flex justify-content-center">

                        <a href="{{route('meals-show', $meal)}}"
                           class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>

                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Name</th>
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
                {targets: "_all", className: "text-center"},
                {targets: -1, searchable: false, orderable: false}
            ]
        });
    </script>
@stop


