<?php

namespace App\Classes\Model;

use App\Classes\Exceptions\FileFormatException;
use App\Classes\Exceptions\SourceFileException;
use \SplFileObject;

class ImporterSql
{
    private string $filename;
    private array $columns;
    private string $tableName;
    private string $queryFileName;
    private SplFileObject $fileObject;

    private array $result = [];
    private string $insertQueryString = '';

    public function __construct(string $filename, array $columns, string $tableName)
    {
        $this->filename = $filename;
        $this->columns = $columns;
        $this->tableName = $tableName;
        $this->queryFileName = sprintf("%s.seeds.sql", $this->tableName);
    }

    /**
     * Run an importing process and updating the $this->result param as a result
     * 
     * @throws \Exception
     */
    public function import():void
    {
        if (!$this->validateColumns()) {
            throw new FileFormatException("Заданы неверные заголовки столбцов");
        }

        if (!file_exists($this->filename)) {
            throw new SourceFileException("Такого файла не существует");
        }

        try {
            $this->fileObject = new SplFileObject($this->filename);
        } catch (RuntimeException $e) {
            throw new SourceFileException("Не удалось прочесть файл");
        }

        $headerData = $this->getHeaderData();
        if (!$this->validateHeaders($headerData)) {
            throw new FileFormatException("Набор столбцов в исходном файле не совпадает с ожидаемым");
        }

        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }
    }

    /**
     * Checks whether passed columns and columns names from the file are the same
     * 
     * @return bool
     */
    private function validateHeaders(array $headerData):bool
    {
        return $headerData === array_keys($this->columns); // todo
    }


    /**
     * Validates each colum in a columns' array
     * 
     * @return bool
     */
    private function validateColumns():bool
    {
        if (empty($this->columns)) {
            return false;
        }
        foreach ($this->columns as $fileKey => $tableKey) {
            if (!is_string($fileKey) || !is_string($tableKey)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns header data in a form of an array
     * 
     * @return array|null
     */
    private function getHeaderData():?array
    {
        $this->fileObject->rewind();
        $headers = $this->fileObject->fgetcsv();

        // There is a need of removing some special characters from a string
        return $headers ? array_map( function($header) {
            $bom = pack('H*','EFBBBF');
            $fixedHeader = preg_replace("/^$bom/", '', $header);

            return $fixedHeader;
        }, $headers ) : [];
    }

    /**
     * Generator of looping through all the file's rows
     * 
     * @return iterable|null
     */
    private function getNextLine():?iterable
    {
        $result = null;

        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }
    }

    /**
     * Returns the file's data as an array
     * 
     * @return array
     */
    public function getData():array
    {
        return $this->result;
    }

    /**
     * Create and returns an SQL-query string for inserting data to the table
     */
    public function setInsertQueryString():void
    {
        if (empty($this->result)) {
            $query = '';
        } else {
            $values = [];
            foreach ($this->result as $row) {
                $values[] = sprintf(
                    "(%s)", 
                    implode(
                        ', ', 
                        array_map(
                            function($value) {
                                return "'$value'";
                            }, 
                            $row
                        )
                    )
                );
            }
            $query = sprintf(
                "INSERT INTO %s (%s) VALUES %s;", 
                $this->tableName,
                implode(', ', array_values($this->columns)),
                implode(', ', $values),
            );
        }

        $this->insertQueryString = $query;
    }

    /**
     * Returns an SQL query string of inserting data from a file to the DB
     * 
     * @return string
     */
    public function getInsertQueryString():string
    {
        return $this->insertQueryString;
    }

    /**
     * Write the insert query string to a file
     * 
     * @return int|bool
     */
    public function setInsertQueryIntoFile():int|bool
    {
        if (!$this->getInsertQueryString()) {
            return false;
        }

        return file_put_contents($this->queryFileName, $this->insertQueryString);
    }

}