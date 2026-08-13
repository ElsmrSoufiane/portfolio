<?php

use Livewire\Component;
use App\Models\Blog;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

new class extends Component
{ 
  use WithPagination,WithPagination;
    #[Computed]
    public function blogs()
    {
        return  Blog::with("tags")->paginate(10);
    }
};
?>

<div>
   <!-- Videos Section -->
    <section id="videos" class="mx-auto max-w-[1280px] px-6 py-20 lg:px-12">
    <div id="videos_header_618294" class="h-full flex flex-col justify-center items-center gap-8 text-lg font-bold text-center">
  <div id="videos_title_group_752681" class="text-center">
    <span class="text-xs uppercase tracking-[.2em] text-[#4A9EE8]">03 / Tutorials</span>
    <h2 class="display mt-3 text-4xl font-bold">Learn by shipping.</h2>
  </div>
</div>
      <div id="videos_grid_739214" class="mt-10 grid gap-5 md:grid-cols-2">
        @forelse ($this->blogs as $blog)
        <a href="/blog/{{ $blog->id }}" wire:navigate wire:key="blog-{{ $blog->id }}" class="blog">
        <article id="video_{{$blog->id}}" class="group flex gap-5 rounded-xl border border-[#1E3050] bg-[#141920] p-4 transition duration-700 hover:border-[#4A9EE8]">
          <div id="video_{{$blog->id}}_visual" class="flex h-28 w-40 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-[#1A2130]">
            @if ($blog->image)
              <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="h-full w-full object-cover">
            @else
              <i data-lucide="play" class="h-9 w-9 text-[#4A9EE8]"></i>
            @endif
          </div>
          <div id="video_{{$blog->id}}_copy">
            <span class="text-xs text-[#506070]">Duration {{ $blog->duration }} · Views {{ $blog->views }} · {{ $blog->tags->pluck('name')->implode(' · ') }}</span>
            <h3 class="display mt-2 text-xl font-bold">{{ $blog->title }}</h3>
            <p class="mt-2 text-sm text-[#8AAEC8]">{{ $blog->video }}</p>
          </div>
        </article>
        </a>
        @empty
        <p class="col-span-full rounded-xl border border-dashed border-[#1E3050] py-16 text-center text-sm text-[#506070]">No videos published yet — check back soon.</p>
        @endforelse
      </div>
          {{$this->blogs->links()  }}  
    </section>

    <script>
      gsap.registerPlugin(ScrollTrigger);
      gsap.from(".blog", {
        ease: 'power.out',
        stagger: 0.5,
        duration: 0.8,
        opacity: 0,
        y: 100,
        scrollTrigger: {
          trigger: ".blog",
          toggleActions: "play none none reverse"
        }
      });
    </script>
</div>
