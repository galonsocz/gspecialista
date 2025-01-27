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
 * RoundRobin Settings GSpecialistA Settings
 * showFormRoundRobin showFormGSpecialistA
 * RoundRobin
 */
require_once '../inc/config.class.php';
require_once '../inc/logger.class.php';
require_once '../inc/config.form.class.php';

/**
 * render menu bar
 */
Html::header('GSpecialistA Settings', $_SERVER['PHP_SELF'], "plugins", PluginGSpecialistAConfig::$PLUGIN_GSPECIALISTA_CODE, "config");

$PluginGSpecialistAConfigForm = new PluginGSpecialistASettings();

/**
 * check for post form data and perform requested action
 */
if (isset($_REQUEST['save'])) {
    PluginGSpecialistALogger::addWarning(__METHOD__ . ' - SAVE: POST: ', $_POST);
    $PluginGSpecialistAConfigForm::saveSettings();
    Session::AddMessageAfterRedirect('Config saved');
    Html::back();
}

if (isset($_REQUEST['cancel'])) {
    PluginGSpecialistALogger::addWarning(__METHOD__ . ' - CANCEL: POST: ', $_POST);
    Session::AddMessageAfterRedirect('Config reset');
    Html::back();
}

/**
 * then render current configuration
 */
$PluginGSpecialistAConfigForm->renderTitle();
$PluginGSpecialistAConfigForm->showFormGSpecialistA();
