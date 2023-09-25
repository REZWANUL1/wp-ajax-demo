<?php
/*
 * Plugin Name:       Wp Ajax Demo
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rezwanul Haque
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 */
if (!defined('ABSPATH')) {
   exit;
}

add_action('admin_enqueue_scripts', function ($hook) {
   if ('toplevel_page_ajax-demo' == $hook) {
      wp_enqueue_style('pure-grid-css', '//unpkg.com/purecss@1.0.1/build/grids-min.css');
      wp_enqueue_style('ajax-demo-css', plugin_dir_url(__FILE__) . "assets/css/style.css", null, time());
      wp_enqueue_script('ajax-demo-js', plugin_dir_url(__FILE__) . "assets/js/main.js", array('jquery'), time(), true);

      $action = 'ajd_protected';
      $ajd_nonce = wp_create_nonce($action);
      wp_localize_script(
         'ajax-demo-js',
         'plugindata',
         array('ajax_url' => admin_url('admin-ajax.php'), 'ajd_nonce' => $ajd_nonce)
      );

      wp_localize_script('ajax-demo-js', 'bucket', array('name' => 'Rezwanul Haque', 'email' => 'me@mukto.me'));
   }
});

add_action('admin_menu', function () {
   add_menu_page('Ajax Demo', 'Ajax Demo', 'manage_options', 'ajax-demo', 'ajaxdemo_admin_page');
});

function ajaxdemo_admin_page()
{
?>
   <div class="container" style="padding-top:20px;">
      <h1>Ajax Demo</h1>
      <div class="pure-g">
         <div class="pure-u-1-4" style='height:100vh;'>
            <div class="plugin-side-options">
               <button class="action-button" data-task='simple_ajax_call'>Simple Ajax Call</button>
               <button class="action-button" data-task='unp_ajax_call'>Unprivileged Ajax Call</button>
               <button class="action-button" data-task='ajd_localize_script'>Why wp_localize_script</button>
               <button class="action-button" data-task='ajd_secure_ajax_call'>Security with Nonce</button>
            </div>
         </div>
         <div class="pure-u-3-4">
            <div class="plugin-demo-content">
               <h3 class="plugin-result-title">Result</h3>
               <div id="plugin-demo-result" class="plugin-result"></div>
            </div>
         </div>
      </div>
   </div>
<?php
}
//? simple ajax call
add_action('wp_ajax_ajd_simple', 'wp_ajax_ajd_simple_callback');
function wp_ajax_ajd_simple_callback()
{
   $data = $_POST['data'];
   echo "Hello " . strtoupper($data);
   die();
}

//? privilege ajax call
//? non privilege ajax call

add_action('wp_ajax_nopriv_unp_call', 'wp_ajax_nopriv_ajd_simple_callback');
add_action('wp_ajax_unp_call', 'wp_ajax_nopriv_ajd_simple_callback');
function wp_ajax_nopriv_ajd_simple_callback()
{
   $data = $_POST['data'];
   echo "Hello " . strtoupper($data);
   die();
}


//? non privilege ajax call

add_action('wp_ajax_adj_process_user', 'ajd_localize_script_ajd_simple_callback');
function ajd_localize_script_ajd_simple_callback()
{
   $data = $_POST['person'];
   echo "Hello {$data['name']} your email is {$data['email']}" ;
   die();
}
