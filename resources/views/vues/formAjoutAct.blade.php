@extends('layouts.master')
@section('content')
    @php
        $nom = strtoupper($unPrat[0]->nom_praticien)
    @endphp
    <br>
    <br>
    <br>
    <h1>Ajouter une activité a {{$nom}} {{$unPrat[0]->prenom_praticien}}</h1>
    {!! Form::open(['url' => 'ajoutFin']) !!}
    <div class="cardForm formAjoutAct">
            <div class="act">
                <input type="hidden" name="idPrat" required value="{{$unPrat[0]->id_praticien}}">
                <label> Choisir l'activite:</label>
                <select name="idAct" required>
                    <option value="0">Sélectionner une activité</option>
                    @foreach($mesActs as $uneAct)
                        @php $afficher = 0;@endphp
                        @php $egal = 0;@endphp
                        @foreach($lesActsPrat as $actsPrat)
                            @if($uneAct->id_activite_compl == $actsPrat->id_activite_compl)
                                @php $egal = 1;@endphp

                            @endif

                        @endforeach
                        @if($egal == 0 && $afficher == 0)
                            <option value="{{ $uneAct->id_activite_compl }}">{{ $uneAct->theme_activite }} {{ $uneAct->lieu_activite }} {{ $uneAct->motif_activite }} {{ $uneAct->date_activite }}</option>
                        @endif
                    @endforeach
                </select>
                <div class="spe">
                    <label> Spécialiste :</label>
                    <input type="text" name="spe" required>
                </div>
            </div>
            <br>
            <button class="btn" href="{{url('//infosAct')}}/{{$unPrat[0]->id_praticien}}" class="annuler">Annuler</button>
            &nbsp
            <button class="btn" type="submit" class="valider">Valider</button>
    </div>
@stop
