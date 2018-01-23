<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Simple Mailer</title>
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body class="bg-grey-lighter">
        <div class="container mx-auto max-w-lg mt-6">
            <div class="flex mb-2">
                <div class="w-full bg-transparent h-12">
                    <h1 class="text-grey-darkest font-thin"><span class="font-thin font-normal">Simple</span>Mailer</h1>
                </div>
            </div>
            <div class="flex mb-2">
                <div class="w-full h-12">
                    <form action="{{ route('rest.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        <div>
                            <label class="form-label" for="email">Email Address</label>
                            <input class="form-input" id="email" type="email" name="email" aria-label="Email Address" required>
                        </div>
                        <div class="mt-4">
                            <label class="form-label" for="message">Message</label>
                            <textarea class="form-input" id="message" name="message" aria-label="Message Content" required rows="10"></textarea>
                        </div>
                        <div class="text-right mt-4 -mb-2">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-blue" aria-label="Submit Form">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
