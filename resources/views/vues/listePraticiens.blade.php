@extends('layouts.master')
@section('content')
<div>
    <br><br>
    <br><br>
    <div class="container listePrat">
        <div>
            <h1>Liste des Praticiens</h1>
        </div>

        <div class="left_right">
            <div class="input_container left">
                <input class="awsome_input" id='myInput' onkeyup='searchTable()' type='text' placeholder="Rechercher...">
                <span class="awsome_input_border"/>
            </div>
            <div class="right">
                <a class="buttonLink" type="button" href="{{url('/ajoutPrat')}}"> Ajouter un praticien </a>
            </div>
        </div>


        <table id='myTable' class="table table-bordered table-striped table-hover table-light my-custom-scrollbar table-wrapper-scroll-y pratTable">
            <thead>
            <tr id="tableHeader" class="tableHeader">
                <th>Prenom</th>
                <th>Nom</th>
                <th>Spécialité</th>
                <th>Type</th>
                <th class="iAwesom"><i class="fa fa-calendar" aria-hidden="true"></i></th>
                <th class="iAwesom"><i class="fa fa-pencil"></i></th>
                <th class="iAwesom"><i class="fa fa-times"></i></th>
            </tr>
            </thead>
            @foreach($mesPratsPoss as $unPratPoss)
                    <tr>
                        <td>{{ $unPratPoss->prenom_praticien }}</td>
                        <td class="search text-uppercase">{{ $unPratPoss->nom_praticien }}</td>
                        <td class="search">{{ $unPratPoss->lib_specialite }}</td>
                        <td class="search">{{ $unPratPoss->lib_type_praticien }}</td>
                        <td><a class="button greenBtn" type="button" href="{{url('/infosAct')}}/{{ $unPratPoss->id_praticien }}" data-toggle="tooltip" title="Informations activité(s)"><i class="fa fa-calendar" aria-hidden="true"></i></a></td>
                        <td><a class="button greenBtn" type="button" href="{{url('/modifPrat')}}/{{ $unPratPoss->id_praticien }}" data-toggle="tooltip" title="Modifier"><i class="fa fa-pencil"></i></a></td>
                        <td><a class="button greenBtn" type="button" href="{{url('/supprPrat')}}/{{ $unPratPoss->id_praticien }}" data-toggle="tooltip" title="Supprimer"><i class="fa fa-times"></i></a></td>
                    </tr>
            @endforeach
            @foreach($mesPrats as $unPrat)
                <tr>
                    <td>{{ $unPrat->prenom_praticien }}</td>
                    <td class="search text-uppercase">{{ $unPrat->nom_praticien }}</td>
                    <td class="search">Pas de spécialité</td>
                    <td class="search">{{ $unPratPoss->lib_type_praticien }}</td>
                    <td><a class="button greenBtn" type="button" href="{{url('/infosAct')}}/{{ $unPratPoss->id_praticien }}" data-toggle="tooltip" title="Informations activité(s)"><i class="fa fa-calendar" aria-hidden="true"></i></a></td>
                    <td><a class="button greenBtn" type="button" href="{{url('/modifPrat')}}/{{ $unPratPoss->id_praticien }}" data-toggle="tooltip" title="Modifier"><i class="fa fa-pencil"></i></a></td>
                    <td><a class="button greenBtn" type="button" href="{{url('/supprPrat')}}/{{ $unPratPoss->id_praticien }}" data-toggle="tooltip" title="Supprimer"><i class="fa fa-times"></i></a></td>
                </tr>
            @endforeach
            <br><br>
        </table>

        <script>
            function searchTable() {
                var input, filter, found, table, tr, td, i, j;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByClassName("search");
                    for (j = 0; j < td.length; j++) {
                        if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                        }
                    }
                    if (found) {
                        tr[i].style.display = "";
                        found = false;
                    } else {
                        if (tr[i].id !== 'tableHeader'){
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
    </div>
</div>
@stop
