@extends('master')
@section('content')
<!-- Tutorial Section -->
<div id="tutorial" class="contact-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
                <form enctype="multipart/form-data" id="contact"  action="{{route('tutorials.update',$tutorial->id) }}"  method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="section-heading">
                                <h6>modifier le tutorial: {{$tutorial->titre}}  </h6>
                              
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <fieldset>
                                        <input value="{{$tutorial->titre}}" type="text" name="titre" id="titre" placeholder="Titre" autocomplete="on" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <input value="{{$tutorial->url}}" type="url" name="url" id="url" placeholder="URL du tutoriel" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input  type="file" name="icon" id="icon" placeholder="icon du tutoriel" required>
                                        
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="main-button">modifier</button>
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