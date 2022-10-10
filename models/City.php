<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "City".
 *
 * @property int $id
 * @property string $name
 * @property float $longitude
 * @property float $latitude
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'City';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'longitude', 'latitude'], 'required'],
            [['longitude', 'latitude'], 'number'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
        ];
    }
}
