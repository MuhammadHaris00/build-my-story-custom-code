# Build My Story Custom Code

Repository containing custom code for buildmystory.com.

## Contents

| Path | Description |
|------|-------------|
| `buildmystory-custom-code.php` | WordPress plugin with custom shortcodes |
| `build.sh` | Build script that zips the plugin for installation |
| `jacob-get-user-location/` | Small demo: fetches user IP & country via ipify / ipapi.co |

## WordPress Plugin: BuildMyStory Custom Code

A WordPress plugin (MU-style/custom code plugin) adding two shortcodes for the BuildMyStory project.

### Installation

1. Run `./build.sh` to create `buildmystory-custom-code.zip`.
2. Upload the zip via WordPress Plugins → Add New → Upload Plugin, or place `buildmystory-custom-code.php` in `wp-content/plugins/`.
3. Activate the plugin.

Requires Advanced Custom Fields (ACF) — the `get_field()` calls depend on it.

### Shortcodes

#### `pdf_resources_grid`

Renders a grid of PDF/PPTX resources from an ACF field named `resources` on the current post.

Each resource item displays a thumbnail (custom thumbnail, fallback file thumbnail, or a default PDF/PPTX icon) linking to the file, plus its title.

```
[pdf_resources_grid]
```

HTML structure:

```html
<div class="hrs-pdf-grid">
  <div class="hrs-pdf-item">
    <a href="..." target="_blank" rel="noopener">
      <img src="..." alt="..." class="hrs-pdf-thumb" />
    </a>
    <div class="hrs-pdf-name">Title</div>
  </div>
  ...
</div>
```

#### `student_work_loop`

Renders a grid of related "student work" posts from an ACF Post Object field named `student_work` on the current post. Each item links to the related post and shows its title, the `made_by` field, and a thumbnail.

```
[student_work_loop]
```

HTML structure:

```html
<div class="student-work-grid">
  <div class="student-work-item">
    <a href="...">
      <div class="student-work-content">
        <h3 class="student-work-title">Title</h3>
        <p class="student-work-madeby">By Name</p>
      </div>
      <div class="student-work-thumb">...</div>
    </a>
  </div>
  ...
</div>
```

### Build

```bash
./build.sh
```

Produces `buildmystory-custom-code.zip`.

## jacob-get-user-location

A small vanilla JS demo showing a user's IP address and country.

Open `jacob-get-user-location/index.html` in a browser. It calls:

- `https://api64.ipify.org?format=json` to get the user's IP
- `https://ipapi.co/{ip}/json/` to get location data

Results are written into `#user-ip` and `#user-country` elements.

## License

No license specified. All rights reserved by Muhammad Haris.
