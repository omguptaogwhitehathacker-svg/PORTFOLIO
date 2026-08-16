<doctype html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title> OM | portfolio</title>
            <!-- Vue.js for reactivity -->
             <scriptsrc ="https://unpkg.com/vue@3/dist/vue.global.js"></script>
             <style>
                :root {
                    --glass-bg: rgba(255, 255, 255 , 0.1);
                    --glass-border: rgba(255, 255, 255, 0.2);
                    --text-main: #ffffff;
                    --accent: #00ffcc;
                }
                * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        /* Vibrant Animated Background */
        body {
            background: linear-gradient(-45deg, #0f0c29, #302b63, #24243e, #0f0c29);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Responsive Text using clamp() */
        h1 { font-size: clamp(2.5rem, 5vw, 5rem); margin-bottom: 1rem; }
        h2 { font-size: clamp(2rem, 4vw, 3.5rem); margin-bottom: 2rem; color: var(--accent); }
        p { font-size: clamp(1rem, 1.5vw, 1.2rem); line-height: 1.6; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        section {
            padding: 5rem 0;
            border-bottom: 1px solid var(--glass-border);
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .tags {
            color: var(--accent);
            font-size: 0.9rem;
            margin-top: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Forms & Admin */
        input, textarea {
            width: 100%;
            padding: 1rem;
            margin-bottom: 1rem;
            background: rgba(0,0,0,0.2);
            border: 1px solid var(--glass-border);
            color: white;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            background: var(--accent);
            color: #000;
            border: none;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        button:hover {
            background: #00e6b8;
            transform: scale(1.02);
        }

        .admin-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0,0,0,0.5);
            color: white;
            font-size: 0.8rem;
            padding: 10px;
        }

        /* Interactive JS Cursor Glow */
        #cursor-glow {
            position: fixed;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0,255,204,0.15) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: -1;
        }
             </style>
             </head>
<body>
    <div id="cursor-glow"></div>

    <div id="app" class="container">
        
        <!-- ABOUT SECTION -->
        <section id="about">
            <h1>Hi, I'm om.</h1>
            <p>I'm a 15-year-old programmer based in Agra. I build high-performance tools, break things to learn how they work, and engineer hardware-software integrations.</p>
        </section>

        <!-- PROJECTS SECTION (Reactive via Vue & PHP) -->
        <section id="projects">
            <h2>Systems & Projects</h2>
            
            <div v-if="loading">Loading projects from server...</div>

            <div v-else class="project-grid">
                <div class="glass-card" v-for="project in projects" :key="project.id">
                    <h3>{{ project.title }}</h3>
                    <p style="margin-top: 10px;">{{ project.description }}</p>
                    <div class="tags">{{ project.tags }}</div>
                </div>
            </div>
        </section>

        <!-- ADMIN PANEL -->
        <section id="admin" v-if="adminMode" class="glass-card" style="border-color: var(--accent);">
            <h2 style="font-size: 2rem;">⚡ Admin: Deploy New Project</h2>
            <form @submit.prevent="submitProject">
                <input v-model="newProject.title" type="text" placeholder="Project Name" required>
                <textarea v-model="newProject.description" placeholder="Technical details..." rows="3" required></textarea>
                <input v-model="newProject.tags" type="text" placeholder="Tags (e.g., Vue.js, PHP, Hardware)">
                <button type="submit" :disabled="isSubmitting">
                    {{ isSubmitting ? 'Pushing to Server...' : 'Ship It' }}
                </button>
            </form>
        </section>

        <!-- CONTACT SECTION -->
        <section id="contact">
            <h2>Initialize Contact</h2>
            <div class="glass-card">
                <p>Looking for a high-performance web build or want to collaborate on a hardware project?</p>
                <p style="margin-top:1rem;">Email for business inquiries only.</p>
            </div>
        </section>

        <button class="admin-toggle" @click="adminMode = !adminMode">
            ⚙️ Toggle Admin Panel
        </button>
    </div>

    <script>
        // Interactive Cursor Glow
        document.addEventListener('mousemove', (e) => {
            const glow = document.getElementById('cursor-glow');
            glow.style.left = e.clientX + 'px';
            glow.style.top = e.clientY + 'px';
        });

        // Vue.js Application
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    projects: [],
                    adminMode: false,
                    loading: true,
                    isSubmitting: false,
                    newProject: {
                        title: '',
                        description: '',
                        tags: ''
                    }
                }
            },
            mounted() {
                this.fetchProjects();
            },
            methods: {
                // GET request to PHP API
                async fetchProjects() {
                    try {
                        const response = await fetch('api.php');
                        const data = await response.json();
                        this.projects = data;
                        this.loading = false;
                    } catch (error) {
                        console.error("Error fetching projects:", error);
                        this.loading = false;
                    }
                },
                // POST request to PHP API
                async submitProject() {
                    this.isSubmitting = true;
                    try {
                        const response = await fetch('api.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(this.newProject)
                        });
                        
                        const result = await response.json();
                        
                        if (result.status === 'success') {
                            // Reactively update the UI instantly
                            this.projects.unshift(result.project);
                            // Clear the form
                            this.newProject = { title: '', description: '', tags: '' };
                        }
                    } catch (error) {
                        console.error("Error saving project:", error);
                    }
                    this.isSubmitting = false;
                }
            }
        }).mount('#app');
    </script>
</body>
</html>