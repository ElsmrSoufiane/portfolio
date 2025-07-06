@extends('master')
@section('content')
<!-- Contact Section -->
<div id="contact" class="contact-us section">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
                <form id="contact" action="{{route('login')}}" method="post" >
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="section-heading">
                                <h6>connecter vous</h6>
                                
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <fieldset>
                                        <input type="email" name="email" id="login" placeholder="login" autocomplete="on" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <input type="password" name="password" id="mot de passe" placeholder="mot de passe" required>
                                    </fieldset>
                                </div>
                               
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="main-button">connecter</button>
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