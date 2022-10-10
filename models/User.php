<?php

namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $telegram
 * @property string $password
 * @property string $role
 * @property int $city_id
 * @property int|null $avatar_id
 * @property string|null $birthday
 * @property string|null $description
 * @property float|null $current_rating
 * @property string $registered_at
 * @property string|null $last_updated_at
 *
 * @property File $avatar
 * @property City $city
 * @property Response[] $responses
 * @property Review[] $reviews
 * @property Review[] $reviews0
 * @property Task[] $tasks
 * @property Task[] $tasks0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'phone', 'password', 'role', 'city_id'], 'required'],
            [['city_id', 'avatar_id'], 'integer'],
            [['birthday', 'registered_at', 'last_updated_at'], 'safe'],
            [['description'], 'string'],
            [['current_rating'], 'number'],
            [['name', 'email', 'telegram', 'password', 'role'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 11],
            [
                ['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::class,
                'targetAttribute' => ['city_id' => 'id']
            ],
            [
                ['avatar_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => File::class,
                'targetAttribute' => ['avatar_id' => 'id']
            ],
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
            'email' => 'Email',
            'phone' => 'Phone',
            'telegram' => 'Telegram',
            'password' => 'Password',
            'role' => 'Role',
            'city_id' => 'City ID',
            'avatar_id' => 'Avatar ID',
            'birthday' => 'Birthday',
            'description' => 'Description',
            'current_rating' => 'Current Rating',
            'registered_at' => 'Registered At',
            'last_updated_at' => 'Last Updated At',
        ];
    }

    /**
     * Gets query for [[Avatar]].
     *
     * @return ActiveQuery
     */
    public function getAvatar(): ActiveQuery
    {
        return $this->hasOne(File::class, ['id' => 'avatar_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return ActiveQuery
     */
    public function getResponses(): ActiveQuery
    {
        return $this->hasMany(Response::class, ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return ActiveQuery
     */
    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Review::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'user_id'])->viaTable('user_category', ['category_id' => 'id']);
    }
}
