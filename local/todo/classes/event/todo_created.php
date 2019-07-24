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
 * @package    local_todo
 * @copyright  2019 Danilo Madrigalejos
 * @license    http://www.gnu.org/copyleft/gpl.html gnu gpl v3 or later
 */
namespace local_todo\event;
defined('MOODLE_INTERNAL') || die();
/**
 * The todo_created event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - PUT INFO HERE
 * }
 *
 * @copyright 2019 Danilo Madrigalejos
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 **/
class todo_created extends \core\event\base {
    protected function init() {
        $this->data['crud'] = 'c'; // c(reate), r(ead), u(pdate), d(elete)
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'local_todo';
    }
 
    public static function get_name() {
        return get_string('eventtodocreated', 'local_todo');
    }
 
    public function get_description() {
        return "The user with id '{$this->userid}' created an todo with id '{$this->objectid}'.";
    }
 
    public function get_url() {
        return new \moodle_url('/local/todo/todo.php', array('id' => $this->objectid));
    }
 
}