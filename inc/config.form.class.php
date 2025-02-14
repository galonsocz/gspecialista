<?php

 /**
 * -------------------------------------------------------------------------
 * Group Specialist Assignment plugin for GLPI
 * -------------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of Group Specialist Assignment GLPI Plugin.
 *
 * Group Specialist Assignment is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * Group Specialist Assignment is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Group Specialist Assignment. If not, see <http://www.gnu.org/licenses/>.
 * -------------------------------------------------------------------------
 * @copyright Copyright (C) 2024 by PEMEX. - http://www.pemex.com
 * @license   GPLv3 https://www.gnu.org/licenses/gpl-3.0.html
 * @link      https://github.com/pemex/GroupSpecialistA
 * -------------------------------------------------------------------------
 */
include ('../../../inc/includes.php');
require_once 'config.class.php';
require_once 'GSAssignmentsEntity.class.php';

class PluginGSpecialistASettings extends CommonDBTM {

    public function __construct() {
        PluginGSpecialistALogger::addWarning(__METHOD__ . ' - constructor called');
    }

    public function renderTitle() {
        $injectHTML = <<< EOT
                <p>
                    <div align='center'>
                        <h1>GSpecialistA Settings</h1>
                    </div>
                </p>
EOT;
        echo $injectHTML;
    }

    public function showFormGSpecialistA() {
        global $CFG_GLPI, $DB;

        if (self::checkCentralInterface()) {
            PluginGSpecialistALogger::addWarning(__METHOD__ . ' - display contents');
            self::displayContent();
        } else {
            echo "<div align='center'><br><img src='" . $CFG_GLPI['root_doc'] . "/pics/warning.png'><br>" . __("Access denied") . "</div>";
        }
    }

    public static function checkCentralInterface() {
        $currentInterface = Session::getCurrentInterface();
        PluginGSpecialistALogger::addWarning(__METHOD__ . ' - current interface: ' . $currentInterface);
        return $currentInterface === 'central';
    }

    public static function displayContent() {
        echo "<div class='center'>";
        echo "<form name='settingsForm' action='config.form.php' method='post' enctype='multipart/form-data'>";
        echo Html::hidden('_glpi_csrf_token', ['value' => Session::getNewCSRFToken()]);
        echo "<table class='tab_cadre_fixe'>";
        echo "<tr><th colspan='4'>" . "Enable Group Round Robin Ticket Assignment for each ITILCategory" . "</th></tr>";
        echo "<tr><th colspan='4'>" . "<hr />" . "</th></tr>";

        /**
         * option row
         */
        echo "<tr><th colspan='4'>";
        echo "Assign also to the original Group: &nbsp;&nbsp; <input type='radio' name='auto_assign_group' value='1'";
        $auto_assign_group = self::getAutoAssignGoup();
        if ($auto_assign_group) {
            echo "checked='checked'";
        }
        echo "> Yes&nbsp;&nbsp;";
        echo "<input type='radio' name='auto_assign_group' value='0'";
        if (!$auto_assign_group) {
            echo "checked='checked'";
        }
        echo "> No";
        echo "</th></tr>";

        /**
         * assignments rows
         */
        echo "<tr><th colspan='4'>" . "<hr />" . "</th></tr>";
        echo "<tr><th>ITILCategory</th><th>Group</th><th>Members #</th><th>Setting</th></tr>";

        /**
         * render each row for profile and settings
         */
        foreach (self::getSettings() as $row) {
            $id = $row['id'];
            $itilcategories_id = $row['itilcategories_id'];
            $category_name = $row['category_name'];
            $group_name = isset($row['group_name']) ? $row['group_name'] : "<em>No group assigned</em>";
            $num_group_members = isset($row['group_name']) ? $row['num_group_members'] : "<em>N/A</em>";
            $is_active = $row['is_active'];

            echo "<tr><td>$category_name</td><td>$group_name</td><td>$num_group_members</td>";
            echo "<td>";
            echo Html::hidden('itilcategories_id_' . $id, ['value' => $itilcategories_id]);
            echo "<input type='radio' name='is_active_$id' value='1'";
            if ($is_active) {
                echo "checked='checked'";
            }
            echo "> Enabled&nbsp;&nbsp;";
            echo "<input type='radio' name='is_active_$id' value='0'";
            if (!$is_active) {
                echo "checked='checked'";
            }
            echo "> Disabled</td></tr>";
        }
        /**
         * controls
         */
        echo "<tr><td colspan='4'><hr/></td></tr>";
        echo "<tr><td colspan='3'>&nbsp;<td><input type='submit' name='save' class='submit' value=" . __('Save') . ">&nbsp;&nbsp;<input type='submit' class='submit' name='cancel' value=" . __('Cancel') . "></td></tr>";
        echo "</table>";
    }

    protected static function getSettings() {
        $gsAssignmentsEntity = new PluginGSpecialistAGSAssignmentsEntity();
        return $gsAssignmentsEntity->getAll();
    }

    protected static function getAutoAssignGoup() {
        $gsAssignmentsEntity = new PluginGSpecialistAGSAssignmentsEntity();
        return $gsAssignmentsEntity->getOptionAutoAssignGroup();
    }

    public static function saveSettings() {
        PluginGSpecialistALogger::addWarning(__METHOD__ . ' - POST: ' . print_r($_POST, true));
        $gsAssignmentsEntity = new PluginGSpecialistAGSAssignmentsEntity();

        /**
         * save option(s)
         */
        $gsAssignmentsEntity->updateAutoAssignGroup($_POST['auto_assign_group']);

        /**
         * save all assignments
         */
        foreach (self::getSettings() as $row) {
            $itilCategoryId = $_POST["itilcategories_id_{$row['id']}"];
            $newValue = $_POST["is_active_{$row['id']}"];
            $gsAssignmentsEntity->updateIsActive($itilCategoryId, $newValue);
        }
    }

}
