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
 * ITILCategory Group
 * 
 */
class PluginGSpecialistAGroupHookHandler extends CommonDBTM implements IPluginGSpecialistAHookItemHandler {

    public function itemAdded(CommonDBTM $item) {
        PluginGSpecialistALogger::addWarning(__METHOD__ . " - Item Type: " . $item->getType());
        if ($item->getType() !== 'Group') {
            return;
        }
        PluginGSpecialistALogger::addWarning(__METHOD__ . " - GroupId: " . $this->getGroupId($item));
        $gsAssignmentsEntity = new PluginGSpecialistAGSAssignmentsEntity();
        $gsAssignmentsEntity->insertGroup($this->getGroupId($item));
    }

    protected function getGroupId(CommonDBTM $item) {
        return $item->fields['id'];
    }

    public function itemDeleted(CommonDBTM $item) {
        PluginGSpecialistALogger::addWarning(__METHOD__ . " - Item Type: " . $item->getType());
        if ($item->getType() !== 'Group') {
            return;
        }
        PluginGSpecialistALogger::addWarning(__METHOD__ . " - GroupId: " . $this->getGroupId($item));
        $gsAssignmentsEntity = new PluginGSpecialistAGSAssignmentsEntity();
        $gsAssignmentsEntity->updateIsActive($this->getGroupId($item), 0);
    }

    public function itemPurged(CommonDBTM $item) {
        PluginGSpecialistALogger::addWarning(__METHOD__ . " - Item Type: " . $item->getType());
        if ($item->getType() !== 'Group') {
            return;
        }
        PluginGSpecialistALogger::addWarning(__METHOD__ . " - GroupId: " . $this->getGroupId($item));
        $gsAssignmentsEntity = new PluginGSpecialistAGSAssignmentsEntity();
        $gsAssignmentsEntity->deleteGroup($this->getGroupId($item));
    }

}
