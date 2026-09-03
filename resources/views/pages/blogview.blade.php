<?php

use Livewire\Component;
use App\Models\Blog;
use App\Models\User;

new class extends Component
{
    public Blog  $blog;

     public function mount($id){
                $this->blog=Blog::with("sections")->find($id);
                $this->blog->views++;
                $this->blog->save();
     }
};
?>

<div>

  <div id="root_container_684219" style="min-height:100%;width:100%;background:#0F1319;color:#E4EEF8;font-family:'DM Sans',system-ui,sans-serif;">
  <main id="article_page_390571" class="grid-bg min-h-full">
    <section id="article_hero_814260" class="mx-auto max-w-[1280px] px-6 py-16 lg:px-12 lg:py-24">
      <div id="hero_content_650218" class="max-w-4xl reveal">
        <div id="category_label_728451" class="mb-6 flex items-center gap-3 text-xs uppercase tracking-[.2em] text-[#7EC8F0]">
          <span id="category_line_841362" class="h-px w-8 bg-[#4A9EE8]">
          </span>
          {{ $blog->tags->pluck('name')->implode(' · ') }}
        </div>
        <h1 id="article_title_274905" class="display max-w-4xl text-5xl font-bold leading-[.98] tracking-[-.03em] text-white md:text-7xl">
          {{ $blog->title }}
        </h1>
        <div id="article_meta_318742" class="mt-8 flex flex-wrap items-center gap-5 text-sm text-[#506070]">
          <span id="date_meta_583927">
            <i data-lucide="calendar" class="mr-1 inline h-4 w-4"></i>
            {{ $blog->created_at?->format('F j, Y') }}
          </span>
          <span id="read_time_meta_694138">
            <i data-lucide="clock" class="mr-1 inline h-4 w-4"></i>
            {{ $blog->duration }}
          </span>
          <span id="views_meta_694138">
            <i data-lucide="eye" class="mr-1 inline h-4 w-4"></i>
            {{ $blog->views }} views
          </span>
        </div>
      </div>
      <div id="video_card_927416" class="mt-14 w-full overflow-hidden border border-[#2A4060] bg-[#141920] shadow-[0_4px_6px_rgba(0,0,0,.18)] reveal">
        <div id="video_visual_650739" class="relative min-h-[280px] w-full overflow-hidden bg-[#1A2130]">
          @if ($blog->video)
            <div class="nex-video-player"
              data-src="{{ asset('storage/' . $blog->video) }}"
              data-title="{{ $blog->title }}"></div>
          @else
            <img id="video_thumbnail_716284" src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?crop=entropy&amp;cs=tinysrgb&amp;fit=max&amp;fm=jpg&amp;ixid=M3w3MjM4OTh8MHwxfHNlYXJjaHwxfHxmaW5hbmNlJTIwZGFzaGJvYXJkfGVufDB8fHx8MTc4NjU2NDc2MHww&amp;ixlib=rb-4.1.0&amp;q=80&amp;w=1080" data-image-label="Finance dashboard" alt="Finance dashboard video thumbnail" class="h-full w-full object-cover opacity-65 user-uploaded-image" data-attribution-url="" data-author="" data-author-link="">
            <div id="video_overlay_827395" class="absolute inset-0 bg-[#0F1319]/45">
            </div>
            <button id="play_video_button_938416" class="absolute left-1/2 top-1/2 flex h-16 w-16 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-[#4A9EE8] text-[#0F1319] transition duration-700 hover:scale-110 hover:bg-[#7EC8F0]" aria-label="Play video">
              <i data-lucide="play" class="ml-1 h-6 w-6 fill-current">
              </i>
            </button>
            <span id="video_duration_149528" class="absolute bottom-5 left-5 border border-white/20 bg-[#0F1319]/70 px-3 py-1 text-xs text-white">
              {{ $blog->duration }}
            </span>
          @endif
        </div>
      </div>
    </section>
    <section id="article_body_253870" class="mx-auto grid max-w-[1280px] gap-12 px-6 pb-24 lg:grid-cols-[220px_1fr] lg:px-12">
      <aside id="contents_panel_794162" class="lg:sticky lg:top-8 lg:self-start">
        <p id="contents_label_825314" class="text-xs uppercase tracking-[.18em] text-[#506070]">
          In this story
        </p>
        <nav id="contents_navigation_936425" class="mt-5 space-y-3 border-l border-[#2A4060] pl-4 text-sm text-[#8AAEC8]">
          @foreach ($blog->sections as $index => $section)
            <a id="contents_link_{{ $loop->iteration }}" href="#section_{{ $index }}" class="block transition duration-700 hover:translate-x-1 hover:text-[#7EC8F0]">
              {{ $section->title }}
            </a>
          @endforeach
        </nav>
      </aside>
      <article id="article_sections_608431" class="max-w-3xl space-y-16">
        @forelse ($blog->sections as $index => $section)
          <section id="section_{{ $index }}" class="reveal">
            <p id="section_{{ $index }}_label" class="mb-4 text-sm font-medium text-[#4A9EE8]">
              {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ $section->title }}
            </p>
            <h2 id="section_{{ $index }}_title" class="display text-3xl font-bold tracking-[-.03em] text-white md:text-4xl">
              {{ $section->title }}
            </h2>
            <div id="section_{{ $index }}_content" class="mt-6 space-y-5 text-[17px] font-light leading-8 text-[#8AAEC8]">
              @foreach (preg_split('/\R{2,}/', $section->content) as $paragraph)
                @if (trim($paragraph) !== '')
                  <p>{!! trim($paragraph) !!}</p>
                @endif
              @endforeach
            </div>
          </section>
        @empty
          <p class="rounded-xl border border-dashed border-[#1E3050] py-16 text-center text-sm text-[#506070]">
            No sections published yet — check back soon.
          </p>
        @endforelse
      </article>
    </section>
    <section id="comments_section_608431" class="mx-auto max-w-[1280px] px-6 pb-24 lg:px-12">
      <div class="max-w-3xl">
        <span class="text-xs uppercase tracking-[.2em] text-[#7EC8F0]">Comments</span>
        <h2 id="comments_title_390571" class="display mt-4 text-5xl font-bold">
          Discussion <span class="text-[#4A9EE8]">({{ $blog->comments()->count() }})</span>
        </h2>
        @guest
          <p class="mt-4 text-[#8AAEC8]">
            <a href="/user/login" class="text-[#4A9EE8] hover:underline">Log in</a>
            to share your opinion.
          </p>
        @endguest
      </div>
      <div class="dark">
        @livewire('commentions.comments', [
            'record' => $blog,
            'mentionables' => User::all(),
            'readonly' => false,
            'sidebarEnabled' => false,
        ])
      </div>
    </section>
  </main>
</div>