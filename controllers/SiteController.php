<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;

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
        $regForm = new RegisterForm();
        $newUser = new User();
        if ($regForm->load(Yii::$app->request->post())) {
            $newUser->login = $regForm->login;
            $newUser->email = $regForm->email;
            $newUser->password = Yii::$app->getSecurity()->generatePasswordHash($regForm->password);
            //  PASSWORD ENCRYPTOR WORKS BOTH DIRECTIONS !!!
            /*if(Yii::$app->getSecurity()->validatePassword('qwerty', $newUser->password)) {
                $newUser->save();
                return $this->goBack();
            }*/
            if($newUser->save()){
                return $this->goBack();
            }
        } else {
            return $this->render('register', ['model' => $regForm]);
        }

    }

}
