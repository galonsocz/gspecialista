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
class PluginGSpecialistAConfig {

    public static $PLUGIN_GSPECIALISTA_ENV = 'development';
    public static $PLUGIN_GSPECIALISTA_NAME = 'Group Specialist Assignment';
    public static $PLUGIN_GSPECIALISTA_CODE = 'GSpecialistA';
    public static $PLUGIN_GSPECIALISTA_VERSION = '1.0.1';
    public static $PLUGIN_GSPECIALISTA_AUTHOR = '<a href="https://www.initiativa.it/glpi.php" target="_blank">initiativa s.r.l.</a>';
    public static $PLUGIN_GSPECIALISTA_LICENSE = 'GPLv3';
    public static $PLUGIN_GSPECIALISTA_HOME_PAGE = 'https://github.com/initiativa/roundrobin/';
    public static $PLUGIN_GSPECIALISTA_MIN_GLPI_VERSION = '9.5.5';
    public static $PLUGIN_GSPECIALISTA_GLPI_VERSION_ERROR = "This plugin requires GLPI >= 9.5.5 and GLPI <= 10.0.99";
    public static $PLUGIN_GSPECIALISTA_MAX_GLPI_VERSION = '10.0.99';
    public static $PLUGIN_GSPECIALISTA_MAX_GLPI_VERSION_ERROR = 'This plugin requires ';
    public static $PLUGIN_GSPECIALISTA_MIN_PHP_VERSION = '7.3';

    public static function init() {
        PluginGSpecialistALogger::addWarning(__METHOD__ . ' - defining hooks handlers');
        global $PLUGIN_HOOKS;
        $PLUGIN_HOOKS['csrf_compliant'][self::$PLUGIN_GSPECIALISTA_CODE] = true;
        /**
         * hooks declarations
         */
        $PLUGIN_HOOKS['pre_item_add'][self::$PLUGIN_GSPECIALISTA_CODE] = [
            'Ticket' => 'plugin_GSPECIALISTA_hook_pre_item_add_handler'
        ];
        $PLUGIN_HOOKS['item_add'][self::$PLUGIN_GSPECIALISTA_CODE] = [
            'Ticket' => 'plugin_GSPECIALISTA_hook_item_add_handler',
            'ITILCategory' => 'plugin_GSPECIALISTA_hook_item_add_handler'
        ];

        $PLUGIN_HOOKS['item_update'][self::$PLUGIN_GSPECIALISTA_CODE] = [
            'Ticket' => 'plugin_GSPECIALISTA_hook_item_update_handler'
        ];

        $PLUGIN_HOOKS['pre_item_delete'][self::$PLUGIN_GSPECIALISTA_CODE] = [
            'Ticket' => 'plugin_GSPECIALISTA_hook_pre_item_delete_handler'
        ];

        $PLUGIN_HOOKS['item_delete'][self::$PLUGIN_GSPECIALISTA_CODE] = [
            'Ticket' => 'plugin_GSPECIALISTA_hook_item_delete_handler',
            'ITILCategory' => 'plugin_GSPECIALISTA_hook_item_delete_handler'
        ];
        $PLUGIN_HOOKS['item_purge'][self::$PLUGIN_GSPECIALISTA_CODE] = [
            'Ticket' => 'plugin_GSPECIALISTA_hook_item_purge_handler',
            'ITILCategory' => 'plugin_GSPECIALISTA_hook_item_purge_handler'
        ];
    }

    public static function getVersion() {
        return [
            'name' => self::$PLUGIN_GSPECIALISTA_NAME,
            'version' => self::$PLUGIN_GSPECIALISTA_VERSION,
            'author' => self::$PLUGIN_GSPECIALISTA_AUTHOR,
            'license' => self::$PLUGIN_GSPECIALISTA_LICENSE,
            'homepage' => self::$PLUGIN_GSPECIALISTA_HOME_PAGE,
            'requirements' => [
                'glpi' => [
                    'min' => self::$PLUGIN_GSPECIALISTA_MIN_GLPI_VERSION,
                    'max' => self::$PLUGIN_GSPECIALISTA_MAX_GLPI_VERSION
                ],
                'php' => [
                    'min' => self::$PLUGIN_GSPECIALISTA_MIN_PHP_VERSION
                ]
            ]
        ];
    }

    public static function loadSources() {
        global $PLUGIN_HOOKS;

        PluginGSpecialistALogger::addWarning(__METHOD__ . ' - loading sources...');
        /**
         * add config section
         */
        $PLUGIN_HOOKS['config_page'][self::$PLUGIN_GSPECIALISTA_CODE] = 'front/config.form.php';
    }

    public static function hookAddSource($uriArray, $hook, $sourceFile) {
        global $PLUGIN_HOOKS;

        /**
         * on uri page perform loading of necessary js code or styles
         */
        if (is_array($uriArray) === false) {
            throw new Exception("invalid URI structure, expected array");
        }
        foreach ($uriArray as $uri) {
            if (strpos(PluginGSpecialistARequest::getServerParam('REQUEST_URI'), $uri) !== false) {
                $PLUGIN_HOOKS[$hook][self::$PLUGIN_GSPECIALISTA_CODE] = $sourceFile;
                PluginGSpecialistALogger::addWarning(__METHOD__ . " - source $sourceFile loaded!");
                break;
            }
        }
    }

    public static function getgsAssignmentTable() {
        $pluginCode = self::$PLUGIN_GSPECIALISTA_CODE;
        return "glpi_plugin_" . $pluginCode . "_rr_assignments";
    }

    public static function getgsOptionsTable() {
        $pluginCode = self::$PLUGIN_GSPECIALISTA_CODE;
        return "glpi_plugin_" . $pluginCode . "_rr_options";
    }

}
