<?php


namespace app\core;


/**
 * Interface MigrationInterface
 * @package app\core
 */
interface MigrationInterface
{
    /**
     * Method to make changes in database
     */
    public function up(): void;

    /**
     * Method to delete all changes made
     * with the help of 'up' method
     */
    public function down(): void;
}