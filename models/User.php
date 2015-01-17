<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $email
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['login', 'password', 'email'], 'required'],
            [['login', 'password', 'email'], 'string', 'max' => 255]
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
        ];
    }
    
    /**
     * Validates the password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id:',
            'login' => 'login:',
            'password' => 'password:',
            'email' => 'email:',
        ];
    }
}
