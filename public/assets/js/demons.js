import { gsap } from 'gsap';

// Demon Carousel with GSAP
class DemonCarousel {
  constructor() {
    this.currentIndex = 0;
    this.slides = document.querySelectorAll('.carousel-slide');
    this.miniCards = document.querySelectorAll('.mini-card');
    this.totalSlides = this.slides.length;
    this.isAnimating = false;

    // Demon data
    this.demonData = [
      {
        name: "ASMODEUS",
        description: "The Prince of Demons, master of desire and temptation. Commands the legions of the underworld with unmatched power.",
        level: "10",
        type: "Prince",
        power: 6,
        speed: 4,
        defense: 5
      },
      {
        name: "BELPHEGOR",
        description: "The Demon of Sloth, seducer of idle minds. Whispers promises of easy wealth and corrupts through laziness.",
        level: "08",
        type: "Duke",
        power: 5,
        speed: 3,
        defense: 6
      },
      {
        name: "LILITH",
        description: "The First Woman, Queen of Demons. Ancient spirit of the night, mother of monsters and dark enchantments.",
        level: "09",
        type: "Queen",
        power: 5,
        speed: 5,
        defense: 4
      },
      {
        name: "AZAZEL",
        description: "The Fallen Angel, teacher of forbidden arts. Bound in chains of divine wrath, yet still spreads corruption.",
        level: "10",
        type: "Fallen",
        power: 6,
        speed: 5,
        defense: 3
      }
    ];

    this.init();
  }

  init() {
    // Set initial slide
    if (this.slides.length > 0) {
      this.slides[0].classList.add('active');
    }
    this.updateInfo(0);

    // Add click handlers to mini cards
    this.miniCards.forEach((card, index) => {
      card.addEventListener('click', () => this.goToSlide(index));
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') this.prevSlide();
      if (e.key === 'ArrowRight') this.nextSlide();
    });

    // Auto-advance carousel
    this.startAutoPlay();

    // Animate entrance
    this.animateEntrance();
  }

  goToSlide(index) {
    if (this.isAnimating || index === this.currentIndex) return;
    this.isAnimating = true;

    const currentSlide = this.slides[this.currentIndex];
    const nextSlide = this.slides[index];

    // Simple fade transition
    gsap.to(currentSlide, {
      opacity: 0,
      duration: 0.5,
      ease: "power2.inOut",
      onComplete: () => {
        currentSlide.classList.remove('active');
      }
    });

    gsap.to(nextSlide, {
      opacity: 1,
      duration: 0.5,
      delay: 0.3,
      ease: "power2.out",
      onStart: () => {
        nextSlide.classList.add('active');
      },
      onComplete: () => {
        this.isAnimating = false;
      }
    });

    // Update mini cards
    this.miniCards.forEach(card => card.classList.remove('active'));
    this.miniCards[index].classList.add('active');

    // Update info panel
    this.updateInfo(index);

    this.currentIndex = index;
  }

  nextSlide() {
    const nextIndex = (this.currentIndex + 1) % this.totalSlides;
    this.goToSlide(nextIndex);
  }

  prevSlide() {
    const prevIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
    this.goToSlide(prevIndex);
  }

  updateInfo(index) {
    const data = this.demonData[index];
    
    const nameEl = document.querySelector('.demon-name');
    const descEl = document.querySelector('.demon-description');
    const statsEl = document.querySelector('.demon-stats');
    
    if (!nameEl || !descEl || !statsEl) return;

    // Animate out old info
    gsap.to([nameEl, descEl, statsEl], {
      opacity: 0,
      x: -20,
      duration: 0.3,
      onComplete: () => {
        // Update content
        nameEl.textContent = data.name;
        descEl.textContent = data.description;
        
        const statItems = statsEl.querySelectorAll('.flex');
        if (statItems.length >= 2) {
          statItems[0].querySelector('.text-gray-300').textContent = data.level;
          statItems[1].querySelector('.text-gray-300').textContent = data.type;
        }

        // Update power bars
        const powerBarsContainer = document.querySelector('.mt-auto');
        if (powerBarsContainer) {
          const powerBars = powerBarsContainer.querySelectorAll('.flex.justify-between');
          if (powerBars.length >= 3) {
            this.updatePowerBar(powerBars[0], data.power);
            this.updatePowerBar(powerBars[1], data.speed);
            this.updatePowerBar(powerBars[2], data.defense);
          }
        }

        // Animate in new info
        gsap.to([nameEl, descEl, statsEl], {
          opacity: 1,
          x: 0,
          duration: 0.4,
          stagger: 0.1,
          ease: "power2.out"
        });
      }
    });
  }

  updatePowerBar(element, level) {
    const bar = element.querySelector('.text-amber-500');
    const filled = '█'.repeat(level);
    const empty = '░'.repeat(6 - level);
    bar.textContent = filled + empty;
  }

  startAutoPlay(interval = 5000) {
    this.autoPlayInterval = setInterval(() => {
      if (!this.isAnimating) {
        this.nextSlide();
      }
    }, interval);
  }

  stopAutoPlay() {
    if (this.autoPlayInterval) {
      clearInterval(this.autoPlayInterval);
    }
  }

  animateEntrance() {
    const leftPanel = document.querySelector('.w-\\[550px\\]:first-of-type');
    const rightPanel = document.querySelector('.w-\\[550px\\]:last-of-type');
    
    if (leftPanel) {
      gsap.from(leftPanel, {
        x: -300,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
      });
    }

    if (rightPanel) {
      gsap.from(rightPanel, {
        x: 300,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
      });
    }

    // Animate first demon image
    const activeSlide = document.querySelector('.carousel-slide.active img');
    if (activeSlide) {
      gsap.from(activeSlide, {
        scale: 0,
        opacity: 0,
        duration: 1.2,
        delay: 0.5,
        ease: "back.out(1.7)"
      });
    }

    // Animate mini cards
    gsap.from('.mini-card', {
      scale: 0,
      opacity: 0,
      duration: 0.4,
      delay: 0.8,
      stagger: 0.1,
      ease: "back.out(1.7)"
    });
  }
}

// Initialize carousel when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  console.log('DOM loaded, checking for GSAP...');
  
  // Check if GSAP is loaded
  if (typeof gsap === 'undefined') {
    console.error('GSAP is not loaded. Please include GSAP library.');
    return;
  }
  
  console.log('GSAP found, initializing carousel...');

  // Initialize carousel
  const carousel = new DemonCarousel();
  
  console.log('Carousel initialized with', carousel.slides.length, 'slides');

  // Pause autoplay on hover
  const slides = document.querySelectorAll('.carousel-slide');
  if (slides.length > 0) {
    slides.forEach(slide => {
      slide.addEventListener('mouseenter', () => carousel.stopAutoPlay());
      slide.addEventListener('mouseleave', () => carousel.startAutoPlay());
    });
  }
});
