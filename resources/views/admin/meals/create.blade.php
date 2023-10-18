@extends('adminlte::page')

@section('title_prefix', 'Novi obrok - ')

@section('content_header')
    <h1>Novi obrok</h1>
@stop

@section('content')
    <form action="{{route('meals-store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="meal_name" class="form-label">Naziv Obroka</label>
            <input type="text" class="form-control" id="meal_name" name="meal_name" placeholder="Unesite naziv obroka...">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Opis</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Cijena</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Unesite cijenu...">
        </div>

        <x-adminlte-input-file name="photo" label="Fotografija" placeholder="Otpremite fotografiju..."
                               disable-feedback/>

        <div class="mb-3">
            <label for="dietary_restrictions" class="form-label">Karakteristike</label>
            <input type="text" class="form-control" id="dietary_restrictions" name="dietary_restrictions"
                   placeholder="Posno, slatko, sadrzi gluten, vegan...">
        </div>

        <div class="d-flex w-100 justify-content-end">
            <button type="submit" class="btn btn-success" style="width: 100px">Kreiraj</button>
        </div>
    </form>
@stop
