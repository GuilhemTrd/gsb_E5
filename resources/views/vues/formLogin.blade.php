@extends('layouts.master')
@section('content')

    <h1>Authentification</h1>

    {!! Form::open(['url' => 'login']) !!}
        <div class="cardForm formLogin login">
            <div class="formConnect">
                <div class="id">
                    <label> Identifiant :</label>
                    <input type="text" name="login" required>
                </div>
                <br>
                <div class="mdp">
                    <label> Mot de passe :</label>
                    <input type="password" name="pwd" required>
                </div>
                <br>
                <button class="btn" type="reset" class="annuler">Annuler</button>
                &nbsp
                <button class="btn" type="submit" class="valider">Valider</button>
                <br>
                @if($erreur)
                    @php echo $erreur @endphp
                @endif
            </div>
        </div>
@stop
