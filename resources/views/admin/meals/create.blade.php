@extends('adminlte::page')

@section('title_prefix', 'Novi obrok - ')

@section('content_header')
    <h1>Novi obrok</h1>
@stop

@section('js')
    <script>

        const generateImage = () => {

            const generateButton = document.getElementById('generateButton');
            const toggleButton = document.getElementById('toggleButton');

            generateButton.innerHTML =
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...`;

            generateButton.disabled = true;
            toggleButton.disabled = true;

            const requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer {{config('services.openai.key')}}`
                },
                body: JSON.stringify({
                    prompt: document.getElementById('promptField').value,
                    size: '256x256'
                })
            };

            fetch('https://api.openai.com/v1/images/generations', requestOptions)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    document.getElementById('imagePreview').src = data.data[0].url;
                    document.getElementById('url_field').value = data.data[0].url;
                    generateButton.disabled = false;
                    toggleButton.disabled = false;
                    generateButton.innerHTML = 'Generiši';
                })
                .catch(error => {
                    generateButton.disabled = false;
                    toggleButton.disabled = false;
                    generateButton.innerHTML = 'Generiši';
                    console.error(error);
                });

        }

        function toggleContent() {
            const photoArea = document.getElementById('photoArea');
            const toggleButton = document.getElementById('toggleButton');

            if (toggleButton.innerHTML === 'Mod - Upload') {
                photoArea.innerHTML =
                    `
                    <div class="mb-2">
                        <label for="promptField">Upit</label>
                        <input class="form-control" id="promptField" placeholder="Opis fotografije" />
                    </div>
                    <div>
                        <x-adminlte-input id="url_field" type="text" name="photo_url" label="Link" placeholder="URL nije dostupan..." readonly/>
                    </div>
                    <div>
                        <b>Prikaz fotografije</b>
                        <div class="d-flex justify-content-center mt-2 border border-black">
                            <img style="max-width: 100%; height: 300px; object-fit: cover;" id="imagePreview" src="" alt="Prikaz nije dostupan.">
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-between align-items-center flex-row-reverse">
                        <button type="button" id="generateButton" onclick="generateImage()" class="btn btn-dark mt-2">Generiši</button>
                        <div class="d-flex align-items-center" style="column-gap: 5px">
                            <div>Powered by</div>
                            <img src="{{asset('openai.svg')}}" height="20" alt="">
                            <b>DALL·E</b>
                        </div>
                    </div>
                `

                toggleButton.innerHTML = 'Mod - AI'
            } else {
                photoArea.innerHTML =
                    `
                    <x-adminlte-input-file id="fileInput" name="photo" label="Fotografija" placeholder="Otpremite fotografiju..." onchange="updatePreview(event)" disable-feedback/>
                    <b>Prikaz fotografije</b>
                    <div class="d-flex justify-content-center mt-2 border border-black">
                        <img style="max-width: 100%; height: 300px; object-fit: cover;" id="imagePreview" src="" alt="Prikaz nije dostupan.">
                    </div>
                `

                toggleButton.innerHTML = 'Mod - Upload'
            }
        }

        const imagePreview = document.getElementById('imagePreview');

        const updatePreview = (e) => {

            console.log(e)
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                };

                reader.readAsDataURL(file);

            } else {

                imagePreview.src = '';
            }
        }

    </script>
@stop



@section('content')
    <form action="{{route('meals-store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 col-12">

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
                    <input type="number" class="form-control" id="price" name="price" placeholder="Unesite cijenu...">
                </div>

                <div class="mb-3">
                    <label for="dietary_restrictions" class="form-label">Karakteristike</label>
                    <input type="text" class="form-control" id="dietary_restrictions" name="dietary_restrictions"
                           placeholder="Posno, slatko, sadrzi gluten, vegan...">
                </div>

            </div>

            <div class="col-md-6 col-12 mb-5">
                <b>Mod</b>
                <button type="button"
                        id="toggleButton"
                        class="btn btn-outline-secondary w-100"
                        onclick="toggleContent()">Mod - AI</button>

                <div id="photoArea" class="mt-2">
                    <div class="mb-2">
                        <label for="promptField">Upit</label>
                        <input class="form-control" id="promptField" placeholder="Opis fotografije" />
                    </div>
                    <div>
                        <x-adminlte-input id="url_field" type="text" name="photo_url" label="Link" placeholder="URL nije dostupan..." readonly/>
                    </div>
                    <div>
                        <b>Prikaz fotografije</b>
                        <div class="d-flex justify-content-center mt-2 border border-black">
                            <img style="max-width: 100%; height: 300px; object-fit: cover;" id="imagePreview" src="" alt="Prikaz nije dostupan.">
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-between align-items-center flex-row-reverse">
                        <button type="button" id="generateButton" onclick="generateImage()" class="btn btn-dark mt-2">Generiši</button>
                        <div class="d-flex align-items-center" style="column-gap: 5px">
                            <div>Powered by</div>
                            <img src="{{asset('openai.svg')}}" height="20" alt="">
                            <b>DALL·E</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success" style="width: 100px">Kreiraj</button>
    </form>
@stop

@section('js')
    <script>

    </script>
@stop

