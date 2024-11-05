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
 * BBB Utils class
 *
 * @package   bbbext_bnlocksettings
 * @copyright 2023 onwards, Blindside Networks Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Shamiso Jaravaza (shamiso.jaravaza@blindsidenetworks.com)
 */
class utils {
    /**
     * Get lock settings that need to be passed.
     * @param int $instanceid
     * @return string
     */
    public static function get_lock_settings(int $instanceid) {
        global $DB;
        $record = $DB->get_record(mod_instance_helper::SUBPLUGIN_TABLE, [
            'bigbluebuttonbnid' => $instanceid,
        ]);
        if ($record) {
            // Retrieve configurations.
            return self::generate_lock_settings($record);
        }
        return false;
    }

    /**
     * Generate the lock settings based on the database record.
     *
     * @param object $record
     * @return array
     */
    private static function generate_lock_settings($record) {
        // Retrieve configurations from subplugin. We invert values to match API.
        $locksettings = [
            'lockSettingsDisableCam' => $record->enablecam ? 'false' : 'true',
            'lockSettingsDisableMic' => $record->enablemic ? 'false' : 'true',
            'lockSettingsDisablePrivateChat' => $record->enableprivatechat ? 'false' : 'true',
            'lockSettingsDisablePublicChat' => $record->enablepublicchat ? 'false' : 'true',
            'lockSettingsDisableNotes' => $record->enablenote ? 'false' : 'true',
            'lockSettingsHideUserList' => $record->enableuserlist ? 'false' : 'true',
        ];
        return $locksettings;
    }
}
