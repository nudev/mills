<?php

/**
 * Plugin Name: BlockMeister
 * Plugin URI: https://wpblockmeister.com
 * Description: Block pattern builder. Lets you easily and visually create custom block patterns.
 * Version: 2.0.8
 * Requires at least: 5.5
 * Requires PHP: 5.6
 * Author: BlockMeister
 * License: GNU General Public License v2 or later
 * License URI: https://opensource.org/licenses/GPL-2.0
 * Text Domain: blockmeister
 * Domain Path: /languages
 *
 * @package    BlockMeister
 * @author     ProDevign <info@prodevign.com>
 * @copyright  Copyright © 2020 ProDevign.
 * @link       https://wpblockmeister.com
 * @license    https://opensource.org/licenses/GPL-2.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 */
namespace ProDevign\BlockMeister;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 *  kick-off the plugin
 */

BlockMeister::init( __FILE__ );