// ========== Default Projects Data ==========
const defaultProjects = [
  { id: 1, title: 'HHO Solar Powered Car', description: 'A car powered by HHO gas generated from water, supplemented with solar energy.', emoji: '☀️🚗', imageUrl: '' },
  { id: 2, title: 'Arc Reactor Imitation', description: 'A replica of the iconic arc reactor using LEDs and 3D-printed parts.', emoji: '💡🔵', imageUrl: '' },
  { id: 3, title: 'HHO Reactor', description: 'An HHO reactor that produces hydrogen and oxygen gas through electrolysis.', emoji: '🧪⚡', imageUrl: '' },
  { id: 4, title: 'HHO Rocket', description: 'A rocket propulsion system powered by HHO gas combustion.', emoji: '🚀🔥', imageUrl: '' },
  { id: 5, title: 'Sun Tracking Solar Panels', description: 'Solar panels that automatically track the sun for maximum efficiency.', emoji: '☀️🔧', imageUrl: '' },
  { id: 6, title: 'ESP32 Car RC', description: 'A remote-controlled car built with ESP32 and smartphone control.', emoji: '🚙📱', imageUrl: '' }
];

// ========== LocalStorage Helpers ==========
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

function saveProjects(projects) {
  localStorage.setItem('portfolioProjects', JSON.stringify(projects));
}

function initProjects() {
  if (!localStorage.getItem('portfolioProjects')) {
    saveProjects(defaultProjects);
  }
}

// ========== Authentication ==========
const ADMIN_USERNAME = 'om';
const ADMIN_PASSWORD = 'om123';

function isLoggedIn() {
  return sessionStorage.getItem('adminLoggedIn') === 'true';
}

function setLoggedIn(status) {
  if (status) {
    sessionStorage.setItem('adminLoggedIn', 'true');
  } else {
    sessionStorage.removeItem('adminLoggedIn');
  }
}

function showLoginOverlay(show) {
  const overlay = document.getElementById('loginOverlay');
  if (overlay) {
    if (show) {
      overlay.classList.remove('hidden');
    } else {
      overlay.classList.add('hidden');
    }
  }
}

function showLogoutButton(show) {
  const logoutBtn = document.getElementById('logoutBtn');
  if (logoutBtn) {
    logoutBtn.style.display = show ? 'inline-block' : 'none';
  }
}

function handleLogin(event) {
  event.preventDefault();
  const username = document.getElementById('username').value.trim();
  const password = document.getElementById('password').value;
  const errorMsg = document.getElementById('loginError');

  if (username === ADMIN_USERNAME && password === ADMIN_PASSWORD) {
    setLoggedIn(true);
    showLoginOverlay(false);
    showLogoutButton(true);
    errorMsg.textContent = '';
    // Clear password field for security
    document.getElementById('password').value = '';
  } else {
    errorMsg.textContent = 'Invalid username or password!';
    // Clear password field
    document.getElementById('password').value = '';
  }
}

function handleLogout() {
  setLoggedIn(false);
  showLoginOverlay(true);
  showLogoutButton(false);
  // Reset login form
  document.getElementById('loginForm').reset();
  document.getElementById('loginError').textContent = '';
}

// ========== Admin Panel Logic ==========
let editingId = null;

const projectForm = document.getElementById('projectForm');
const projectIdInput = document.getElementById('projectId');
const titleInput = document.getElementById('title');
const descriptionInput = document.getElementById('description');
const emojiInput = document.getElementById('emoji');
const imageUrlInput = document.getElementById('imageUrl');
const submitBtn = document.getElementById('submitBtn');
const cancelEditBtn = document.getElementById('cancelEditBtn');
const formTitle = document.getElementById('formTitle');
const adminProjectList = document.getElementById('adminProjectList');

function renderAdminList() {
  if (!adminProjectList) return;
  const projects = loadProjects();
  adminProjectList.innerHTML = '';

  if (projects.length === 0) {
    adminProjectList.innerHTML = '<p>No projects yet.</p>';
    return;
  }

  projects.forEach(project => {
    const item = document.createElement('div');
    item.className = 'admin-project-item';
    item.innerHTML = `
      <div class="item-info">
        <strong>${project.emoji ? project.emoji + ' ' : ''}${project.title}</strong>
      </div>
      <div class="item-actions">
        <button class="edit-btn" data-id="${project.id}" title="Edit">✏️</button>
        <button class="delete-btn" data-id="${project.id}" title="Delete">🗑️</button>
      </div>
    `;
    adminProjectList.appendChild(item);
  });

  // Attach event listeners
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => startEdit(btn.dataset.id));
  });
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => deleteProject(btn.dataset.id));
  });
}

function startEdit(id) {
  const projects = loadProjects();
  const project = projects.find(p => p.id === Number(id));
  if (!project) return;

  editingId = project.id;
  formTitle.textContent = 'Edit Project';
  submitBtn.textContent = 'Update Project';
  cancelEditBtn.style.display = 'inline-block';

  projectIdInput.value = project.id;
  titleInput.value = project.title;
  descriptionInput.value = project.description;
  emojiInput.value = project.emoji || '';
  imageUrlInput.value = project.imageUrl || '';
}

function resetForm() {
  editingId = null;
  formTitle.textContent = 'Add New Project';
  submitBtn.textContent = 'Add Project';
  cancelEditBtn.style.display = 'none';
  projectForm.reset();
  projectIdInput.value = '';
}

projectForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const projects = loadProjects();

  const projectData = {
    title: titleInput.value.trim(),
    description: descriptionInput.value.trim(),
    emoji: emojiInput.value.trim() || '🔧',
    imageUrl: imageUrlInput.value.trim()
  };

  if (editingId) {
    const index = projects.findIndex(p => p.id === editingId);
    if (index !== -1) {
      projects[index] = { ...projects[index], ...projectData };
    }
  } else {
    const newId = projects.length > 0 ? Math.max(...projects.map(p => p.id)) + 1 : 1;
    projects.push({ id: newId, ...projectData });
  }

  saveProjects(projects);
  resetForm();
  renderAdminList();
});

cancelEditBtn.addEventListener('click', resetForm);

function deleteProject(id) {
  if (!confirm('Are you sure you want to delete this project?')) return;
  let projects = loadProjects();
  projects = projects.filter(p => p.id !== Number(id));
  saveProjects(projects);
  renderAdminList();
}

// ========== Initialization ==========
document.addEventListener('DOMContentLoaded', () => {
  initProjects();

  // Login form listener
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', handleLogin);
  }

  // Logout button listener
  const logoutBtn = document.getElementById('logoutBtn');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', handleLogout);
  }

  // Check login state
  if (isLoggedIn()) {
    showLoginOverlay(false);
    showLogoutButton(true);
  } else {
    showLoginOverlay(true);
    showLogoutButton(false);
  }

  renderAdminList();
  resetForm();
});