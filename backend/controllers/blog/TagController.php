<?php

namespace backend\controllers\blog;

use backend\forms\Blog\TagsAjaxSearch;
use grigor\blog\module\tag\api\TagInterface;
use grigor\blogManagement\BlogManagementContract;
use grigor\blogManagement\services\forms\TagForm;
use Yii;
use backend\forms\Blog\TagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TagController extends Controller
{
    private $blog;

    public function __construct($id, $module, BlogManagementContract $blog, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->blog =$blog;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'search' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearch()
    {
        if (!\Yii::$app->request->isAjax) {
            $this->fire404();
        }

        $searchModel = new TagsAjaxSearch();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $searchModel->search(\Yii::$app->request->post());
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function actionUpdate(string $id)
    {
        if (!isset($_POST['hasEditable'])) {
            $this->fire404();
        }

        if (!$tag = $this->findModel($id)) {
            return ['output' => '', 'message' => 'No access.'];
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $form = new TagForm($tag, false);
        if ($form->load(\Yii::$app->request->post(), '') && $form->validate()) {
            try {
                $this->blog->editTag($tag->id, $form);
                return ['output' => $tag->name === $form->name ? $form->slug : $form->name, 'message' => ''];
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $errors = $form->getFirstErrors();
        return ['output' => '', 'message' => implode(', ', $errors)];
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->blog->removeTag($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param string $id
     * @return TagInterface the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(string $id): TagInterface
    {
        $contract = \Yii::$container->get(BlogManagementContract::class);
        $query = $contract->createTagQuery();
        if (($model = $query->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        }
        $this->fire404();
    }

    private function fire404()
    {
        throw new NotFoundHttpException(\Yii::t('app', 'Page not found.'));
    }
}
