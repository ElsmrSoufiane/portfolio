<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<header id="nav_517304" class="mx-auto flex max-w-[1280px] items-center justify-between px-6 py-6 lg:px-12">
  <a id="brand_681924" href="#home" class="display text-xl font-bold text-[#E4EEF8]">
    lasmarsoufiane
    <span class="text-[#4A9EE8]">.dev</span>
  </a>
  <nav id="main_nav_473816" class="hidden items-center gap-8 text-sm text-[#8AAEC8] md:flex">
    <a id="nav_home_829461" href="/" wire:current.exact="!bg-sky-100 !text-black !p-2 !font-bold !rounded-sm" wire:navigate class="transition hover:-translate-y-0.5 hover:text-white">Home</a>
    <a id="nav_about_514738" href="/about" wire:current.exact="!bg-sky-100 !text-black !p-2 !font-bold !rounded-sm" wire:navigate class="transition hover:-translate-y-0.5 hover:text-white">About</a>
    <a id="nav_projects_693182" href="/projects" wire:current.exact="!bg-sky-100 !text-black !p-2 !font-bold !rounded-sm" wire:navigate class="transition hover:-translate-y-0.5 hover:text-white">Projects</a>
    <a id="nav_blog_746291" href="/blog" wire:current.exact="!bg-sky-100 !text-black !p-2 !font-bold !rounded-sm" wire:navigate class="transition hover:-translate-y-0.5 hover:text-white">Blog</a>
  </nav>
  <div id="auth_actions_492781" class="flex items-center gap-3">
    <a id="sign_in_link_739416" href="#sign-in" class="rounded-lg border border-[#2A4060] px-4 py-2.5 text-sm font-semibold text-[#E4EEF8] transition duration-500 hover:-translate-y-0.5 hover:border-[#4A9EE8] hover:text-white">Sign in</a>
    <a id="log_in_link_825174" href="#log-in" class="rounded-lg bg-[#4A9EE8] px-4 py-2.5 text-sm font-semibold text-[#0F1319] transition duration-500 hover:scale-105 hover:bg-[#7EC8F0]">
      Log in
      <i data-lucide="log-in" class="ml-1 inline h-4 w-4"></i>
    </a>
  </div>
</header>