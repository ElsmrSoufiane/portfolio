<?php

use Livewire\Component;
use App\Models\Project;
use App\Models\Blog;

new class extends Component
{
  public ?int $postscount;

  public ?int $videoscount;

  public ?int $projectscount;
  
  public \Illuminate\Database\Eloquent\Collection $projects;

  public \Illuminate\Database\Eloquent\Collection $blogs;

  public function mount(){
           $this->projects=Project::with("tags")->latest()->limit(3)->get();
           $this->blogs=Blog::with("tags")->latest()->limit(3)->get();
           $this->postscount=Blog::all()->count();
           $this->projectscount=Project::all()->count();
           $this->videoscount=Blog::all()->count() + Project::whereHas("videos")->count();
  }

};
?>

<div id="root_638271" style="height: 100%; width: 100%; min-height: 100%;">
  <div id="page_741926" class="min-h-screen overflow-hidden">
    <!-- Ticker -->
    

    <!-- Hero Section -->
    <section id="home" class="relative mx-auto grid max-w-[1280px] gap-12 px-6 pb-24 pt-16 lg:grid-cols-[1.05fr_.95fr] lg:px-12 lg:pb-32 lg:pt-24">
      <div id="hero_grid_395817" class="grid-bg absolute inset-0 -z-0"></div>
      <div id="hero_copy_306728" class="relative z-10 rise">
        <div id="hero_eyebrow_724691" class="mb-7 flex items-center gap-3 text-md uppercase tracking-[.2em] text-[#4A9EE8]">
          <span class="h-px w-8 bg-[#4A9EE8]"></span>
          Full-stack developer · builder · teacher
        </div>
        <h1 id="hero_heading_618439" class="display max-w-3xl text-6xl  font-bold leading-[.94] text-[#E4EEF8] sm:text-7xl lg:text-8xl">
        <span class="mx-2 font-bold"> Build useful things.</span> 
          <span class="text-[#4A9EE8] font-bold ">Ship them beautifully.</span>
        </h1>
        <p id="hero_description_285716" class="mt-8 max-w-xl text-lg font-light leading-8 text-[#8AAEC8]">
          I design and build focused digital products with Laravel, TallStack, Filament, and modern DevOps workflows. Explore my work, learn with me, or bring an idea to life.
        </p>
        <div id="hero_actions_936172" class="mt-10 flex flex-wrap gap-4">
          <div class="flex  w-full font-bold">
            <div class="h-full  flex items-center">
          <a id="hero_video_link_782451" href="#videos" class="rounded-lg border border-[#2A4060] px-5 py-3 text-[#E4EEF8] transition duration-500 hover:-translate-y-1 hover:border-[#4A9EE8]">
            Watch tutorials
            <i data-lucide="circle-play" class="ml-2 inline h-4 w-4"></i>
          </a>
        </div>
          <div 
  class="nex-video-player"
  data-src="367684_medium.mp4"
  data-title="Video Title"
></div>
        </div>
        </div>
           </div>
      <div id="hero_visual_483029" class="relative z-10 flex items-center justify-center rise" style="animation-delay:.15s">
        <div id="workspace_card_816394" class="relative w-full max-w-md rotate-2 rounded-2xl border border-[#2A4060] bg-[#141920] p-3 soft transition duration-700 hover:rotate-0 hover:scale-[1.02]">
          <div id="workspace_inner_527681" class="rounded-xl border border-[#1E3050] bg-[#1A2130] p-5">
            <div id="workspace_header_391752" class="mb-8 flex items-center justify-between">
              <span class="text-sm text-[#8AAEC8]">Developer workspace</span>
              <span class="rounded-full bg-[#3DCC8E]/10 px-2 py-1 text-xs text-[#3DCC8E]">Active</span>
            </div>
            <div id="workspace_block_648215" class="mb-8">
              <span class="text-sm text-[#506070]">Current focus</span>
              <div class="display mt-2 text-4xl font-bold">
                Shipping products
                <span class="ml-2 text-sm font-normal text-[#4A9EE8]">on track</span>
              </div>
            </div>
            <svg id="workspace_chart_927416" viewBox="0 0 500 150" class="h-36 w-full" aria-label="Progress chart">
              <path d="M0 125 C45 118 65 95 105 105 S160 68 205 82 S255 30 300 60 S355 70 390 35 S445 46 500 10" fill="none" stroke="#4A9EE8" stroke-width="4"></path>
              <path d="M0 125 C45 118 65 95 105 105 S160 68 205 82 S255 30 300 60 S355 70 390 35 S445 46 500 10 V150 H0Z" fill="#4A9EE8" opacity=".08"></path>
            </svg>
            <div id="workspace_metrics_581629" class="grid grid-cols-2 gap-3">
              <div id="skills_metric_746281" class="rounded-lg bg-[#141920] p-3">
                <span class="text-xs text-[#506070]">Stack</span>
                <strong class="display mt-1 block text-xl">Laravel</strong>
              </div>
              <div id="delivery_metric_295814" class="rounded-lg bg-[#141920] p-3">
                <span class="text-xs text-[#506070]">Delivery</span>
                <strong class="display mt-1 block text-xl">Reliable</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
   <div id="hero_stats_921564" class="mt-5 grid   grid-cols-3 gap-5 border-t border-[#1E3050] pt-2 place-items-center  w-full">
          <div id="stat_projects_384915">
            <strong class="display block text-3xl text-[#E4EEF8]"> {{$this->projectscount  }} </strong>
            <span class="text-xs text-[#506070]">projects</span>
          </div>
          <div id="stat_posts_619284">
            <strong class="display block text-3xl text-[#E4EEF8]"> {{$this->postscount  }} </strong>
            <span class="text-xs text-[#506070]">posts</span>
          </div>
          <div id="stat_videos_752416">
            <strong class="display block text-3xl text-[#E4EEF8]"> {{$this->videoscount  }} </strong>
            <span class="text-xs text-[#506070]">videos</span>
          </div>
        </div>

    <!-- Projects Section -->
    <section id="projects" class="mx-auto max-w-[1280px] px-6 py-20 lg:px-12">
      <div id="projects_heading_517649" class="mb-10 flex items-end justify-between">
        <div id="projects_title_group_682415">
          <span class="text-xs uppercase tracking-[.2em] text-[#4A9EE8]">01 / Selected work</span>
          <h2 class="display mt-3 text-4xl font-bold">Products built to be used.</h2>
        </div>
        <a id="projects_contact_link_381926" href="https://wa.me/212612345678" target="_blank" rel="noopener" class="hidden text-sm text-[#8AAEC8] md:block">
          Need something similar?
          <span class="text-[#4A9EE8]">Let's talk →</span>
        </a>
      </div>
      <div id="projects_grid_704182" class="grid gap-5 md:grid-cols-3">
        
       @forelse ($projects as  $project)
         <a href="/project/{{ $project->id }}" wire:navigate wire:key="project-{{ $project->id }}"> 
               <article id="project_{{$project->id}}" class="group rounded-xl border border-[#1E3050] bg-[#141920] p-5 transition duration-700 hover:-translate-y-1 hover:border-[#4A9EE8]">
          <div id="project_visual_{{$project->id}}" class="mb-6 flex h-40 items-center justify-center overflow-hidden rounded-lg bg-[#1A2130]">
            @if ($project->image)
              <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
            @else
              <i data-lucide="layout-dashboard" class="h-12 w-12 text-[#4A9EE8]"></i>
            @endif
          </div>
          <span class="text-xs text-[#4A9EE8]">
            @foreach ($project->tags as $tag)
              {{$tag->name  }}.
            @endforeach
          </span>

          <h3 class="display mt-2 text-2xl font-bold"> {{$project->title}} </h3>
          <p class="mt-2 text-sm leading-6 text-[#8AAEC8]"> {{$project->description}} </p>
         <div class="mt-6 flex items-center justify-between text-sm"> 
             <span class="text-[#E4EEF8]">Instant access</span>
            <i data-lucide="arrow-up-right" class="h-4 w-4 text-[#4A9EE8]"></i>
          </div> 
        </article>
      </a>   
       @empty
        <p class="col-span-full rounded-xl border border-dashed border-[#1E3050] py-16 text-center text-sm text-[#506070]">No projects published yet — check back soon.</p> 
       @endforelse 
      </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="border-y border-[#1E3050] bg-[#141920]">
      <div id="blog_inner_682514" class="mx-auto max-w-[1280px] px-6 py-20 lg:px-12">
        <div id="blog_layout_914627" class="grid gap-12 lg:grid-cols-[.8fr_1.2fr]">
          <div id="blog_intro_528193">
            <span class="text-xs uppercase tracking-[.2em] text-[#4A9EE8]">02 / Blog</span>
            <h2 class="display mt-3 text-4xl font-bold">Notes from the build.</h2>
            <p class="mt-5 max-w-sm leading-7 text-[#8AAEC8]">Practical lessons on shipping products, marketing them, and keeping production systems boring.</p>
          </div>
          <div id="blog_posts_371649" class="divide-y divide-[#1E3050]">
            <a id="blog_post_one_618527" class="group flex items-center justify-between py-5" href="#">
              <div id="blog_post_one_copy_739416">
                <span class="text-xs text-[#506070]">DEVOPS · 6 MIN READ</span>
                <h3 class="mt-1 text-lg text-[#E4EEF8] transition group-hover:text-[#4A9EE8]">Deploying Laravel apps with Docker without the drama</h3>
              </div>
              <i data-lucide="arrow-up-right" class="h-5 w-5 text-[#506070] transition group-hover:-translate-y-1 group-hover:text-[#4A9EE8]"></i>
            </a>
            <a id="blog_post_two_925174" class="group flex items-center justify-between py-5" href="#">
              <div id="blog_post_two_copy_681429">
                <span class="text-xs text-[#506070]">MARKETING · 4 MIN READ</span>
                <h3 class="mt-1 text-lg text-[#E4EEF8] transition group-hover:text-[#4A9EE8]">The first 100 users: a developer's practical launch plan</h3>
              </div>
              <i data-lucide="arrow-up-right" class="h-5 w-5 text-[#506070] transition group-hover:-translate-y-1 group-hover:text-[#4A9EE8]"></i>
            </a>
            <a id="blog_post_three_517638" class="group flex items-center justify-between py-5" href="#">
              <div id="blog_post_three_copy_294816">
                <span class="text-xs text-[#506070]">LARAVEL · 8 MIN READ</span>
                <h3 class="mt-1 text-lg text-[#E4EEF8] transition group-hover:text-[#4A9EE8]">Queues, jobs, and the small architecture that scales</h3>
              </div>
              <i data-lucide="arrow-up-right" class="h-5 w-5 text-[#506070] transition group-hover:-translate-y-1 group-hover:text-[#4A9EE8]"></i>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Videos Section -->
    <section id="videos" class="mx-auto max-w-[1280px] px-6 py-20 lg:px-12">
      <div id="videos_header_618294" class="flex flex-col justify-between gap-8 md:flex-row md:items-end">
        <div id="videos_title_group_752681">
          <span class="text-xs uppercase tracking-[.2em] text-[#4A9EE8]">03 / Tutorials</span>
          <h2 class="display mt-3 text-4xl font-bold">Learn by shipping.</h2>
        </div>
        <a id="videos_all_link_481625" href="#" class="text-sm text-[#4A9EE8]">View all videos →</a>
      </div>
      <div id="videos_grid_739214" class="mt-10 grid gap-5 md:grid-cols-2">
        @forelse ($blogs as $blog)
        <a href="/blog/{{ $blog->id }}" wire:navigate wire:key="blog-{{ $blog->id }}">
        <article id="video_{{$blog->id}}" class="group flex gap-5 rounded-xl border border-[#1E3050] bg-[#141920] p-4 transition duration-700 hover:border-[#4A9EE8]">
          <div id="video_{{$blog->id}}_visual" class="flex h-28 w-40 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-[#1A2130]">
            @if ($blog->image)
              <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="h-full w-full object-cover">
            @else
              <i data-lucide="play" class="h-9 w-9 text-[#4A9EE8]"></i>
            @endif
          </div>
          <div id="video_{{$blog->id}}_copy">
            <span class="text-xs text-[#506070]">24 MIN · {{ $blog->tags->pluck('name')->implode(' · ') }}</span>
            <h3 class="display mt-2 text-xl font-bold">{{ $blog->title }}</h3>
            <p class="mt-2 text-sm text-[#8AAEC8]">{{ $blog->video }}</p>
          </div>
        </article>
        </a>
        @empty
        <p class="col-span-full rounded-xl border border-dashed border-[#1E3050] py-16 text-center text-sm text-[#506070]">No videos published yet — check back soon.</p>
        @endforelse
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="border-t border-[#1E3050] bg-[#141920]">
      <div id="about_inner_752416" class="mx-auto max-w-[1280px] px-6 py-20 lg:px-12">
        <span id="about_eyebrow_618295" class="text-xs uppercase tracking-[.2em] text-[#4A9EE8]">04 / About</span>
        <div id="about_content_491726" class="mt-5 grid gap-8 lg:grid-cols-[.8fr_1.2fr]">
          <h2 id="about_heading_826415" class="display text-4xl font-bold">Code, products, and ideas that move forward.</h2>
          <p id="about_description_739182" class="max-w-2xl text-lg leading-8 text-[#8AAEC8]">I'm a full-stack developer working with PHP, Laravel, TallStack, Filament, and DevOps tools. Alongside building reliable products, I bring nine months of digital marketing experience to help ideas reach the right audience.</p>
        </div>
      </div>
    </section>



</div>
</div>