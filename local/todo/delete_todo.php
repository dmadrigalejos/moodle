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
 * Manage Todo
 *
 * @package    
 * @copyright  2019 Danilo Madrigalejos
 * @license    http://www.gnu.org/copyleft/gpl.html gnu gpl v3 or later
 */

require_once('../../config.php');
 
require_login();
$context = context_system::instance();
$PAGE->set_url('/local/todo/delete_todo.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('todo:managetodo', 'local_todo'));
$PAGE->set_pagelayout('admin');

require_capability('local/todo:managetodo', $context);

$manager = new \local_todo\manager;
$confirm = optional_param('confirm', '', PARAM_INT);
$todoid = required_param('id', PARAM_INT);

if(!$todo = $manager->get_todo($todoid)){
    print_error('error:todoinvalid','local_todo');
}

if(!$confirm){
    echo $OUTPUT->header();

    $strdelete = get_string('tododelete', 'local_todo', $todo->name);

    echo $OUTPUT->confirm($strdelete, new moodle_url("/local/todo/delete_todo.php", array('id' => $todoid, 'confirm' => 1, 'sesskey' => $USER->sesskey)),
                                      new moodle_url("/local/todo/manage.php"));

    echo $OUTPUT->footer();
    exit;
}
$redirecturl = new moodle_url('/local/todo/manage.php');

///
/// Delete
///

if (!confirm_sesskey()) {
    print_error('confirmsesskeybad', 'error');
}

if ($manager->delete_todo($todoid)) {
    redirect($redirecturl, get_string('tododeleted', 'local_todo'), null, 'success');
} else {
    print_error('error:errordelete', 'local_todo');
}
