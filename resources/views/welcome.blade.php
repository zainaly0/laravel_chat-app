<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        
        .baby {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

<body>
    <div class="baby">
        <h1 style="padding-bottom: 30px">Home page</h1>
        <div class="baby2">
            <button class="btn btn-primary"><a href="http://127.0.0.1:8000/login" class=" text-light">Login<a> </button>
                <button class="btn btn-secondary text-light"><a href="http://127.0.0.1:8000/register"
                        class="text-light">Register<a>
                </button>
        </div>
    </div>

</body>

</html>
