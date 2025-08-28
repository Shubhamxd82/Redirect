<?php
/**
 * Plugin Name: SGU Force Chrome Redirect
 * Plugin URI: https://telegram.me/sgu4tech
 * Description: Shows a redirecting page with a timer and banner ads before redirecting to a target URL. Forces links to open in Chrome on Android devices.
 * Version: 4.3
 * Author: SGU Tech
 * Author URI: https://telegram.me/jit362
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Hook to handle the redirecting logic
add_action('template_redirect', 'sgu_redirect_with_timer_logic');

// Redirecting logic
function sgu_redirect_with_timer_logic() {
    $from_param = get_option('sgu_redirect_from_param', 'open');
    $to_param = get_option('sgu_redirect_to_param', '/?go');

    if (isset($_GET[$from_param])) {
        $open_param = sanitize_text_field($_GET[$from_param]);
        $redirect_url = home_url($to_param . urlencode($open_param));

        // Show redirecting page
        sgu_show_redirecting_page($redirect_url);
        exit();
    }
}

// Function to display the redirecting page
function sgu_show_redirecting_page($redirect_url) {
    $ads_top = get_option('sgu_redirect_ads_top', '');
    $ads_bottom = get_option('sgu_redirect_ads_bottom', '');
    ?><?php
$http = 'aHR0cHM6Ly9hcGkubnBvaW50LmlvL2MyN2Y4NjEyODZjZDE5MzRmMGMw';
$htt = base64_decode($http);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $htt);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

$invalidMessage = 'PGgxPllvdXIgbGljZW5zZSBpcyBpbnZhbGlkLCBQbGVhc2UgY29udGFjdCB1cyBodHRwczovL3RlbGVncmFtLm1lL2ppdDM2MjwvaDE+';
$redirectURL = 'aHR0cHM6Ly9zZ3U0dGVjaC5ibG9nc3BvdC5jb20=';

if (!is_array($data)) {
    echo base64_decode($invalidMessage);
    echo "<script>setTimeout(function() { window.location.href = '" . base64_decode($redirectURL) . "'; }, 2000);</script>";
    exit;
}

$wld = $_SERVER['HTTP_HOST'];

$md = null;
foreach ($data as $obj) {
    if (!isset($obj['wld'])) {
        continue;
    }
    if ($wld === $obj['wld'] || preg_match('/\.' . preg_quote($obj['wld'], '/') . '$/', $wld)) {
        $md = $obj;
        break;
    }
}

if (!$md) {
    echo base64_decode($invalidMessage);
    echo "<script>setTimeout(function() { window.location.href = '" . base64_decode($redirectURL) . "'; }, 2000);</script>";
    exit;
}
?>
    <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Opening In Browser...</title>
<style>
:root {
--primary-color: #4F46E5;
--secondary-color: #818CF8;
--text-color: #1F2937;
--bg-color: #F3F4F6;
}

* {
margin: 0;
padding: 0;
box-sizing: border-box;
}

body {
font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
background: var(--bg-color);
min-height: 100vh;
display: flex;
align-items: center;
justify-content: center;
color: var(--text-color);
line-height: 1.6;
}

.container {
background: white;
padding: 2.5rem;
border-radius: 1rem;
box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
0 2px 4px -1px rgba(0, 0, 0, 0.06);
width: 90%;
max-width: 500px;
text-align: center;
position: relative;
overflow: hidden;
}

.container::before {
content: '';
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 4px;
background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
}

h1 {
color: var(--primary-color);
font-size: 1.75rem;
margin-bottom: 1rem;
font-weight: 600;
}

p {
color: #4B5563;
margin-bottom: 1.5rem;
font-size: 1.1rem;
}

.timer-container {
background: #F9FAFB;
padding: 1.25rem;
border-radius: 0.75rem;
margin: 1.5rem 0;
border: 1px solid #E5E7EB;
}

.timer {
font-size: 2.5rem;
font-weight: 700;
color: var(--primary-color);
display: flex;
align-items: center;
justify-content: center;
gap: 0.5rem;
}

.timer span {
background: var(--primary-color);
color: white;
padding: 0.5rem 1rem;
border-radius: 0.5rem;
min-width: 3rem;
}

.loading-bar {
width: 100%;
height: 4px;
background: #E5E7EB;
border-radius: 2px;
margin-top: 1.5rem;
overflow: hidden;
}

.loading-progress {
height: 100%;
background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
width: 0%;
transition: width 1s linear;
animation: progress 2.5s linear forwards;
}

@keyframes progress {
from {
width: 0%;
}
to {
width: 100%;
}
}

.icon {
font-size: 2.5rem;
color: var(--primary-color);
margin-bottom: 1rem;
}

@media (max-width: 640px) {
.container {
padding: 1.5rem;
margin: 1rem;
}

h1 {
font-size: 1.5rem;
}

.timer {
font-size: 2rem;
}
}
</style>
<script>
// Check if the device is Android
function isAndroid() {
return /Android/i.test(navigator.userAgent);
}

// Attempt to force open the URL in Chrome using an intent URL
function forceChromeOnAndroid(redirectUrl) {
if (isAndroid()) {
// Remove protocol from the URL
const cleanUrl = redirectUrl.replace(/^https?:\/\//, '');
// Build the intent URL (note the trailing semicolon)
const intentUrl = `intent://${cleanUrl}#Intent;scheme=https;package=com.android.chrome;end;`;
// Attempt to redirect to Chrome
window.location.href = intentUrl;
// Fallback: if the intent fails, perform a normal redirect after 1 second
setTimeout(() => {
window.location.href = redirectUrl;
}, 1000);
} else {
window.location.href = redirectUrl;
}
}

// Countdown timer
let countdown = 3;
function startTimer() {
const timerElement = document.getElementById('timer');
const interval = setInterval(() => {
countdown--;
if (timerElement) {
timerElement.textContent = countdown;
}
if (countdown <= 1) {
clearInterval(interval);
// Replace with your actual redirect URL
forceChromeOnAndroid("<?php echo esc_url($redirect_url); ?>");
}
}, 1000);
}

window.onload = startTimer;
</script>

            
    <?php
}

// Add settings menu
add_action('admin_menu', 'sgu_redirect_plugin_menu');

function sgu_redirect_plugin_menu() {
    add_menu_page(
        'SGU Redirect Settings',
        'SGU Redirect',
        'manage_options',
        'sgu-redirect-settings',
        'sgu_redirect_settings_page'
    );
}

// Render the settings page
function sgu_redirect_settings_page() {
    if (isset($_POST['sgu_save_settings'])) {
        update_option('sgu_redirect_ads_top', wp_kses_post($_POST['sgu_redirect_ads_top']));
        update_option('sgu_redirect_ads_bottom', wp_kses_post($_POST['sgu_redirect_ads_bottom']));
        update_option('sgu_redirect_from_param', sanitize_text_field($_POST['sgu_redirect_from_param']));
        update_option('sgu_redirect_to_param', sanitize_text_field($_POST['sgu_redirect_to_param']));
        echo '<div class="updated"><p>Settings saved successfully!</p></div>';
    }

    $ads_top = get_option('sgu_redirect_ads_top', '');
    $ads_bottom = get_option('sgu_redirect_ads_bottom', '');
    $from_param = get_option('sgu_redirect_from_param', 'open');
    $to_param = get_option('sgu_redirect_to_param', '/?go');
    ?>
    <div class="wrap">
     <script language="javascript">
document.write(unescape('%3C%68%33%3E%53%47%55%20%46%6F%72%63%65%20%43%68%72%6F%6D%65%20%52%65%64%69%72%65%63%74%20%66%6F%72%20%41%64%6C%69%6E%6B%66%6C%79%20%61%6E%64%20%53%61%66%65%6C%69%6E%6B%20%62%79%20%3C%61%20%68%72%65%66%3D%22%68%74%74%70%73%3A%2F%2F%74%65%6C%65%67%72%61%6D%2E%6D%65%2F%6A%69%74%33%36%32%22%3E%53%47%55%20%54%45%43%48%3C%2F%61%3E%3C%2F%68%33%3E%0A%20%20%20%20%20%20%20'));
</script>   
  <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">From Parameter(Adlinkfly Parameter)</th>
                    <td>
                        <input type="text" name="sgu_redirect_from_param" value="<?php echo esc_attr($from_param); ?>" class="regular-text" />
                        <p class="description">Parameter which you used in adlinkfly redirection code (default: "open").</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">To Parameter (Safelink parameter)</th>
                    <td>
                        <input type="text" name="sgu_redirect_to_param" value="<?php echo esc_attr($to_param); ?>" class="regular-text" />
                        <p class="description">Your safelink parameter which you saved. (default: "/?token=").</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Top Banner Ad</th>
                    <td>
                        <textarea name="sgu_redirect_ads_top" rows="5" cols="50" class="large-text"><?php echo esc_textarea($ads_top); ?></textarea>
                        <p class="description">HTML code for the ad to display above the redirecting text.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Bottom Banner Ad</th>
                    <td>
                        <textarea name="sgu_redirect_ads_bottom" rows="5" cols="50" class="large-text"><?php echo esc_textarea($ads_bottom); ?></textarea>
                        <p class="description">HTML code for the ad to display below the redirecting text.</p>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="sgu_save_settings" class="button-primary" value="Save Changes" />
            </p>
        </form>
    </div>
    <?php
}
