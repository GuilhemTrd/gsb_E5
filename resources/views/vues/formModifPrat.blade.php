@extends('layouts.master')
@section('content')

    <h1>Modification des informations de {{$prat[0]->nom_praticien}} {{$prat[0]->prenom_praticien}}</h1>

    {!! Form::open(['url' => 'modifPratFin']) !!}
    <div class="formModifPratGene">
        <div class="cardForm formModifPrat formPratLeft cardFormInput">
            {{--                {{var_dump($prat)}}--}}
            <input type="hidden" name="id" required value="{{$prat[0]->id_praticien}}">
            <div class="grid-container">
                <div class="adresse">
                    <label> Adresse :</label>
                    <input type="text" name="adresse" required value="{{$prat[0]->adresse_praticien}}">
                </div>
                <div class="cp">
                    <label> Code Postal :</label>
                    <input type="text" name="cp" required value="{{$prat[0]->cp_praticien}}">
                </div>
                <div class="ville">
                    <label> Ville :</label>
                    <input type="text" name="ville" required value="{{$prat[0]->ville_praticien}}">
                </div>
            </div>
        </div>
        <div class="formModifPratGene">
            <div class="cardForm formModifPrat formPratRight cardFormInput">
                <div class="grid-container">
                    <div class="coef">
                        <label> Coefficient Notoriété :</label>
                        <input type="text" name="coef" required value="{{$prat[0]->coef_notoriete}}">
                    </div>
                    <div class="typePrat">
                        <label> Type de praticien:</label>
                        <select name="typePrat" required>
                            <option value="{{$prat[0]->id_type_praticien}}"
                                    selected>{{$prat[0]->lib_type_praticien}}</option>
                            @foreach($mesTypes as $unType)
                                {{$typePrat=$prat[0]->lib_type_praticien}}
                                {{$typeAll=$unType->lib_type_praticien}}
                                @if($typePrat != $typeAll)
                                    <option
                                        value="{{ $unType->id_type_praticien }}">{{ $unType->lib_type_praticien }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="spe">
                        <label> Spécialité :</label>
                        <select name="spe" required>
                            <option value="{{$prat[0]->id_specialite}}">{{$prat[0]->lib_specialite}}</option>
                            @foreach($mesSpe as $uneSpe)
                                {{$spePrat=$prat[0]->lib_type_praticien}}
                                {{$speAll=$unType->lib_type_praticien}}
                                <option value="{{ $uneSpe->id_specialite }}">{{ $uneSpe->lib_specialite }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cardForm formBtn">
        <button class="btn" href="{{url('/listePraticiens')}}" class="annuler">Annuler</button>
        &nbsp
        <button class="btn" type="submit" class="valider">Valider</button>
    </div>
@stop
