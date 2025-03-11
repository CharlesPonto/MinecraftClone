// JavaScript for Hamburger Menu 
const hamburger = document.querySelector('.hamburger');
const navbar = document.querySelector('.navbar');

hamburger.addEventListener('click', () => {
  navbar.classList.toggle('active');
});

document.addEventListener('DOMContentLoaded', function() {
  // 1. SMOOTH SCROLL NAVIGATION
  // This enables smooth scrolling when clicking on navigation links
  const navLinks = document.querySelectorAll('a[href^="#"]');

  navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = this.getAttribute('href');
      const targetSection = document.querySelector(targetId);

      if (targetSection) {
        window.scrollTo({
          top: targetSection.offsetTop,
          behavior: 'smooth'
        });
      }
    });
  });
  
  // 2. CYCLING TEXT EFFECT FOR WELCOME MESSAGEhjbhn
  // This creates a typing and deleting animation that cycles through different game names
  const heroHeading = document.querySelector('.hero-content h1');
  const baseText = "Welcome to ";
  const gameTexts = [
    "Minecraft Adventures!",
    "Minecraft Education!", 
    "Minecraft Dungeons!", 
    "Minecraft Legends!", 
    "Minecraft Education!"
  ];

  heroHeading.textContent = baseText;
  let gameIndex = 0;
  let isDeleting = false;
  let currentText = '';
  let charIndex = 0;
  
  function typeEffect() {
    const fullText = gameTexts[gameIndex];
    
    if (isDeleting) {
      currentText = fullText.substring(0, charIndex - 1);
      charIndex--;
    } else {
      currentText = fullText.substring(0, charIndex + 1);
      charIndex++;
    }

    heroHeading.textContent = baseText + currentText;
    let typeSpeed = 100;
    
    if (isDeleting) {
      typeSpeed = 50;  
    }

    if (!isDeleting && charIndex === fullText.length) {
      typeSpeed = 2000; 
      isDeleting = true;
    } else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      gameIndex++;

      if (gameIndex === gameTexts.length) {
        gameIndex = 0;
      }
      typeSpeed = 500;
    }
    setTimeout(typeEffect, typeSpeed);
  }
  setTimeout(typeEffect, 1000);
  
  // 3. SCROLL ANIMATION FOR GAME CARDS
  // This adds a slide-in effect when scrolling to game cards
  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 &&
      rect.bottom >= 0
    );
  }
  
  const gameCards = document.querySelectorAll('.game-card');
  gameCards.forEach(card => {
    card.style.transform = 'translateY(50px)';
    card.style.opacity = '0';
    card.style.transition = 'transform 0.6s ease-out, opacity 0.6s ease-out';
  });

  function handleScroll() {
    gameCards.forEach(card => {
      if (isInViewport(card)) {
        card.style.transform = 'translateY(0)';
        card.style.opacity = '1';
      }
    });
  }
  
  window.addEventListener('scroll', handleScroll);
  setTimeout(handleScroll, 100);
});