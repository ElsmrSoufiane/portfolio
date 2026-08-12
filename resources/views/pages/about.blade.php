<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section id="about" class="border-t border-[#1E3050] bg-[#141920]">
  <div id="about_inner_752416" class="mx-auto max-w-[1280px] px-6 py-20 lg:px-12">
    <span id="about_eyebrow_618295" class="about-reveal text-xs uppercase tracking-[.2em] text-[#4A9EE8]">About</span>
    <div id="about_content_491726" class="about-reveal mt-5 grid gap-8 lg:grid-cols-[.8fr_1.2fr]">
      <h2 id="about_heading_826415" class="display text-4xl font-bold">Code, products, and ideas that move forward.</h2>
      <p id="about_description_739182" class="max-w-2xl text-lg leading-8 text-[#8AAEC8]">I'm a full-stack developer working with PHP, Laravel, TallStack, Filament, and DevOps tools. Alongside building reliable products, I bring nine months of digital marketing experience to help ideas reach the right audience.</p>
    </div>
  </div>
  <script>
    gsap.registerPlugin(ScrollTrigger);
    gsap.from(".about-reveal", {
      ease: 'power.out',
      stagger: 0.2,
      duration: 0.8,
      opacity: 0,
      y: 100,
      scrollTrigger: {
        trigger: "#about",
        toggleActions: "play none none reverse"
      }
    });
  </script>
</section>