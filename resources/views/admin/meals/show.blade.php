@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('title_prefix', 'Obrok - ')

@section('content')

    <x-adminlte-modal id="deleteModal" title="Brisanje obroka" theme="danger" icon="fas fa-trash" v-centered static-backdrop scrollable>
        <form action="{{ route('meals-destroy', $meal->id) }}" method="post">
            @csrf
            @method('DELETE')
            <div>Da li ste sigurni da želite da obrišete obrok?</div>

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
    <div class="d-flex pt-3 ">
        <div class="mr-2">
            <a href="{{ route('meals-edit', $meal) }}">
                <button type="button" class="btn btn-primary">
                    <div class="fa fa-edit"></div>
                    <span>Izmijeni obrok</span>
                </button>
            </a>
        </div>

        <x-adminlte-button label="Obriši obrok" data-toggle="modal" data-target="#deleteModal" class="bg-danger" />
    </div>


    <div class="w-100 mt-3">
        <div class="d-flex">
            <div class="row mr-3">
                <div class="col-md-12">
                    <div class="card mb-4 shadow">
                        <div class="position-relative">
                            <img src="{{ asset($meal->image_url) }}" class="card-img-top rounded-top" alt="Food Image">
                            <div class="overlay"></div>
                            <h5 class="font-weight-bold px-3 pt-3">{{ $meal->meal_name }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-2 font-weight-bold">Description:</h6>
                                <p class="card-text">{{ $meal->description }}</p>
                            </div>
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-2 font-weight-bold">Price:</h6>
                                <p class="card-text">{{ $meal->price }}</p>
                            </div>
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-2 font-weight-bold">Dietary Restrictions:</h6>
                                <p class="card-text">{{ $meal->dietary_restrictions }}</p>
                            </div>
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-2 font-weight-bold">Rating:</h6>
                                @php
                                    $zbir = 0;
                                    if(sizeof($meal->ratings) > 0) {
                                        foreach ($meal->ratings as $rating) {
                                        $zbir += $rating->rating;
                                        }
                                        $zbir /= sizeOf($meal->ratings);
                                    }
                                @endphp
                                <div class="d-flex align-items-center">
                                    @if($zbir > 0)
                                        <div>{{ $zbir }}</div>
                                        <i class="fa fa-star" style="color: #d98d33"></i>
                                    @endif

                                    @if($zbir === 0)
                                        <div>Nema ocjena.</div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row w-50">
                <div class="col-md-12">
                    <div class="card mb-4 sshadow">
                        @foreach ($meal->ratings as $rating)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-1 sshadow">

                                        <div class="card-body">
                                            <div class="mb-2">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <img class="rounded-circle" height="60" src="{{ $rating->user->profile_picture }} " alt="user_picture">
                                                        <div class="d-flex flex-column justify-content-around ml-2">
                                                            <div>
                                                                <b>{{ $rating->user->first_name }} {{ $rating->user->last_name }}</b>
                                                            </div>
                                                            <div class="d-flex">
                                                                @for ($i = 0; $i < $rating->rating; $i++)
                                                                    <div>
                                                                        <i class="fa fa-star" style="color: #d98d33"></i>
                                                                    </div>
                                                                @endfor
                                                                @for ($i = 0; $i < 5 - $rating->rating; $i++)
                                                                    <div>
                                                                        <i class="fa fa-star"></i>
                                                                    </div>
                                                                @endfor

                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $datumVrijeme = explode(' ', $rating->created_at);
                                                    @endphp
                                                    <div class="d-flex flex-column align-items-end">
                                                        <div>
                                                            {{ $datumVrijeme[0] }}
                                                        </div>
                                                        <div>
                                                            {{ $datumVrijeme[1] }}
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                            <div class="mb-4">
                                                <div>
                                                    {{ $rating->feedback_comments }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </div>


@stop
