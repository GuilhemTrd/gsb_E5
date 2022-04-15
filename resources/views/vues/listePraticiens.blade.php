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
                    <input class="awsome_input" id='myInput' onkeyup='searchTable()' type='text'
                           placeholder="Rechercher...">
                    <span class="awsome_input_border"/>
                </div>
                <div class="right">
                    <a class="buttonLink" type="button" href="{{url('/ajoutPrat')}}"> Ajouter un praticien </a>
                </div>
            </div>

            <br>
            <table id='myTable' class="table table-bordered table-striped table-hover table-light my-custom-scrollbar table-wrapper-scroll-y pratTable">
                <thead>
                <tr id="tableHeader" class="tableHeader">
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Spécialité</th>
                    <th>Type</th>
                    <th class="iAwesom"><i class="fa fa-calendar" aria-hidden="true"></i></th>
                    <th class="iAwesom"><i class="fa fa-pencil"></i></th>
                    <th class="iAwesom"><i class="fa fa-times"></i></th>
                </tr>
                </thead>

                @foreach($allInfos as $cpt=>$unPrat)
                    @if($cpt == 0)
                        @php
                            $cpt = 1;
                        @endphp
                    @endif
                @if($allInfos[$cpt-1]->id_praticien != $allInfos[$cpt]->id_praticien)
                    <tr>
                        <td class="search text-uppercase">{{ $unPrat->nom_praticien }}</td>
                        <td>{{ $unPrat->prenom_praticien }}</td>
                        <td class="search">{{ $unPrat->lib_specialite }}@if($unPrat->lib_specialite == null) Pas de spécialité @endif</td>
                        <td class="search">{{ $unPrat->lib_type_praticien }}</td>
                        <td>
                            <a class="button greenBtn" type="button" href="{{url('/infosAct')}}/{{ $unPrat->id_praticien }}" data-toggle="tooltip" title="Informations activité(s)"><i class="fa fa-calendar" aria-hidden="true"></i></a>
                        </td>
                        <td>
                            <a class="button greenBtn" type="button" href="{{url('/modifPrat')}}/{{ $unPrat->id_praticien }}" data-toggle="tooltip" title="Modifier"><i class="fa fa-pencil"></i></a>
                        </td>
                        <td>
                            <a class="button greenBtn" type="button" href="{{url('/supprPrat')}}/{{ $unPrat->id_praticien }}" data-toggle="tooltip" title="Supprimer"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endif
                @endforeach
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
                                if (tr[i].id !== 'tableHeader') {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    }
                </script>
        </div>
    </div>
@stop
