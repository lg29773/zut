<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
        <input placeholder="Nazwa dla nowego katalogu .." class="form-control new_dir_name" >
            <button class="btn btn-success create_dir" data-catalog="{{$current}}" style="width: 100%;">Dodaj nowy katalog</button>
            <form method="POST" action="/ftp" enctype="multipart/form-data"  style="margin-top:50px;" >
                {{csrf_field()}}
                <input type="hidden"  name="type" value="upload">
                <input type="hidden"  name="catalog" value="{{$current}}">

                <input type="file" name="fileinput" id="fileinput" />
                <button type="send" class="btn">Wgraj Plik</button>
            </form>
        </div>

    </div>
    <h2>FTP </h2>
    <h3>Obecny Katalog: {{$current}} </h3>
    @if($current != "/")
        <a class="btn btn-warning return">Wróć</a>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th>Nazwa</th>
            <th>Rodzaj</th>
            <th>Uprawnienia</th>
            <th>Data</th>
            <th>Rozmiar</th>
            <th>Akcja</th>


        </tr>
        </thead>
        <tbody>
        @foreach($directory as $key => $dir)
            <tr>
                <td>{{$key}}</td>
                <td>{{$dir['type']}}</td>
                <td>{{$dir['rights']}}</td>
                <td>{{$dir['day']}}, {{$dir['month']}},{{$dir['time']}}</td>
                <td>{{$dir['size']}}</td>
                <td>
                    @if($dir['type'] == 'directory')
                        <button class="btn btn-info change_catalog" data-catalog="{{$current}}/{{$key}}">Przejdź</button>
                        <button class="btn btn-danger delete_dir2" data-catalog="{{$current}}/{{$key}}">Usuń</button>

                    @elseif($dir['type'] == 'file')
                        <button class="btn btn-danger delete_dir" data-catalog="{{$current}}/{{$key}}">Usuń</button>
                    @endif
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        $('.change_catalog').on('click', function () {
            var dir = $(this).attr('data-catalog');
            var newulr = dir.replace(/\//g, '_');
            window.location.href = "/ftp/" + newulr;

        })
        $('.return').on('click', function () {
            window.history.back();
        })
        $('.create_dir').on('click',function () {
            $.ajax({
                type: 'POST',
                url: '/ftp',
                data: {
                    'type': 'create_dir',
                    'dir': $(this).attr('data-catalog')+"/"+$('.new_dir_name').val()
                },
                success: function(msg){
                    location.reload();
                }
            });
        })
        $('.delete_dir').on('click',function () {
            $.ajax({
                type: 'POST',
                url: '/ftp',
                data: {
                    'type': 'delete',
                    'dir': $(this).attr('data-catalog')+"/"+$('.new_dir_name').val()
                },
                success: function(msg){
                    location.reload();
                }
            });
        })
        $('.delete_dir2').on('click',function () {
            $.ajax({
                type: 'POST',
                url: '/ftp',
                data: {
                    'type': 'delete_dir',
                    'dir': $(this).attr('data-catalog')+"/"+$('.new_dir_name').val()
                },
                success: function(msg){
                    location.reload();
                }
            });
        })
    </script>
</body>
</html>