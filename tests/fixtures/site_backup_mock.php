<?php
// This file is part of plugin tool_vault - https://lmsvault.io
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * The site_backup_test test class.
 *
 * @package     tool_vault
 * @category    test
 * @copyright   2022 Marina Glancy <marina.glancy@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_vault\fixtures;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/' . $CFG->admin . '/tool/vault/tests/fixtures/files_backup_mock.php');

/**
 * Mock class for site backup
 */
class site_backup_mock extends \tool_vault\site_backup {
    /** @var int|null chunk size to use for the table export instead of the calculated one */
    public $chunksize = null;

    /**
     * Helper function, how many rows should we add to one chunk of the db table export
     *
     * @param string $tablename
     * @return int
     */
    protected function get_chunk_size(string $tablename) {
        return $this->chunksize ?? parent::get_chunk_size($tablename);
    }

    /**
     * Get the helper to backup files of the specified type
     *
     * @param string $filetype
     * @return files_backup_mock
     */
    public function get_files_backup(string $filetype): \tool_vault\local\helpers\files_backup {
        if (!array_key_exists($filetype, $this->filesbackups)) {
            $this->filesbackups[$filetype] = new files_backup_mock($this, $filetype);
        }
        return $this->filesbackups[$filetype];
    }
}
