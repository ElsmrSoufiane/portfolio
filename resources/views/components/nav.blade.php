<?php

use Livewire\Component;

new class extends Component
{
    public array $availableLocales = ['en' => 'English', 'fr' => 'Français', 'ar' => 'العربية'];

    public function currentLocale(): string
    {
        return app()->getLocale();
    }
};
?>

<nav class="bg-[#0F1319] fixed w-full z-20 top-0 start-0 border-b border-[#1E2D42]" x-data="{ mobileOpen: false }">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="/" wire:navigate class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-xl text-[#E4EEF8] font-semibold whitespace-nowrap">lasmarsoufiane<span class="text-[#4A9EE8]">.dev</span></span>
    </a>
    <button x-on:click="mobileOpen = !mobileOpen" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-[#8AAEC8] rounded-lg md:hidden hover:bg-[#1A2130] hover:text-[#E4EEF8] focus:outline-none focus:ring-2 focus:ring-[#2A4060]" aria-controls="navbar-default" :aria-expanded="mobileOpen.toString()">
      <span class="sr-only">{{ __('Open main menu') }}</span>
      <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
    </button>
    <div class="w-full md:block md:w-auto" id="navbar-default" :class="mobileOpen ? '' : 'hidden'">
      <ul class="font-medium flex flex-col gap-3 mt-4 p-4 border border-[#1E2D42] rounded-lg bg-[#1A2130] md:flex-row md:items-center md:gap-6 md:p-0 md:mt-0 md:border-0 md:bg-transparent">
        <li>
          <a href="/" wire:current.exact="!bg-[#4A9EE8] !text-[#0F1319] md:!bg-transparent md:!text-[#4A9EE8]" wire:navigate class="block py-2 px-3 text-[#E4EEF8] rounded-lg hover:bg-[#1E2D42] md:hover:bg-transparent md:border-0 md:hover:text-[#4A9EE8] md:p-0">{{ __('Home') }}</a>
        </li>
        <li>
          <a href="/about" wire:current.exact="!bg-[#4A9EE8] !text-[#0F1319] md:!bg-transparent md:!text-[#4A9EE8]" wire:navigate class="block py-2 px-3 text-[#E4EEF8] rounded-lg hover:bg-[#1E2D42] md:hover:bg-transparent md:border-0 md:hover:text-[#4A9EE8] md:p-0">{{ __('About') }}</a>
        </li>
        <li>
          <a href="/projects" wire:current.exact="!bg-[#4A9EE8] !text-[#0F1319] md:!bg-transparent md:!text-[#4A9EE8]" wire:navigate class="block py-2 px-3 text-[#E4EEF8] rounded-lg hover:bg-[#1E2D42] md:hover:bg-transparent md:border-0 md:hover:text-[#4A9EE8] md:p-0">{{ __('Projects') }}</a>
        </li>
        <li>
          <a href="/blog" wire:current.exact="!bg-[#4A9EE8] !text-[#0F1319] md:!bg-transparent md:!text-[#4A9EE8]" wire:navigate class="block py-2 px-3 text-[#E4EEF8] rounded-lg hover:bg-[#1E2D42] md:hover:bg-transparent md:border-0 md:hover:text-[#4A9EE8] md:p-0">{{ __('Blog') }}</a>
        </li>
        <li x-data="{ open: false }" class="relative">
          @php($locale = app()->getLocale())
          <button x-on:click="open = !open" type="button" class="flex w-full items-center justify-between gap-2 rounded-lg py-2 px-3 text-sm font-medium text-[#8AAEC8] hover:text-[#E4EEF8] md:w-auto" :aria-expanded="open.toString()">
            <span>{{ strtoupper($locale) }}</span>
            <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
          </button>
          <div x-show="open" x-on:click.outside="open = false" x-transition class="absolute start-0 z-30 mt-2 w-full min-w-40 rounded-lg border border-[#1E2D42] bg-[#0F1319] p-1.5 shadow-xl">
            @foreach ($availableLocales as $code => $label)
              <a href="{{ route('locale.switch', $code) }}" class="flex w-full items-center justify-between gap-2 rounded-md px-3 py-2 text-sm text-[#8AAEC8] hover:bg-[#1A2130] hover:text-[#E4EEF8] {{ $locale === $code ? 'text-[#4A9EE8]' : '' }}">
                <span>{{ $label }}</span>
                @if ($locale === $code)
                  <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l4 4L19 6"/></svg>
                @endif
              </a>
            @endforeach
          </div>
        </li>
        <li class="border-t border-[#1E2D42] md:hidden"></li>
        @guest()
        <li>
          <a href="/user/register" class="block rounded-lg border border-[#2A4060] px-4 py-2.5 text-center text-sm font-semibold text-[#E4EEF8] transition duration-500 hover:-translate-y-0.5 hover:border-[#4A9EE8] hover:text-white">{{ __('Sign in') }}</a>
        </li>
        <li>
          <a href="/user/login" class="block rounded-lg bg-[#4A9EE8] px-4 py-2.5 text-center text-sm font-semibold text-[#0F1319] transition duration-500 hover:scale-105 hover:bg-[#7EC8F0]">{{ __('Log in') }}</a>
        </li>
        @endguest
        @auth()
        <li>
          <a href="/user" class="block rounded-lg bg-[#4A9EE8] px-4 py-2.5 text-center text-sm font-semibold text-[#0F1319] transition duration-500 hover:scale-105 hover:bg-[#7EC8F0]">{{ strtoupper(Str::substr(auth()->user()->name, 0, 2)) }}</a>
        </li>
        <li>
          <form method="POST" action="{{ route('filament.user.auth.logout') }}">
            @csrf
            <button type="submit" class="block w-full rounded-lg border border-[#2A4060] px-4 py-2.5 text-center text-sm font-semibold text-[#E4EEF8] transition duration-500 hover:-translate-y-0.5 hover:border-[#4A9EE8] hover:text-white">{{ __('Log out') }}</button>
          </form>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>