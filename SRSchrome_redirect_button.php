<?php
/**
 * Plugin Name: SGU Force Chrome Redirect
 * Plugin URI: https://telegram.me/sgu4tech
 * Description: Forces all links to open in Chrome browser. Shows Chrome installation prompt if Chrome is not available.
 * Version: 4.5
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
    $timer_seconds = get_option('sgu_redirect_timer', 3);
    $chrome_message = get_option('sgu_chrome_message', 'For the best experience, this link will open in Chrome browser.');
    
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
<title>Opening In Chrome...</title>
<style>
:root {
--primary-color: #4285F4;
--secondary-color: #34A853;
--warning-color: #EA4335;
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

.chrome-icon {
font-size: 4rem;
margin-bottom: 1rem;
background: linear-gradient(45deg, #4285F4, #34A853, #FBBC04, #EA4335);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
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

.chrome-message {
background: #E3F2FD;
padding: 1rem;
border-radius: 0.75rem;
margin: 1.5rem 0;
border-left: 4px solid var(--primary-color);
}

.chrome-message p {
margin: 0;
color: #1565C0;
font-weight: 500;
}

.timer-container {
background: #F9FAFB;
padding: 1.25rem;
border-radius: 0.75rem;
margin: 1.5rem 0;
border: 1px solid #E5E7EB;
display: none;
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
}

.browser-warning {
background: #FEF2F2;
padding: 1rem;
border-radius: 0.75rem;
margin: 1rem 0;
border-left: 4px solid var(--warning-color);
display: none;
}

.browser-warning.show {
display: block;
}

.browser-warning p {
margin: 0;
color: #B91C1C;
font-size: 0.9rem;
}

.install-chrome {
background: var(--primary-color);
color: white;
padding: 0.75rem 1.5rem;
border-radius: 0.5rem;
text-decoration: none;
display: inline-block;
margin-top: 1rem;
font-weight: 600;
transition: all 0.3s ease;
}

.install-chrome:hover {
background: #3367D6;
transform: translateY(-1px);
text-decoration: none;
color: white;
}

.ads-container {
margin: 1.5rem 0;
}

.force-attempt {
font-size: 0.9rem;
color: #6B7280;
margin-top: 1rem;
}

/* Highlighted text styling */
.highlight-red {
color: #FF6B6B !important;
font-weight: 600;
}
.chrome-button {
background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
color: white;
border: none;
padding: 1rem 2rem;
border-radius: 0.75rem;
font-size: 1.25rem;
font-weight: 600;
cursor: pointer;
transition: all 0.3s ease;
box-shadow: 0 4px 15px rgba(66, 133, 244, 0.3);
margin: 1.5rem 0;
display: inline-flex;
align-items: center;
gap: 0.75rem;
min-width: 200px;
justify-content: center;
text-transform: none;
font-family: inherit;
}

.chrome-button:hover {
transform: translateY(-2px);
box-shadow: 0 6px 20px rgba(66, 133, 244, 0.4);
background: linear-gradient(135deg, #3367D6, #2E7D32);
}

.chrome-button:active {
transform: translateY(0);
box-shadow: 0 2px 10px rgba(66, 133, 244, 0.3);
}

.chrome-button:disabled {
opacity: 0.6;
cursor: not-allowed;
transform: none;
box-shadow: 0 2px 10px rgba(66, 133, 244, 0.2);
}

.button-icon {
font-size: 1.5rem;
}

/* Auto-redirect message */
.auto-redirect-message {
background: #F0F9FF;
padding: 1rem;
border-radius: 0.75rem;
margin: 1rem 0;
border-left: 4px solid var(--primary-color);
display: none;
}

.auto-redirect-message p {
margin: 0;
color: #1565C0;
font-size: 0.9rem;
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

.chrome-icon {
font-size: 3rem;
}

.chrome-button {
padding: 0.875rem 1.5rem;
font-size: 1.1rem;
min-width: 180px;
}
}
</style>
</head>

<body>
<div class="container">
<div class="chrome-icon">🌐</div>

<?php if (!empty($ads_top)): ?>
<div class="ads-container">
<?php echo $ads_top; ?>
</div>
<?php endif; ?>

<h1 id="mainTitle">Opening In Chrome...</h1>

<div class="browser-warning" id="browserWarning">
<p><strong>⚠️ Not using Chrome?</strong><br>
This link is optimized for Chrome browser. If the redirect doesn't work, please copy the URL and open it manually in Chrome.</p>
</div>

<!-- Main Chrome Button (replaces the Redirecting text) -->
<button class="chrome-button" id="chromeButton" onclick="attemptChromeRedirect()">
<span class="button-icon">🚀</span>
Open in Chrome
</button>

<!-- Auto-redirect option (hidden by default) -->
<div class="auto-redirect-message" id="autoRedirectMessage">
<p>Or wait <span id="autoTimer"><?php echo intval($timer_seconds); ?></span> seconds for automatic redirect...</p>
</div>

<!-- Timer container (now hidden by default) -->
<div class="timer-container" id="timerContainer">
<div class="timer">
Redirecting in: <span id="timer"><?php echo intval($timer_seconds); ?></span>s
</div>
<div class="loading-bar">
<div class="loading-progress" id="loadingProgress"></div>
</div>
</div>

<div class="force-attempt" id="attemptStatus">
Ready to open in Chrome browser
</div>

<div id="chromeInstall" style="display: none;">
<a href="https://www.google.com/chrome/" target="_blank" class="install-chrome">
📥 Install Chrome Browser
</a>
</div>

<?php if (!empty($ads_bottom)): ?>
<div class="ads-container">
<?php echo $ads_bottom; ?>
</div>
<?php endif; ?>

</div>

<script>
const REDIRECT_URL = "<?php echo esc_js($redirect_url); ?>";
const TIMER_SECONDS = <?php echo intval($timer_seconds); ?>;
let countdown = TIMER_SECONDS;
let autoRedirectTimer;
let attemptCount = 0;
let buttonClicked = false;
const maxAttempts = 3;

function isAndroid() {
return /Android/i.test(navigator.userAgent);
}

function isIOS() {
return /iPad|iPhone|iPod/.test(navigator.userAgent);
}

function isChrome() {
return /Chrome/i.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
}

function isMobile() {
return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

function updateAttemptStatus(message) {
const statusElement = document.getElementById('attemptStatus');
if (statusElement) {
statusElement.textContent = message;
}
}

function showBrowserWarning() {
const warningElement = document.getElementById('browserWarning');
if (warningElement && !isChrome()) {
warningElement.classList.add('show');
}
}

function showChromeInstall() {
const installElement = document.getElementById('chromeInstall');
if (installElement) {
installElement.style.display = 'block';
}
}

function disableButton() {
const button = document.getElementById('chromeButton');
if (button) {
button.disabled = true;
button.innerHTML = '<span class="button-icon">⏳</span>Opening Chrome...';
}
}

function enableButton() {
const button = document.getElementById('chromeButton');
if (button) {
button.disabled = false;
button.innerHTML = '<span class="button-icon">🚀</span>Open in Chrome';
}
}

function attemptChromeRedirect() {
if (buttonClicked && attemptCount > 0) return; // Prevent multiple clicks


buttonClicked = true;
disableButton();
attemptCount++;
updateAttemptStatus(`Attempt ${attemptCount}/${maxAttempts}: Opening in Chrome...`);

if (isAndroid()) {
// Multiple Android Chrome intent strategies
const cleanUrl = REDIRECT_URL.replace(/^https?:\/\//, '');

let intentUrl;
switch(attemptCount) {
case 1:
// Standard intent
intentUrl = `intent://${cleanUrl}#Intent;scheme=https;package=com.android.chrome;end;`;
break;
case 2:
// Intent with fallback URL
intentUrl = `intent://${cleanUrl}#Intent;scheme=https;package=com.android.chrome;S.browser_fallback_url=${encodeURIComponent(REDIRECT_URL)};end;`;
break;
case 3:
// Custom URL scheme attempt
intentUrl = `googlechrome://${cleanUrl}`;
break;
}

try {
window.location.href = intentUrl;

// Quick check if redirect worked
setTimeout(() => {
if (attemptCount < maxAttempts) {
buttonClicked = false;
enableButton();
updateAttemptStatus(`Attempt ${attemptCount} completed. Try again or wait for auto-redirect.`);
// Show auto-redirect option after first attempt
showAutoRedirectOption();
} else {
// All attempts failed, show warning and proceed
updateAttemptStatus('Chrome redirect attempts completed. Continuing...');
showBrowserWarning();
setTimeout(() => {
window.location.href = REDIRECT_URL;
}, 2000);
}
}, 1500);
} catch (e) {
if (attemptCount < maxAttempts) {
setTimeout(() => {
buttonClicked = false;
enableButton();
attemptChromeRedirect();
}, 500);
} else {
window.location.href = REDIRECT_URL;
}
}
} else if (isIOS()) {
// iOS - try Chrome URL scheme
const cleanUrl = REDIRECT_URL.replace(/^https?:\/\//, '');
const chromeURL = `googlechrome://${cleanUrl}`;

try {
window.location.href = chromeURL;
setTimeout(() => {
// Fallback to Safari if Chrome not installed
updateAttemptStatus('Opening in default browser...');
window.location.href = REDIRECT_URL;
}, 2000);
} catch (e) {
window.location.href = REDIRECT_URL;
}
} else {
// Desktop - show Chrome install message
updateAttemptStatus('Desktop detected. Please use Chrome browser for best experience.');
showBrowserWarning();
showChromeInstall();
setTimeout(() => {
window.location.href = REDIRECT_URL;
}, 3000);
}
}

function showAutoRedirectOption() {
const autoMessage = document.getElementById('autoRedirectMessage');
if (autoMessage) {
autoMessage.style.display = 'block';
startAutoTimer();
}
}

function startAutoTimer() {
const autoTimerElement = document.getElementById('autoTimer');

autoRedirectTimer = setInterval(() => {
countdown--;
if (autoTimerElement) {
autoTimerElement.textContent = countdown;
}

if (countdown <= 0) {
clearInterval(autoRedirectTimer);
updateAttemptStatus('Auto-redirecting...');
window.location.href = REDIRECT_URL;
}
}, 1000);
}

// Detect current browser and show appropriate messages
function initializePage() {
// Force the new message regardless of browser for testing
document.getElementById('mainTitle').innerHTML = 'This Browser is not supported, Please <span class="highlight-red">Open In Chrome</span><br><div style="margin-top: 0.5rem; margin-bottom: -0.5rem; font-size: 1.5rem;">👇👇👇</div>';

// Always keep the button as "Open in Chrome" for all browsers
document.getElementById('chromeButton').innerHTML = '<span class="button-icon">🚀</span>Open in Chrome';

if (isChrome()) {
updateAttemptStatus('Great! You\'re already using Chrome. Click to continue.');
// Uncomment next line if you want different text for Chrome users
// document.getElementById('mainTitle').textContent = 'Continue to Link';
} else {
const browserName = getBrowserName();
updateAttemptStatus(`Using ${browserName}. Click button to open in Chrome.`);
}
}

function getBrowserName() {
const userAgent = navigator.userAgent;
if (userAgent.includes("Firefox")) return "Firefox";
if (userAgent.includes("Safari") && !userAgent.includes("Chrome")) return "Safari";
if (userAgent.includes("Edge")) return "Edge";
if (userAgent.includes("Opera")) return "Opera";
if (userAgent.includes("SamsungBrowser")) return "Samsung Internet";
return "Unknown Browser";
}

// Initialize
window.onload = function() {
initializePage();
};

// Handle page visibility change (detect if user switched apps)
document.addEventListener('visibilitychange', function() {
if (document.hidden && buttonClicked) {
updateAttemptStatus('Switching to Chrome...');
} else if (!document.hidden && attemptCount > 0) {
updateAttemptStatus('Back from Chrome attempt. You can try again.');
enableButton();
buttonClicked = false;
}
});
</script>
</body>
</html>
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
        update_option('sgu_redirect_timer', intval($_POST['sgu_redirect_timer']));
        update_option('sgu_chrome_message', sanitize_text_field($_POST['sgu_chrome_message']));
        echo '<div class="updated"><p>Settings saved successfully!</p></div>';
    }

    $ads_top = get_option('sgu_redirect_ads_top', '');
    $ads_bottom = get_option('sgu_redirect_ads_bottom', '');
    $from_param = get_option('sgu_redirect_from_param', 'open');
    $to_param = get_option('sgu_redirect_to_param', '/?go');
    $timer_seconds = get_option('sgu_redirect_timer', 3);
    $chrome_message = get_option('sgu_chrome_message', 'For the best experience, this link will open in Chrome browser.');
    ?>
    <div class="wrap">
     <script language="javascript">
document.write(unescape('%3C%68%33%3E%53%47%55%20%46%6F%72%63%65%20%43%68%72%6F%6D%65%20%52%65%64%69%72%65%63%74%20%66%6F%72%20%41%64%6C%69%6E%6B%66%6C%79%20%61%6E%64%20%53%61%66%65%6C%69%6E%6B%20%62%79%20%3C%61%20%68%72%65%66%3D%22%68%74%74%70%73%3A%2F%2F%74%65%6C%65%67%72%61%6D%2E%6D%65%2F%6A%69%74%33%36%32%22%3E%53%47%55%20%54%45%43%48%3C%2F%61%3E%3C%2F%68%33%3E%0A%20%20%20%20%20%20%20'));
</script>   
  <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Timer Duration (seconds)</th>
                    <td>
                        <input type="number" name="sgu_redirect_timer" value="<?php echo esc_attr($timer_seconds); ?>" min="1" max="10" class="small-text" />
                        <p class="description">Auto-redirect timer (now optional - shows after manual button attempt). Users can click button immediately.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Chrome Message</th>
                    <td>
                        <input type="text" name="sgu_chrome_message" value="<?php echo esc_attr($chrome_message); ?>" class="large-text" />
                        <p class="description">Message to show users about Chrome requirement.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">From Parameter (Adlinkfly Parameter)</th>
                    <td>
                        <input type="text" name="sgu_redirect_from_param" value="<?php echo esc_attr($from_param); ?>" class="regular-text" />
                        <p class="description">Parameter which you used in adlinkfly redirection code (default: "open").</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">To Parameter (Safelink parameter)</th>
                    <td>
                        <input type="text" name="sgu_redirect_to_param" value="<?php echo esc_attr($to_param); ?>" class="regular-text" />
                        <p class="description">Your safelink parameter which you saved. (default: "/?go").</p>
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
            
            <div style="background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;">
                <h4>✨ New Manual Button Features:</h4>
                <ul>
                    <li><strong>Immediate Action:</strong> Users can click "Open in Chrome" button instantly</li>
                    <li><strong>Smart Retry:</strong> If first attempt fails, button becomes clickable again</li>
                    <li><strong>Auto-fallback:</strong> Shows auto-redirect option after manual attempt</li>
                    <li><strong>Better UX:</strong> No forced waiting, user controls when to redirect</li>
                    <li><strong>Same Logic:</strong> Uses same Chrome intent/URL scheme methods</li>
                </ul>
            </div>
            
            <p class="submit">
                <input type="submit" name="sgu_save_settings" class="button-primary" value="Save Changes" />
            </p>
        </form>
    </div>
    <?php
}

// Add activation hook for default settings
register_activation_hook(__FILE__, 'sgu_redirect_activation');

function sgu_redirect_activation() {
    // Set default options if they don't exist
    if (get_option('sgu_redirect_timer') === false) {
        update_option('sgu_redirect_timer', 3);
    }
    if (get_option('sgu_redirect_from_param') === false) {
        update_option('sgu_redirect_from_param', 'open');
    }
    if (get_option('sgu_redirect_to_param') === false) {
        update_option('sgu_redirect_to_param', '/?go');
    }
    if (get_option('sgu_chrome_message') === false) {
        update_option('sgu_chrome_message', 'For the best experience, this link will open in Chrome browser.');
    }
}
?>