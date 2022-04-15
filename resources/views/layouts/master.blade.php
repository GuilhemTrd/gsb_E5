<!doctype html>
<html lang="fr">
<head>
    <title>GSB</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::to('assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="body">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{url('/')}}">GSB</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
            @if(Session::get('id') == 0)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/formLogin')}}">Connexion</a>
            </li>
            @endif
            @if(Session::get('id') > 0)
                    <li class="nav-item active">
                        <a class="nav-link" href="{{url('/listePraticiens')}}">Liste des utilisateurs</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{url('/getLogout')}}">Déconnexion</a>
                     </li>
            @endif
        </ul>
    </div>
</nav>
<div class="container">
    @yield('content')
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
{!! Html::script('assets/js/bootstrap.min.js') !!}
{!! Html::script('assets/js/jquery-2.1.3.min.js')  !!}
{!! Html::script('assets/js/ui-bootstrap-tpls.js')  !!}
{!! Html::script('assets/js/bootstrap.js')  !!}
{!! Html::script('assets/js/ajaxConnexion.js')  !!}
</body>
</html>
