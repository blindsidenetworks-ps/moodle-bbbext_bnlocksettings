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

namespace bbbext_bnlocksettings;

use bbbext_bnlocksettings\bigbluebuttonbn\mod_instance_helper;

/**
 * BBB Lock class
 *
 * @package   bbbext_bnlocksettings
 * @copyright 2023 onwards, Blindside Networks Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Shamiso Jaravaza (shamiso.jaravaza@blindsidenetworks.com)
 */
class lock {
    /**
     * Get lock settings that need to be passed.
     * @param int $instanceid
     * @return string
     */
    public static function get_lock_settings(int $instanceid) {
        $lockconfig = get_config('bbbext_bnlocksettings');
        $locksettingnames = [
            'lockSettingsDisableCam' => 'enablecam',
            'lockSettingsDisableMic' => 'enablemic',
            'lockSettingsDisablePrivateChat' => 'enableprivatechat',
            'lockSettingsDisablePublicChat' => 'enablepublicchat',
            'lockSettingsDisableNotes' => 'enablenote',
            'lockSettingsHideUserList' => 'enableuserlist',
        ];
        $locksettings = [];
        foreach ($locksettingnames as $key => $settingname) {
            $locksettings[$key] = self::get_setting($settingname, $lockconfig, $instanceid);
        }
        return $locksettings;
    }

    /**
     * Get configuration at subplugin or activity level.
     *
     * @param string $settingname the name of the lock setting
     * @param object $lockconfig the subplugin settings
     * @param int $instanceid
     * @return string The value of the lock
     */
    private static function get_setting(string $settingname, object $lockconfig, int $instanceid) {
        if ($lockconfig->{$settingname . '_settings'} === 'editable') {
            return self::get_editable_value($settingname, $instanceid);
        }
        return self::get_default_value($settingname, $lockconfig);
    }

    /**
     * Get activity lock setting.
     *
     * @param string $lockname
     * @param int $instanceid
     * @return array
     */
    private static function get_editable_value(string $lockname, int $instanceid) {
        global $DB;
        $record = $DB->get_record(mod_instance_helper::SUBPLUGIN_TABLE, [
            'bigbluebuttonbnid' => $instanceid,
        ]);
        if ($record) {
            // We need to invert boolean values to match API.
            return $record->$lockname ? 'false' : 'true';
        }
        return 'false';
    }

    /**
     * Get subplugin default lock setting.
     *
     * @param string $lockname
     * @param object $config setting value
     * @return array
     */
    private static function get_default_value(string $lockname, object $config) {
        if ($config->{$lockname . '_settings'} === 'disable') {
            // We need to invert boolean values to match API.
            return 'true';
        }
        return 'false';
    }
}
