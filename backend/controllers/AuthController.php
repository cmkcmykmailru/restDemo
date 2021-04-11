<?php

namespace backend\controllers;

use grigor\userManagement\services\forms\LoginForm;
use grigor\userManagement\UserManagementContract;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AuthController extends Controller
{
    private UserManagementContract $userManagement;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function __construct($id, $module, UserManagementContract $contract, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->userManagement = $contract;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->userManagement->login($form);
                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionlogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
