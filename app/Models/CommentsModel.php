<?php
namespace Commentout\Models;

/*
 * Класс модели комментариев
 *
 */
class CommentsModel extends Model
{
    /**
     * Количество отображаемых комментариев на странице
     * @int
     */
    const CommentsPerPage = 6;

    /**
     * Получает общее количество комментариев в базе
     *
     * @return int | bool
     */
    public function getPostsCount()
    {
        if ($res = $this->db->query("SELECT COUNT(id) FROM comments")) {
            $result = $res->fetch_row();
            return $result[0];
        }
        return false;
    }

    /**
     * Подсчет количества страниц с учетом количества комментариев на страницу
     *
     * @return int | bool
     */
    public function getPagesCount()
    {
        return ceil($this->getPostsCount() / self::CommentsPerPage);
    }

    /**
     * Выборка комментариев для отображения на указанной странице
     *
     * @param $pageNum int
     * @return array
     */
    public function getCommentsByPage($pageNum)
    {
        $commentsPerPage = self::CommentsPerPage;
        $startPost =  $commentsPerPage * $pageNum - $commentsPerPage;

        $query = "SELECT name, email, date, title, comment
            FROM comments  
            ORDER BY id DESC 
            LIMIT {$commentsPerPage} OFFSET {$startPost}";

        if ($res = $this->db->query($query)) {
            $result = $res->fetch_all(MYSQLI_ASSOC);
            return $result;
        }

        return [];
    }

    /**
     * Сохранение комментария в базу
     *
     * @param $postsArr array Данные комментария
     * @return string
     */
    public function saveComment(array $commentData)
    {
        /* подготовка запроса для вставки данных в mysql */
        $commentData['comment'] = mysqli_real_escape_string($this->db->getDbInstatce(), $commentData['comment']);
        $values = '(\''.implode('\',\'',array_values($commentData))."')";
        $keys = '('.implode(',', array_keys($commentData)).')';

        if ($values == '')
            return 'nn';

        $query = "INSERT INTO comments $keys VALUES $values";
        if ($this->db->query($query)) {
            return 'ok';
        }

        return 'error: ' . $this->db->getDbInstatce()->error;
    }
}