@extends('layouts.master')
@section('content')
    <div>
        <br><br>
        <br><br>
        @php
            $nom = strtoupper($unPrat[0]->nom_praticien);
        @endphp
        <div class="infosActs">
            <div>
                <h1>Gestion des activités de {{$nom}} {{$unPrat[0]->prenom_praticien}}</h1>
            </div>
                <a class="buttonLink" type="button" href="{{url('/ajoutAct')}}/{{ $unPrat[0]->id_praticien }}"> Inviter à une activité </a>
            <table id='myTable'
                   class="table table-bordered table-striped table-hover table-light my-custom-scrollbar table-wrapper-scroll-y actTable">
                <thead>
                <tr id="tableHeader">
                    <th>Lieu</th>
                    <th>Thème</th>
                    <th>Motif</th>
                    <th>Spécialiste</th>
                    <th>Date</th>
                    <th class="iAwesom"><i class="fa fa-times"></i></th>
                    <th class="iAwesom"><i class="fa fa-pencil"></i></th>
                </tr>
                </thead>
                @foreach($lesActsPrat as $cpt=>$unAct)
                    @if($nbAct > 0)
                        <tr>
                            <td>{{ $unAct->lieu_activite }}</td>
                            <td>{{ $unAct->theme_activite }}</td>
                            <td>{{ $unAct->motif_activite }}</td>
                            <td>{{ $unAct->specialiste }}</td>
                            <td>{{ $unAct->date_activite }}</td>
                            <td><a class="button greenBtn" type="button"
                                   href="{{url('/supprAct')}}/{{ $unAct->id_activite_compl }}/{{ $unAct->id_praticien }}"
                                   data-toggle="tooltip" title="Supprimer"><i class="fa fa-times"></i></a></td>
                            <td><a class="button greenBtn" type="button"
                                   href="{{url('/modifAct')}}/{{ $unAct->id_activite_compl }}/{{ $unAct->id_praticien }}/{{ $unAct->specialiste }}"
                                   data-toggle="tooltip" title="Modifier"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                    @endif
                @endforeach
                @if($nbAct == 0)
                    <tr>
                        <td colspan="6">{{$nom}} {{$unPrat[0]->prenom_praticien}} n'a pas encore d'activité</td>
                    </tr>
                @endif
                <br><br>
            </table>
        </div>
        <div class="cardForm formBtn">
           <a class="btn" href="{{url('/listePraticiens')}}" class="annuler">Retour à la liste</a>
        </div>
    </div>
@stop
