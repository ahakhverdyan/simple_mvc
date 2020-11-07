<?php


class News
{

    public static function getNewsItemById($id) {
        $id = intval($id);
        $newItem = [];

        if($id) {
            $db = Db::getConnection();

            $sql = 'SELECT * FROM `product` WHERE id=:id';
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();
            $newItem = $result->fetch();
        }

        return $newItem;
    }

    public static function getNewsList() {
        $db = Db::getConnection();
        $result = $db->query('SELECT * FROM `product` ORDER BY id DESC LIMIT 10');
        $newsList = [];

        $i = 0;
        while ($row = $result->fetch()) {
            $newsList[$i] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'price' => $row['price'],
            ];

            $i++;
        }
        
        return $newsList;
    }
}