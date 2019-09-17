<?php

class State {
    public static function save()
    {
        $geo = new Geo();
        // Проверка user-agent пользователя
        // Не принимаем поисковых ботов
        if ($geo->is_valid_user_agent()) {
            $ip = $geo->get_ip();
            $cityId = false;

            if (isset($_COOKIE['geobase'])) {
                // Если данные о пользователе сохранены в куки
                $geo = unserialize($_COOKIE['geobase']);
                $cityId = $geo['city_id'];
            } else {
                // Проверка IP на валидность
                if ($geo->is_valid_ip($ip)) {
                    $data = $geo->get_value();
                    $cityId = $data['city_id'];
                }
            }
            // Город не был определен
            if ($cityId) {
                self::insertToDB($ip, $cityId);
            }
        }
    }

    public static function insertToDB($ip, $idCity)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `geo__stat`(`ip`, `idCity`) VALUES(:ip, :idCity);';
        $result = $db->prepare($sql);
        $result->bindParam(':ip', $ip, PDO::PARAM_STR);
        $result->bindParam(':idCity', $idCity, PDO::PARAM_INT);

        return $result->execute();
    }
}