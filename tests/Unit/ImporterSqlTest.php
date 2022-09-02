<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use App\Classes\Model\ImporterSql;
use App\Classes\Exceptions\FileFormatException;
use App\Classes\Exceptions\SourceFileException;

class ImporterSqlTest extends TestCase
{
    const CITIES = [
        'filename' => './data/cities.csv',
        'columns' => [
            'name' => 'name',
            'lat' => 'latitude',
            'long' => 'longitude',
        ],
        'tableName' => 'cities',
    ];
    const CATEGORIES = [
        'filename' => 'data/categories.csv',
        'columns' => [
            'name' => 'name',
            'icon' => 'slug',
        ],
        'tableName' => 'categories',
    ];

    public function testInvalidColumnsFormat()
    {
        $this->expectException(FileFormatException::class);
        $this->expectExceptionMessage('Заданы неверные заголовки столбцов');

        $classInstance = new ImporterSql(
            self::CITIES['filename'], 
            [
                'name' => 0,
                'icon' => 'slug',
            ],
            self::CITIES['tableName']
        );
        $classInstance->import();
    }

    public function testInvalidColumnsAssignment()
    {
        $this->expectException(FileFormatException::class);
        $this->expectExceptionMessage('Набор столбцов в исходном файле не совпадает с ожидаемым');

        $classInstance = new ImporterSql(
            self::CITIES['filename'], 
            [
                'noname' => 'name',
                'icon' => 'slug',
            ],
            self::CITIES['tableName']
        );
        $classInstance->import();
    }

    public function testInvalidFilename()
    {
        $this->expectException(SourceFileException::class);
        $this->expectExceptionMessage('Такого файла не существует');

        $classInstance = new ImporterSql(
            './data/nonfile', 
            self::CITIES['columns'], 
            self::CITIES['tableName']
        );
        $classInstance->import();
    }

}
