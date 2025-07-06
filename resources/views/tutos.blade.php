@extends('master')
@section('content')
<div id="tutorials" class="our-services section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow bounceIn" data-wow-duration="1s" data-wow-delay="0.2s">
            <h6>gestion des tutoriels</h6>
         <a class="main-blue-button" href="/create_tutorial"  > +ajouter</a>
          </div>
        </div>
      </div>
    </div>
    </div>
<table class="table table-striped text-center" >
    <tr>
        <th>titre</th>
        <th>url</th>
        <th>icon</th>
        
       
        <th>modifier</th>
        <th>suprimer</th>
        </tr>
        @foreach($tutorials as $tutorial)
         <tr>
        <td>{{$tutorial->titre}}</td>
        <td>{{$tutorial->url}}</td>
        <td>{{$tutorial->icon}}</td>
        
    
         <td> <a class="main-blue-button" href="/edittutoriel/{{$tutorial->id}}"  > modifier</a></td>
         <td> <a class="main-blue-button" href="/delete/tutoriel/{{$tutorial->id}}"  > suprimer</a></td>
        </tr>
        @endforeach
</table>
@endsection