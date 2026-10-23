# Neo Associates WordPress

This repository packages the Neo Associates WordPress implementation as a conventional theme plus two companion plugins:

- `theme/neo` — the public Neo Associates theme, its templates, JavaScript, styles, fonts, images, video, and gallery media.
- `plugins/neo-content` — free, native WordPress content types and Custom Fields registration for services, products, gallery records, and page content.
- `plugins/neo-pencil` — a front-end editing layer for authorised WordPress users.

No commercial plugin is required. The only external dependency is the free **Advanced Custom Fields** plugin from WordPress.org.

## Install in LocalWP or WordPress

1. Copy `theme/neo` to `wp-content/themes/neo`.
2. Copy `plugins/neo-content` and `plugins/neo-pencil` to `wp-content/plugins/`.
3. In **Plugins**, install and activate the free **Advanced Custom Fields** plugin, then activate **Neo Content** and **Neo Pencil**.
4. In **Appearance → Themes**, activate **Neo Associates**.
5. Create or select the front page, then choose **Neo Home** from its Page Attributes template selector. Repeat for the remaining templates as needed.
6. Import the starter content and media from the repository root using WP-CLI:

   ```powershell
   wp neo import --asset-root="C:\path\to\neo-wp\theme\neo"
   ```

7. Set that page as the homepage in **Settings → Reading**, then configure the primary menu in **Appearance → Menus**.

The importer is safe to run again: it updates the created content instead of duplicating it.

## Content editing

- Edit page copy and images from the native WordPress editor and the Neo field groups.
- Manage services and products in their Neo custom post types.
- Manage the navigation through the `Primary` WordPress menu location.
- While logged in, use **Edit with Pencil** on the front end for supported text fields. The plugin saves through WordPress permissions and REST nonces.

## Verification

The included Playwright checks exercise the local WordPress site after it is installed:

```powershell
node tests/verify-wordpress.cjs
node tests/navbar.cjs
```

These tests expect a LocalWP site at `http://neo.local/`. Update the URLs in the scripts when using a different local domain.

## Repository scope

This is the deployable WordPress package. It deliberately excludes the original static-site source, frame-sequence source media, LocalWP databases, WordPress core, uploads, and any local credentials.
