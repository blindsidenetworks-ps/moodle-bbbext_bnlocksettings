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

namespace bbbext_bnlocksettings\bigbluebuttonbn;

use stdClass;

/**
 * A class for the main mod form extension
 *
 * @package   bbbext_bnlocksettings
 * @copyright 2023 onwards, Blindside Networks Inc
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Shamiso Jaravaza (shamiso.jaravaza@blindsidenetworks.com)
 */
class mod_form_addons extends \mod_bigbluebuttonbn\local\extension\mod_form_addons {
    /**
     * Allows modules to modify the data returned by form get_data().
     * This method is also called in the bulk activity completion form.
     *
     * Only available on moodleform_mod.
     *
     * @param stdClass $data passed by reference
     */
    public function data_postprocessing(\stdClass &$data): void {
        // Nothing for now.
    }

    /**
     * Allow module to modify  the data at the pre-processing stage.
     *
     * This method is also called in the bulk activity completion form.
     *
     * @param array|null $defaultvalues
     */
    public function data_preprocessing(?array &$defaultvalues): void {
        // This is where we can add the data from the bnlocksettings table to the data provided.
        if (!empty($defaultvalues['id'])) {
            global $DB;
            $bnlocksettingsrecord = $DB->get_record(mod_instance_helper::SUBPLUGIN_TABLE, [
                'bigbluebuttonbnid' => $defaultvalues['id'],
            ]);
            if ($bnlocksettingsrecord) {
                $defaultvalues['enablecam'] = $bnlocksettingsrecord->enablecam;
                $defaultvalues['enablemic'] = $bnlocksettingsrecord->enablemic;
                $defaultvalues['enableprivatechat'] = $bnlocksettingsrecord->enableprivatechat;
                $defaultvalues['enablepublicchat'] = $bnlocksettingsrecord->enablepublicchat;
                $defaultvalues['enablenote'] = $bnlocksettingsrecord->enablenote;
                $defaultvalues['enableuserlist'] = $bnlocksettingsrecord->enableuserlist;
            }
        }
    }

    /**
     * Can be overridden to add custom completion rules if the module wishes
     * them. If overriding this, you should also override completion_rule_enabled.
     * <p>
     * Just add elements to the form as needed and return the list of IDs. The
     * system will call disabledIf and handle other behaviour for each returned
     * ID.
     *
     * @return array Array of string IDs of added items, empty array if none
     */
    public function add_completion_rules(): array {
        return [];
    }

    /**
     * Called during validation. Override to indicate, based on the data, whether
     * a custom completion rule is enabled (selected).
     *
     * @param array $data Input data (not yet validated)
     * @return bool True if one or more rules is enabled, false if none are;
     *   default returns false
     */
    public function completion_rule_enabled(array $data): bool {
        return false;
    }

    /**
     * Form adjustments after setting data
     *
     * @return void
     */
    public function definition_after_data() {
        $this->remove_lock_settings();
    }

    /**
     * Remove existing lock settings from form.
     *
     * @return void
     */
    private function remove_lock_settings() {
        $lockelements = [
            'lock',
            'disablecam',
            'disablemic',
            'disableprivatechat',
            'disablepublicchat',
            'disablenote',
            'hideuserlist',
            'no_locksettings',
        ];
        foreach ($lockelements as $lockelement) {
            if ($this->mform->elementExists($lockelement)) {
                $this->mform->removeElement($lockelement);
            }
        }
    }

    /**
     * Add new form field definition.
     *
     * @return void
     */
    public function add_fields(): void {
        $this->mform->addElement('header', 'bnlocksettings', get_string('pluginname', 'bbbext_bnlocksettings'));
        $editsettings = false;
        $config = get_config('bbbext_bnlocksettings');
        $locksettings = [
            'enablecam' => 'mod_form_overridecam',
            'enablemic' => 'mod_form_overridemic',
            'enableprivatechat' => 'mod_form_overrideprivatechat',
            'enablepublicchat' => 'mod_form_overridepublicchat',
            'enablenote' => 'mod_form_overridenote',
            'enableuserlist' => 'mod_form_overrideuserlist',
        ];

        // Check if setting should be shown in the activity.
        foreach ($locksettings as $configname => $string) {
            // TODO: Simplify this when we have a better way to handle config in core phpunit tests.
            $mode = is_object($config) ? ($config->{$configname . '_settings'} ?? '') : '';
            if ($mode === 'editable') {
                $this->add_checkbox_field($configname, $string);
                $editsettings = true;
            } else {
                $this->mform->addElement('hidden', $configname, 0);
                $this->mform->setType($configname, PARAM_INT);
            }
        }
        // Output a string if no settings are editable.
        if (!$editsettings) {
            $this->mform->addElement('static', 'no_settings', '', get_string('mod_form_no_settings', 'bbbext_bnlocksettings'));
        }
    }

    /**
     * Helper method to add a checkbox element to the form.
     *
     * @param string $name The name of the checkbox.
     * @param string $string The string for the field.
     * @return void
     */
    private function add_checkbox_field(string $name, string $string): void {
        $this->mform->addElement('checkbox', $name, get_string($string, 'bbbext_bnlocksettings'));
        $this->mform->setType($name, PARAM_INT);
        $this->mform->setDefault($name, 1);
    }

    /**
     * Validate form and returns an array of errors indexed by field name
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation(array $data, array $files): array {
        $errors = [];
        return $errors;
    }
}
