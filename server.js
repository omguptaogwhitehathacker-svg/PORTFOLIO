const express = require('express');
const session = require('express-session');
const fs = require('fs');
const path = require('path');
const crypto = require('crypto');

const app = express();
const PORT = process.env.PORT || 3000;
const ROOT_DIR = __dirname;
const DATA_FILE = path.join(ROOT_DIR, 'projects.json');
const ADMIN_PASSWORD = 'admin2026';
const ADMIN_HASH = crypto.createHash('sha256').update(ADMIN_PASSWORD).digest('hex');

app.set('trust proxy', 1);

function ensureDataFile() {
  if (!fs.existsSync(DATA_FILE)) {
    fs.writeFileSync(DATA_FILE, '[]', 'utf8');
  }
}

function readProjects() {
  ensureDataFile();

  try {
    const raw = fs.readFileSync(DATA_FILE, 'utf8');
    const parsed = JSON.parse(raw);
    return Array.isArray(parsed) ? parsed : [];
  } catch (error) {
    return [];
  }
}

function writeProjects(projects) {
  ensureDataFile();
  fs.writeFileSync(DATA_FILE, JSON.stringify(projects, null, 2), 'utf8');
}

function sanitizeText(value) {
  return String(value ?? '')
    .replace(/<[^>]*>/g, '')
    .trim();
}

app.use(express.json({ limit: '1mb' }));
app.use(
  session({
    secret: process.env.SESSION_SECRET || 'portfolio-admin-secret',
    resave: false,
    saveUninitialized: false,
    cookie: {
      httpOnly: true,
      sameSite: 'lax',
      secure: process.env.NODE_ENV === 'production'
    }
  })
);

app.use(express.static(ROOT_DIR, { index: false }));

app.get('/', (req, res) => {
  res.sendFile(path.join(ROOT_DIR, 'index.php'));
});

app.get('/index.php', (req, res) => {
  res.sendFile(path.join(ROOT_DIR, 'index.php'));
});

app.get('/index.html', (req, res) => {
  res.sendFile(path.join(ROOT_DIR, 'index.php'));
});

app.all(['/api', '/api.php'], (req, res) => {
  const { method } = req;

  if (method === 'GET') {
    if (req.query.auth === '1') {
      return res.json({ authenticated: Boolean(req.session.admin_logged_in) });
    }

    return res.json(readProjects());
  }

  if (method === 'POST') {
    const input = req.body && typeof req.body === 'object' ? req.body : {};

    if (input.action === 'login') {
      const password = String(input.password ?? '').trim();
      const submittedHash = crypto.createHash('sha256').update(password).digest('hex');

      if (submittedHash === ADMIN_HASH) {
        req.session.admin_logged_in = true;
        return res.json({ status: 'success', authenticated: true });
      }

      return res.status(401).json({ status: 'error', message: 'Invalid password' });
    }

    if (input.action === 'logout') {
      req.session.destroy(() => {
        return res.json({ status: 'success' });
      });
      return;
    }

    if (!req.session.admin_logged_in) {
      return res.status(401).json({ status: 'error', message: 'Unauthorized' });
    }

    if (!input.title || !input.description) {
      return res.status(400).json({ status: 'error', message: 'Title and description are required' });
    }

    const projects = readProjects();
    const newProject = {
      id: `${Date.now()}-${Math.floor(Math.random() * 9000 + 1000)}`,
      title: sanitizeText(input.title),
      description: sanitizeText(input.description),
      tags: sanitizeText(input.tags ?? '')
    };

    projects.unshift(newProject);
    writeProjects(projects);

    return res.status(201).json({ status: 'success', project: newProject });
  }

  if (method === 'PUT') {
    if (!req.session.admin_logged_in) {
      return res.status(401).json({ status: 'error', message: 'Unauthorized' });
    }

    const input = req.body && typeof req.body === 'object' ? req.body : {};
    const projectId = input.id;

    if (!projectId || !input.title || !input.description) {
      return res.status(400).json({ status: 'error', message: 'Missing project fields' });
    }

    const projects = readProjects();
    let updated = false;

    for (const project of projects) {
      if (String(project.id) === String(projectId)) {
        project.title = sanitizeText(input.title);
        project.description = sanitizeText(input.description);
        project.tags = sanitizeText(input.tags ?? project.tags ?? '');
        updated = true;
        break;
      }
    }

    if (!updated) {
      return res.status(404).json({ status: 'error', message: 'Project not found' });
    }

    writeProjects(projects);

    return res.json({
      status: 'success',
      project: {
        id: projectId,
        title: sanitizeText(input.title),
        description: sanitizeText(input.description),
        tags: sanitizeText(input.tags ?? '')
      }
    });
  }

  if (method === 'DELETE') {
    if (!req.session.admin_logged_in) {
      return res.status(401).json({ status: 'error', message: 'Unauthorized' });
    }

    const input = req.body && typeof req.body === 'object' ? req.body : {};
    const projectId = input.id;

    if (projectId === undefined || projectId === null || projectId === '') {
      return res.status(400).json({ status: 'error', message: 'Project id is required' });
    }

    const projects = readProjects();
    const filtered = projects.filter((project) => String(project.id) !== String(projectId));

    if (filtered.length === projects.length) {
      return res.status(404).json({ status: 'error', message: 'Project not found' });
    }

    writeProjects(filtered);
    return res.json({ status: 'success', deletedId: projectId });
  }

  return res.status(405).json({ status: 'error', message: 'Method not allowed' });
});

app.use((req, res) => {
  res.status(404).json({ status: 'error', message: 'Not found' });
});

if (require.main === module) {
  app.listen(PORT, () => {
    console.log(`Portfolio running at http://localhost:${PORT}`);
  });
}

module.exports = app;
