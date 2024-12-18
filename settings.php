<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file defines the admin settings for this plugin
 *
 * @package   bbbext_bnlocksettings
 * @copyright 2023 onwards, Blindside Networks Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Shamiso Jaravaza (shamiso.jaravaza@blindsidenetworks.com)
 */

defined('MOODLE_INTERNAL') || die();

$addsetting = function($settings, $name) {
    $options = [
        'enable' => get_string("settings_enable", 'bbbext_bnlocksettings'),
        'disable' => get_string("settings_disable", 'bbbext_bnlocksettings'),
        'editable' => get_string("settings_editable", 'bbbext_bnlocksettings'),
    ];

    $settings->add(new admin_setting_configselect(
        "bbbext_bnlocksettings/{$name}_settings",
        get_string("settings_{$name}", 'bbbext_bnlocksettings'),
        get_string("settings_{$name}_description", 'bbbext_bnlocksettings'),
        'editable',
        $options
    ));
};

$addsetting($settings, 'enablecam');
$addsetting($settings, 'enablemic');
$addsetting($settings, 'enableprivatechat');
$addsetting($settings, 'enablepublicchat');
$addsetting($settings, 'enablenote');
$addsetting($settings, 'enableuserlist');

