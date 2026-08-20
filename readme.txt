# Om's Portfolio Website

Hey! This is my personal portfolio. I built it to show off my projects (HHO stuff, solar things, etc.) and maybe get some cool collabs.

## What's inside

- **About page** – who I am and what I like.
- **Projects page** – all my projects with emojis and descriptions.
- **Contact page** – my email and socials.
- **Admin panel** – a hidden page where I can add, edit, or delete projects. It has a login (username: `om`, password: `om123`). Keep it secret 😉.

## How to run

Just open `index.html` in any browser. No server needed, it's all static HTML, CSS, and JavaScript. Projects are saved in `localStorage`, so they stay even after refresh.

## The techy stuff

- Plain HTML, CSS, and vanilla JavaScript. No frameworks because I wanted to keep it simple.
- The background has a parallax effect – it moves slower than the page when you scroll. I did that by listening to the scroll event and changing the `transform` property.
- The admin panel uses `localStorage` to store projects. So if I add a new project, it's saved on my computer (or wherever the site is hosted). It's not a real database, but fine for now.
- Login uses `sessionStorage` so it only stays logged in for that tab.

## Why I made it

I like building things, both software and hardware. This website is kind of a mix of both – it's a coding project that shows off my hardware projects. I wanted it to look industrial because my projects are mostly mechanical/scientific. Orange is my favorite color, and it fits the "metal and sparks" vibe.

## Known issues / future ideas

- The login is not secure at all – anyone can read the source code and find the password. For a real site I'd need a backend.
- I want to add a real database later (maybe Firebase) so the admin panel works on any device.
- I'd love to add a lightbox for project images.

That's it. Thanks for checking it out!