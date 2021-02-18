<?php


namespace impossible\phpmvc;


use impossible\phpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}