@extends('master')
@section('content')
<div id="tutorials" class="our-services section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow bounceIn" data-wow-duration="1s" data-wow-delay="0.2s">
            <h6>gestion des images de : {{ $projet->titre }} </h6>

         <a class="main-blue-button" href="/createimage/{{$projet->id}}"  > +ajouter</a>
          </div>
        </div>
      </div>
    </div>
    </div>
<table class="table table-striped text-center" >
    <tr>
        <th>titre</th>
        <th>description</th>
       
        <th>suprimer</th>
        </tr>
        @foreach($images as $image)
         <tr>
        <td>{{$image->titre}}</td>
        <td>{{$image->description}}</td>
   
         <td> <a class="main-blue-button" href="/delete/image/{{$image->id}}"  > suprimer</a></td>
        </tr>
        @endforeach
</table>
@endsection