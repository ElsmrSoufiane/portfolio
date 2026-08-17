<?php
use Livewire\Component;
use App\Models\Project;
new class extends Component
{
    public Project $project;
    public function mount(int $id): void
    {
        $this->project = Project::with([
            'tags',
            'sections',
            'videos',
            'themes.themeimages',
            'images',
        ])->findOrFail($id);
    }
};
?>
<div>
  <div id="root_container_684291" style="height: 100%; width: 100%; min-height: 100%; background:#0F1319; color:#E4EEF8; font-family:'DM Sans',system-ui,sans-serif;">
    <main id="project_page_739182" class="relative min-h-full overflow-hidden">
      <section id="project_hero_384927" class="nova-shell relative mx-auto grid max-w-[1280px] gap-12 px-12 pb-24 pt-20 md:grid-cols-[1.05fr_.95fr]">
        <div id="project_thumbnail_518306" class="nova-card nova-hover order-2 overflow-hidden md:order-1">
          <div id="thumbnail_frame_736214" class="relative aspect-[4/3] bg-[#1E2838]">
            @if ($project->image)
              <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="h-full w-full object-cover opacity-80">
            @else
              <div class="flex h-full items-center justify-center">
                <i data-lucide="layout-dashboard" class="h-16 w-16 text-[#4A9EE8]"></i>
              </div>
            @endif
            <div id="thumbnail_overlay_341862" class="absolute inset-0 bg-gradient-to-tr from-[#0F1319]/80 via-transparent to-[#4A9EE8]/20"></div>
          </div>
        </div>
        <div id="project_hero_copy_592704" class="nova-reveal order-1 self-center md:order-2">
          <div id="project_kicker_618203" class="mb-6 flex items-center gap-3 text-xs uppercase tracking-[.24em] text-[#7EC8F0]">
            <span class="h-2 w-2 rounded-full bg-[#3DCC8E]"></span>
            @foreach ($project->tags as $tag)
              {{ $tag->name }}@if (!$loop->last) · @endif
            @endforeach
          </div>
          <h1 id="project_title_804316" class="nova-display nova-title text-7xl font-extrabold leading-[.9] text-[#E4EEF8]">
            {{ $project->title }}
            <span class="text-[#4A9EE8]">.</span>
          </h1>
          <p id="project_description_471850" class="mt-8 max-w-xl text-lg font-light leading-8 text-[#8AAEC8]">
            {{ $project->description }}
          </p>
          @if ($project->images->isNotEmpty() || $project->videos->isNotEmpty())
            <div id="project_media_thumbs_902674" class="mt-10 flex flex-wrap gap-3">
              @if ($project->images->isNotEmpty())
                {{-- Images modal (Filament) --}}
                <x-filament::modal id="project-images-modal-{{ $project->id }}" width="7xl" alignment="center">
                  <x-slot name="trigger">
                    <button
                      type="button"
                      class="inline-flex items-center gap-2 rounded-lg border border-sky-300 px-4 py-2 text-sm font-medium text-sky-300 transition-all duration-300 hover:bg-sky-300/10 hover:border-sky-400 hover:shadow-lg hover:shadow-sky-300/20 focus:outline-none focus:ring-2 focus:ring-sky-300/50"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                      </svg>
                      {{ $project->images->count() }} {{ Str::plural('Image', $project->images->count()) }}
                    </button>
                  </x-slot>

                  <div
                    x-data="{
                      slides: @js($project->images->map(fn ($img) => [
                        'imgSrc' => asset('storage/' . $img->image),
                        'imgAlt' => $project->title . ' - Image',
                      ])->values()->all()),
                      currentSlideIndex: 1,
                      previous() {
                        this.currentSlideIndex = this.currentSlideIndex > 1
                          ? this.currentSlideIndex - 1
                          : this.slides.length
                      },
                      next() {
                        this.currentSlideIndex = this.currentSlideIndex < this.slides.length
                          ? this.currentSlideIndex + 1
                          : 1
                      },
                    }"
                    class="relative w-full overflow-hidden rounded-lg bg-[#1A2130]"
                  >
                    <!-- Navigation Buttons -->
                    <button
                      type="button"
                      class="absolute left-5 top-1/2 z-20 flex -translate-y-1/2 items-center justify-center rounded-full bg-black/40 p-2 text-white transition hover:bg-black/60"
                      aria-label="previous slide"
                      x-on:click="previous()"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                      </svg>
                    </button>
                    <button
                      type="button"
                      class="absolute right-5 top-1/2 z-20 flex -translate-y-1/2 items-center justify-center rounded-full bg-black/40 p-2 text-white transition hover:bg-black/60"
                      aria-label="next slide"
                      x-on:click="next()"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                      </svg>
                    </button>
                    <div class="relative min-h-[50svh] w-full">
                      <template x-for="(slide, index) in slides" :key="index">
                        <div
                          x-show="currentSlideIndex === index + 1"
                          class="absolute inset-0"
                          x-transition.opacity.duration.1000ms
                        >
                          <img
                            class="absolute inset-0 h-full w-full object-cover"
                            x-bind:src="slide.imgSrc"
                            x-bind:alt="slide.imgAlt"
                          />
                        </div>
                      </template>
                    </div>
                    <!-- Dots -->
                    <div
                      class="absolute bottom-3 left-1/2 z-20 flex -translate-x-1/2 gap-3 rounded-full bg-black/60 px-3 py-1.5 md:bottom-5"
                      role="group"
                      aria-label="slides"
                    >
                      <template x-for="(slide, index) in slides" :key="index">
                        <button
                          class="size-2 rounded-full transition"
                          x-on:click="currentSlideIndex = index + 1"
                          x-bind:class="[currentSlideIndex === index + 1 ? 'bg-white' : 'bg-white/50']"
                          x-bind:aria-label="'slide ' + (index + 1)"
                        ></button>
                      </template>
                    </div>
                  </div>
                </x-filament::modal>
              @endif
              @if ($project->videos->isNotEmpty())
                {{-- Videos modal (Filament) --}}
                <x-filament::modal id="project-videos-modal-{{ $project->id }}" width="7xl" alignment="center">
                  <x-slot name="trigger">
                    <button
                      type="button"
                      class="inline-flex items-center gap-2 rounded-lg border border-sky-300 px-4 py-2 text-sm font-medium text-sky-300 transition-all duration-300 hover:bg-sky-300/10 hover:border-sky-400 hover:shadow-lg hover:shadow-sky-300/20 focus:outline-none focus:ring-2 focus:ring-sky-300/50"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                      </svg>
                      {{ $project->videos->count() }} {{ Str::plural('Video', $project->videos->count()) }}
                    </button>
                  </x-slot>

                  <div
                    x-data="{
                      slides: @js($project->videos->map(fn ($vid) => [
                        'videoSrc' => asset('storage/' . $vid->video),
                        'title' => $vid->title,
                      ])->values()->all()),
                      currentSlideIndex: 1,
                      previous() {
                        this.currentSlideIndex = this.currentSlideIndex > 1
                          ? this.currentSlideIndex - 1
                          : this.slides.length
                      },
                      next() {
                        this.currentSlideIndex = this.currentSlideIndex < this.slides.length
                          ? this.currentSlideIndex + 1
                          : 1
                      },
                    }"
                    class="relative w-full overflow-hidden rounded-lg bg-[#1A2130]"
                  >
                    <!-- Navigation Buttons -->
                    <button
                      type="button"
                      class="absolute left-5 top-1/2 z-20 flex -translate-y-1/2 items-center justify-center rounded-full bg-black/40 p-2 text-white transition hover:bg-black/60"
                      aria-label="previous slide"
                      x-on:click="previous()"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                      </svg>
                    </button>
                    <button
                      type="button"
                      class="absolute right-5 top-1/2 z-20 flex -translate-y-1/2 items-center justify-center rounded-full bg-black/40 p-2 text-white transition hover:bg-black/60"
                      aria-label="next slide"
                      x-on:click="next()"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                      </svg>
                    </button>
                    <div class="relative min-h-[50svh] w-full">
                      <template x-for="(slide, index) in slides" :key="index">
                        <div
                          x-show="currentSlideIndex === index + 1"
                          class="absolute inset-0"
                          x-transition.opacity.duration.1000ms
                        >
                          <div class="flex h-full w-full items-center justify-center bg-[#1A2130]">
                            <video
                              x-bind:src="slide.videoSrc"
                              class="max-h-[80vh] w-full object-contain"
                              preload="metadata"
                              controls
                            ></video>
                          </div>
                        </div>
                      </template>
                    </div>
                    <!-- Dots -->
                    <div
                      class="absolute bottom-3 left-1/2 z-20 flex -translate-x-1/2 gap-3 rounded-full bg-black/60 px-3 py-1.5 md:bottom-5"
                      role="group"
                      aria-label="slides"
                    >
                      <template x-for="(slide, index) in slides" :key="index">
                        <button
                          class="size-2 rounded-full transition"
                          x-on:click="currentSlideIndex = index + 1"
                          x-bind:class="[currentSlideIndex === index + 1 ? 'bg-white' : 'bg-white/50']"
                          x-bind:aria-label="'slide ' + (index + 1)"
                        ></button>
                      </template>
                    </div>
                  </div>
                </x-filament::modal>
              @endif
            </div>
          @endif
        </div>
      </section>
      @if ($project->sections->isNotEmpty())
        <section id="content_sections_817364" class="nova-shell relative mx-auto max-w-[1280px] px-12 pb-24">
          <div id="content_intro_369150" class="mb-12">
            <span class="text-xs uppercase tracking-[.2em] text-[#4A9EE8]">Project details</span>
            <h2 id="content_intro_title_450871" class="nova-display mt-4 text-5xl font-bold">
              {{ $project->sections->first()->title }}
            </h2>
          </div>
          <div id="section_stack_783604" class="space-y-5">
            @foreach ($project->sections as $section)
              <article id="section_{{ $section->id }}" class="nova-card grid gap-8 p-8 md:grid-cols-[.7fr_1.3fr] md:p-10">
                <div>
                  <span class="text-xs uppercase tracking-[.2em] text-[#506070]">
                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                  </span>
                  <h3 class="nova-display mt-4 text-3xl font-bold">
                    {{ $section->title }}
                  </h3>
                </div>
                <div class="text-lg font-light leading-8 text-[#8AAEC8]">
                  {!! $section->content !!}
                </div>
              </article>
            @endforeach
          </div>
        </section>
      @endif
      @if ($project->themes->isNotEmpty())
        <section id="themes_section_463918" class="nova-shell relative mx-auto max-w-[1280px] px-12 pb-28">
          <div id="themes_header_740526" class="mb-10">
            <span class="text-xs uppercase tracking-[.2em] text-[#7EC8F0]">Download themes</span>
            <h2 id="themes_title_285604" class="nova-display mt-4 text-5xl font-bold">
              Take the system with you.
            </h2>
            <p id="themes_description_619407" class="mt-4 max-w-2xl text-lg font-light leading-8 text-[#8AAEC8]">
              Download the foundational themes and use them as a starting point for your next product.
            </p>
          </div>
          <div id="theme_cards_641295" class="grid gap-5 md:grid-cols-3">
            @foreach ($project->themes as $theme)
              <article id="theme_card_{{ $theme->id }}" class="nova-card nova-hover p-7">
                <div class="mb-12 flex items-center justify-between">
                  @if ($theme->themeimages->isNotEmpty())
                    <img
                      src="{{ asset('storage/' . $theme->themeimages->first()->image) }}"
                      alt="{{ $theme->title }}"
                      class="h-6 w-6 rounded object-cover"
                    >
                  @else
                    <i data-lucide="palette" class="h-6 w-6 text-[#7EC8F0]"></i>
                  @endif
                  <span class="text-xs text-[#506070]">
                    RAR / {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                  </span>
                </div>
                <h3 class="nova-display text-2xl font-bold">
                  {{ $theme->title }}
                </h3>
                <p class="mt-4 min-h-[84px] leading-7 text-[#8AAEC8]">
                  {{ $theme->description }}
                </p>
                @if ($theme->code)
                  <a
                    href="{{ asset('storage/' . $theme->code) }}"
                    download
                    class="nova-hover mt-8 flex w-full items-center justify-center gap-2 rounded-lg border border-[#2A4060] px-5 py-3 text-sm text-[#E4EEF8]"
                  >
                    <i data-lucide="download" class="h-4 w-4"></i>
                    Download RAR
                  </a>
                @endif
              </article>
            @endforeach
          </div>
        </section>
      @endif
    </main>
  </div>
</div>