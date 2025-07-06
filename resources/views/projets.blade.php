@extends('master')
@section('content')
<div id="tutorials" class="our-services section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow bounceIn" data-wow-duration="1s" data-wow-delay="0.2s">
            <h6>gestion des projets</h6>
         
         <a class="main-blue-button" href="/createprojet"  > +ajouter</a>
          </div>
        </div>
      </div>
    </div>
    </div>
<table class="table table-striped text-center" >
    <tr>
        <th>titre</th>
        <th>description</th>
        <th>code_source</th>
        <th>deploiement</th>
        <th>gerer les images</th>
        <th>modifier</th>
        <th>suprimer</th>
        </tr>
        @foreach($projects as $project)
         <tr>
        <td>{{$project->titre}}</td>
        <td>{{$project->description}}</td>
        <td>{{$project->code_source}}</td>
        <td>{{$project->deploiement}}</td>
        <td> <a class="main-blue-button" href="/images/{{$project->id}}"  > gerer les images</a></td>
         <td> <a class="main-blue-button" href="/editprojet/{{$project->id}}"  > modifier</a></td>
         <td> <a class="main-blue-button" href="/delete/projet/{{$project->id}}"  > suprimer</a></td>
        </tr>
        @endforeach
</table>
@endsection