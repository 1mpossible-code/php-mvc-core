<?php


namespace impossible\phpmvc;


/**
 * Interface MigrationInterface
 * @package impossible\phpmvc
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