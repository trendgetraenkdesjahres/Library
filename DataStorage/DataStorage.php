<?php

namespace DataStorage;

use Settings\Settings;

require_once 'Tables/Table.php';
require_once 'Database.php';
require_once 'File.php';



/**
 * DataStorageInterface defines the contract for DataStorage classes.
 */
interface DataStorageInterface
{
    public static function get_table(string $table_name): DataStorageTable;
    public static function get_queried_data(): mixed;
    public static function initalize(): bool;
}

/**
 * DataStorage is a factory class for creating DataStorageTable instances.
 */
class DataStorage
{
    /**
     * Get a table instance by name.
     *
     * @param string $name The name of the table.
     * @return DataStorageTable The table instance.
     * @throws \Error If no suitable configuration for Filebased or DBbased setting is found.
     */
    public function get_table(string $name): DatabaseTable
    {
        if (Settings::get('db_name')) {
            DatabaseStorage::initalize();
            return DatabaseStorage::get_table($name);
        } elseif (Settings::get('data_file_name')) {
            FileStorage::initalize();
            return FileStorage::get_table($name);
        } else {
            throw new \Error("No Setting for 'db_name' or 'data_file_name' found.");
        }
    }
}