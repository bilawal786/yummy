<!DOCTYPE html>
<html lang="en">
<head>
    <title>Intro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .button {
            border: none;
            color: white;
            padding: 5px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            width: 100%;
            border-radius: 20px;
            margin-top: 20px;
            background-color: #ef4574;
            position: fixed;
            left: 0;
            bottom: 0;
        }
    </style>
</head>
<body>

<div style="height: 100vh;">
    <img id="1slide1" style="width: 100%; height: 100%" src="{{asset('intro/01.png')}}" alt="">
    <img id="2slide2" style="width: 100%; height: 100%; display: none" src="{{asset('intro/02.png')}}" alt="">
    <img id="3slide3" style="width: 100%; height: 100%; display: none" src="{{asset('intro/03.png')}}" alt="">
    <img id="4slide4" style="width: 100%; height: 100%; display: none" src="{{asset('intro/04.png')}}" alt="">
    <img id="5slide5" style="width: 100%; height: 100%; display: none" src="{{asset('intro/05.png')}}" alt="">
    <img id="6slide6" style="width: 100%; height: 100%; display: none" src="{{asset('intro/06.png')}}" alt="">
        <button id="1slide" class="button">Continuez</button>
        <button id="2slide" class="button" style="display: none">Continuez</button>
        <button id="3slide" class="button" style="display: none">Continuez</button>
        <button id="4slide" class="button" style="display: none">Continuez</button>
        <button id="5slide" class="button" style="display: none">Continuez</button>
    <a href="{{route('login')}}"><button id="6slide" class="button" style="display: none">Continuez</button></a>
</div>
<script>
    $(document).ready(function() {
        $("#1slide").click(function() {
            $("#1slide1").hide();
            $("#1slide").hide();
            $("#2slide2").show();
            $("#2slide").show();
        });
        $("#2slide").click(function() {
            $("#2slide2").hide();
            $("#2slide").hide();
            $("#3slide3").show();
            $("#3slide").show();
        });
        $("#3slide").click(function() {
            $("#3slide3").hide();
            $("#3slide").hide();
            $("#4slide4").show();
            $("#4slide").show();
        });
        $("#4slide").click(function() {
            $("#4slide4").hide();
            $("#4slide").hide();
            $("#5slide5").show();
            $("#5slide").show();
        });
        $("#5slide").click(function() {
            $("#5slide5").hide();
            $("#5slide").hide();
            $("#6slide6").show();
            $("#6slide").show();
        });

    });
</script>
</body>
</html>
