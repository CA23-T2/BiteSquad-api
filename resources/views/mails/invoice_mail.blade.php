<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        * {
            font-family: Poppins, 'sans-serif';
        }

        /* Centrirajte logo horizontalno */
        .logo {
            margin: 0 auto;
            padding: 0 10%;
        }

        /* Centrirajte sadržaj na sredini stranice */
        .content {
            text-align: left;
            padding: 0 10%;
        }

        /* Stilizujte poruku */
        .message {
            font-size: 16px;
            margin-top: 20px;
            padding: 0 10%;
        }
    </style>
</head>
<body>
<div class="content">
    <img height="60" src="{{ $message->embed(asset('BiteSquad_logo.png')) }}" alt="Vaš Logo" class="logo">
    <h1 style="padding: 0 10%;">Priložen Račun</h1>
    <div class="message">
        Poštovani/a,
    </div>
    <div class="message">
        Sa zadovoljstvom Vam dostavljamo priloženi račun za ketering u toku prethodnog mjeseca. Molimo da pronađete račun priložen uz ovaj email.

        Hvala Vam na Vašem poslovanju!
    </div>

    <div class="message">
        S poštovanjem,
        <br>
        BiteSquad.
    </div>
</div>
</body>
</html>
