<?php
/**
 * Plugin Name: WP Rocket Helper Custom
 * Description: Delays loading of non-critical CSS and JS assets.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1) Convert every non-critical style into a placeholder
add_filter( 'style_loader_tag', function( $html, $handle, $href, $media ) {
  if ( is_admin() ) return $html;
  // let WP Rocket’s critical CSS remain untouched
  if ( strpos( $handle, 'rocket-critical-css' ) !== false ) {
    return $html;
  }
  return sprintf(
    '<link data-type="wprocket-main-css" data-href="%s" media="print" onerror="this.media=\'all\'" />',
    esc_url( $href )
  );
}, 10, 4 );

// 2) Convert every non-critical script into a placeholder
add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {
  if ( is_admin() ) return $tag;
  // allow jQuery and WP Rocket’s own JS
  if ( in_array( $handle, [ 'jquery-core', 'jquery', 'rocket-main-js' ], true ) ) {
    return $tag;
  }
  return sprintf(
    '<script data-type="wprocket-main-js" data-src="%s"></script>',
    esc_url( $src )
  );
}, 10, 3 );

// 3) Inline the helper loader JS in the footer
add_action( 'wp_footer', function() {
  if ( is_admin() ) return;
  ?>
  <script>
  (function(){
    // — Paste your friend’s helper JS here from js‑jj.txt —
    // It watches for data-type="wprocket-main-css" and data-type="wprocket-main-js"
    // then swaps in real <link> and <script> after a delay or on first scroll/mousemove.
var helper_main_js_delay=60000,helper_main_css_delay=60000,helper_inline_js_delay=55000,helper_google_fonts_delay=60000,helper_external_css_delay=30000,helper_excluded_css_delay=60000,helper_external_js_delay=60000,helper_excluded_js_delay=60000,helper_event_controller=5000,helper_main_js=!0,helper_main_css=!0,helper_google_fonts=!0,helper_external_js=!0,helper_inline_js=!0,helper_external_css=!0,helper_excluded_css=!0,helperUserInteractionEvents=["scroll","mousemove","touchstart"],helperLoadMainJSTimer=setTimeout(helperTimerMainJS,helper_main_js_delay);function helperEventsMainJS(){helper_main_js&&helperTimerMainJS(),clearTimeout(helperLoadMainJSTimer),helperUserInteractionEvents.forEach(function(e){window.removeEventListener(e,helperEventsMainJS,{passive:!0})})}function helperTimerMainJS(){document.querySelectorAll("script[data-type='wprocket-main-js']").forEach(function(e){e.setAttribute("type","text/javascript"),e.setAttribute("src",e.getAttribute("data-src")),e.removeAttribute("data-src")}),helper_main_js=!1}helperUserInteractionEvents.forEach(function(e){window.addEventListener(e,helperEventsMainJS,{passive:!0})});var helperLoadMainCSSTimer=setTimeout(helperTimerMainCSS,helper_main_css_delay);function helperEventsMainCSS(){helper_main_css&&helperTimerMainCSS(),clearTimeout(helperLoadMainCSSTimer),helperUserInteractionEvents.forEach(function(e){window.removeEventListener(e,helperEventsMainCSS,{passive:!0})})}function helperTimerMainCSS(){document.querySelectorAll("link[data-type='wprocket-main-css']").forEach(function(e){e.setAttribute("rel","stylesheet"),e.setAttribute("href",e.getAttribute("data-href")),e.removeAttribute("data-href"),e.removeAttribute("onerror")}),helper_main_css=!1}helperUserInteractionEvents.forEach(function(e){window.addEventListener(e,helperEventsMainCSS,{passive:!0})});var helperLoadGoogleFontsTimer=setTimeout(helperTimerGoogleFonts,helper_google_fonts_delay);function helperEventsGoogleFonts(){helper_google_fonts&&helperTimerGoogleFonts(),clearTimeout(helperLoadGoogleFontsTimer),helperUserInteractionEvents.forEach(function(e){window.removeEventListener(e,helperEventsGoogleFonts,{passive:!0})})}function helperTimerGoogleFonts(){document.querySelectorAll("link[data-type='wprocket-google-fonts']").forEach(function(e){e.setAttribute("rel","stylesheet"),e.setAttribute("href",e.getAttribute("data-href")),e.setAttribute("media","all"),e.removeAttribute("data-href")}),helper_google_fonts=!1}helperUserInteractionEvents.forEach(function(e){window.addEventListener(e,helperEventsGoogleFonts,{passive:!0})});var helperLoadExcludedJSTimer=setTimeout(helperTimerExcludedJS,helper_excluded_js_delay);function helperTimerExcludedJS(){document.querySelectorAll("script[data-type='wprocket-excluded-js']").forEach(function(e){e.setAttribute("src",e.getAttribute("data-src")),e.removeAttribute("data-src")})}var helperInlineJSTimer=setTimeout(loadJqueryInlineScripts,helper_inline_js_delay);function helperEventsInlineJS(){helper_inline_js&&loadJqueryInlineScripts(),clearTimeout(helperInlineJSTimer),helperUserInteractionEvents.forEach(function(e){window.removeEventListener(e,helperEventsInlineJS,{passive:!0})})}function loadJqueryInlineScripts(){setTimeout(function(){document.querySelectorAll("script[data-type='wprocket-inline-js']").forEach(function(e){e.setAttribute("src",e.getAttribute("data-src")),e.removeAttribute("data-src")}),helper_inline_js=!1},helper_event_controller)}helperUserInteractionEvents.forEach(function(e){window.addEventListener(e,helperEventsInlineJS,{passive:!0})});var helperLoadExternalJSTimer=setTimeout(helperTimerExternalJS,helper_external_js_delay);function helperEventsExternalJS(){helper_external_js&&helperTimerExternalJS(),clearTimeout(helperLoadExternalJSTimer),helperUserInteractionEvents.forEach(function(e){window.removeEventListener(e,helperEventsExternalJS,{passive:!0})})}function helperTimerExternalJS(){document.querySelectorAll("script[data-type='wprocket-external-js']").forEach(function(e){e.setAttribute("src",e.getAttribute("data-src")),e.removeAttribute("data-src")}),helper_external_js=!1}helperUserInteractionEvents.forEach(function(e){window.addEventListener(e,helperEventsExternalJS,{passive:!0})});var helperLoadExternalCSSTimer=setTimeout(helperTimerExternalCSS,helper_external_css_delay);function helperEventsExternalCSS(){helper_external_css&&helperTimerExternalCSS(),clearTimeout(helperLoadExternalCSSTimer),helperUserInteractionEvents.forEach(function(e){window.removeEventListener(e,helperEventsExternalCSS,{passive:!0})})}function helperTimerExternalCSS(){document.querySelectorAll("link[data-type='wprocket-external-css']").forEach(function(e){e.setAttribute("rel","stylesheet"),e.setAttribute("href",e.getAttribute("data-href")),e.removeAttribute("data-href"),e.removeAttribute("onerror")}),helper_external_css=!1}helperUserInteractionEvents.forEach(function(e){window.addEventListener(e,helperEventsExternalCSS,{passive:!0})});var helperLoadExcludedCSSTimer=setTimeout(helperTimerExcludedCSS,helper_excluded_css_delay);function helperEventsExcludedCSS(){helper_excluded_css&&helperTimerExcludedCSS(),clearTimeout(helperLoadExcludedCSSTimer),helperUserInteractionEvents.forEach(function(e){window.removeEventListener(e,helperEventsExcludedCSS,{passive:!0})})}function helperTimerExcludedCSS(){document.querySelectorAll("link[data-type='wprocket-excluded-css']").forEach(function(e){e.setAttribute("rel","stylesheet"),e.setAttribute("href",e.getAttribute("data-href")),e.removeAttribute("data-href"),e.removeAttribute("onerror")}),helper_excluded_css=!1}helperUserInteractionEvents.forEach(function(e){window.addEventListener(e,helperEventsExcludedCSS,{passive:!0})});

  })();
  </script>
  <?php
}, 100 );
