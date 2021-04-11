<?php
namespace grigor\signup\controllers;

use grigor\signup\model\handlers\ConfirmHandler;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class ConfirmController extends Controller
{
    private ConfirmHandler $confirmHandler;

    public function __construct($id, $module, ConfirmHandler $handler, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->confirmHandler = $handler;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $token
     * @return mixed
     */
    public function actionIndex($token)
    {
        try {
            $this->confirmHandler->execute($token);
            Yii::$app->session->setFlash('success', 'Your email is confirmed.');
            return $this->redirect(['/auth/login/index']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }
}
