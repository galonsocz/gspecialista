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
 *   RR GSA
 *   RRAssignmentsEntity.class.php GSAssignmentsEntity.class.php
 *  $rrAssignmentsEntity $gsAssignmentsEntity
 *   PluginGSpecialistAGSAssignmentsEntity() PluginGSpecialistAGSAssignmentsEntity()
 *    
 */
if (!defined('GLPI_ROOT')) {
    define('GLPI_ROOT', '../../..');
}
require_once GLPI_ROOT . '/inc/includes.php';

if (!defined('PLUGIN_GSPECIALISTA_DIR')) {
    define('PLUGIN_GSPECIALISTA_DIR', __DIR__);
}
require_once PLUGIN_GSPECIALISTA_DIR . '/inc/TicketHookHandler.class.php';
require_once PLUGIN_GSPECIALISTA_DIR . '/inc/GroupHookHandler.class.php';
require_once PLUGIN_GSPECIALISTA_DIR . '/inc/GSAssignmentsEntity.class.php';

/**
 * Hook Item Handlers by Item Type
 */
function plugin_GSPECIALISTA_getHookHandlers() {
    $HOOK_HANDLERS = [
        'Ticket' => new PluginGSpecialistATicketHookHandler(),
        'ITILCategory' => new PluginGSpecialistAITILCategoryHookHandler()
    ];
    return $HOOK_HANDLERS;
}

/**
 * Install hook
 *
 * @return boolean
 */
function plugin_GSPECIALISTA_install() {
    global $DB;

    PluginGSpecialistALogger::addWarning(__FUNCTION__ . ' - entered...');
    $gsAssignmentsEntity = new PluginGSpecialistAGSAssignmentsEntity();

    /**
     * create setting table
     */
    $gsAssignmentsEntity->init();
    return true;
}

/**
 * Uninstall hook
 *
 * @return boolean
 */
function plugin_GSPECIALISTA_uninstall() {
    global $DB;
    /**
     * @todo removing tables, generated files, ...
     */
    PluginGSpecialistALogger::addWarning(__FUNCTION__ . ' - entered...');
    $gsAssignmentsEntity = new PluginGSpecialistAGSAssignmentsEntity();
    /**
     * drop settings
     */
    $gsAssignmentsEntity->cleanUp();
    return true;
}

/**
 * hook handlers
 */

/**
 * pre item add
 */
function plugin_GSPECIALISTA_hook_pre_item_add_handler(CommonDBTM $item) {
    PluginGSpecialistALogger::addWarning(__FUNCTION__ . " - entered with item: " . print_r($item, true));
    return $item;
}

/**
 * item added
 */
function plugin_GSPECIALISTA_hook_item_add_handler(CommonDBTM $item) {
    PluginGSpecialistALogger::addWarning(__FUNCTION__ . " - entered with item: " . print_r($item, true));
    $HOOK_HANDLERS = plugin_GSPECIALISTA_getHookHandlers();
    if (array_key_exists($item->getType(), $HOOK_HANDLERS)) {
        $handler = $HOOK_HANDLERS[$item->getType()];
        $handler->itemAdded($item);
    }
    return $item;
}

/**
 * item updated
 */
function plugin_GSPECIALISTA_hook_item_update_handler(CommonDBTM $item) {
    PluginGSpecialistALogger::addWarning(__FUNCTION__ . " - entered with item: " . print_r($item, true));
    PluginGSpecialistALogger::addWarning(__FUNCTION__ . " - Hook Hanlder: ITEM UPDATE: " . $item->getType());
    Session::addMessageAfterRedirect(sprintf(__('%1$s: %2$s'), __('Hook Hanlder: ITEM UPDATE'), $item->getType()));
    return $item;
}

/**
 * pre item delete
 */
function plugin_GSPECIALISTA_hook_pre_item_delete_handler(CommonDBTM $item) {
    PluginGSpecialistALogger::addWarning(__FUNCTION__ . " - entered with item: " . print_r($item, true));
    return $item;
}

/**
 * item deleted
 */
function plugin_GSPECIALISTA_hook_item_delete_handler(CommonDBTM $item) {
    PluginGSpecialistALogger::addWarning(__FUNCTION__ . " - entered with item: " . print_r($item, true));
    $HOOK_HANDLERS = plugin_GSPECIALISTA_getHookHandlers();
    if (array_key_exists($item->getType(), $HOOK_HANDLERS)) {
        $handler = $HOOK_HANDLERS[$item->getType()];
        $handler->itemDeleted($item);
    }
    return $item;
}

/**
 * item purged
 */
function plugin_GSPECIALISTA_hook_item_purge_handler(CommonDBTM $item) {
    PluginGSpecialistALogger::addWarning(__FUNCTION__ . " - entered with item: " . print_r($item, true));
    $HOOK_HANDLERS = plugin_GSPECIALISTA_getHookHandlers();
    if (array_key_exists($item->getType(), $HOOK_HANDLERS)) {
        $handler = $HOOK_HANDLERS[$item->getType()];
        $handler->itemPurged($item);
    }
    return $item;
}
