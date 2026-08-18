// Default projects data
const defaultProjects = [
  {
    id: 1,
    title: 'HHO Solar Powered Car',
    description: 'A car powered by HHO gas generated from water, supplemented with solar energy.',
    emoji: '☀️🚗',
    imageUrl: ''
  },
  {
    id: 2,
    title: 'Arc Reactor Imitation',
    description: 'A replica of the iconic arc reactor using LEDs and 3D-printed parts.',
    emoji: '💡🔵',
    imageUrl: ''
  },
  {
    id: 3,
    title: 'HHO Reactor',
    description: 'An HHO reactor that produces hydrogen and oxygen gas through electrolysis.',
    emoji: '🧪⚡',
    imageUrl: ''
  },
  {
    id: 4,
    title: 'HHO Rocket',
    description: 'A rocket propulsion system powered by HHO gas combustion.',
    emoji: '🚀🔥',
    imageUrl: ''
  },
  {
    id: 5,
    title: 'Sun Tracking Solar Panels',
    description: 'Solar panels that automatically track the sun for maximum efficiency.',
    emoji: '☀️🔧',
    imageUrl: ''
  },
  {
    id: 6,
    title: 'ESP32 Car RC',
    description: 'A remote-controlled car built with ESP32 and smartphone control.',
    emoji: '🚙📱',
    imageUrl: ''
  }
];

// Load projects from localStorage or use defaults
function loadProjects() {
  const stored = localStorage.getItem('portfolioProjects');
  if (stored) {
    try {
      return JSON.parse(stored);
    } catch {
      return [...defaultProjects];
    }
  }
  return [...defaultProjects];
}

// Save projects to localStorage
function saveProjects(projects) {
  localStorage.setItem('portfolioProjects', JSON.stringify(projects));
}

// Initialize localStorage with defaults if not present
function initProjects() {
  if (!localStorage.getItem('portfolioProjects')) {
    saveProjects(defaultProjects);
  }
}

// Render projects on the projects page
function renderProjectsPage() {
  const grid = document.getElementById('projectsGrid');
  if (!grid) return;

  const projects = loadProjects();
  grid.innerHTML = '';

  projects.forEach(project => {
    const card = document.createElement('div');
    card.className = 'project-card';

    // Determine background for image area
    let imageStyle = '';
    if (project.imageUrl && project.imageUrl.trim() !== '') {
      imageStyle = `background-image: url('${project.imageUrl}'); background-size: cover; background-position: center;`;
    } else {
      // Use gradient based on emoji or title hash
      const gradients = ['#a1c4fd', '#c2e9fb', '#fbc2eb', '#a6c1ee', '#84fab0', '#fdcbf1'];
      const hash = project.title.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0);
      const gradient = gradients[hash % gradients.length];
      imageStyle = `background: linear-gradient(135deg, ${gradient}, #ffffff);`;
    }

    const imageDiv = document.createElement('div');
    imageDiv.className = 'project-image';
    imageDiv.style = imageStyle;
    imageDiv.textContent = project.emoji || '🔧';

    const infoDiv = document.createElement('div');
    infoDiv.className = 'project-info';
    infoDiv.innerHTML = `<h3>${project.title}</h3><p>${project.description}</p>`;

    card.appendChild(imageDiv);
    card.appendChild(infoDiv);
    grid.appendChild(card);
  });
}

// Run on load
document.addEventListener('DOMContentLoaded', () => {
  initProjects();
  renderProjectsPage();
});