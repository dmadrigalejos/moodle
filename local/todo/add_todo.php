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
 * Add todo
 *
 * @package    
 * @copyright  2019 Danilo Madrigalejos
 * @license    http://www.gnu.org/copyleft/gpl.html gnu gpl v3 or later
 */


require_once('../../config.php');

 
require_login();
$context = context_system::instance();
$PAGE->set_url('/local/todo/add_todo.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('todo:managetodo', 'local_todo'));
$PAGE->set_pagelayout('admin');
require_capability('local/todo:managetodo', $context);

$returnurl = new moodle_url('/local/todo/manage.php');

$framework = new stdClass();
$framework->description = '';
$framework->description_editor = '';
$PAGE->navbar->add(get_string('todo:managetodo', 'local_todo'), $returnurl);
$PAGE->navbar->add(get_string('addtodo', 'local_todo'));

$editoroptions = array('maxfiles' => 0, 'maxbytes'=>$CFG->maxbytes, 'trusttext'=>false, 'noclean'=>true, 'context' => $context);
$customdata = array(
    'framework' => $framework,
    'editoroptions' => $editoroptions,
);
$mform = new \local_todo\forms\add_todo_form(null, $customdata);
$framework = file_prepare_standard_editor($framework, 'description', $editoroptions, $context, 'local_todo', 0);

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();