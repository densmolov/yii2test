<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegistrationForm is the data structure for submitting
 * user data. It is used by the 'registration' action of 'SiteController'.
 */
class RegistrationForm //extends Model//CFormModel
{
	public $login;
	public $email;
	public $password;

	/** * Declares the validation rules.
	* The rules state that first name, last name, email and pass are required,
     * email must be valid email.
     * email must be unique using User class.
     */
	public function rules() {
		return array(
		// username and password are required 
		array('login, email, password', 'required'), 
		// trim date for first names, further validation? strip_tags? 
		array('login, email, password', 'filter', 'filter' => 'trim'), 
		// email must be valid email 
		array('email', 'email'), 
		// email must be unique and use User class 
		array('email', 'unique', 'className' => 'User')
		);
	}

	/** * Declares attribute labels. */ 
	public function attributeLabels() {
		return array(
			'login'=>'Login', 
			'email'=>'Email', 
			'password'=>'Password', 
		);
	} 

}