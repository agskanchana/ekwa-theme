# EKWA Theme — Copilot Instructions

## Project Overview
WordPress **parent theme** for dental/medical practice websites managed by EKWA Marketing. Built on the Underscores (`_s`) starter theme. No build step — all CSS/JS are hand-authored flat files. Client sites use a **child theme** for customizations; this base theme is updatable via GitHub releases.

## Child Theme Architecture

This is a **parent theme**. Each client site uses a child theme (cloned from `ekwa-starter-child/`) that:
- Inherits all blocks, settings, CPTs, and functionality
- Can override any parent block by placing `blocks/{name}/block.json` + `block.php` in the child
- Adds client-specific styles in `css/child-styles.css`
- Gets its own GitHub-based updates independently
- Contains `html-mockups/` for the AI mockup-to-WordPress conversion workflow (HTML files or screenshots in `html-mockups/assets/screenshots/`)

### Block Override System
`ekwa_get_block_path($block_name)` in [blocks/ekwa-blocks.php](../blocks/ekwa-blocks.php) checks `get_stylesheet_directory()` first, then falls back to `get_template_directory()`. Child themes can override any block by providing the same directory structure.

### GitHub Theme Updater
`Ekwa_Theme_Updater` class in [inc/class-ekwa-theme-updater.php](../inc/class-ekwa-theme-updater.php) hooks into `pre_set_site_transient_update_themes` and `themes_api` to check GitHub releases. Configure via `wp-config.php`:
```php
define( 'EKWA_GITHUB_REPO', 'your-org/ekwa-theme' );       // parent
define( 'EKWA_CHILD_GITHUB_REPO', 'your-org/client-theme' ); // child
define( 'EKWA_GITHUB_TOKEN', 'ghp_xxxxxxxxxxxx' );           // private repo access
```

### Theme Activation Defaults
On `after_switch_theme`, `ekwa_theme_activation_defaults()` in `functions.php` auto-creates a default Header and Footer CPT post (if none exist) and sets the corresponding theme_mods.

## Block Architecture

All custom blocks are **ACF Gutenberg blocks** registered on `acf/init` in [blocks/ekwa-blocks.php](../blocks/ekwa-blocks.php). Each block lives in `blocks/{block-name}/` and contains exactly:

| File | Purpose |
|---|---|
| `block.json` | Block manifest — name must be `acf/ekwa-{name}`, category `ekwa-blocks` |
| `block.php` | Server-side render template |
| `README.md` | Developer notes |

**Active blocks** are listed in the `$active_blocks` array in `ekwa_register_acf_blocks()`. **Inactive blocks** (section, main-menu, webp-image) have their folders kept but are not registered.

**Registration:** Blocks are registered via a loop: `register_block_type( ekwa_get_block_path( $block_name ) )`. To add a new block: create the directory with the three files and add the name to the `$active_blocks` array.

**`block.json` key fields:**
```json
{ "name": "acf/ekwa-section", "category": "ekwa-blocks",
  "acf": { "mode": "preview", "renderTemplate": "block.php" },
  "supports": { "anchor": true, "className": true, "jsx": true } }
```
Use `"jsx": true` only for InnerBlocks containers (e.g., `section`, `conditional`).

## Block Template Conventions (`block.php`)

```php
// Standard ID/class boilerplate at top of every block.php:
$block_id = 'ekwa-{name}-' . $block['id'];
if (!empty($block['anchor'])) { $block_id = $block['anchor']; }
$class_name = 'ekwa-{name}';
if (!empty($block['className'])) { $class_name .= ' ' . $block['className']; }
```

Inline styles are built from ACF fields using helpers in [settings/acf-common-block-styles.php](../settings/acf-common-block-styles.php):
- `ekwa_acf($property, $acf_slug, $prefix, $bg)` — outputs a single CSS property from a field
- `ekwa_padding_marging($type, $direction, $device)` — padding/margin from advance groups
- `ekwa_sizing($width_or_height)` — width/height with unit
- `ekwa_advanced_border($direction)` / `ekwa_advanced_bdrs($x, $y)` — complex borders

**CLS prevention:** The section block uses `$ekwa_section_head_styles` global + `ob_start()` output buffering to move `<style>` tags from footer to `<head>` (see [blocks/section/block.php](../blocks/section/block.php)).

## ACF Field Groups

JSON files live in [acf-json/](../acf-json/) — ACF auto-syncs to/from this directory via `acf/settings/save_json` and `acf/settings/load_json` filters in `functions.php`. Newer files use semantic names (`group_ekwa_section_block.json`); older files use timestamp keys (`group_5f637c4….json`). When editing field groups in the UI, the JSON auto-updates on save.

Some groups are PHP-registered via `acf_add_local_field_group()` in [settings/acf.php](../settings/acf.php) (site settings, CPT meta).

## Template Hierarchy

Headers and footers are **Gutenberg-block-editor content** stored in `ekwa_theme_headers` / `ekwa_theme_footers` custom post types — not hard-coded PHP. Each page can override via ACF fields `custom_header` / `select_header`.

```
page.php / single.php
  └── get_header() → header.php → fetches CPT post content for header
  └── [Gutenberg block content]
  └── get_footer() → footer.php → fetches CPT post content for footer
```

Mobile header partial: `template-parts/mobile-header.php`. The mobile bottom icon bar is rendered via the `acf/ekwa-mobile-icon-menu` block placed inside the Footer CPT post (not a template part).

## Custom Post Types, Phone Tracking & Multi-Location

Dental/medical specific CPTs registered in [settings/theme-functions.php](../settings/theme-functions.php):
- `ekwa_theme_headers`, `ekwa_theme_footers` (builder templates)
- Phone number blocks handle "New Patients" vs "Existing Patients" numbers with ad-tracking cookie logic (`call_tracking_number`, `adsense_number`, `existing_patients_phone`)

**Multi-location helpers** (all in `settings/theme-functions.php`):
- `get_location($sub_val, $which_location = 1)` — reads from `location_info` Kirki theme mod (repeater); `$sub_val` is the field key (e.g., `'city'`, `'state'`, `'street_address'`, `'phone'`, `'phone_ex'`, `'zip'`); `$which_location` is 1-based index
- `get_address($which_location = 1)` — returns formatted address string for a location
- `get_location_working_hours($which_location = 1)` — returns array of working hours for a location
- `display_location_working_hours($which_location, $format)` — renders hours as `'list'`, `'table'`, or `'schema'`
- `get_appointment_link()` — returns appointment URL (supports internal page or external URL via `appointment_page_type` theme mod)

## CSS Architecture

- CSS custom properties (`--color_one`, `--font_body`, etc.) are output inline at `wp_head` priority 1 via `settings/customizer-font-end/index.php` with hardcoded defaults. **Child themes override these by defining a `:root {}` block in `css/child-styles.css`** — do not use the Customizer for colors or fonts.
- [css/critical.css](../css/critical.css) — critical path styles
- Block styles are inline `<style>` tags inside `block.php` templates, moved to `<head>` via the section head styles mechanism
- Bootstrap pre-built assets live in `layouts/bootstrap/`
- `css/color-variables.css` — legacy file written by `update_admin_css()` on Customizer save; **not loaded/enqueued** — ignore it

## PHP Conventions

- **All functions prefixed `ekwa_`** — no PHP namespaces; flat function-based approach
- Only one class: `EKWA_Plugin_Wizard` (singleton) in `inc/class-ekwa-plugin-wizard.php`
- **Dependency guards** before every ACF/Kirki call: `if (!function_exists('acf_register_block_type'))`, `if (!class_exists('Kirki'))`
- Every PHP file starts with `if (!defined('ABSPATH')) { exit; }`
- Theme settings use `get_theme_mod()` / Kirki — not raw `get_option()`
- Global variables `$ekwa_section_head_styles`, `$phone`, `$existing_phone` are used intentionally across template scope

## Coding Standards

PHPCS with `WordPress` ruleset defined in [phpcs.xml.dist](../phpcs.xml.dist). Run: `vendor/bin/phpcs` (if Composer deps are installed) — checks `.php` and `.css`, skips JS. Text domain: `ekwa`.

## Shortcodes

Registered in [settings/short-codes-post-types.php](../settings/short-codes-post-types.php):

| Shortcode | Purpose |
|---|---|
| `[phone]` / `[phone location="2"]` | Primary phone (ad-tracking aware) |
| `[phone_ex]` | Existing patients phone |
| `[mobile_number]` / `[mobile_number_ex]` | tel: formatted numbers |
| `[ekwa_address]` / `[ekwa_address location="2"]` | Formatted practice address |
| `[ekwa_working_hours format="list"]` | Working hours (list or table) |
| `[ekwa_nav_menu location="main-menu" class="x"]` | WordPress nav menu wrapper |
| `[fa_icon class="fas fa-phone"]` | FontAwesome icon |

## Key File Map

| Directory / File | Role |
|---|---|
| `blocks/` | ACF block definitions — `block.json` + `block.php` + `README.md` per block |
| `acf-json/` | ACF field group JSON (auto-synced) |
| `settings/` | CPTs, Kirki Customizer, ACF PHP groups, shared block style helpers |
| `inc/` | Underscores core helpers, plugin wizard, **theme updater class** |
| `inc/class-ekwa-theme-updater.php` | GitHub release-based update mechanism |
| `css/` | Flat CSS — color variables, critical, desktop overrides |
| `js/` | Flat JS — no bundler/transpiler |
| `layouts/bootstrap/` | Pre-built Bootstrap assets |
