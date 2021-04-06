<?php

namespace backend\controllers\blog;

use Exception;

use grigor\blog\module\post\api\PostInterface;
use grigor\blogManagement\BlogManagementContract;
use grigor\blogManagement\services\forms\PostForm;
use Yii;
use backend\forms\Blog\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PostController extends Controller
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
                    'activate' => ['POST'],
                    'draft' => ['POST'],
                    'trash' => ['POST'],
                    'restore' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function actionCreate()
    {
        $form = new PostForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $post = $this->blog->createPost($form);
                return $this->redirect(['update', 'id' => $post->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate(string $id)
    {
        $post = $this->findModel($id);

        $form = new PostForm($post);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->blog->editPost($post->id, $form);
                return $this->redirect(['update', 'id' => $post->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'post' => $post,
        ]);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function actionActivate(string $id)
    {
        try {
            $this->blog->activatePost($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function actionDraft(string $id)
    {
        try {
            $this->blog->draftPost($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param string $id
     * @return PostInterface the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(string $id): PostInterface
    {
        if (($model = $this->blog->createPostQuery()->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
