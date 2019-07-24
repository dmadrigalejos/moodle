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
 * -
 *
 * @package    
 * @copyright  2019 Danilo Madrigalejos
 * @license    http://www.gnu.org/copyleft/gpl.html gnu gpl v3 or later
 */

namespace local_todo\forms;

defined('MOODLE_INTERNAL') || die();

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
 
class add_todo_form extends \moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;
 
        $mform = $this->_form; // Don't forget the underscore! 
        
        $todo = $this->_customdata['todo'];
        $editoroptions = $this->_customdata['editoroptions'];

        $mform->addElement('hidden', 'todoid', null);
        $mform->setType('todoid', PARAM_INT);
        if(isset($todo->id)){
            $mform->setConstant('todoid', $todo->id);
        }
 
        $mform->addElement('text', 'name', get_string('name'), 'maxlength="60"'); // Add elements to your form
        $mform->setType('name', PARAM_TEXT);                   //Set type of element
        $mform->addRule('name', get_string('required'), 'required');
        
        $mform->addElement('editor', 'description_editor', get_string("description"), null, $editoroptions);
        $mform->setType('description', PARAM_RAW);
        
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        global $DB;

        $errors = parent::validation($data, $files);
        
        $name = $data['name'];
        
        if($DB->record_exists_sql('SELECT id FROM {local_todo} WHERE name = ? AND id <> ?', array($name, $data['todoid']))){
            $errors['name'] = get_string('error');
        }
        
        return $errors;
    }
}
