<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<nav class="bg-[#0F1319] fixed w-full z-20 top-0 start-0 border-b border-[#1E2D42]" x-data="{ mobileOpen: false }">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="/" wire:navigate class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-xl text-[#E4EEF8] font-semibold whitespace-nowrap">lasmarsoufiane<span class="text-[#4A9EE8]">.dev</span></span>
    </a>
    <button x-on:click="mobileOpen = !mobileOpen" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-[#8AAEC8] rounded-lg md:hidden hover:bg-[#1A2130] hover:text-[#E4EEF8] focus:outline-none focus:ring-2 focus:ring-[#2A4060]" aria-controls="navbar-default" :aria-expanded="mobileOpen.toString()">
      <span class="sr-only">Open main menu</span>
      <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
    </button>
    <div class="w-full md:block md:w-auto" id="navbar-default" :class="mobileOpen ? '' : 'hidden'">
      <ul class="font-medium flex flex-col gap-3 mt-4 p-4 border border-[#1E2D42] rounded-lg bg-[#1A2130] md:flex-row md:items-center md:gap-8 md:p-0 md:mt-0 md:border-0 md:bg-transparent">
        <li>
          <a href="/" wire:current.exact="!bg-[#4A9EE8] !text-[#0F1319] md:!bg-transparent md:!text-[#4A9EE8]" wire:navigate class="block py-2 px-3 text-[#E4EEF8] rounded-lg hover:bg-[#1E2D42] md:hover:bg-transparent md:border-0 md:hover:text-[#4A9EE8] md:p-0">Home</a>
        </li>
        <li>
          <a href="/about" wire:current.exact="!bg-[#4A9EE8] !text-[#0F1319] md:!bg-transparent md:!text-[#4A9EE8]" wire:navigate class="block py-2 px-3 text-[#E4EEF8] rounded-lg hover:bg-[#1E2D42] md:hover:bg-transparent md:border-0 md:hover:text-[#4A9EE8] md:p-0">About</a>
        </li>
        <li>
          <a href="/projects" wire:current.exact="!bg-[#4A9EE8] !text-[#0F1319] md:!bg-transparent md:!text-[#4A9EE8]" wire:navigate class="block py-2 px-3 text-[#E4EEF8] rounded-lg hover:bg-[#1E2D42] md:hover:bg-transparent md:border-0 md:hover:text-[#4A9EE8] md:p-0">Projects</a>
        </li>
        <li>
          <a href="/blog" wire:current.exact="!bg-[#4A9EE8] !text-[#0F1319] md:!bg-transparent md:!text-[#4A9EE8]" wire:navigate class="block py-2 px-3 text-[#E4EEF8] rounded-lg hover:bg-[#1E2D42] md:hover:bg-transparent md:border-0 md:hover:text-[#4A9EE8] md:p-0">Blog</a>
        </li>
        <li class="border-t border-[#1E2D42] md:hidden"></li>
        @guest()
        <li>
          <a href="/user/register" class="block rounded-lg border border-[#2A4060] px-4 py-2.5 text-center text-sm font-semibold text-[#E4EEF8] transition duration-500 hover:-translate-y-0.5 hover:border-[#4A9EE8] hover:text-white">Sign in</a>
        </li>
        <li>
          <a href="/user/login" class="block rounded-lg bg-[#4A9EE8] px-4 py-2.5 text-center text-sm font-semibold text-[#0F1319] transition duration-500 hover:scale-105 hover:bg-[#7EC8F0]">Log in</a>
        </li>
        @endguest
        @auth()
        <li>
          <a href="/user" class="block rounded-lg bg-[#4A9EE8] px-4 py-2.5 text-center text-sm font-semibold text-[#0F1319] transition duration-500 hover:scale-105 hover:bg-[#7EC8F0]">{{ strtoupper(Str::substr(auth()->user()->name, 0, 2)) }}</a>
        </li>
        <li>
          <form method="POST" action="{{ route('filament.user.auth.logout') }}">
            @csrf
            <button type="submit" class="block w-full rounded-lg border border-[#2A4060] px-4 py-2.5 text-center text-sm font-semibold text-[#E4EEF8] transition duration-500 hover:-translate-y-0.5 hover:border-[#4A9EE8] hover:text-white">Log out</button>
          </form>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>