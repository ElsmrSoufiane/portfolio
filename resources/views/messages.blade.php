@extends('master')
@section('content')
<div id="tutorials" class="our-services section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow bounceIn" data-wow-duration="1s" data-wow-delay="0.2s">
            <h6>gestion des messages</h6>
         
       
          </div>
        </div>
      </div>
    </div>
    </div>
<table class="table table-striped text-center" >
    <tr>
        <th>nom</th>
        <th>email</th>
        <th>message</th>
    
        <th>suprimer</th>
        </tr>
        @foreach($contacts as $contact)
         <tr>
        <td>{{$contact->nom}}</td>
        <td>{{$contact->email}}</td>
        <td>{{$contact->message}}</td>
        <td> <a class="main-blue-button" href="/delete/contact/{{$contact->id}}"  > suprimer</a></td>
        </tr>
        @endforeach
</table>
@endsection