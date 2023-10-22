@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('title_prefix', 'Fakture - ')

@section('content_header')
    <h1>Fakture</h1>
@stop


@section('content')
    <div class="my-3">
        <a href="{{route('invoice-newInvoice')}}">
            <button type="button" class="btn btn-primary">
                <span class="fa fa-plus"></span>
                <span>Nova faktura za tekuci mjesec</span>
            </button>
        </a>
    </div>

    <table id="datatable" class="table table-striped table-bordered"
           style="width:100%">
        <thead>
        <tr>
            <th>Broj racuna</th>
            <th>PDF</th>
            <th>Kreirano</th>
            <th>Ažurirano</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{$invoice->id}}</td>
                <td><a href="{{url($invoice->pdf_link)}}">LINK</a></td>
                <td>{{$invoice->created_at}}</td>
                <td>{{$invoice->updated_at}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Broj racuna</th>
            <th>PDF</th>
            <th>Kreirano</th>
            <th>Ažurirano</th>
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


