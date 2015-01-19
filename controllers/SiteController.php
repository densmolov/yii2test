<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'user'],
                'rules' => [
                    [
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
            return $this->redirect(['user']);
        } else {
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    public function actionRegister()
    {
        $regForm = new RegisterForm();
        $newUser = new User();
        $noSuchLoginYet = true;
        if ($regForm->load(Yii::$app->request->post())) {
            //  try catch ?   ////////////////////////////////////////////////////////////
            $allUsersFromDB = User::find()
                ->select('login')
                ->all();
            foreach ($allUsersFromDB as $foundUser) {
                if($regForm->login == $foundUser->login) {
                    $noSuchLoginYet = false;
                }
            }
            if(($noSuchLoginYet) && (strcasecmp($regForm->password, $regForm->repeatPassword) === 0)) {
                $newUser->login = $regForm->login;
                $newUser->email = $regForm->email;
                $newUser->passwordHash = Yii::$app->getSecurity()->generatePasswordHash($regForm->password);
                $newUser->save();
                return $this->redirect(['login']);
            } else {
                return $this->render('register', ['model' => $regForm]);
            }
        } else {
            return $this->render('register', ['model' => $regForm]);////////////////////////////////?????????????????
        }
    }

    public function actionUser()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->select(['login', 'email'])->orderBy('LOWER(login)'),
        ]);
        return $this->render('user', ['dataProvider' => $dataProvider]);
    }

}
