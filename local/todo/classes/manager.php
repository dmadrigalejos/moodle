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
    /**
     * Get list of todos
     * @global \local_todo\type $DB
     * @return type
     */
    public static function get_todos(){
        global $DB;
        
        $query = 'SELECT id, name, description FROM {local_todo}';
        $todos = $DB->get_records_sql($query);
        
        return $todos;
    }

    /**
     * Get todo by ID
     * @global \local_todo\type $DB
     * @param int $id Todo ID
     * @return mixed Boolean or Todo object on success 
     */
    public static function get_todo(int $id){
        global $DB;
        
        $query = 'SELECT * FROM {local_todo} WHERE id = ?';
        if($todo = $DB->get_record_sql($query, array($id))){
            return $todo;
        }
        return false;
    }

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

    public function update_todo($data, $editoroptions){
        global $DB, $USER;
        
        $data->id = $data->todoid;
        $data = file_postupdate_standard_editor($data, 'description', $editoroptions, \context_system::instance(),'local_todo', 'description', 0);
        $DB->update_record('local_todo',$data);
        $event = \local_todo\event\todo_updated::create(array(
            'objectid' => $data->id,
            'userid' => $USER->id,
            'context' => \context_system::instance()
        ));
        $event->trigger();
    }
}