<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $login
 * @property string $passwordHash
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
    //  DO WE NEED THIS?!   ////////////////////////////////////////////////////////////////
    public function rules()
    {
        return [
            [['login', 'email', 'passwordHash'], 'required'],
            [['login', 'email', 'passwordHash'], 'string', 'max' => 255, 'min' => 3],
            ['email','email'],
            // passwordHash is validated by validatePassword()
            //['passwordHash', 'validatePassword'],
        ];
    }
    
    /**
     * Validates the passwordHash.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute/*, $params*/)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->passwordHash)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Finds user by login
     *
     * @param  string $login
     * @return static|null
     */
    public static function findByLogin($login)
    {
        // the following will retrieve the user from the database
        $user = User::find()->where(['login' => $login])->one();
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['login'], $login) === 0) {
                return new static($user);
            }
        }
        return null;*/
        return $user;
    }

    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    /*public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByLogin($this->login);
        }
        return $this->_user;
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id:',
            'login' => 'login:',
            'passwordHash' => 'password:',
            'email' => 'email:',
        ];
    }
}
