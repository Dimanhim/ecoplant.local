<?php

class Check {
	public static function strLength($str, $lengthMin, $lengthMax = -1) {
		if ($lengthMax != -1) {
			if (mb_strlen($str) >= $lengthMin && mb_strlen($str) < $lengthMax) {
				return true;
			}
		} else {
			if (mb_strlen($str) >= $lengthMin) {
				return true;
			}
		}
		
		return false;
	}

	public static function valideEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        return true;
		}

		return false;
	}

    public static function isInt($int)
    {
        if ($int == 0 || $int == '0') {
            return true;
        }

        if ($int == '' || $int == null) {
            return false;
        }

        if (is_numeric($int)) {
            return true;
        }

        return false;
	}

    # Функция для определения параметров изображения
    # Возвращает массив параметров если файл изображение и FALSE при ошибке
    public static function get_image_info($file = NULL)
    {
        if(!is_file($file)) return false;

        if(!$data = getimagesize($file) or !$filesize = filesize($file)) return false;

        $extensions = array(1 => 'gif',     2 => 'jpg',
            3 => 'png',     4 => 'swf',
            5 => 'psd',     6 => 'bmp',
            7 => 'tiff',    8 => 'tiff',
            9 => 'jpc',     10 => 'jp2',
            11 => 'jpx',    12 => 'jb2',
            13 => 'swc',    14 => 'iff',
            15 => 'wbmp',   16 => 'xbmp');

        $result = array('width'     =>  $data[0],
                        'height'    =>  $data[1],
                        'extension' =>  $extensions[$data[2]],
                        'size'      =>  $filesize,
                        'mime'      =>  $data['mime']);

        return $result;
    }
}