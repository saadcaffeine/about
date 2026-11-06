# about

Source for [ediblemakerspace.com/about](https://ediblemakerspace.com/about/) (mirrored at [saadcaffeine.github.io/about](https://saadcaffeine.github.io/about)) — Saad Chinoy's personal site: bio, project timeline, talks, network, and contact info.

Served via GitHub Pages directly from `index.html` on `main`. A plain-text mirror of the page content lives in [ABOUT.md](ABOUT.md).

## Editing

- Timeline entries live in the `ENTRIES` list in `index.html`; talks are the static Talks section. After editing either, run `node tools/build.js` to pre-render the timeline into the HTML (so crawlers can read it) and regenerate `ABOUT.md`.
- Pushing to `main` deploys the page to ediblemakerspace.com/about/ over FTPS.

## WordPress sitemap plugin

`wordpress/mu-plugins/ems-about-sitemap.php` adds this page and /citizenquack/ to ediblemakerspace.com's WordPress sitemap (`/wp-sitemap.xml`). It is deployed separately and only on demand: Actions → "Deploy sitemap plugin to ediblemakerspace.com WordPress" → Run workflow. To remove it, delete the file from `wp-content/mu-plugins/` on the server.
