@extends('master')
@section('content')
<!-- Contact Section -->
<div id="contact" class="contact-us section">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
                <form id="contact" action="{{route('image.store',$projet->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="section-heading">
                                <h6> ajouter une image à : {{$projet->titre}} </h6>
                              
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <fieldset>
                                        <input type="text" name="titre" id="titre" placeholder="Titre" autocomplete="on" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <input type="file" name="image" id="image" placeholder="Image" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="description" id="description" placeholder="Description" required></textarea>
                                    </fieldset>
                                </div>
                               
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="main-button">Ajouter image</button>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection