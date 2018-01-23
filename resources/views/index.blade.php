<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Simple Mailer</title>
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body class="bg-grey-lighter">
        <div class="container mx-auto max-w-lg mt-6" id="app">
            <div class="flex mb-2">
                <div class="w-full bg-transparent h-12">
                    <h1 class="text-grey-darkest font-thin"><span class="font-thin font-normal">Simple</span>Mailer</h1>
                </div>
            </div>
            <app/>
        </div>
        <script src="js/app.js"></script>
    </body>
</html>
