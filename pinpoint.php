<?php
/*
* Plugin Name: Pinpoint Jobs Widget
* Author: Pinpoint
* Description: Add [pinpoint domain="your-domain"] shortcode to any page to display your Pinpoint jobs. You can add the following options: theme-color, scondary-color, highlight-color, widget-class, structure-name e.g. [pinpoint domain="test" theme-color="#16537e" highlight-color="pink" secondary-color="#F9F9F9" widget-class="widget"]
* Version: 0.0.1
* License: GPL v2 or later
*/

function pinpoint_shortcode($atts = [], $content = null, $tag = '')
{
  // add the required external inpoint CSS and JS scripts to the header to redner table
  add_action('wp_head', 'pinpoint_scripts');

  // normalize attribute keys, lowercase
  $atts = array_change_key_case((array) $atts, CASE_LOWER);

  // override default attributes with user attributes
  $pinpoint_atts = shortcode_atts(
    array(
      'domain' => 'acme-demo',
      'theme-color' => '#455C51',
      'secondary-color' => '#F4F4F4',
      'highlight-color' => '#999999',
      'structure-name' => 'Custom Structure',
      'widget-class' => ''

    ),
    $atts,
    $tag
  );

  // esc_html will remove any HTML for saftey

  $widget = '<div data-pinpoint-subdomain="' . esc_html($pinpoint_atts['domain']) . '" 
  data-pinpoint-custom-structure-name="' . esc_html($pinpoint_atts['structure-name']) . '" 
  data-pinpoint-primary-theme-color="' . esc_html($pinpoint_atts['theme-color']) . '" 
  data-pinpoint-secondary-theme-color="' . esc_html($pinpoint_atts['secondary-color']) . '"
  data-pinpoint-highlight-theme-color="' . esc_html($pinpoint_atts['highlight-color']) . '"
  class="pinpoint-external-jobs-table-widget ' . esc_html($pinpoint_atts['widget-class']) . '"></div>';



  // return output
  return $widget;
}

function pinpoint_scripts()
{
  /* these scripts are Pinpoint hosted scripts for the JS and CSS of the table and need adding
   * to the head of the page where the table shortcode is being used
  */
  echo '<link rel="stylesheet" href="https://dywrfp5ctng3l.cloudfront.net/external-jobs-table/index.css">
    <script type="module" crossorigin src="https://dywrfp5ctng3l.cloudfront.net/external-jobs-table/index.js"></script>';
}

/*
 * Central location to create all shortcodes.
 */
function pinpoint_shortcodes_init()
{
  add_shortcode('pinpoint', 'pinpoint_shortcode');
}

add_action('init', 'pinpoint_shortcodes_init');
