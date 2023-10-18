@extends('adminlte::page')

@section('title_prefix', 'Izmjena obroka - ')

@section('content_header')
    <h1>Izmjena obroka - {{$meal->meal_name}}</h1>
@stop

@section('content')
    <form action="{{route('meals-update', $meal)}}" method="post">
        @csrf

        <div class="mb-3">
            <label for="meal_name" class="form-label">Naziv Obroka</label>
            <input type="text" class="form-control" id="meal_name" name="meal_name" placeholder="Unesite naziv obroka..." value="{{$meal->meal_name}}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Opis</label>
            <textarea class="form-control" id="description" name="description">{{$meal->description}}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Cijena</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Unesite cijenu..." value="{{$meal->price}}">
        </div>

        <x-adminlte-input-file name="image_url" label="Fotografija" placeholder="Otpremite fotografiju..."
                               disable-feedback/>

        <div class="mb-3">
            <label for="dietary_restrictions" class="form-label">Karakteristike</label>
            <input type="text" class="form-control" id="dietary_restrictions" name="dietary_restrictions"
                   placeholder="Posno, slatko, sadrzi gluten, vegan..." value="{{$meal->dietary_restrictions}}">
        </div>

        <div class="d-flex w-100 justify-content-end">
            <button type="submit" class="btn btn-success" style="width: 100px">Sačuvaj</button>
        </div>
    </form>
@stop
