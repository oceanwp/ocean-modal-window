# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

Ocean Modal Window is a free OceanWP add-on (published on WordPress.org) for building modal popups that open on click. Each modal is a post of the `ocean_modal_window` custom post type; its content is the post content or a My Library template. It only works with the OceanWP theme.

## Commands

```bash
npx grunt              # default: browserify + babel JS, uglify, SCSS (style + metabox, expanded + min), autoprefixer, csscomb
npx grunt watch        # rebuild on SCSS/JS changes (livereload)
npx grunt build        # copy a release copy to build/ocean-modal-window/
npx grunt package      # zip build/ocean-modal-window/ into build/ocean-modal-window.zip
npx grunt final        # default + build + package in one go
npm run lint:js        # wp-scripts lint-js
composer lint:php      # phpcs (phpcs.xml.dist) + parallel-lint + PHPCompatibilityWP 5.6+ (also: npm run lint:php)
composer make-pot      # wp i18n make-pot -> languages/ocean-modal-window.pot (needs WP-CLI; also: npm run pot)
composer update-mo     # msgmerge + msgfmt for the es_ES, pl_PL and fr_FR translations (needs gettext)
```

There are no tests. `npm run build` / `npm run start` point wp-scripts at `omw-src/metabox` and `omw-src/modal-settings`, which are not in this repo; only the compiled files in `assets/dist/` are committed. The csscomb step expects a `.csscomb.json` that is also not in the repo.

PHPCS uses WordPress-Extra + WordPress-Docs, text domain `ocean-modal-window`, global prefix `omw`, and skips `assets/`.

## Built assets are committed

Edit sources, then run `npx grunt` and commit the outputs too:
- `assets/src/js/modal-window.js` (imports `base/base.js`, `lib/utils.js`) -> browserify -> `assets/js/modal-window.js` -> `modal-window.min.js`
- `assets/css/style.scss` and `metabox.scss` -> `.css` and `.min.css`
- `assets/js/customizer.js` (Customizer preview) and `assets/js/metabox.js` (jQuery for the display-condition rows on the CPT edit screen) are hand-written and only minified

## Architecture

All logic is in the singleton `Ocean_Modal_Window` in `ocean-modal-window.php`; display-condition helpers are in `includes/helper.php`.

Load order and gating:
- No license gating. The constructor hooks `omw_setup()` and the CPT registration on `init` directly. `omw_setup()` adds the rest only when OceanWP is the active theme or parent theme.
- The Freemius block at the bottom is the free SDK (`is_premium` false), started through Ocean Extra's `OceanWP_EDD_Addon_Migration` on the theme's `owp_fs_loaded` action, and only if `Ocean_Extra` exists. It does not gate features.
- Butterbean metaboxes and the block editor panels come from Ocean Extra, so without Ocean Extra the CPT has no settings metabox. Condition choices also use Ocean Extra's `oe_get_page_template_list()`.
- For OceanWP 3.6.1 or older, `includes/update-message.php` is loaded when Ocean Extra is missing or is 2.3.1 or older.

Settings (three layers):
- Global defaults are Theme Mods prefixed `omw_` (size, padding, border, typography, colors), defined in `includes/options.php` and handed to the theme's React Customizer through `ocean_customize_options_data`. Skipped when Ocean Extra's theme panel toggle `ocean_modal_window_panel` is off.
- Per-modal settings are post meta on the CPT, prefixed `oceanwp_mw_` (e.g. `oceanwp_mw_template`, `oceanwp_mw_width`, `oceanwp_mw_cond_logic`), via a Butterbean manager `oceanwp_mw_settings` and the block editor sidebar `assets/dist/modal-settings.js`. Display rules are saved separately on `save_post` as arrays in `mw_display_on` / `mw_hide_on` (from `$_POST['omw_rules']`).
- Per-page switch: post meta `omw_enable_modal_window` (`'disable'` stops all modals and assets on that page), added as a Butterbean tab on normal posts and via `assets/dist/metabox.js` (only if Ocean Extra's `oe_check_post_types_settings()` passes). This and the editor assets are added only for users with `ocean_main_metaboxes_capabilities` (default `manage_options`).

Front end:
- `modal_display()` on `wp_footer` queries every published modal, skips those whose rules fail, and prints `<div id="omw-{ID}" class="omw-modal">`. Rules are evaluated by `omw_match_conditions()`, which only accepts values from the allowed choice list (no `eval`).
- Any link with class `omw-open-modal` and `href="#omw-{ID}"` opens it (the CPT edit screen shows this in a "Modal Link" side box). JS also listens for an `init-omw-for-element` event to bind new elements.
- When `oceanwp_mw_template` is set, `template/template.php` renders it (Elementor, Beaver Builder, SiteOrigin or blocks). This template is included from the plugin only; there is no theme override path.
- Per-modal CSS is printed in a `<style>` tag right after each modal in `modal_display()`. Global CSS from the `omw_` Theme Mods goes through `ocean_head_css`. Fonts load in `load_fonts()`.

AJAX: `wp_ajax_get_mw_conditional_rules` returns the condition-row HTML for the CPT edit screen. It is logged-in only and has no nonce or capability check.
