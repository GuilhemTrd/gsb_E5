@extends('layouts.master')
@section('content')

    <h1>Ajout d'un praticien</h1>
    {!! Form::open(['url' => 'ajoutPratFin']) !!}
    <div>
        <div class="formAjoutPratGene">
            <div class="cardForm formAjoutPrat formPratLeft">
                <input type="hidden" name="count" required value="{{$count}}">
                <div class="nom donnee">
                    <input size="30" type="text" name="nom" placeholder="Nom" required>
                </div>
                <div class="prenom donnee">
                    <input size="30" type="text" name="prenom" placeholder="Prenom" required>
                </div>
                <div class="adresse donnee">
                    <input size="30" type="text" name="adresse" placeholder="Adresse" required>
                </div>
                <div class="cp donnee">
                    <input size="30" type="text" name="cp" placeholder="Code Postal" required>
                </div>
                <div class="ville donnee">
                    <input size="30" type="text" name="ville" placeholder="Ville" required>
                </div>
            </div>
        </div>
        <div class="cardForm formAjoutPrat formPratRight">
            <div class="coef donnee">
                <input size="30" type="text" name="coef" placeholder="Coefficient" required>
            </div>
            <div class="diplome donnee">
                <input size="30" type="text" name="diplome" placeholder="Diplôme" required>
            </div>
            <div class="typePrat donnee">
                <select name="typePrat" required>
                    <option value="0">Sélectionner un type</option>
                    @foreach($mesTypes as $unType)
                        <option value="{{ $unType->id_type_praticien }}">{{ $unType->lib_type_praticien }}</option>
                    @endforeach
                </select>
            </div>
            <div class="spe donnee">
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
        <a class="btn" href="{{url('/listePraticiens')}}" class="annuler">Annuler</a>
        &nbsp
        <button class="btn" type="submit" class="valider">Valider</button>
    </div>
@stop
{{--@else--}}
{{--    vous n'êtes pas connecté--}}
{{--@endif--}}
