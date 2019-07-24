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
 * Manager Class for Todo
 *
 * @package    
 * @copyright  2019 Danilo Madrigalejos
 * @license    http://www.gnu.org/copyleft/gpl.html gnu gpl v3 or later
 */
namespace local_todo;

defined('MOODLE_INTERNAL') || die();

class manager{
    public function create_todo($data, $editoroptions){
        global $DB, $USER;
        
        $data = file_postupdate_standard_editor($data, 'description', $editoroptions, \context_system::instance(),'local_todo', 'description', 0);
        $todoid = $DB->insert_record('local_todo',$data, true);
        
        $event = \local_todo\event\todo_created::create(array(
            'objectid' => $todoid,
            'userid' => $USER->id,
            'context' => \context_system::instance()
        ));
        $event->trigger();
        
        return $todoid;
    }
}