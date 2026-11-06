<?php
/**
 * Plugin Name: EMS About Page in Sitemap
 * Description: Adds static pages that live outside WordPress (/about/ from the saadcaffeine/about repo, and /citizenquack/) to the WordPress core sitemap at /wp-sitemap.xml.
 * Version:     1.1.0
 * Author:      Saad Chinoy
 *
 * Must-use plugin: lives in wp-content/mu-plugins/ and loads automatically.
 * Source: https://github.com/saadcaffeine/about/tree/main/wordpress/mu-plugins
 *
 * Result: /wp-sitemap.xml gains an entry for /wp-sitemap-standalone-1.xml,
 * which lists https://ediblemakerspace.com/about/ and /citizenquack/ with
 * their last-modified dates. To add another static page, add it to pages().
 * To remove: delete this file. Nothing is stored in the database.
 *
 * Written for PHP 5.6+ and WordPress 5.5+ (when core sitemaps were added).
 * On older WordPress, or if sitemaps are disabled, it does nothing.
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'WP_Sitemaps_Provider' ) && ! class_exists( 'EMS_Standalone_Sitemap_Provider' ) ) {

	/**
	 * Lists static pages that live alongside WordPress but outside it.
	 */
	class EMS_Standalone_Sitemap_Provider extends WP_Sitemaps_Provider {

		public function __construct() {
			// Lowercase letters only: becomes /wp-sitemap-standalone-1.xml.
			$this->name        = 'standalone';
			$this->object_type = 'standalone';
		}

		/**
		 * Static pages to list: path under the site root => file used for lastmod.
		 *
		 * @return array
		 */
		protected function pages() {
			return array(
				'about/' => 'about/index.html',
				'citizenquack/' => 'citizenquack/index.html',
			);
		}

		public function get_url_list( $page_num, $object_subtype = '' ) {
			if ( 1 !== (int) $page_num ) {
				return array();
			}
			$urls = array();
			foreach ( $this->pages() as $path => $file ) {
				$entry = array( 'loc' => home_url( '/' . $path ) );
				$disk  = ABSPATH . $file;
				if ( is_readable( $disk ) ) {
					$mtime = filemtime( $disk );
					if ( false !== $mtime ) {
						$entry['lastmod'] = gmdate( 'Y-m-d\TH:i:s+00:00', $mtime );
					}
				}
				$urls[] = $entry;
			}
			return $urls;
		}

		public function get_max_num_pages( $object_subtype = '' ) {
			return 1;
		}
	}

	// Documented hook for adding sitemaps; fires only when the sitemap system starts.
	add_action(
		'wp_sitemaps_init',
		function ( $wp_sitemaps ) {
			if ( is_object( $wp_sitemaps ) && isset( $wp_sitemaps->registry ) ) {
				$wp_sitemaps->registry->add_provider( 'standalone', new EMS_Standalone_Sitemap_Provider() );
			}
		}
	);
}
