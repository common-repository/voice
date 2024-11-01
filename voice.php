<?php
/**
 * Plugin Name:     Voice Blocks
 * Plugin URI:      https://sunbreak.io/voice/
 * Description:     Voice blocks for WordPress. Easily implement text-to-speech capabilities for your existing WordPress blocks. Visit <a href="https://sunbreak.io/voice" target="_blank">https://sunbreak.io</a> for more information.
 * Author:          Sunbreak Inc.
 * Author URI:      https://sunbreak.io
 * Text Domain:     voice
 * Domain Path:     /languages
 * Version:         1.0.6
 */

namespace Voice;

const VERSION = '1.0.6';

require_once 'includes/class-admin-menu.php';
require_once 'blocks/voice.php';
