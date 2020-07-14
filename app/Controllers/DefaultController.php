<?php
namespace Commentout\Controllers;

/*
 * Контроллер приложения по умолчанию.
 * Выводит главную страницу.
 *
 */
class DefaultController extends Controller
{
    public function action()
    {
        $comments = $this->model('CommentsModel');
        $data["pagesCount"] = $comments->getPagesCount();
        $data["items"] = $comments->getCommentsByPage(1);

        $this->render('header');
        $this->render('comments', $data);
        $this->render('footer');
    }
}