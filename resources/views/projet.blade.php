@extends('master')
@section('content')

<div class="project-detail-section">
    <div class="container">
        <!-- Project Header -->
        <div class="project-header text-center mb-5">
            <h1 class="project-title">{{ $projet->titre }}</h1>
            @if($projet->deploiement)
            <div class="main-green-button">
                 
               
                <a href="{{ $projet->deploiement }}" target="_blank" class="">View Live Project</a>
            </div>
           
                @endif
                <br>
            @if($projet->code_source)
              <div class="main-green-button">
                <a href="{{ $projet->code_source }}" target="_blank" class="btn btn-secondary ml-2">View Source Code</a>
            </div>
            @endif
        </div>

        <!-- Main Project Image -->
        <div class="main-project-image mb-5">
            <img src="{{ asset('storage/' . $projet->image) }}" alt="{{ $projet->titre }}" class="img-fluid rounded shadow">
        </div>

        <!-- Project Description -->
        <div class="project-description mb-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="description-content">
                        <h3 class="mb-4">description</h3>
                        <p class="lead">{{ $projet->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Gallery -->
        @if($images->count() > 0)
        <div class="project-gallery mb-5">
            <h3 class="text-center mb-4">pages:</h3>
            <div class="row">
                @foreach($images as $image)
                <div class="col-md-6 mb-4">
                    <div class="gallery-item">
                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->titre }}" class="img-fluid rounded shadow-sm">
                        @if($image->description)
                        <div class="image-caption mt-2" >
                            <p style="font-size: 25px;">{{ $image->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Project Features -->
       

        <!-- Technologies Used -->
     
    </div>
</div>

<style>
    .project-detail-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }
    
    .project-title {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #333;
    }
    
    .main-project-image {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .gallery-item {
        transition: transform 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-5px);
    }
    
    .feature-list {
        list-style-type: none;
        padding-left: 0;
    }
    
    .feature-list li {
        padding: 8px 0;
        position: relative;
        padding-left: 25px;
    }
    
    .feature-list li:before {
        content: "✓";
        color: #0d6efd;
        position: absolute;
        left: 0;
    }
    
    .tech-badges {
        margin-top: 15px;
    }
    
    .badge {
        font-size: 0.9rem;
        padding: 8px 12px;
        margin-bottom: 8px;
    }
</style>

@endsection