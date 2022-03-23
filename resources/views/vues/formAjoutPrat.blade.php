{{--@if($_SESSION['token'])--}}
@extends('layouts.master')
@section('content')

    <h1>Ajout d'un praticien</h1>
    {!! Form::open(['url' => 'ajoutPratFin']) !!}
    <div>
        <div class="formAjoutPratGene">
            <div class="cardForm formAjoutPrat formPratLeft">
                <div class="nom">
                    <label> Nom :</label>
                    <input type="text" name="nom" required>
                </div>
                <input type="hidden" name="count" required value="{{$count}}">
                <br>
                <div class="prenom">
                    <label> Prénom :</label>
                    <input type="text" name="prenom" required>
                </div>
                <div class="adresse">
                    <label> Adresse :</label>
                    <input type="text" name="adresse" required>
                </div>
                <div class="cp">
                    <label> Code Postal :</label>
                    <input type="text" name="cp" required>
                </div>
                <div class="ville">
                    <label> Ville :</label>
                    <input type="text" name="ville" required>
                </div>
            </div>
        </div>
        <div class="cardForm formAjoutPrat formPratRight">
            <div class="coef">
                <label> Coefficient Notoriété :</label>
                <input type="text" name="coef" required>
            </div>
            <div class="diplome">
                <label> Diplôme :</label>
                <input type="text" name="diplome" required>
            </div>
            <div class="typePrat">
                <label> Type de praticien:</label>
                <select name="typePrat" required>
                    <option value="0">Sélectionner un type</option>
                    @foreach($mesTypes as $unType)
                        <option value="{{ $unType->id_type_praticien }}">{{ $unType->lib_type_praticien }}</option>
                    @endforeach
                </select>
            </div>
            <div class="spe">
                <label> Type de praticien:</label>
                <select name="spe" required>
                    <option value="0">Sélectionner une spécialité</option>
                    @foreach($mesSpe as $uneSpe)
                        <option value="{{ $uneSpe->id_specialite }}">{{ $uneSpe->lib_specialite }}</option>
                    @endforeach
                </select>
            </div>
            <br>
        </div>
    </div>
    <div class="cardForm formBtn">
        <button class="btn" href="{{url('/listePraticiens')}}" class="annuler">Annuler</button>
        &nbsp
        <button class="btn" type="submit" class="valider">Valider</button>
    </div>
@stop
{{--@else--}}
{{--    vous n'êtes pas connecté--}}
{{--@endif--}}
