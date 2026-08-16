<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ashu | Portfolio</title>
    <!-- Vue 3 CDN -->
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: var(--bg-black);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Fixed Background Canvas for Stars, Shapes & Lines */
        #bg-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }

        /* Layout Container */
        .container {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--card-border);
            backdrop-filter: blur(8px);
        }

        .logo {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 2px;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            margin-left: 2rem;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: var(--accent-cyan);
        }

        /* Typography */
        h1 { font-size: clamp(2.8rem, 6vw, 5rem); font-weight: 900; line-height: 1.1; margin-bottom: 1rem; }
        h2 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; margin-bottom: 2rem; color: #fff; display: flex; align-items: center; gap: 10px; }
        h2::after { content: ''; flex: 1; height: 1px; background: var(--card-border); }

        /* Sections */
        section {
            padding: 4rem 0;
        }

        .hero-desc {
            font-size: clamp(1.1rem, 2vw, 1.4rem);
            color: var(--text-muted);
            max-width: 650px;
            line-height: 1.6;
        }

        /* Projects Grid */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
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

        /* Admin Panel Form */
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
    </style>
</head>
<body>

    <!-- Background Canvas for Moving Stars, Geometric Shapes & Lines -->
    <canvas id="bg-canvas"></canvas>

    <div id="app" class="container">
        
        <nav>
            <div class="logo">ASHU</div>
            <div class="nav-links">
                <a href="#about">About</a>
                <a href="#projects">Projects</a>
                <a href="#contact">Contact</a>
            </div>
        </nav>

        <!-- HERO / ABOUT SECTION -->
        <section id="about">
            <div style="color: var(--accent-cyan); font-weight: 600; margin-bottom: 0.5rem; letter-spacing: 1px;">01. ABOUT ME</div>
            <h1>15yo Developer & Hardware Enthusiast.</h1>
            <p class="hero-desc">
                Building high-performance web architecture, exploring cybersecurity lab setups, and pushing custom hardware projects. Fast, minimal execution, zero clutter.
            </p>
        </section>

        <!-- PROJECTS SECTION -->
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
                </div>
            </div>
        </section>

        <!-- REAL-TIME ADMIN PANEL -->
        <section v-if="adminMode" class="admin-box">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--accent-cyan);">⚙️ System Admin: Push Project</h2>
            <form @submit.prevent="submitProject">
                <input v-model="newProject.title" type="text" placeholder="Project Title" required>
                <textarea v-model="newProject.description" placeholder="Project Description..." rows="3" required></textarea>
                <input v-model="newProject.tags" type="text" placeholder="Tags (comma separated, e.g., Hardware, Python, Web)">
                <button type="submit" :disabled="isSubmitting">
                    {{ isSubmitting ? 'Syncing with Server...' : 'Deploy Project' }}
                </button>
            </form>
        </section>

        <!-- CONTACT SECTION -->
        <section id="contact">
            <h2>Contact</h2>
            <div class="project-card" style="max-width: 500px;">
                <p class="project-desc">Open for web design pitches, custom software builds, or tech collaborations.</p>
                <p style="color: var(--accent-cyan); font-weight: 600; margin-top: 1rem;">Business Email Available Upon Request</p>
            </div>
        </section>

        <button class="admin-btn" @click="adminMode = !adminMode">
            {{ adminMode ? 'Close Admin' : '⚙️ Admin Console' }}
        </button>

    </div>

    <!-- Interactive Background Stars & Geometrics Script -->
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

        // Star Particles
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

        // Floating Geometric Shapes
        class Shape {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.size = Math.random() * 30 + 15;
                this.sides = Math.floor(Math.random() * 3) + 3; // Triangles, Squares, Pentagons
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

        // Initialize Background Objects
        for (let i = 0; i < 90; i++) stars.push(new Star());
        for (let i = 0; i < 12; i++) shapes.push(new Shape());

        function animate() {
            ctx.clearRect(0, 0, width, height);

            // Draw & Update Shapes
            shapes.forEach(s => { s.update(); s.draw(); });

            // Draw & Connect Stars
            for (let i = 0; i < stars.length; i++) {
                stars[i].update();
                stars[i].draw();

                // Draw connecting lines between close stars
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

                // Connect to mouse cursor
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

    <!-- Vue App Script -->
    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    projects: [],
                    adminMode: false,
                    loading: true,
                    isSubmitting: false,
                    newProject: { title: '', description: '', tags: '' }
                }
            },
            mounted() {
                this.fetchProjects();
            },
            methods: {
                formatTags(tagString) {
                    if (!tagString) return [];
                    return tagString.split(',').map(t => t.trim());
                },
                async fetchProjects() {
                    try {
                        const response = await fetch('api.php');
                        const data = await response.json();
                        this.projects = data;
                    } catch (err) {
                        console.error('Failed to load projects:', err);
                    } finally {
                        this.loading = false;
                    }
                },
                async submitProject() {
                    this.isSubmitting = true;
                    try {
                        const response = await fetch('api.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(this.newProject)
                        });
                        const result = await response.json();
                        if (result.status === 'success') {
                            this.projects.unshift(result.project);
                            this.newProject = { title: '', description: '', tags: '' };
                        }
                    } catch (err) {
                        console.error('Error adding project:', err);
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            }
        }).mount('#app');
    </script>
</body>
</html>
