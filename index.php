<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Om | Portfolio</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <style>
        :root {
            --bg-black: #050508;
            --card-bg: rgba(18, 18, 26, 0.75);
            --card-border: rgba(255, 255, 255, 0.12);
            --accent-cyan: #00f0ff;
            --accent-purple: #7000ff;
            --text-main: #f0f0f5;
            --text-muted: #a0a0b8;
            --danger: #ff6b6b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-black);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        #bg-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1.5rem 5rem;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--card-border);
            backdrop-filter: blur(8px);
            gap: 1rem;
        }

        .logo {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 2px;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 1.4rem;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: var(--accent-cyan);
        }

        h1 {
            font-size: clamp(2.8rem, 6vw, 5rem);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1rem;
        }

        h2 {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800;
            margin-bottom: 2rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h2::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--card-border);
        }

        section {
            padding: 4rem 0;
        }

        .hero-desc {
            font-size: clamp(1.1rem, 2vw, 1.4rem);
            color: var(--text-muted);
            max-width: 650px;
            line-height: 1.6;
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.8rem;
        }

        .project-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.8rem;
            backdrop-filter: blur(12px);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .project-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 240, 255, 0.4);
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.1);
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .project-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff;
        }

        .project-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tag-badge {
            background: rgba(0, 240, 255, 0.08);
            color: var(--accent-cyan);
            border: 1px solid rgba(0, 240, 255, 0.2);
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-box {
            background: rgba(18, 18, 26, 0.95);
            border: 1px solid var(--accent-cyan);
            border-radius: 12px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 0 25px rgba(0, 240, 255, 0.15);
        }

        input, textarea {
            width: 100%;
            padding: 0.9rem;
            margin-bottom: 1rem;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--card-border);
            color: #fff;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--accent-cyan);
        }

        button {
            background: linear-gradient(135deg, var(--accent-cyan), #00a8ff);
            color: #000;
            border: none;
            padding: 0.8rem 1.8rem;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        button:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .secondary-btn {
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-main);
        }

        .danger-btn {
            background: linear-gradient(135deg, #ff6b6b, #ff8a5b);
            color: #fff;
        }

        .admin-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #12121a;
            border: 1px solid var(--card-border);
            color: var(--text-muted);
            padding: 0.6rem 1.2rem;
            border-radius: 30px;
            font-size: 0.85rem;
            cursor: pointer;
            z-index: 100;
        }

        .admin-btn:hover {
            border-color: var(--accent-cyan);
            color: #fff;
        }

        .inline-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.2rem;
            flex-wrap: wrap;
        }

        @media (max-width: 640px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-links {
                gap: 0.8rem 1.2rem;
            }

            .admin-box {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <canvas id="bg-canvas"></canvas>

    <div id="app" class="container">
        <nav>
            <div class="logo">OM</div>
            <div class="nav-links">
                <a href="#about">About</a>
                <a href="#projects">Projects</a>
                <a href="#contact">Contact</a>
            </div>
        </nav>

        <section id="about">
            <div style="color: var(--accent-cyan); font-weight: 600; margin-bottom: 0.5rem; letter-spacing: 1px;">01. ABOUT ME</div>
            <h1>15yo Developer & Hardware Enthusiast.</h1>
            <p class="hero-desc">
                Building high-performance web architecture, exploring cybersecurity lab setups, and pushing custom hardware projects. Fast, minimal execution, zero clutter.
            </p>
        </section>

        <section id="projects">
            <h2>Featured Systems</h2>

            <div v-if="loading" style="color: var(--text-muted);">Fetching systems...</div>

            <div v-else class="projects-grid">
                <div class="project-card" v-for="project in projects" :key="project.id">
                    <div>
                        <div class="project-header">
                            <div class="project-title">{{ project.title }}</div>
                        </div>
                        <p class="project-desc">{{ project.description }}</p>
                    </div>
                    <div class="tag-list">
                        <span class="tag-badge" v-for="tag in formatTags(project.tags)" :key="tag">
                            {{ tag }}
                        </span>
                    </div>

                    <div v-if="adminAuthenticated" class="inline-actions">
                        <button type="button" @click="startEdit(project)">Edit</button>
                        <button type="button" class="danger-btn" @click="deleteProject(project)">Delete</button>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="adminMode" class="admin-box">
            <div v-if="!adminAuthenticated">
                <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--accent-cyan);">🔒 Admin Login</h2>
                <input v-model="loginPassword" type="password" placeholder="Enter admin password" @keyup.enter="loginAdmin">
                <p v-if="loginError" style="color:#ff8a5b; margin-bottom: 1rem;">{{ loginError }}</p>
                <p style="color: var(--text-muted); margin-bottom: 1rem;">Default password: admin2026</p>
                <button type="button" @click="loginAdmin">Unlock Admin Panel</button>
            </div>

            <div v-else>
                <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1rem;">
                    <h2 style="font-size:1.5rem; margin:0; color: var(--accent-cyan);">⚙️ Project Manager</h2>
                    <button type="button" class="danger-btn" @click="logoutAdmin" style="padding:0.6rem 1rem;">Logout</button>
                </div>

                <form @submit.prevent="submitProject">
                    <input v-model="newProject.title" type="text" :placeholder="formMode === 'edit' ? 'Edit project title' : 'Project Title'" required>
                    <textarea v-model="newProject.description" :placeholder="formMode === 'edit' ? 'Edit project description...' : 'Project Description...'" rows="3" required></textarea>
                    <input v-model="newProject.tags" type="text" :placeholder="formMode === 'edit' ? 'Edit tags...' : 'Tags (comma separated, e.g., Hardware, Python, Web)'">
                    <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                        <button type="submit" :disabled="isSubmitting">
                            {{ isSubmitting ? (formMode === 'edit' ? 'Updating...' : 'Publishing...') : (formMode === 'edit' ? 'Update Project' : 'Deploy Project') }}
                        </button>
                        <button type="button" class="secondary-btn" @click="resetForm">Cancel</button>
                    </div>
                </form>
            </div>
        </section>

        <section id="contact">
            <h2>Contact</h2>
            <div class="project-card" style="max-width: 500px;">
                <p class="project-desc">Open for web design pitches, custom software builds, or tech collaborations.</p>
                <p style="color: var(--accent-cyan); font-weight: 600; margin-top: 1rem;">Business Email Available Upon Request</p>
            </div>
        </section>

        <button class="admin-btn" @click="toggleAdmin">
            {{ adminAuthenticated ? (adminMode ? 'Close Admin' : '⚙️ Admin Console') : '🔒 Admin Login' }}
        </button>
    </div>

    <script>
        const canvas = document.getElementById('bg-canvas');
        const ctx = canvas.getContext('2d');

        let width, height;
        let stars = [];
        let shapes = [];
        let mouse = { x: null, y: null, radius: 150 };

        window.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });

        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        class Star {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.size = Math.random() * 1.8 + 0.5;
                this.vx = (Math.random() - 0.5) * 0.4;
                this.vy = (Math.random() - 0.5) * 0.4;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0) this.x = width;
                if (this.x > width) this.x = 0;
                if (this.y < 0) this.y = height;
                if (this.y > height) this.y = 0;
            }

            draw() {
                ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        class Shape {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.size = Math.random() * 30 + 15;
                this.sides = Math.floor(Math.random() * 3) + 3;
                this.angle = Math.random() * Math.PI * 2;
                this.rotSpeed = (Math.random() - 0.5) * 0.01;
                this.vx = (Math.random() - 0.5) * 0.3;
                this.vy = (Math.random() - 0.5) * 0.3;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;
                this.angle += this.rotSpeed;

                if (this.x < -50) this.x = width + 50;
                if (this.x > width + 50) this.x = -50;
                if (this.y < -50) this.y = height + 50;
                if (this.y > height + 50) this.y = -50;
            }

            draw() {
                ctx.strokeStyle = 'rgba(0, 240, 255, 0.15)';
                ctx.lineWidth = 1.5;
                ctx.beginPath();
                for (let i = 0; i < this.sides; i++) {
                    let a = this.angle + (i * 2 * Math.PI / this.sides);
                    let sx = this.x + this.size * Math.cos(a);
                    let sy = this.y + this.size * Math.sin(a);
                    if (i === 0) ctx.moveTo(sx, sy);
                    else ctx.lineTo(sx, sy);
                }
                ctx.closePath();
                ctx.stroke();
            }
        }

        for (let i = 0; i < 90; i++) stars.push(new Star());
        for (let i = 0; i < 12; i++) shapes.push(new Shape());

        function animate() {
            ctx.clearRect(0, 0, width, height);
            shapes.forEach(s => { s.update(); s.draw(); });

            for (let i = 0; i < stars.length; i++) {
                stars[i].update();
                stars[i].draw();

                for (let j = i + 1; j < stars.length; j++) {
                    let dx = stars[i].x - stars[j].x;
                    let dy = stars[i].y - stars[j].y;
                    let dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 110) {
                        ctx.strokeStyle = `rgba(112, 0, 255, ${0.25 - dist / 440})`;
                        ctx.lineWidth = 0.8;
                        ctx.beginPath();
                        ctx.moveTo(stars[i].x, stars[i].y);
                        ctx.lineTo(stars[j].x, stars[j].y);
                        ctx.stroke();
                    }
                }

                if (mouse.x && mouse.y) {
                    let mdx = stars[i].x - mouse.x;
                    let mdy = stars[i].y - mouse.y;
                    let mdist = Math.sqrt(mdx * mdx + mdy * mdy);
                    if (mdist < mouse.radius) {
                        ctx.strokeStyle = `rgba(0, 240, 255, ${0.4 - mdist / (mouse.radius * 2.5)})`;
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(stars[i].x, stars[i].y);
                        ctx.lineTo(mouse.x, mouse.y);
                        ctx.stroke();
                    }
                }
            }

            requestAnimationFrame(animate);
        }
        animate();
    </script>

    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    projects: [],
                    adminMode: false,
                    loading: true,
                    isSubmitting: false,
                    adminAuthenticated: false,
                    loginPassword: '',
                    loginError: '',
                    formMode: 'add',
                    editingProjectId: null,
                    newProject: { title: '', description: '', tags: '' }
                };
            },
            mounted() {
                this.fetchProjects();
                this.checkAdminSession();
            },
            methods: {
                formatTags(tagString) {
                    if (!tagString) return [];
                    if (Array.isArray(tagString)) {
                        return tagString.map((t) => String(t).trim()).filter(Boolean);
                    }
                    return String(tagString).split(',').map((t) => t.trim()).filter(Boolean);
                },
                async checkAdminSession() {
                    try {
                        const response = await fetch('api.php?auth=1');
                        const data = await response.json();
                        this.adminAuthenticated = Boolean(data.authenticated);
                    } catch (error) {
                        this.adminAuthenticated = false;
                    }
                },
                toggleAdmin() {
                    if (!this.adminAuthenticated) {
                        this.adminMode = !this.adminMode;
                        this.loginError = '';
                        return;
                    }

                    this.adminMode = !this.adminMode;
                    if (!this.adminMode) {
                        this.resetForm();
                    }
                },
                resetForm() {
                    this.formMode = 'add';
                    this.editingProjectId = null;
                    this.newProject = { title: '', description: '', tags: '' };
                    this.loginError = '';
                },
                async loginAdmin() {
                    if (!this.loginPassword.trim()) {
                        this.loginError = 'Please enter the admin password.';
                        return;
                    }

                    try {
                        const passwordHash = await this.sha256(this.loginPassword.trim());
                        const response = await fetch('api.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ action: 'login', password: passwordHash })
                        });

                        const result = await response.json();
                        if (response.ok && result.status === 'success') {
                            this.adminAuthenticated = true;
                            this.adminMode = true;
                            this.loginPassword = '';
                            this.loginError = '';
                            this.resetForm();
                            return;
                        }

                        this.loginError = result.message || 'Invalid password.';
                    } catch (error) {
                        this.loginError = 'Unable to authenticate admin.';
                    }
                },
                async logoutAdmin() {
                    try {
                        await fetch('api.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ action: 'logout' })
                        });
                    } catch (error) {
                        console.warn('Logout request failed:', error);
                    }

                    this.adminAuthenticated = false;
                    this.adminMode = false;
                    this.loginPassword = '';
                    this.resetForm();
                },
                startEdit(project) {
                    this.formMode = 'edit';
                    this.editingProjectId = project.id;
                    this.newProject = {
                        title: project.title,
                        description: project.description,
                        tags: project.tags || ''
                    };
                    this.adminMode = true;
                },
                async fetchProjects() {
                    try {
                        const response = await fetch('api.php');
                        const data = await response.json();
                        this.projects = Array.isArray(data) ? data : [];
                    } catch (error) {
                        console.error('Failed to load projects:', error);
                        this.projects = [];
                    } finally {
                        this.loading = false;
                    }
                },
                async submitProject() {
                    if (!this.adminAuthenticated) {
                        this.adminMode = true;
                        return;
                    }

                    this.isSubmitting = true;
                    try {
                        const payload = {
                            title: this.newProject.title.trim(),
                            description: this.newProject.description.trim(),
                            tags: this.newProject.tags.trim()
                        };

                        const method = this.formMode === 'edit' ? 'PUT' : 'POST';
                        const requestBody = this.formMode === 'edit'
                            ? { id: this.editingProjectId, ...payload }
                            : payload;

                        const response = await fetch('api.php', {
                            method,
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(requestBody)
                        });

                        const result = await response.json();
                        if (!response.ok || result.status !== 'success') {
                            throw new Error(result.message || 'Project action failed.');
                        }

                        if (this.formMode === 'edit') {
                            this.projects = this.projects.map((project) => {
                                if (String(project.id) === String(this.editingProjectId)) {
                                    return { ...project, ...result.project, id: this.editingProjectId };
                                }
                                return project;
                            });
                        } else {
                            this.projects.unshift(result.project);
                        }

                        this.resetForm();
                        this.adminMode = false;
                    } catch (error) {
                        alert(error.message || 'Unable to save project.');
                    } finally {
                        this.isSubmitting = false;
                    }
                },
                async deleteProject(project) {
                    const confirmed = window.confirm(`Delete "${project.title}" from the portfolio?`);
                    if (!confirmed) return;

                    try {
                        const response = await fetch('api.php', {
                            method: 'DELETE',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: project.id })
                        });

                        const result = await response.json();
                        if (!response.ok || result.status !== 'success') {
                            throw new Error(result.message || 'Delete failed.');
                        }

                        this.projects = this.projects.filter((item) => String(item.id) !== String(project.id));
                    } catch (error) {
                        alert(error.message || 'Unable to delete project.');
                    }
                },
                async sha256(text) {
                    const buffer = new TextEncoder().encode(text);
                    const digest = await crypto.subtle.digest('SHA-256', buffer);
                    return Array.from(new Uint8Array(digest)).map((byte) => byte.toString(16).padStart(2, '0')).join('');
                }
            }
        }).mount('#app');
    </script>
</body>
</html>
