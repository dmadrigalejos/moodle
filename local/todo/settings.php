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

/**
 * You may have settings in your plugin
 *
 * @package    local_todo
 * @copyright  2019 Danilo Madrigalejos
 * @license    http://www.gnu.org/copyleft/gpl.html gnu gpl v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$ADMIN->add('root', new admin_category('todo', get_string('todo', 'local_todo')));
$ADMIN->add('todo', new admin_externalpage('managetodo', get_string('todo:managetodo', 'local_todo'), 
        $CFG->wwwroot.'/local/todo/manage.php', 'local/todo:managetodo'));