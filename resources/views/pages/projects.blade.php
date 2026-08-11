<?php

use Livewire\Component;
use App\Models\Project;

new class extends Component
{
    public \Illuminate\Database\Eloquent\Collection $projects;

    public function mount()
    {
        $this->projects = Project::with("tags")->get();
    }
};
?>

<div>
   <!-- Projects Section -->
    <section id="projects" class="mx-auto max-w-[1280px] px-6 py-20 lg:px-12">
      <div id="projects_heading_517649" class="mb-10 flex items-end text-lg font-bold  justify-center">
        <div  id="projects_title_group_682415">
          <span class="text-xs uppercase  tracking-[.2em] text-[#4A9EE8]">01 / Selected work</span>
          <h2 class="display mt-3 text-4xl font-bold">Products built to be used.</h2>
        </div>
           </div>
      <div id="projects_grid_704182" class="grid gap-5 md:grid-cols-3">

       @forelse ($projects as $project)
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


</div>
