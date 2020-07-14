<?php
namespace Commentout\Controllers;

/*
 * Контроллер модели комментариев.
 * Получает список комментириев и сохраняет коментарийю
 *
 */
class CommentsController extends Controller
{
    /*
     * Метод для получения страницы с комментариями в формате JSON
     */
    public function getCommentsPage()
    {
        if (isset($_POST["page"])) {
            $pageNum = (int)$_POST["page"];
        } else {
            $pageNum = 1;
        }

        $comments = $this->model('CommentsModel');
        $data["pagesCount"] = $comments->getPagesCount();
        $data["items"] = $comments->getCommentsByPage($pageNum);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /*
     * Метод для размещения комментария в базе.
     * Производит проверку вводимых данных.
     */
    public function storeNewComment()
    {
        if (
            !isset($_POST["title"])
            || !isset($_POST["comment"])
            || !isset($_POST["name"])
            || !isset($_POST["email"])
            || empty($_POST["title"])
            || empty($_POST["comment"])
            || empty($_POST["name"])
            || empty($_POST["email"])
            || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)
        ) {
            die('novalid');
        }

        $comments = $this->model('CommentsModel');

        print_r($comments->saveComment(
            [
                'title' => $_POST["title"],
                'comment' => $_POST["comment"],
                'name' => $_POST["name"],
                'email' => $_POST["email"],
                'date' => date('Y-m-d H:i:s')
            ]
        ));
    }
}