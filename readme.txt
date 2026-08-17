OM GUPTA // PORTFOLIO PROJECT

ABOUT THIS PROJECT
------------------
This project is a personal portfolio website blended with a futuristic operating-system-inspired desktop experience.
It combines a premium front-end vibe, admin-controlled project management, interactive desktop windows,
text editor tooling, local file handling, and a music app where users can upload and play their own MP3 files.

Built for portfolio presentation, creative branding, and immersive web UI experimentation.


CORE FEATURES
-------------
- Portfolio landing page with about, projects, and contact-style sections
- Dynamic project list driven by JSON data
- Admin panel for adding, editing, and deleting project entries
- SHA-256 based password protection for admin access
- OS-style desktop simulation with:
  - draggable windows
  - taskbar and start menu
  - desktop icon grid
  - theme toggle
- Text editor app with open, save, rename, and file management
- Music app with MP3 upload support and playback controls
- Responsive design for desktop and smaller screens
- Docker-ready static deployment for quick setup


PROJECT STRUCTURE
-----------------
/root
  index.php               - Main portfolio page and UI shell
  api.php                 - Project CRUD API and admin authentication logic
  projects.json           - Stored project data
  readme.txt              - Project documentation
  license.txt             - License information
  weboss/
    index.html            - Desktop OS-inspired interactive front-end
    Dockerfile            - Docker build for the WebOS page
    readme.txt            - WebOS-specific notes


HOW TO RUN
----------
Option 1: Open directly in browser
- Open index.php in a PHP-enabled local server
- Example:
  php -S localhost:8000
  Then visit http://localhost:8000

Option 2: Run the WebOS app via Docker
- Open the weboss folder
- Build the image:
  docker build -t om-webos .
- Run it:
  docker run -p 8080:80 om-webos
- Then visit http://localhost:8080


ADMIN ACCESS
------------
The admin panel is protected using SHA-256 hashing.
Use the configured admin credential logic defined in api.php.

IMPORTANT:
- Please read license.txt for the official legal terms.
- This project is created for creative and portfolio use.
- Credit is appreciated and recommended.


CREDITS
--------
Built by: OM GUPTA
Project identity: D3RLORD3 / omguptaogwhitehathacker
Concept direction: cyber aesthetic, minimal premium UI

"D3RLORD3 is not a name. It is a signal. A code for control, precision, and vision."


LICENSE
--------
This project is shared under the terms described in license.txt.
Please refer to that file for the full copyright and redistribution details.


FINAL NOTE
----------
This project was created with passion, experimentation, and a desire to push the boundaries
of personal branding through a visual aesthatic digital experience.
It is open for learning, customization, and creative reuse, with credit where it is due.

"Built to feel like a machine. Crafted to feel like a statement."

----------------------------------------------
OM GUPTA // DIGITAL DOMAIN / PORTFOLIO
----------------------------------------------