<?php

namespace app\controllers;

use app\models\User;
use core\Controller;

class SiteController extends Controller
{
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (isset($_SESSION['admin'])) {
            header('Location: /');
            return;
        }

        $user = new User();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->loadData($_POST);
            if ($user->validate() && $user->login()) {
                header('Location: /');
                return;
            }
        }

        return $this->render('login', [
            'model' => $user,
        ]);
    }

    /**
     * Logout action.
     */
    public function actionLogout()
    {
        unset($_SESSION['admin']);
        header('Location: /');
    }
}
