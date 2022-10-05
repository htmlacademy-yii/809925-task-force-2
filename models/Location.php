<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "location".
 *
 * @property int $id
 * @property string $name
 * @property float $longitude
 * @property float $latitude
 * @property string $registered_at
 *
 * @property Task[] $tasks
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'longitude', 'latitude'], 'required'],
            [['longitude', 'latitude'], 'number'],
            [['registered_at'], 'safe'],
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
            'registered_at' => 'Registered At',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return ActiveQuery
     */
    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Task::class, ['location_id' => 'id']);
    }
}
