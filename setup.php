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
 * GSPECIALISTA ROUNDROBIN
 * _GSPECIALISTA_ _ROUNDROBIN_
 * _roundrobin() _gspecialista()
 * PluginGSpecialistA PluginGSpecialistA
 * ITILCategoryHookHandler.class GroupHookHandler.class
 *  roundrobin gspecialista
 * roundrobin Group Specialist Assingment
 * initiativa pemex
 */
if (!defined('PLUGIN_GSPECIALISTA_DIR')) {
    define('PLUGIN_GSPECIALISTA_DIR', __DIR__);
}

require_once PLUGIN_GSPECIALISTA_DIR . '/inc/logger.class.php';
require_once PLUGIN_GSPECIALISTA_DIR . '/inc/request.class.php';
require_once PLUGIN_GSPECIALISTA_DIR . '/inc/config.class.php';

/**
 * Init the hooks of the plugins - Needed
 *
 * @return void
 */
function plugin_init_gspecialista() {
    PluginGSpecialistALogger::addWarning(__FUNCTION__ . ' - plugin initialization');
    PluginGSpecialistAConfig::init();
    PluginGSpecialistAConfig::loadSources();
}

/**
 * Get the name and the version of the plugin - Needed
 *
 * @return array
 */
function plugin_version_gspecialista() {
    return PluginGSpecialistAConfig::getVersion();
}

/**
 * Optional : check prerequisites before install : may print errors or add to message after redirect
 *            (to disable the check, return always true)
 *
 * @return boolean
 */
function plugin_GSPECIALISTA_check_prerequisites() {
    /*
     * glpi version check
     */
    if (version_compare(GLPI_VERSION, PluginGSpecialistAConfig::$PLUGIN_GSPECIALISTA_MIN_GLPI_VERSION, 'le') ||
            version_compare(GLPI_VERSION, PluginGSpecialistAConfig::$PLUGIN_GSPECIALISTA_MAX_GLPI_VERSION, 'ge')) {
        PluginGSpecialistALogger::addCritical(__FUNCTION__ . ' - plugin prerequisites do not match: ' . PluginGSpecialistAConfig::$PLUGIN_GSPECIALISTA_GLPI_VERSION_ERROR);
        if (method_exists('Plugin', 'messageIncompatible')) {
            Plugin::messageIncompatible('core', PluginGSpecialistAConfig::$PLUGIN_GSPECIALISTA_GLPI_VERSION_ERROR);
        }
        return false;
    }
    PluginGSpecialistALogger::addDebug(__FUNCTION__ . ' - plugin CAN be installed AND activated');
    return true;
}

/**
 * Check configuration process for plugin : need to return true if succeeded
 * Can display a message only if failure and $verbose is true
 *
 * @param boolean $verbose Enable verbosity. Default to false
 *
 * @return boolean
 */
function plugin_GSPECIALISTA_check_config($verbose = false) {
    /**
     * @todo if needed add check behaviour
     */
    if (true) {
        return true;
    }

    if ($verbose) {
        echo "Installed, but not configured";
    }
    return false;
}
