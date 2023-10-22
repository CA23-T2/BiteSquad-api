@extends('adminlte::page')

@section('title_prefix', 'Podešavanja - ')

@section('content_header')
    <h1>Podešavanja</h1>
@stop


@section('content')
    <div class="mt-4">
        @foreach($settings as $setting)
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <h5 class="m-0"><b>{{$setting->name}}</b></h5>
                </div>
                <b class="mr-3">-</b>
                <div class="mr-3">
                    <h6 class="m-0 text-primary">{{$setting->value}}</h6>
                </div>

                <x-adminlte-modal id="editModal-{{$setting->id}}" title="Izmjena podesavanja"  theme="primary"
                                  icon="fas fa-edit" v-centered static-backdrop scrollable>
                    <form action="{{route('settings-update', $setting->id)}}" method="post">
                        @csrf
                        @method('PATCH')

                        <div>{{$setting->name}}</div>

                        <div class="mb-3 mt-3">
                            <label for="value">Vrijednost</label>
                            @if($setting->setting === 'dall-e_output_resolution')
                                <select name="value" id="value" class="form-control">
                                    <option value="256x256" {{$setting->value === "256x256" ? 'selected' : null}}>256x256</option>
                                    <option value="512x512" {{$setting->value === "512x512" ? 'selected' : null}}>512x512</option>
                                    <option value="1024x1024" {{$setting->value === "1024x1024" ? 'selected' : null}}>1024x1024</option>
                                </select>
                            @else
                                <input type="text" name="value" id="value" class="form-control" value="{{$setting->value}}">
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary mr-auto" type="submit">
                                <div class="fa fa-save"></div>
                                <span>Ažuriraj</span>
                            </button>

                            <x-adminlte-button type="button" theme="secondary" label="Otkaži" data-dismiss="modal"/>
                        </div>

                        <x-slot name="footerSlot"></x-slot>
                    </form>
                </x-adminlte-modal>

                <div>
                    <button class="btn btn-outline-success ml-2 mr-2" data-toggle="modal" data-target="#editModal-{{$setting->id}}"><i class="fa fa-edit"></i></button>
                </div>
            </div>
            <em>{{$setting->description}}</em>
            <hr>
        @endforeach
    </div>
@stop


