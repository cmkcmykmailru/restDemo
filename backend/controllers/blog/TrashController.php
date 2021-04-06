<?php

namespace backend\controllers\blog;

use backend\forms\Blog\TrashSearch;
use grigor\blogManagement\BlogManagementContract;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class TrashController extends Controller
{
    private $blog;

    public function __construct($id, $module, BlogManagementContract $blog, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->blog = $blog;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'trash' => ['POST'],
                    'restore' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TrashSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws \Exception
     */
    public function actionDelete(string $id)
    {
        try {
            $this->blog->removePost($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionTrash(string $id)
    {
        try {
            $this->blog->trashPost($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRestore(string $id)
    {
        try {
            $this->blog->restorePostFromTrash($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}