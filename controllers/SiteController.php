<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\User;
use yii\base\Model;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionRegister()
    {
        $model = new RegistrationForm();
        $newUser = new User();
        /*if($model.validate) {
            $newUser->login = $model->login;
            $newUser->email = $model->email;
            $newUser->password = $model->password;
        }*//*
        $newUser->login = 'fake';//$model->login;
        $newUser->email = 'email@fake';//$model->email;
        $newUser->password = 'fake';//$model->password;*/

        if ($model->load(Yii::$app->request->post())) {
            $newUser->login = $model->login;
            $newUser->email = $model->email;
            $newUser->password = $model->password;
            $newUser->save();
            return $this->goBack();
        } else {
            return $this->render('register', ['model' => $model]);
        }


        //$newUser->password = hash_hmac('sha256', $model->password, Yii::app()->params['encryptionKey']);

        /*if($newUser->save()) {                          
            $this->redirect(array('site/login'));
        }*/
        /*$connection = \Yii::$app->db;
        $connection->createCommand()->insert('user', [
            'login' => 'Sam',
            'email' => 'qwerty@sfcsc',
            'password' => 'password',
        ])->execute();*/

        /*if ($model->load(Yii::$app->request->post())) {
            return $this->goBack();
        } else {
            return $this->render('register', ['model' => $model]);
        }*/




        //$model=new RegistrationForm();
        //$newUser = new User;

        // if it is ajax validation request    
        /*if(isset($_POST['ajax']) && $_POST['ajax']==='register-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }*/
    
        // collect user input data
        /*if(isset($_POST['register-form']))
        {
            $model->attributes=$_POST['register-form'];
            
            if ($model->validate()) {
                $newUser->login = $model->login;
                $newUser->email = $model->email;
                $newUser->password = hash_hmac('sha256', $model->password, Yii::app()->params['encryptionKey']);

                if($newUser->save()) {                          
                    $this->redirect(array('site/index'));
                }
            }
        }*/
        // display the register form
        //return $this->render('register',array('model'=>$model));
    }


}
