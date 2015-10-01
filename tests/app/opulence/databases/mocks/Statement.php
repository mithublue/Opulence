<?php
/**
 * Copyright (C) 2015 David Young
 *
 * Mocks the statement class for use in testing
 */
namespace Opulence\Tests\Databases\SQL\Mocks;

use PDO;
use Opulence\Databases\IStatement;

class Statement implements IStatement
{
    /**
     * @inheritdoc
     */
    public function bindParam($parameter, &$variable, $dataType = PDO::PARAM_STR, $length = null)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function bindValue($parameter, $value, $dataType = PDO::PARAM_STR)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function bindValues(array $values)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function closeCursor()
    {
        // Do nothing
    }

    /**
     * @inheritdoc
     */
    public function columnCount()
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function errorCode()
    {
        return "";
    }

    /**
     * @inheritdoc
     */
    public function errorInfo()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function execute($parameters = null)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function fetch($fetchStyle = PDO::ATTR_DEFAULT_FETCH_MODE)
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function fetchAll($fetchStyle = PDO::ATTR_DEFAULT_FETCH_MODE)
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function fetchColumn($columnNumber = 0)
    {
        return "";
    }

    /**
     * @inheritdoc
     */
    public function rowCount()
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function setFetchMode($fetchMode)
    {
        return true;
    }
} 