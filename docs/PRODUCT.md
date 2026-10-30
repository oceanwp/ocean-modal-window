# Ocean Modal Window - Features Documentation

Complete documentation of all features available in Ocean Modal Window.

---

## Table of Contents

1. [Plugin Overview](#plugin-overview)
2. [License & Availability](#license--availability)
3. [Modals](#modals)
4. [Per-Modal Settings](#per-modal-settings)
5. [Display Conditions](#display-conditions)
6. [Global Styling (Customizer)](#global-styling-customizer)
7. [Per-Page Switch](#per-page-switch)
8. [Opening a Modal](#opening-a-modal)
9. [Admin Pages](#admin-pages)
10. [Display & Developer API](#display--developer-api)

---

## Plugin Overview

**Ocean Modal Window** lets you build popups that open on click. Each modal can show its own content or a template from OceanWP's My Library, and you can open it from any link, button or menu item on the site.

| Property | Value |
|----------|-------|
| Version | 2.3.6 |
| Minimum WordPress | 5.6 |
| Minimum PHP | Not declared |
| Tested up to | 7.1 |
| Text Domain | `ocean-modal-window` |
| Main Class | `Ocean_Modal_Window` (singleton, `ocean-modal-window.php`) |
| Requires | OceanWP theme (active theme or parent theme). Ocean Extra for the settings metaboxes, block editor panels and condition choices |
| Distribution | Free on WordPress.org |

### Key Capabilities

- Create any number of modals as posts of the `ocean_modal_window` post type
- Modal content from the post editor (blocks or any page builder) or from a My Library template
- Render My Library templates built with Elementor, Beaver Builder, SiteOrigin or blocks
- Per-modal size, padding, border, colors, typography and close button
- Separate width, height, padding and typography for tablet and mobile
- Show or hide each modal on chosen pages, categories, WooCommerce pages and user login state
- Global default styles in the Customizer
- Turn all modals off on a single page
- Open with a simple link: `href="#omw-{ID}"` plus the class `omw-open-modal`
- Closes on the close button, a click on the overlay, or the Escape key

---

## License & Availability

Ocean Modal Window is free. There is no license check: all features load as soon as the OceanWP theme is active.

| Property | Value |
|----------|-------|
| Freemius product ID | 3814 |
| Freemius mode | Free SDK (`is_premium` false, `has_paid_plans` false) |
| Freemius start | Only when Ocean Extra is active, on the theme's `owp_fs_loaded` action |
| Without a license | All features work. Freemius does not gate anything |

The readme links to the **Ocean Core Extensions Bundle** (`https://oceanwp.org/core-extensions-bundle/`) for OceanWP's premium add-ons. Pricing is not listed here because it could not be confirmed.

---

## Modals

Each modal is a post of the custom post type `ocean_modal_window`, shown in the admin menu as **Modal** (icon `dashicons-editor-expand`, menu position 20).

| Property | Value |
|----------|-------|
| Public | No (not publicly queryable, excluded from search, no archive) |
| Admin UI | Yes, with its own menu |
| REST | Yes (`show_in_rest`), so the block editor works |
| Capability type | `page` |
| Supports | Title, editor, custom fields |
| Filter | `ocean_modal_window_args` (registration arguments) |

The post content is the modal body unless a My Library template is selected. The post title can be shown as the modal title.

---

## Per-Modal Settings

Edit a modal and use the **Modal Settings** metabox (Butterbean, from Ocean Extra) or the modal settings sidebar in the block editor. Both save the same post meta keys, prefixed `oceanwp_mw_`.

### General

| Setting | Key | Description | Default |
|---------|-----|-------------|---------|
| Select A Template | `oceanwp_mw_template` | A template from Theme Panel > My Library to use as the modal content | Default (post content) |
| Display Title | `oceanwp_mw_title` | Show the modal title (Enable / Disable) | Disable |
| Title Tag | `oceanwp_mw_title_tag` | H1 to H6, p or span | H2 |
| Display Close Button | `oceanwp_mw_close_btn` | Show the close button (Enable / Disable) | Enable |
| Conditional Logic | `oceanwp_mw_cond_logic` | Turn on the Display On / Hide On rules (see [Display Conditions](#display-conditions)) | Off |
| Custom Width | `oceanwp_mw_width` | Modal width in px | 700 |
| Custom Height | `oceanwp_mw_height` | Modal height in px. 0 means auto | 0 |
| Background Image | `oceanwp_mw_background_image` | Image used as the modal background (centered, cover) | None |

### Styling

| Setting | Key | Description | Default |
|---------|-----|-------------|---------|
| Padding | `oceanwp_mw_padding` | CSS padding, for example `20px 30px 20px 30px` | Empty (stylesheet uses 50px) |
| Border Width | `oceanwp_mw_border` | CSS border width, for example `2px 1px 2px 1px` | Empty (0) |
| Border Type | `oceanwp_mw_border_style` | Solid, Double, Dotted or Dashed. Used only when a border width is set | Empty |
| Border Radius | `oceanwp_mw_border_radius` | CSS border radius | Empty |

### Colors

| Setting | Key | Default |
|---------|-----|---------|
| Overlay Background Color | `oceanwp_mw_overlay_bg_color` | `#000000` |
| Overlay Opacity | `oceanwp_mw_overlay_opacity` | 0.9 |
| Background Color | `oceanwp_mw_bg_color` | `#ffffff` |
| Border Color | `oceanwp_mw_border_color` | Empty |
| Text Color | `oceanwp_mw_text_color` | Empty |
| Title Color | `oceanwp_mw_title_color` | `#333333` |
| Close Button Background | `oceanwp_mw_close_btn_bg` | Empty |
| Close Button Hover Background | `oceanwp_mw_close_btn_hover_bg` | Empty |
| Close Button Color | `oceanwp_mw_close_btn_color` | Empty |
| Close Button Hover Color | `oceanwp_mw_close_btn_hover_color` | Empty |

### Typography

| Setting | Key | Description |
|---------|-----|-------------|
| Font Size | `oceanwp_mw_font_size` | Any CSS size (px, em, rem) |
| Font Family | `oceanwp_mw_font_family` | Custom fonts from child themes, standard fonts and Google Fonts. The chosen Google Font is loaded on the front end |
| Font Weight | `oceanwp_mw_font_weight` | Default, 100, 200, 300, 400, 600, 700 or 800 |
| Font Style | `oceanwp_mw_font_style` | Normal or Italic |
| Text Transform | `oceanwp_mw_text_transform` | Capitalize, Lowercase or Uppercase |
| Line Height | `oceanwp_mw_line_height` | Any CSS value |
| Letter Spacing | `oceanwp_mw_letter_spacing` | Any CSS value |

### Tablet Device and Mobile Device

Tablet values apply at 1023px and below. Mobile values apply at 767px and below.

| Setting | Tablet Key | Mobile Key | Default |
|---------|------------|------------|---------|
| Custom Width (px) | `oceanwp_mw_tablet_width` | `oceanwp_mw_mobile_width` | 700 |
| Custom Height (px) | `oceanwp_mw_tablet_height` | `oceanwp_mw_mobile_height` | 0 |
| Padding | `oceanwp_mw_tablet_padding` | `oceanwp_mw_mobile_padding` | Empty |
| Font Size | `oceanwp_mw_tablet_font_size` | `oceanwp_mw_mobile_font_size` | Empty |
| Line Height | `oceanwp_mw_tablet_line_height` | `oceanwp_mw_mobile_line_height` | Empty |
| Letter Spacing | `oceanwp_mw_tablet_letter_spacing` | `oceanwp_mw_mobile_letter_spacing` | Empty |

### Front-End Behavior

Per-modal styles are printed in a `<style>` tag right after each modal, scoped to `#omw-{ID}`. Overlay colors are scoped to `body.omw-{ID} .omw-modal-overlay`, so each modal can have its own overlay.

---

## Display Conditions

When **Conditional Logic** is on, two rule lists appear: **Display On** (Show on) and **Hide On**. Each list can have several rows, added with **Add new row**.

- A modal with Display On rules is printed only if at least one rule matches.
- A modal is skipped if any Hide On rule matches.
- With Conditional Logic off, the modal is printed on every page.

| Condition Group | Choices |
|-----------------|---------|
| Pages | All Pages, Home Page (`is_home()`), Front Page (`is_front_page()`), and each published page |
| Categories | Each post category |
| Shop | WooCommerce pages (only when WooCommerce is active) |
| Product Categories | Each WooCommerce product category (only when WooCommerce is active) |
| Others | Single Post, Category Page, Archive Page, Logged In User, Logged Out User |

The choice list comes from Ocean Extra's `oe_get_page_template_list()` and can be changed with the `omw_post_settings_data_choices` filter. Rules are checked by `omw_match_conditions()` in `includes/helper.php`. It checks rule arguments against the choice list and runs only a fixed list of WordPress conditional functions. It does not use `eval`.

Rules are saved as arrays in the post meta `mw_display_on` and `mw_hide_on`.

---

## Global Styling (Customizer)

**Customizer > Modal Window** (section `ocean_modal_window_settings`, priority 15) sets default styles for all modals. The section only appears when the **Modal Window** switch is on in the OceanWP Theme Panel's Customizer Controls (stored in the `oe_panels_settings` option, on by default). Most settings preview live.

| Setting | Theme Mod(s) | Description | Default |
|---------|--------------|-------------|---------|
| Custom Width | `omw_custom_width`, `omw_tablet_custom_width`, `omw_mobile_custom_width`, `omw_custom_width_unit` | Width per device, 200 to 1200 | 700, unit px |
| Custom Height | `omw_custom_height`, `omw_tablet_custom_height`, `omw_mobile_custom_height`, `omw_custom_height_unit` | Height per device. 0 means auto | 0, unit px |
| Padding (px) | `omw_top_padding`, `omw_right_padding`, `omw_bottom_padding`, `omw_left_padding`, plus `omw_tablet_*` and `omw_mobile_*` versions | Padding per side and device | Empty |
| Background Image | `omw_background_image` | Image URL used as the modal background | None |
| Border Style | `omw_border_type` | Solid, Double, Dashed or Dotted | Solid |
| Border Width (px) | `omw_top_border_width` and the other sides, per device | Border width per side. On mobile the Bottom field uses the same ID as Right (`omw_mobile_right_border_width`), so it cannot be set on its own | Empty |
| Border Radius (px) | `omw_top_border_radius` and the other corners, per device | Radius per corner. On mobile the Bottom field uses the same ID as Right (`omw_mobile_right_border_radius`) | Empty |
| MW Typography | `omw_font_family`, `omw_font_weight` (plus tablet and mobile), `omw_font_subset`, `omw_font_size` (plus tablet and mobile), `omw_font_size_unit`, `omw_letter_spacing` (plus tablet and mobile, with unit), `omw_line_height` (plus tablet and mobile, with unit), `omw_text_transform` (plus tablet and mobile), `omw_text_decoration` | Font settings for modal text | Units px |
| MW Overlay Background | `omw_overlay_bg` | Overlay color | `rgb(0 0 0 / 50%)` |
| MW Background | `omw_modal_bg` | Modal background color | `#ffffff` |
| MW Border | `omw_modal_border_color` | Border color | Empty |
| MW Text | `omw_modal_text_color` | Text color | Empty |
| MW Title | `omw_modal_title_color` | Title color | `#333333` |
| MW Close Bttn Background | `omw_modal_close_btn_bg`, `omw_modal_close_btn_hover_bg` | Close button background, normal and hover | Empty |
| MW Close Button | `omw_modal_close_btn_color`, `omw_modal_close_btn_hover_color` | Close button icon color, normal and hover | Empty |

The section ends with a **Need Help?** link to the OceanWP documentation. The full option array can be changed with the `omw_customizer_options` filter.

Per-modal settings override these global values because their CSS is scoped to the modal's ID.

---

## Per-Page Switch

On normal posts and pages, the **Modal Window** tab of the OceanWP Settings metabox (Ocean Extra) and the block editor post settings add one switch.

| Setting | Key | Description | Default |
|---------|-----|-------------|---------|
| Enable Modal Window For This Page | `omw_enable_modal_window` | Disable to stop all modals, scripts and styles on that page | Enable |

The tab and the block editor panels are added only for users with the `ocean_main_metaboxes_capabilities` capability (default `manage_options`). The block editor panel loads only when Ocean Extra's post settings are enabled for the post type.

---

## Opening a Modal

Every printed modal has the ID `omw-{post ID}`. Any of these opens it on click:

| Trigger | Example |
|---------|---------|
| Link with the class | `<a href="#omw-123" class="omw-open-modal">Open Modal</a>` |
| Element with the class wrapping a link | `<div class="omw-open-modal"><a href="#omw-123">Open</a></div>` |
| Elementor button inside the class | `.omw-open-modal a.elementor-button` |
| Menu item | Add the class `omw-open-modal` to a menu item and set its URL to `#omw-123` (also works in the Sidr mobile menu) |
| Custom script | Dispatch an `init-omw-for-element` event on an element whose `href` points to the modal |

When a modal opens, the overlay and the modal fade in, and the body gets the class `omw-{ID}`. It closes on the close button, a click on the overlay, or the Escape key. On close, iframes inside the modal are reloaded so videos stop playing. Long content scrolls with Perfect Scrollbar.

The close button links to `{home URL}/#modal-window-close` (an SEO friendly anchor). The anchor text can be changed with the `omw_close_button_anchor` filter, and the full URL with `omw_get_site_name_anchors`. In the Customizer preview it is `#`.

---

## Admin Pages

| Screen | Location | Purpose |
|--------|----------|---------|
| Modal list and editor | **Modal** in the admin menu | Create and edit modals |
| Modal Settings metabox | Modal edit screen | All per-modal settings and display conditions |
| Modal Link box | Modal edit screen, side column | Read-only fields with the Modal ID (`#omw-{ID}`), the link class (`omw-open-modal`) and a full example link to copy |
| Modal Window section | Customizer | Global default styles |

The admin script and stylesheet (`metabox.min.js`, `metabox.min.css`) load only on the modal list and edit screens.

---

## Display & Developer API

### Shortcodes, Blocks and Widgets

The plugin adds no shortcodes, blocks or widgets. Modals are opened with links as shown in [Opening a Modal](#opening-a-modal).

### Templates

| File | Description |
|------|-------------|
| `template/template.php` | Renders a selected My Library template inside the modal (Elementor, Beaver Builder, SiteOrigin, blocks or shortcodes). It is loaded from the plugin only; there is no theme override path |

The modal wrapper itself is printed by `modal_display()` on `wp_footer`, followed by one shared `<div class="omw-modal-overlay">`.

### Filters

| Hook | Description |
|------|-------------|
| `ocean_modal_window_args` | Filter the post type registration arguments |
| `omw_customizer_options` | Filter the Customizer option array |
| `omw_post_meta_args` | Filter the post meta keys registered for the block editor |
| `omw_post_settings_data_choices` | Filter the display condition choices |
| `ocean_modal_window_template_content` | Filter rendered block template content |
| `omw_close_button_anchor` | Filter the close button anchor text (default `modal-window-close`) |
| `omw_get_site_name_anchors` | Filter the close button URL |
| `ocean_main_metaboxes_capabilities` | Theme/Ocean Extra filter used to decide who sees the per-page switch |

The plugin defines no custom actions.

### AJAX Actions

| Action | Access | Description |
|--------|--------|-------------|
| `get_mw_conditional_rules` | Logged-in users (`wp_ajax_`) | Returns the HTML for the condition rows on the modal edit screen, filled from `mw_display_on` / `mw_hide_on` |

There are no REST routes. The post type and the post meta registered through `ocean_post_setting_meta` are available in the core REST API so the block editor can save them.

### Data Storage

| Data | Where |
|------|-------|
| Modals | Posts of type `ocean_modal_window` |
| Per-modal settings | Post meta on the modal, prefixed `oceanwp_mw_` |
| Display rules | Post meta `mw_display_on` and `mw_hide_on` (arrays) |
| Per-page switch | Post meta `omw_enable_modal_window` on any post or page |
| Global styles | Theme mods prefixed `omw_` |
| Version | Option `ocean-modal-window-version`, written on activation |
| Customizer section switch | `oe_panels_settings` option (Ocean Extra) |

### Uninstall

The plugin has no uninstall routine. Deleting it leaves modals, post meta, theme mods and the `ocean-modal-window-version` option in the database.

---

*Ocean Modal Window - Click-to-open popups for the OceanWP theme*
