<!DOCTYPE html>
<html>
    <head>
        <title>EaseFreight:: Token Mismatch</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            .btn-flat {
                background-color: #0054a6;
                background-image: none;
                border: 1px solid #0054a6;
                border-radius: 20px;
                display: block;
                margin: 0 auto;
                padding: 10px 20px;
                position: relative;
                transition: all 0.5s ease 0s;
                font-size: 16px;
                width: 50px;
                text-decoration: none;
                font-weight: bold;
                color:#fff;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Whoops, looks like something went wrong.</div>
                <a class="btn btn-primary btn-block btn-flat" href="{{ URL::previous() }}">Back</a>
            </div>
        </div>
    </body>
</html>
