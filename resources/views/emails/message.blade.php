<!DOCTYPE html>
<html>
    <head>
        <title>new meesage</title>
        <style>
            body {
                min-height: 500px;
                font-family: Arial,sans-serif;
            }
            nav{
                background-color: #007BFF;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                color: #fff;
            }
            a.btn{
                box-sizing: border-box;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                position: relative;
                -webkit-text-size-adjust: none;
                border-radius: 4px;
                color: #fff;
                display: inline-block;
                overflow: hidden;
                text-decoration: none;
                background-color: #2d3748;
                border-bottom: 8px solid #2d3748;
                border-left: 18px solid #2d3748;
                border-right: 18px solid #2d3748;
                border-top: 8px solid #2d3748;

            }
            nav>a{
                box-sizing: border-box;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                position: relative;
                color: #3d4852;
                font-size: 19px;
                font-weight: bold;
                text-decoration: none;
                display: inline-block;
            }

        </style>
    </head>
    <body>
        <div style="text-align: center; background-color: #007BFF">
            <h2 style="text-align: center;padding: 10px;"><a style="color: #fff" href="{{url('/')}}">{{env('APP_NAME')}} <img src="{{asset('img/logo/logo.png')}}" width="50" height="50"> </a></h2>
        </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div style="text-align: center">
        <h2>hello Admin</h2>
        <p> You have new message from : <strong>{{$user}}</strong></p>
        message : <textarea cols="5" rows="10" style="display:block;
        width:80%;margin: auto;
        background-color: transparent;resize: none;">
            {{$messageText}}
        </textarea>
        <p>user Info:
            <br>email :<strong>{{$email}}</strong>
            <br>phone :<strong>{{$phone}}</strong>
        </p>
    </div>
    </body>
</html>

