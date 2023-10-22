@extends('adminlte::page')

@section('title_prefix', 'Korisnici - ')

@section('content_header')
    <h1>Korisnici</h1>
@stop

@section('content')
    <div class="my-3">
        <a href="{{ route('users-create') }}">
            <button type="button" class="btn btn-primary">
                <span class="fa fa-plus"></span>
                <span>Novi korisnik</span>
            </button>
        </a>
    </div>

    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Korisničko ime</th>
                <th>E-mejl</th>
                <th>Tip naloga</th>
                <th>Opcije</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>
                        <div class="d-flex justify-content-center">

                            <a href="{{ route('users-show', $user) }}" class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('users-edit', $user) }}" class="btn btn-outline-success ml-2 mr-2"><i class="fas fa-edit"></i></a>

                            <x-adminlte-modal id="deleteModal-{{ $user->id }}" title="Brisanje korisnika" theme="danger" icon="fas fa-trash" v-centered static-backdrop scrollable>
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

                            <button class="btn btn-outline-danger ml-2 mr-2" data-toggle="modal" data-target="#deleteModal-{{ $user->id }}"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Korisničko ime</th>
                <th>E-mejl</th>
                <th>Tip naloga</th>
                <th>Opcije</th>
            </tr>
        </tfoot>
    </table>
@stop

@section('js')
    <script>
        // console.log('Hi!');
    </script>
@stop
