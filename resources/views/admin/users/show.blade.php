@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('title_prefix', 'Korisnik - ')

@section('content')



    <div class="d-flex">
        <div class="w-25 mt-3">
            <div class="row mr-3">
                <div class="col-md-12">
                    <div class="card mb-4 shadow">
                        <div class="position-relative">
                            <img src="{{ asset($user->profile_picture) }}" class="card-img-top rounded-top" alt="Profile Image">
                            <div class="overlay"></div>
                            <h5 class="font-weight-bold px-3 pt-3">{{ $user->first_name }} {{ $user->last_name }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-2 font-weight-bold">Korisničko ime:</h6>
                                <p class="card-text">{{ $user->username }}</p>
                            </div>
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-2 font-weight-bold">E-mejl:</h6>
                                <p class="card-text">{{ $user->email }}</p>
                            </div>
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-2 font-weight-bold">Tip naloga:</h6>
                                <p class="card-text">{{ $user->role->name }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div>
            <x-adminlte-modal id="deleteModal" title="Brisanje korisnika" theme="danger" icon="fas fa-trash" v-centered static-backdrop scrollable>
                <form action="{{ route('users-destroy', $user->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div>Da li ste sigurni da želite da obrišete korisnika?</div>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-danger mr-auto" type="submit">
                            <div class="fa fa-trash"></div>
                            <span>Da</span>
                        </button>

                        <x-adminlte-button type="button" theme="secondary" label="Ne" data-dismiss="modal" />
                    </div>

                    <x-slot name="footerSlot"></x-slot>
                </form>
            </x-adminlte-modal>
            <div class="pt-3 ">
                <div class="mr-2 mb-2">
                    <a href="{{ route('users-edit', $user) }}">
                        <button type="button" class="btn btn-primary">
                            <div class="fa fa-edit"></div>
                            <span>Izmijeni korisnika</span>
                        </button>
                    </a>
                </div>

                <x-adminlte-button label="Obriši korisnika" data-toggle="modal" data-target="#deleteModal" class="bg-danger" />
            </div>
        </div>
    </div>

    </div>


@stop
