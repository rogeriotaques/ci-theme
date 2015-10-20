<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CI-Theme
 * Provides a simple way to implement a theme based website or app using Codeigniter.
 *
 * Licensed under MIT license:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify, merge,
 * publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
 * to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING
 * BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @requires PHP5+
 * @author Rogério Taques (rogerio.taques@gmail.com)
 * @see https://github.com/rogeriotaques/ci-theme
 * @version 1.4
 *
 */

class Theme
{
		private $ci = NULL;

		private $var_name = 'outputs';
		private $theme_data = array();
		private $theme_path = '../themes/';

		private $assets = array();
		private $metatags = array();	// array( array('param' => 'value') )

		function __construct()
		{
			$this->ci =& get_instance();
			$this->ci->config->load('theme', FALSE, TRUE);

			if ( $this->ci->config->item('output_var_name') )
			{
				$this->var_name = $this->ci->config->item('output_var_name');
			}

			if ( $this->ci->config->item('theme_path') )
			{
				$this->theme_path = $this->ci->config->item('theme_path');
			}

			$this->metatags = array(

        // facebook api
        'property-og-type' => array('property' => 'fb:app_id', 'content' => ''),
        'property-og-type' => array('property' => 'fb:profile_id', 'content' => ''),

				// open-graph
      	'property-og-type' => array('property' => 'og:type', 'content' => 'website'),
      	'property-og-title' => array('property' => 'og:title', 'content' => ''),
      	'property-og-description' => array('property' => 'og:description', 'content' => ''),
      	'property-og-image' => array('property' => 'og:image', 'content' => ''),
      	'property-og-site-name' => array('property' => 'og:site_name', 'content' => ''),
      	'property-og-url' => array('property' => 'og:url', 'content' => ''),

				// pre defined
				'name-viewport' => array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no'),
				'name-robots' => array('name' => 'robots', 'content' => 'index,follow,all'),
				'http-equiv-content-type' => array('http-equiv' => 'Content-Type', 'content' => 'text/html; charset=utf-8'),
				'http-equiv-content-style-type' => array('http-equiv' => 'Content-Style-Type', 'content' => 'text/css'),

        // basic html tags
				'name-title' => array('name' => 'title', 'content' => ''),
				'name-description' => array('name' => 'description', 'content' => ''),
				'name-keywords' => array('name' => 'keywords', 'content' => ''),
				'name-author' => array('name' => 'author', 'content' => ''),
				'name-publisher' => array('name' => 'publisher', 'content' => ''),
				'name-generator' => array('name' => 'generator', 'content' => ''),
				'rel-canonical' => array('rel' => 'canonical', 'href' => ''),

			);

		}

		/**
		 * Sets a new variable data to be passed for theme output
		 * @param $name
		 * @param $value
		 * @return void
		 */
		function set($name, $value)
		{
			$this->theme_data[$name] = $value;
		}

		/**
		 * Loads a view with a given theme.
		 * @param string 	$theme
		 * @param string 	$view
		 * @param array 	$view_data
		 * @param boolean 	$return
		 * @return void
		 */
		function load($theme = '', $view = '' , $view_data = array(), $return = FALSE)
		{
			$this->set($this->var_name, $this->ci->load->view($view, $view_data, TRUE));
			return $this->ci->load->view($this->theme_path . $theme, $this->theme_data, $return);
		}

		/**
		 * A private function to set assets for theme.
		 * @return void
		 */
		private static function set_asset( $asset = '', $group = 'css' )
		{
			$ci =& get_instance();
			$assets =& $ci->theme->assets;

			if (!isset( $assets[$group] ))
			{
				$assets[$group] = array();
			}

			if ( is_array($asset) )
			{
				foreach ($asset as $a)
				{
					if ( !in_array($a, $assets[$group]) )
					{

						$assets[$group][] = $a;
					}
				}
			}
			else
			{
				$assets[$group][] = $asset;
			}

		} // set_asset

		/**
		 * A private function to get assets for theme.
		 * @return void
		 */
		private static function get_asset( $group = 'css' )
		{
			$ci =& get_instance();
			$assets = $ci->theme->assets;

			if ( !isset($assets[$group]) )
			{
				return FALSE;
			}

			return count($assets[$group]) ? $assets[$group] : FALSE;

		} // set_asset

		/**
		 * Sets CSS files to be outputed into theme files.
		 * @param variant $css - String or array(string)
		 * @return void
		 */
		public static function set_css( $css )
		{
			self::set_asset($css, 'css');
		}

		/**
		 * Sets JS files to be outputed into theme files.
		 * @param variant $js - String or array(string)
		 * @return void
		 */
		public static function set_js( $js )
		{
			self::set_asset($js, 'js');
		}

		/**
		 * Get a list of CSS files
		 * @return array(string)
		 */
		public static function get_css( $inline = FALSE )
		{
			if ( $inline === TRUE )
			{
				$assets = self::get_asset('css');
				return count($assets) ? implode(',', $assets) : '';
			}

			return self::get_asset('css');
		}

		/**
		 * Get a list of JS files
		 * @return array(string)
		 */
		public static function get_js( $inline = FALSE )
		{
			if ( $inline === TRUE )
			{
				$assets = self::get_asset('js');
				return count($assets) ?  implode(',', $assets) : '';
			}

			return self::get_asset('js');
		}

		/**
		 * Set metatags.
		 * @param array $element	-	Should be array( [name|property|http-equiv] => '', content => '' )
		 * @return void
		 */
		public static function set_metatag( $element )
		{
			$ci =& get_instance();

			if ( is_array($element) )
			{
				krsort($element);
				$key = '';

				foreach ($element as $pk => $pv)
				{
					$pk  = preg_replace(array('/\s/','/\:/','/\_/','/\./'), '-', $pk);
					$pv  = preg_replace(array('/\s/','/\:/','/\_/','/\./'), '-', $pv);
					$key = strtolower("{$pk}-{$pv}");
					break;
				}

				$ci->theme->metatags[ $key ] = $element;
			}

		} // set_metatag

		/**
		 * Retrieve the HTML portion with all metatags set.
		 * @return string
		 */
		public static function metatags()
		{
			$ci =& get_instance();

      $html = '';
			$ignore = array('name-title', 'http-equiv-content-type', 'rel-canonical');   // what will be ignored in main loop

			// add the enconding
			$html .= PHP_EOL . "\t" . "<meta http-equiv=\"{$ci->theme->metatags['http-equiv-content-type']['http-equiv']}\" content=\"{$ci->theme->metatags['http-equiv-content-type']['content']}\" >" . PHP_EOL;

			// add title (the first meta inside head)
      // further add a tab before the tag
			$html .= "\t" . "<title >{$ci->theme->metatags['name-title']['content']}</title>" . PHP_EOL.PHP_EOL;

			foreach ($ci->theme->metatags as $mk => $mt)
			{
				// skip title, coz it uses a specific tag
				if ( in_array( $mk, $ignore ) ) continue;

				// skip metatags with empty content
				if ( !isset($mt['content']) || empty($mt['content']) ) continue;

        // create the tag, adding a tab in the begining of line.
				$html .= "\t" . '<meta ';

				foreach ($mt as $k => $v)
				{
					$html .= "{$k}=\"{$v}\" ";
				}

				$html .= '>'.PHP_EOL;
			}

			// add canonical metatag
			$html .= PHP_EOL . "\t" . "<link rel=\"canonical\" href=\"{$ci->theme->metatags['rel-canonical']['href']}\" />" . PHP_EOL;

			return $html . PHP_EOL;

		} // metatags

		/**
		 * Set the metatag title.
		 * @param string $str
		 * @return void
		 */
		public static function set_title( $str )
		{
			self::set_metatag( array('name' => 'title', 'content' => $str) );
			self::set_opengraph('title', $str);	// improve eficiency setting the opengraph tag

		} // set_title

		/**
		 * Set the metatag description.
		 * @param string $str
		 * @return void
		 */
		public static function set_description( $str )
		{
			self::set_metatag( array('name' => 'description', 'content' => $str) );
			self::set_opengraph('description', $str);	// improve eficiency setting the opengraph tag

		} // set_description

		/**
		 * Set the metatag keywords.
		 * @param variant (string/array) $str
		 * @return void
		 */
		public static function set_keywords( $piece )
		{
			if ( is_array($piece) )
			{
				$piece = implode(',', $piece);
			}

			self::set_metatag( array('name' => 'keywords', 'content' => $piece) );

		} // set_keywords

		/**
		 * Set the metatag author.
		 * @param string $str
		 * @return void
		 */
		public static function set_author( $str )
		{
			self::set_metatag( array('name' => 'author', 'content' => $str) );

		} // set_author

		/**
		 * Set the metatag canonical.
		 * @param string $str
		 * @return void
		 */
		public static function set_canonical( $url )
		{
			self::set_metatag( array('rel' => 'canonical', 'href' => $url) );
		} // set_canonical

		/**
		 * Set the metatag publisher.
		 * @param string $str
		 * @return void
		 */
		public static function set_publisher( $str )
		{
			self::set_metatag( array('name' => 'publisher', 'content' => $str) );

		} // set_publisher

		/**
		 * Set the metatag generator.
		 * @param string $str
		 * @return void
		 */
		public static function set_generator( $str )
		{
			self::set_metatag( array('name' => 'generator', 'content' => $str) );

		} // set_generator

		/**
		 * Set the metatag robots.
		 * @param variant (string/array) $str
		 * @return void
		 */
		public static function set_robots( $piece )
		{
			if ( is_array($piece) )
			{
				$piece = implode(',', $piece);
			}

			self::set_metatag( array('name' => 'robots', 'content' => $piece) );

		} // set_robots

		/**
		 * Set metatags for Open Graph.
		 * @param string $property
		 * @param string $content
		 * @return void
		 */
		public static function set_opengraph( $property, $content = '' )
		{
			$property = preg_replace('/og\:/', '', $property);
			self::set_metatag( array('property' => "og:{$property}", 'content' => $content) );

		} // set_opengraph

		/**
		 * Set metatags for Facebook Open Graph.
		 * @param string $property
		 * @param string $content
		 * @return void
		 */
		public static function set_fb_opengraph( $property, $content = '' )
		{
			$property = preg_replace('/fb\:/', '', $property);
			self::set_metatag( array('property' => "fb:{$property}", 'content' => $content) );

		} // set_fb_opengraph

} // Theme

/* End of file Theme.php */
/* Location: ./application/libraries/Theme.php */
