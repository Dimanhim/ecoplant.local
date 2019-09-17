<?php

class Geo {

    var $ip;
    var $charset = 'utf-8';
    var $db;

    /**
     * Создаем объект с заданными настройками.
     * @param array $options
     * @return void
     */
    public function __construct(array $options = array()) {
        global $db;
        $db = Db::getConnection();

        // ip
        if (isset($options['ip']) && $this->is_valid_ip($options['ip'])) {
            $this->ip = $options['ip'];
        } else {
            $this->ip = $this->get_ip();
        }
        // кодировка
        if (isset($options['charset']) && is_string($options['charset'])) {
            $this->charset = $options['charset'];
        }
    }

    /**
     * функция возвращет конкретное значение из полученного массива данных по ip
     * @param string - ключ массива. Если интересует конкретное значение.
     * Ключ может быть равным 'inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng'
     * @param bolean - устанавливаем хранить данные в куки или нет
     * Если true, то в куки будут записаны данные по ip и повторные запросы на ipgeobase происходить не будут.
     * Если false, то данные постоянно будут запрашиваться с ipgeobase
     * @return array OR string - дополнительно читайте комментарии внутри функции.
     */
    public function get_value($key = null, $cookie = true) {
        $key_array = array('inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng');
        if (!in_array($key, $key_array)) {
            $key = null;
        }
        $data = $this->get_data($cookie);
        if ($key) { // если указан ключ
            if (isset($data[$key])) { // и значение есть в массиве данных
                return $data[$key]; // возвращаем строку с нужными данными
            } elseif ($cookie) { // иначе если были включены куки
                return $this->get_value($key, false); // пытаемся вернуть данные без использования cookie
            }
            return NULL; // если ничего нет - отдаем NULL
        }
        return $data; // иначе возвращаем массив со всеми данными
    }

    /**
     * Получаем данные с сервера или из cookie
     * @param boolean $cookie
     * @return string|array
     */
    public function get_data($cookie = true) {
        // если используем куки и параметр уже получен, то достаем и возвращаем данные из куки
        if ($cookie && filter_input(INPUT_COOKIE, 'geobase')) {
            return unserialize(filter_input(INPUT_COOKIE, 'geobase'));
        }
        $data = $this->get_geobase_data();
        if (!empty($data)) {
            setcookie('geobase', serialize($data), time() + 3600 * 24 * 7, '/'); //устанавливаем куки на неделю
        }
        return $data;
    }

    /**
     * функция получает данные по ip.
     * @return array - возвращает массив с данными
     */
    protected function get_geobase_data() {
        global $db;
        $long_ip = ip2long($this->ip);
        $result = $db->prepare("SELECT * FROM `geo__base` WHERE `long_ip1`<='$long_ip' AND `long_ip2`>='$long_ip' LIMIT 1;");
        $result->execute();
        $data = false;
        if ($result->rowCount())
        {
            $res1 = $result->fetch();
            $q = $db->prepare("SELECT * FROM `geo__cities` WHERE `city_id`='{$res1['city_id']}' LIMIT 1;");
            $q->execute();
            if ($q->rowCount())
            {
                $res2 = $q->fetch();
                $data = array_merge($res1, $res2);
            }
        }
        return $data;
    }

    /**
     * функция парсит полученные в XML данные в случае, если на сервере не установлено расширение Simplexml
     * @return array - возвращает массив с данными
     */
    protected function parse_string($string) {
        $params = array('inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng');
        $data = $out = array();
        foreach ($params as $param) {
            if (preg_match('#<' . $param . '>(.*)</' . $param . '>#is', $string, $out)) {
                $data[$param] = trim($out[1]);
            }
        }
        return $data;
    }

    /**
     * функция определяет ip адрес по глобальному массиву $_SERVER
     * ip адреса проверяются начиная с приоритетного, для определения возможного использования прокси
     * @return ip-адрес
     */
    public function get_ip() {
        $keys = array('HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR', 'HTTP_X_REAL_IP');
        foreach ($keys as $key) {
            $ip = trim(strtok(filter_input(INPUT_SERVER, $key), ','));
            if ($this->is_valid_ip($ip)) {
                return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
            }
        }
    }

    /**
     * функция для проверки валидности ip адреса
     * @param ip адрес в формате 1.2.3.4
     * @return bolean : true - если ip валидный, иначе false
     */
    public function is_valid_ip($ip) {
        return (bool)filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    public function is_valid_user_agent()
    {
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'Yandex')) {
            $bot = 'Yandex';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {
            $bot = 'Google';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot-Mobile')) {
            $bot = 'Googlebot-Mobile';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot-Image')) {
            $bot = 'Googlebot-Mobile';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'MSNBot-Products')) {
            $bot = 'MSNBot-Products-Google';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Mediapartners-Google')) {
            $bot = 'Mediapartners-Google (Adsense)';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Slurp')) {
            $bot = 'Hot&nbsp;Bot&nbsp;search';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'WebCrawler')) {
            $bot = 'WebCrawler&nbsp;search';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'ZyBorg')) {
            $bot = 'Wisenut&nbsp;search';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'scooter')) {
            $bot = 'AltaVista';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'StackRambler')) {
            $bot = 'Rambler';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Aport')) {
            $bot = 'Aport';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Mail.Ru')) {
            $bot = 'Mail.Ru';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'lycos')) {
            $bot = 'Lycos';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'WebAlta')) {
            $bot = 'WebAlta';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Teoma')) {
            $bot = 'Teoma';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'yahoo')) {
            $bot = 'Yahoo';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Yahoo! Slurp')) {
            $bot = 'Yahoo! Slurp';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'msnbot')) {
            $bot = 'msn';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'msnbot-media')) {
            $bot = 'msnbot-media';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'msnbot-news')) {
            $bot = 'msnbot-news';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'ia_archiver')) {
            $bot = 'Alexa search engine';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'FAST')) {
            $bot = 'AllTheWeb';
        } else {
            return true;
        }

        return false;
    }
}