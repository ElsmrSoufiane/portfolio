<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <!-- TICKER -->
<div class="ticker">
  <div class="ticker-track" id="tickerTrack"></div>
</div>
<!-- NAV -->
<nav id="mainNav">
  <a href="#" class="nav-logo">
    <div class="nav-logo-mark">
      <svg viewBox="0 0 16 16"><polyline points="2,12 6,7 10,9 14,4"/><circle cx="14" cy="4" r="1.5" fill="white" stroke="none"/></svg>
    </div>
    NovaPay
  </a>
  <div class="nav-links">
    <a href="#features">home</a>
    <a href="#dashboard">about</a>
    <a href="#pricing">projects</a>
    <a href="#security">blog/tutorials</a>
  </div>
  <div class="nav-cta">
    <a href="#" class="btn-ghost">Sign in</a>
    <a href="#" class="btn-primary">Get started</a>
  </div>
  <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu"><a href="#features">home</a>
    <a href="#dashboard">about</a>
    <a href="#pricing">projects</a>
    <a href="#security">blog/tutorials</a>
 <div class="m-btns">
    <a href="#" class="btn-ghost">Sign in</a>
    <a href="#" class="btn-primary">Get started free</a>
  </div>
</div>
</div>