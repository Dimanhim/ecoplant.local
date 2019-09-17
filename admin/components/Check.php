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
        if ($int == '' || $int == null) {
            return false;
        }

        if (is_numeric($int)) {
            return true;
        }

        return false;
	}
}