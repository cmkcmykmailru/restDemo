<?php
namespace grigor\signup\controllers;

use grigor\signup\model\handlers\RequestHandler;
use grigor\signup\model\forms\SignupForm;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class RequestController extends Controller
{

    private $requestHandler;

    public function __construct($id, $module, RequestHandler $handler, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->requestHandler = $handler;
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
     * @return mixed
     */
    public function actionIndex()
    {
        $form = new SignupForm($this->module->userEntity);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->requestHandler->execute($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }

}
