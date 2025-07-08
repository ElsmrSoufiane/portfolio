
@extends('master')
@section('content')

  <!-- Hero Banner -->
  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                <h2>Bonjour, je suis <em>Soufiane Lasmar</em></h2>
                <p>Technicien spécialisé en développement digital avec 2 ans d'expérience.</p>
                <div class="main-green-button scroll-to-section">
                  <a href="{{ route('download.cv') }}">Télécharger CV</a>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                <div class="hero-blob-container">
                  <div class="gooey"></div>
                  <img src="{{ asset('s2.png') }}" alt="Soufiane Lasmar" class="hero-image">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- About Section -->
  <div id="about" class="about-us section">
    <div class="container">
      <div class="row">
        <div class="text-center align-self-center wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
          <div class="section-heading">
            <h6>À propos</h6>
            <h2>Qui <em>je suis</em> &amp; ce que <span>je fais</span></h2>
          </div>
          <div class="row">
            <div class="col-lg-4 col-sm-4">
              <div class="about-item">
                <h4>{{ $projects->count() }}+</h4>
                <h6>Projets</h6>
              </div>
            </div>
            <div class="col-lg-4 col-sm-4">
              <div class="about-item">
                <h4>{{ $tutorials->count() }}+</h4>
                <h6>Tutoriels</h6>
              </div>
            </div>
            <div class="col-lg-4 col-sm-4">
              <div class="about-item">
                <h4>2+</h4>
                <h6>Années d'expérience</h6>
              </div>
            </div>
          </div>
          <p>Je suis un technicien spécialisé en développement digital passionné par la création de solutions web modernes. Mon expertise couvre le développement frontend et backend avec Laravel et React, ainsi que la gestion de bases de données SQL et NoSQL.</p>
          <div class="main-blue-button">
            <a href="#">Télécharger CV</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Projects Section -->
  <div id="projects" class="our-portfolio section">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="section-heading wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
            <h6>Mon travail</h6>
            <h2>Mes <em>projets</em> récents</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid wow fadeIn" data-wow-duration="1s" data-wow-delay="0.7s">
      <div class="row">
        <div class="col-lg-12">
          <div class="loop owl-carousel">
            @foreach($projects as $project)
            <div class="item">
              <div class="portfolio-item">
                <div class="thumb">
                  <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->titre }}">
                  <div class="hover-content">
                    <div class="inner-content">
                      @if($project->deploiement)
                        <a href="{{ $project->deploiement }}" target="_blank"><h4>{{ $project->titre }}</h4></a>
                      @else
                        <h4>{{ $project->titre }}</h4>
                      @endif
                      <a href="/projet/{{ $project->id }}" target="_blank" class="text-white">Détails du projet</a>
                      @if($project->code_source)
                        <div class="mt-2">
                          <a href="{{ $project->code_source }}" target="_blank" class="text-white">Voir le code</a>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tutorials Section -->
  <div id="tutorials" class="our-services section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow bounceIn" data-wow-duration="1s" data-wow-delay="0.2s">
            <h6>Mes tutoriels</h6>
            <h2>Apprenez avec <span>mes</span> <em>guides</em></h2>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        @foreach($tutorials as $tutorial)
        <div class="col-lg-4">
          <div class="service-item wow bounceInUp" data-wow-duration="1s" data-wow-delay="0.3s">
            <div class="row">
              <div class="col-lg-4">
                <div class="icon">
                  <img src="{{ asset('storage/' . $tutorial->icon) }}" alt="">
                </div>
              </div>
              <div class="col-lg-8">
                <div class="right-content">
                  <h4>{{ $tutorial->titre }}</h4>
                  <p>{{ $tutorial->description ?? 'Découvrez ce tutoriel complet' }}</p>
                  <a href="{{ $tutorial->url }}" target="_blank" class="text-primary">Lire le tutoriel →</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Skills Section -->
  <div id="skills" class="features section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h6>Mes compétences</h6>
            <h2>Technologies <em>que je maîtrise</em></h2>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="skills-section">
            <div class="container">
              <div class="skills-grid">
                <!-- Compétence Laravel -->
                <div class="skill-card">
                  <div class="skill-info">
                    <div class="skill-icon">
                      <i class="fab fa-laravel"></i>
                    </div>
                    <h3 class="skill-name">Laravel</h3>
                    <div class="skill-level">
                      <div class="level-bar" style="width: 85%;" data-level="85%"></div>
                    </div>
                    <div class="skill-percentage">85%</div>
                  </div>
                  <div class="skill-description">
                    Développement d'applications web robustes avec le framework PHP Laravel
                  </div>
                </div>
                
                <!-- Compétence React -->
                <div class="skill-card">
                  <div class="skill-info">
                    <div class="skill-icon">
                      <i class="fab fa-react"></i>
                    </div>
                    <h3 class="skill-name">React</h3>
                    <div class="skill-level">
                      <div class="level-bar" style="width: 80%;" data-level="80%"></div>
                    </div>
                    <div class="skill-percentage">80%</div>
                  </div>
                  <div class="skill-description">
                    Création d'interfaces utilisateur dynamiques avec React.js
                  </div>
                </div>
                
                <!-- Compétence Python -->
                <div class="skill-card">
                  <div class="skill-info">
                    <div class="skill-icon">
                      <i class="fab fa-python"></i>
                    </div>
                    <h3 class="skill-name">Python</h3>
                    <div class="skill-level">
                      <div class="level-bar" style="width: 70%;" data-level="70%"></div>
                    </div>
                    <div class="skill-percentage">70%</div>
                  </div>
                  <div class="skill-description">
                    Programmation orientée objet et scripts utilitaires en Python
                  </div>
                </div>
                
                <!-- Compétence Bases de données -->
                <div class="skill-card">
                  <div class="skill-info">
                   
                    <h3 class="skill-name">Bases de données</h3>
                    <div class="skill-level">
                      <div class="level-bar" style="width: 75%;" data-level="75%"></div>
                    </div>
                    <div class="skill-percentage">75%</div>
                  </div>
                  <div class="skill-description">
                    MySQL pour les bases relationnelles et MongoDB pour le NoSQL
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Section -->
  <div id="contact" class="contact-us section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
          <form id="contact" action="{{ route('contact.store') }}" method="post">
            @csrf
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="section-heading">
                  <h6>Contactez-moi</h6>
                  <h2>Restons en <span>contact</span></h2>
                </div>
              </div>
              <div class="col-lg-9">
                <div class="row">
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="name" name="nom" id="name" placeholder="Nom" autocomplete="on" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="email" name="email" id="email" placeholder="Email" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <textarea name="message" id="message" placeholder="Votre message" required></textarea>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="main-button">Envoyer le message</button>
                    </fieldset>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="contact-info">
                  <ul>
                    <li>
                      <div class="icon">
                        <img src="assets/images/contact-icon-01.png" alt="">
                      </div>
                      <a href="#">soufianeasmar0@email.com</a>
                    </li>
                    <li>
                      <div class="icon">
                        <img src="assets/images/contact-icon-02.png" alt="">
                      </div>
                      <a href="#">+212 7 66 54 87 09</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<style>
  /* Styles pour l'effet blob */
  .hero-blob-container {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
  }
  
  .gooey {
    background-image: linear-gradient(120deg, #34a1ff 0%, #b400ff 100%);
    border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%;
    width: 300px;
    height: 300px;
    animation: morph 8s linear infinite;
    transform-style: preserve-3d;
    outline: 1px solid transparent;
    will-change: border-radius;
    position: absolute;
    filter: blur(0px);
    z-index: 1;
  }
  
  .gooey:before,
  .gooey:after {
    content: '';
    width: 100%;
    height: 100%;
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%;
    box-shadow: 5px 5px 89px rgba(0, 102, 255, 0.21);
    will-change: border-radius, transform, opacity;
    animation-delay: 200ms;
    background-image: linear-gradient(120deg, rgba(52, 161, 255, 0.55) 0%, rgba(0, 103, 255, 0.89) 100%);
  }
  
  .gooey:before {
    animation: morph 4s linear infinite;
    opacity: .21;
    animation-duration: 1.5s;
  }
  
  .gooey:after {
    animation: morph 5s linear infinite;
    animation-delay: 400ms;
    opacity: .89;
  }
  
  @keyframes morph {
    0%,100% {
      border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%;
      transform: translate3d(0,0,0) rotateZ(0.01deg);
    }
    34% {
      border-radius: 70% 30% 46% 54% / 30% 29% 71% 70%;
      transform: translate3d(0,5px,0) rotateZ(0.01deg);
    }
    50% {
      opacity: .89;
      transform: translate3d(0,0,0) rotateZ(0.01deg);
    }
    67% {
      border-radius: 100% 60% 60% 100% / 100% 100% 60% 60%;
      transform: translate3d(0,-3px,0) rotateZ(0.01deg);
    }
  }
  
  .hero-image {
    position: relative;
    z-index: 2;
    width: 280px;
    height: 280px;
    object-fit: cover;
    border-radius: 50%;
    border: 5px solid white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    animation: float 6s ease-in-out infinite;
  }
  
  @keyframes float {
    0%, 100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-20px);
    }
  }

  /* Styles pour la section des compétences */
  .skills-section {
    padding: 80px 0;
    background: #f9f9ff;
  }

  .section-title {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 15px;
    color: #222;
  }

  .section-subtitle {
    text-align: center;
    color: #777;
    margin-bottom: 60px;
    font-size: 1.1rem;
  }

  .skills-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
  }

  .skill-card {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .skill-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  }

  .skill-info {
    margin-bottom: 20px;
  }

  .skill-icon {
    font-size: 2.5rem;
    color: #34a1ff;
    margin-bottom: 15px;
  }

  .skill-name {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: #333;
  }

  .skill-level {
    height: 8px;
    background: #f0f0f0;
    border-radius: 4px;
    margin-bottom: 8px;
    overflow: hidden;
  }

  .level-bar {
    height: 100%;
    background: linear-gradient(to right, #34a1ff, #94bfff);
    border-radius: 4px;
    transition: width 1.5s ease;
  }

  .skill-percentage {
    text-align: right;
    font-weight: bold;
    color: #34a1ff;
  }

  .skill-description {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.5;
  }

  /* Animation pour les barres de progression */
  @keyframes fillBars {
    from {
      width: 0;
    }
    to {
      width: 100%;
    }
  }
</style>

<script>
  // Animation pour les barres de progression
  document.addEventListener('DOMContentLoaded', function() {
    const levelBars = document.querySelectorAll('.level-bar');
    
    levelBars.forEach(bar => {
      const targetWidth = bar.getAttribute('data-level');
      bar.style.width = '0';
      
      setTimeout(() => {
        bar.style.width = targetWidth;
      }, 100);
    });
  });
</script>
@endsection