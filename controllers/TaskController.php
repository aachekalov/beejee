<?php

namespace app\controllers;

use app\models\Task;
use core\Controller;

class TaskController extends Controller
{
    /**
     * Index page.
     */
    public function actionIndex()
    {
        $model = new Task();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model->loadData($_POST);
            if ($model->validate()) {
                $model->save();
                $_SESSION['success'] = 'Задача добавлена!';
            }
        }

        $page = (int) $_GET['page'];
        /**
         * @var $page int zero-based current page number
         */
        $page = $page < 1 ? 0 : $page - 1;
        $pageSize = 3;

        $totalCount = Task::select()->count();
        $pageCount = ($totalCount + $pageSize - 1) / $pageSize;
        if ($page + 1 > $pageCount) {
            $page = $pageCount - 1;
        }

        $offset = $page * $pageSize;
        $limit = $pageSize;

        $query = Task::select()->offset($offset)->limit($limit);

        $params = [
            'model' => $model,
            'currentPage' => $page + 1,
            'pageCount' => $pageCount,
        ];

        if ($this->setSorting($query, $model->fields())) {
            $params['sort'] = $_GET['sort'];
        }

        $params['items'] = $query->get();

        return $this->render('index', $params);
    }

    private function setSorting($query, $safeFields) : bool
    {
        if (isset($_GET['sort'])) {
            if (strncmp($_GET['sort'], '-', 1) === 0) {
                $sortField = substr($_GET['sort'], 1);
                $sortDirection = 'desc';
            } else {
                $sortField = $_GET['sort'];
                $sortDirection = 'asc';
            }
            if (in_array($sortField, $safeFields)) {
                $query->orderBy($sortField, $sortDirection);
                return true;
            }
        }
        return false;
    }

    private function checkAccess() {
        if (!isset($_SESSION['admin'])) {
            throw new \Exception('Access forbidden');
        }
    }

    public function actionUpdateDescription()
    {
        $this->checkAccess();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id']) && isset($_POST['description'])) {
                $id = (int) $_POST['id'];
                $description = $_POST['description'];
                $task = Task::find($id);
                $task->description = $description;
                $task->edited = true;
                $task->save();
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionMakeDone()
    {
        $this->checkAccess();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                $id = (int) $_POST['id'];
                $task = Task::find($id);
                $task->done = true;
                $task->save();
                return true;
            } else {
                return false;
            }
        }
    }
}
