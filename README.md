BigBlueButton Extension - BN Lock Settings Subplugin
=======================
* Copyright: Blindside Networks Inc
* License:  GNU GENERAL PUBLIC LICENSE Version 3

Overview
===========
The BN Lock Settings subplugin enhances the BigBlueButtonBN module by passing lock settings to BigBlueButton. The subplugin lock settings override any existing core plugin configuration in the Moodle activity UI and in the BigBlueButton meeting.

Features
===========
* **Customize lock configuration:** Manage usage of session features such as webcams, microphones, chats, notes and access to user lists for each meeting.
* **Set lock setting defaults:** Configure each setting at the activity and plugin level.

Installation
============
Prerequisites
------------
* Moodle environment with BigBlueButtonBN module installed.

Git installation
------------
1. Clone the repository:

`git clone https://github.com/blindsidenetworks-ps/moodle-bbbext_bnlocksettings.git`

2. Rename the downloaded directory:

`mv moodle-bbbext_bnlocksettings bnlocksettings`

3. Move the folder to the Moodle BigBlueButtonBN extensions directory:

`mv bnlocksettings /var/www/html/moodle/mod/bigbluebuttonbn/extension/`

4. Run the Moodle upgrade script:

`sudo /usr/bin/php /var/www/html/moodle/admin/cli/upgrade.php`

Manual installation
------------
1. Download the sub plugin zip file and extract it.
2. Place the extracted folder into `mod/bigbluebuttonbn/extension/`
3. Rename the folder `bnlocksettings`
4. Access Moodle's Admin UI at `Site administration > Plugins > Install plugins` to complete the installation.

Configuration
============
Access the subplugin configuration under
`Site Administration > Plugins > BigBlueButton > Manage BigBlueButton extension plugins`

Here, admins can enable/disable the subplugin, manage settings, or uninstall it.

Usage
============
Configuring Lock Settings
------------
From the BigBlueButton activity settings under the “BN Lock Settings” section. For each setting, either enable or disable it using the corresponding checkbox. To set a default for a lock setting instead, see “Managing Lock Setting Defaults”. Note that when a default is set from the subplugin settings, this default will always be used and the option to change it from the activity settings UI will be removed.

Managing Lock Setting Defaults
------------
From the subplugin settings, Site Administrators can set default lock settings that will apply to all instances of a BigBlueButtonBN activity. The available options for each setting are:
* **Enable by default:** If enabled, users can use the feature in the meeting.
* **Disable by default:** If disabled, the feature will be locked in the meeting and can not be used.
* **Edit default per activity:** Edit setting default when an activity is added or updated.

Requirements
============
Requires BigBlueButtonBN module version > 2022112802

For more detailed updates and support, visit the [BN Lock Settings Subplugin GitHub Repository](https://github.com/blindsidenetworks-ps/moodle-bbbext_bnlocksettings)
