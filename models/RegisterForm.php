<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegisterForm is the model behind the registration form.
 */
class RegisterForm extends Model
{
    public $login;
    public $email;
    public $password;
    public $repeatPassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['login', 'email', 'password', 'repeatPassword'], 'required'],
            [['login', 'email', 'password', 'repeatPassword'], 'string', 'max' => 255, 'min' => 3],
            ['login', 'unique'],
            ['email','email']
            // password is validated by validatePassword()
            //'password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    /*public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }*/

    /** * Declares attribute labels. */ 
    public function attributeLabels() { 
        return array( 
            'login'=>'login', 
            'email'=>'email', 
            'password'=>'password',
            'repeatPassword'=>'repeat password:'
        );
    }

    
}
