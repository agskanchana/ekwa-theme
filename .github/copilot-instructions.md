# EKWA Theme — Copilot Instructions

## Project Overview
WordPress theme for dental/medical practice websites managed by EKWA Marketing. Built on the Underscores (`_s`) starter theme. No build step — all CSS/JS are hand-authored flat files.

## Block Architecture

All custom blocks are **ACF Gutenberg blocks** registered on `acf/init` in [blocks/ekwa-blocks.php](../blocks/ekwa-blocks.php). Each block lives in `blocks/{block-name}/` and contains exactly:

| File | Purpose |
|---|---|
| `block.json` | Block manifest — name must be `acf/ekwa-{name}`, category `ekwa-blocks` |
| `block.php` | Server-side render template |
| `README.md` | Developer notes |

**Registration:** `register_block_type(get_template_directory() . '/blocks/{name}')` — WordPress reads `block.json` automatically. To add a new block: create the directory with these three files and add a `register_block_type()` call in `ekwa-blocks.php`.

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

Mobile-specific partials: `template-parts/mobile-header.php`, `mobile-menu.php`, `mobile-footer-icons.php`.

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

- [css/color-variables.css](../css/color-variables.css) — CSS custom properties populated from Kirki Customizer values, output at `wp_head` priority 1 via `settings/customizer-font-end/index.php`
- [css/critical.css](../css/critical.css) — critical path styles
- Block styles are inline `<style>` tags inside `block.php` templates, moved to `<head>` via the section head styles mechanism
- Bootstrap pre-built assets live in `layouts/bootstrap/`

## PHP Conventions

- **All functions prefixed `ekwa_`** — no PHP namespaces; flat function-based approach
- Only one class: `EKWA_Plugin_Wizard` (singleton) in `inc/class-ekwa-plugin-wizard.php`
- **Dependency guards** before every ACF/Kirki call: `if (!function_exists('acf_register_block_type'))`, `if (!class_exists('Kirki'))`
- Every PHP file starts with `if (!defined('ABSPATH')) { exit; }`
- Theme settings use `get_theme_mod()` / Kirki — not raw `get_option()`
- Global variables `$ekwa_section_head_styles`, `$phone`, `$existing_phone` are used intentionally across template scope

## Coding Standards

PHPCS with `WordPress` ruleset defined in [phpcs.xml.dist](../phpcs.xml.dist). Run: `vendor/bin/phpcs` (if Composer deps are installed) — checks `.php` and `.css`, skips JS. **Note:** the text domain in `phpcs.xml.dist` is still set to `_s` (Underscores default) — the correct domain is `ekwa`.

## Key File Map

| Directory | Role |
|---|---|
| `blocks/` | ACF block definitions — `block.json` + `block.php` + `README.md` per block |
| `acf-json/` | ACF field group JSON (auto-synced) |
| `settings/` | CPTs, Kirki Customizer, ACF PHP groups, shared block style helpers |
| `inc/` | Underscores core helpers + plugin wizard class |
| `css/` | Flat CSS — color variables, critical, desktop overrides |
| `js/` | Flat JS — no bundler/transpiler |
| `layouts/bootstrap/` | Pre-built Bootstrap assets |
