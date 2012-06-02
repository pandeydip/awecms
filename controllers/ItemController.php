
<?php

class ItemController extends Controller {

    public function actionIndex($id, $activeId = '') {
        $model = MenuItem::model()->findAllByAttributes(array('menu_id' => $id));
        $this->render('index', array(
            'model' => $model,
            'id' => $id,
            'activeId' => $activeId
        ));
    }

    public function actionCreate() {
        $model = new MenuItem;
        if (isset($_POST['MenuItem'])) {
            $model->setAttributes($_POST['MenuItem']);
            if (isset($_POST['MenuItem']['menu']))
                $model->menu = $_POST['MenuItem']['menu'];
            if (isset($_POST['MenuItem']['parent']))
                $model->parent = $_POST['MenuItem']['parent'];
            
            //pushing newly added item to last
            $maxRight = $model->getMaxRight();
            $model->left = $maxRight+1;
            $model->right = $maxRight+2;

            try {
                if ($model->save()) {
                    $this->redirect(array('/' . $this->module->id . '/item', 'id' => $model->menu_id, 'activeId' => $model->id));
                }
            } catch (Exception $e) {
                $model->addError('', $e->getMessage());
            }
        } elseif (isset($_GET['MenuItem'])) {
            $model->attributes = $_GET['MenuItem'];
        }

        $this->render('create', array('model' => $model, 'menuId' => key($_GET)));
    }

    public function actionEdit() {
        $model = $this->loadModel(key($_GET));
        if (isset($_POST['MenuItem'])) {
            $model->setAttributes($_POST['MenuItem']);
            $model->menu = $_POST['MenuItem']['menu'];
            $model->parent = $_POST['MenuItem']['parent'];
            try {
                if ($model->save()) {
                    $this->redirect(array('/' . $this->module->id . '/item', 'id' => $model->menu_id, 'activeId' => $model->id));
                }
            } catch (Exception $e) {
                $model->addError('', $e->getMessage());
            }
        }

        $this->render('edit', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $menuId = $model->menu_id;
        if (Yii::app()->request->isPostRequest) {
            try {
                $model->delete();
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('/' . $this->module->id . '/item/' . $menuId));
            }
        }
        else
            throw new CHttpException(400,
                    Yii::t('app', 'Invalid request.'));
    }

    public function loadModel($id) {
        $model = MenuItem::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        return $model;
    }

}