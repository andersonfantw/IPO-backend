<?php
namespace App\Traits;

trait tableAssist{
    public static function getTableColumns() {
        $instance = new static;
        return $instance->getConnection()->getSchemaBuilder()->getColumnListing($instance->getTable());
    }
}