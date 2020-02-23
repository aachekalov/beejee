<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $user
 * @property string $email
 * @property string $description
 * @property int $done
 * @property int $edited
 */
class Task extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task';

    public $timestamps = false;

    public $errors = [];

    public function fields()
    {
        return [
            'id',
            'user',
            'email',
            'description',
            'done',
            'edited',
        ];
    }

    public function loadData($data)
    {
        $this->user = $data['user'];
        $this->email = $data['email'];
        $this->description = $data['description'];
    }

    public function validate()
    {
        if (empty($this->user)) {
            $this->errors['user'] = 'Имя пользователя не может быть пустым';
        }
        if (empty($this->email)) {
            $this->errors['email'] = 'E-mail не может быть пустым';
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'E-mail некорректный';
        }
        if (empty($this->description)) {
            $this->errors['description'] = 'Текст задачи не может быть пустым';
        }
        return count($this->errors) === 0;
    }
}
