<?php
/**
 * Helper functions
 *
 * @package Ocean_Modal_Window
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'oe_match_conditions' ) ) {
    /**
     * Safe evaluator for display/hide conditions.
     *
     * Handles:
     * - Page conditions (functions like is_front_page, is_home, is_page, etc.)
     * - WooCommerce conditions (is_shop, is_product_category, etc.)
     * - Menu conditions (menu IDs)
     * - Widget area conditions (sidebar IDs)
     * - Template conditions (post IDs)
     * - User roles
     *
     * Returns TRUE if **any** condition in the array matches.
     *
     * @since 2.3.3
     */
    function oe_match_conditions( $values ) {

        if ( empty( $values ) ) {
			return false;
		}

		$allowed_values = oe_get_allowed_condition_values();

		$conds = oe_parse_condition_string($values);

		$valid_conds = [];

		foreach ( $conds as $cond ) {

			if ( strpos( $cond, ':' ) !== false ) {
				list( $fn, $arg ) = explode( ':', $cond, 2 );

				// If argument is not part of the allowed choices, skip it entirely
				if ( ! in_array( $arg, $allowed_values, true ) ) {
					continue;
				}
			}

			$valid_conds[] = $cond;
		}

		// No valid conditions after filtering
		if ( empty( $valid_conds ) ) {
			return false;
		}

		foreach ( $valid_conds as $cond ) {

			if ( ! is_string( $cond ) ) {
				continue;
			}

			// Basic sanitation
			$cond = trim( $cond );
			if ( preg_match( '/[;`$<>{}]/', $cond ) ) {
				continue;
			}

			// ----------------------------
			// 1) Page template conditions
			// ----------------------------
			// Formats:
			//   is_front_page
			//   is_home
			//   is_page:123
			//   is_page:about
			//   is_single:45
			//   is_category
			//   is_search, is_404, is_tag, etc.
			//   is_product, is_shop, is_cart (Woo)
			// ----------------------------

			if ( preg_match( '/^(!?[a-z_]+)(?:[:\(]([a-zA-Z0-9_-]*)\)?)?$/', $cond, $m ) ) {

				$token = $m[1];
				$arg = isset( $m[2] ) ? $m[2] : null;

				switch ( $token ) {

					case 'is_front_page':
						if ( is_front_page() ) return true;
						break;

					case 'is_home':
						if ( is_home() ) return true;
						break;

					case 'is_page':
						if ( $arg ) {
							if ( is_numeric( $arg ) && is_page( intval( $arg ) ) ) return true;
							if ( is_page( sanitize_text_field( $arg ) ) ) return true;
						} else {
							if ( is_page() ) return true;
						}
						break;

					case 'is_single':
						if ( $arg ) {
							if ( is_numeric( $arg ) && is_single( intval( $arg ) ) ) return true;
							if ( is_single( sanitize_text_field( $arg ) ) ) return true;
						} else {
							if ( is_single() ) return true;
						}
						break;

					case 'is_category':
						if ( is_category() ) return true;
						break;

					case 'is_tag':
						if ( is_tag() ) return true;
						break;

					case 'is_search':
						if ( is_search() ) return true;
						break;

					case 'is_404':
						if ( is_404() ) return true;
						break;

					// WooCommerce
					case 'is_shop':
						if ( function_exists( 'is_shop' ) && is_shop() ) return true;
						break;

					case 'is_product':
						if ( function_exists( 'is_product' ) && is_product() ) return true;
						break;

					case 'is_cart':
						if ( function_exists( 'is_cart' ) && is_cart() ) return true;
						break;

					case 'is_checkout':
						if ( function_exists( 'is_checkout' ) && is_checkout() ) return true;
						break;

					// Product category: is_product_category:slug
					case 'is_product_category':
						if ( function_exists( 'is_product_category' ) ) {
							if ( $arg && is_product_category( sanitize_text_field( $arg ) ) ) return true;
							if ( is_product_category() ) return true;
						}
						break;

					case 'is_user_logged_in':
						if ( function_exists( 'is_user_logged_in' ) && is_user_logged_in() ) return true;
						break;

					case '!is_user_logged_in':
						if ( function_exists( 'is_user_logged_in' ) && !is_user_logged_in() ) return true;
						break;

				}
			}

			// ----------------------------
			// 2) User roles
			// ----------------------------
			// value == role slug (editor, author, subscriber, etc.)
			// ----------------------------
			if ( taxonomy_exists( 'role' ) ) { /* ignore — not used */ }

			$user = wp_get_current_user();
			if ( $user && in_array( $cond, (array) $user->roles, true ) ) {
				return true;
			}

			// ----------------------------
			// 3) Menu ID condition
			// ----------------------------
			// If condition equals menu term_id
			// ----------------------------
			if ( is_numeric( $cond ) ) {
				$menus = wp_get_nav_menu_items( intval( $cond ) );
				if ( ! empty( $menus ) ) {
					// Match if current page matches any menu item
					foreach ( $menus as $item ) {
						if ( get_the_ID() == $item->object_id ) {
							return true;
						}
					}
				}
			}

			// ----------------------------
			// 4) Widget area condition
			// ----------------------------
			global $wp_registered_sidebars;
			if ( isset( $wp_registered_sidebars[ $cond ] ) ) {
				// If you want to check that this page uses this sidebar, implement here.
				// For now, just allow true (same as current OceanWP behavior).
				return true;
			}

			// ----------------------------
			// 5) OceanWP Library template ID
			// ----------------------------
			if ( is_numeric( $cond ) && get_post_type( intval( $cond ) ) === 'oceanwp_library' ) {
				// Match if user selected this template ID
				if ( intval( $cond ) === get_the_ID() ) {
					return true;
				}
			}
		}

		return false;
    }
}

if ( ! function_exists( 'oe_parse_condition_string' ) ) {
    /**
     * Parse condition string into array of conditions.
     *
     * @since 2.3.3
     */
    function oe_parse_condition_string( $str ) {

        if ( empty( $str ) ) {
            return [];
        }

        // Split by || or &&
        $parts = preg_split( '/\s*(\|\||&&)\s*/', $str );

        $final = [];

        foreach ( $parts as $p ) {
            $p = trim($p);

            // 1. Match: is_page(123), is_single(about)
            if ( preg_match('/^(!?[a-z_]+)\(([\w-]*)\)$/i', $p, $m ) ) {

                // function with no args: is_user_logged_in()
                if ( $m[2] === '' ) {
                    $final[] = $m[1] . '()';
                } else {
                    $final[] = $m[1] . '(' . $m[2] . ')';
                }
                continue;
            }

            // 2. Match: is_page:123 → convert to is_page(123)
            if ( preg_match('/^(!?[a-z_]+):([\w-]+)$/i', $p, $m ) ) {
                $final[] = $m[1] . '(' . $m[2] . ')';
                continue;
            }

            // 3. Match: is_user_logged_in OR !is_user_logged_in
            if ( preg_match('/^!?[a-z_]+$/i', $p ) ) {
                $final[] = $p . '()';
                continue;
            }
        }

        return $final;
    }
}