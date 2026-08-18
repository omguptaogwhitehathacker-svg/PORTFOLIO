// ========== Mobile Menu Toggle ==========
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');

if (hamburger && navMenu) {
  hamburger.addEventListener('click', () => {
    navMenu.classList.toggle('active');
  });

  // Close menu when clicking a link
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
      navMenu.classList.remove('active');
    });
  });
}

// ========== Scroll Progress Bar ==========
window.addEventListener('scroll', () => {
  const scrollTop = window.scrollY;
  const docHeight = document.documentElement.scrollHeight - window.innerHeight;
  const scrollPercent = (scrollTop / docHeight) * 100;
  const progressBar = document.getElementById('progressBar');
  if (progressBar) {
    progressBar.style.width = scrollPercent + '%';
  }
});

// ========== Parallax Background Effect ==========
window.addEventListener('scroll', () => {
  const parallaxBg = document.getElementById('parallaxBg');
  if (parallaxBg) {
    const scrollY = window.scrollY;
    // Move background at 0.5 speed (slower) to create depth
    parallaxBg.style.transform = `translateY(${scrollY * 0.4}px)`;
  }
});

// ========== Active Nav Link Highlighting (already done via HTML class, but for dynamic) ==========
// This ensures the correct link is active based on current page
document.addEventListener('DOMContentLoaded', () => {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(link => {
    const linkPage = link.getAttribute('href');
    if (linkPage === currentPage) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });
});