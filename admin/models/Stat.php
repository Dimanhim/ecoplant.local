<?php

class Stat
{
    public static function getViewTodaySQL()
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM
        (SELECT COUNT(`id`) as 'c0' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '00:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '01:00:00')) as table01,
        (SELECT COUNT(`id`) as 'c1' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '01:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '02:00:00')) as table12,
        (SELECT COUNT(`id`) as 'c2' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '02:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '03:00:00')) as table23,
        (SELECT COUNT(`id`) as 'c3' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '03:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '04:00:00')) as table34,
        (SELECT COUNT(`id`) as 'c4' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '04:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '05:00:00')) as table45,
        (SELECT COUNT(`id`) as 'c5' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '05:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '06:00:00')) as table56,
        (SELECT COUNT(`id`) as 'c6' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '06:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '07:00:00')) as table67,
        (SELECT COUNT(`id`) as 'c7' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '07:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '08:00:00')) as table78,
        (SELECT COUNT(`id`) as 'c8' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '08:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '09:00:00')) as table89,
        (SELECT COUNT(`id`) as 'c9' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '09:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '10:00:00')) as table910,
        (SELECT COUNT(`id`) as 'c10' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '10:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '11:00:00')) as table1011,
        (SELECT COUNT(`id`) as 'c11' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '11:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '12:00:00')) as table1112,
        (SELECT COUNT(`id`) as 'c12' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '12:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '13:00:00')) as table1213,
        (SELECT COUNT(`id`) as 'c13' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '13:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '14:00:00')) as table1314,
        (SELECT COUNT(`id`) as 'c14' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '14:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '15:00:00')) as table1415,
        (SELECT COUNT(`id`) as 'c15' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '15:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '16:00:00')) as table1516,
        (SELECT COUNT(`id`) as 'c16' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '16:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '17:00:00')) as table1617,
        (SELECT COUNT(`id`) as 'c17' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '17:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '18:00:00')) as table1718,
        (SELECT COUNT(`id`) as 'c18' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '18:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '19:00:00')) as table1819,
        (SELECT COUNT(`id`) as 'c19' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '19:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '20:00:00')) as table1920,
        (SELECT COUNT(`id`) as 'c20' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '20:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '21:00:00')) as table2021,
        (SELECT COUNT(`id`) as 'c21' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '21:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '22:00:00')) as table2122,
        (SELECT COUNT(`id`) as 'c22' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '22:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '23:00:00')) as table2223,
        (SELECT COUNT(`id`) as 'c23' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '23:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '23:59:59')) as table2324;";
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getUserTodaySQL()
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM
        (SELECT COUNT(DISTINCT `ip`) as 'c0' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '00:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '01:00:00')) as table01,
        (SELECT COUNT(DISTINCT `ip`) as 'c1' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '01:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '02:00:00')) as table12,
        (SELECT COUNT(DISTINCT `ip`) as 'c2' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '02:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '03:00:00')) as table23,
        (SELECT COUNT(DISTINCT `ip`) as 'c3' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '03:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '04:00:00')) as table34,
        (SELECT COUNT(DISTINCT `ip`) as 'c4' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '04:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '05:00:00')) as table45,
        (SELECT COUNT(DISTINCT `ip`) as 'c5' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '05:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '06:00:00')) as table56,
        (SELECT COUNT(DISTINCT `ip`) as 'c6' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '06:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '07:00:00')) as table67,
        (SELECT COUNT(DISTINCT `ip`) as 'c7' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '07:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '08:00:00')) as table78,
        (SELECT COUNT(DISTINCT `ip`) as 'c8' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '08:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '09:00:00')) as table89,
        (SELECT COUNT(DISTINCT `ip`) as 'c9' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '09:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '10:00:00')) as table910,
        (SELECT COUNT(DISTINCT `ip`) as 'c10' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '10:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '11:00:00')) as table1011,
        (SELECT COUNT(DISTINCT `ip`) as 'c11' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '11:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '12:00:00')) as table1112,
        (SELECT COUNT(DISTINCT `ip`) as 'c12' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '12:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '13:00:00')) as table1213,
        (SELECT COUNT(DISTINCT `ip`) as 'c13' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '13:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '14:00:00')) as table1314,
        (SELECT COUNT(DISTINCT `ip`) as 'c14' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '14:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '15:00:00')) as table1415,
        (SELECT COUNT(DISTINCT `ip`) as 'c15' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '15:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '16:00:00')) as table1516,
        (SELECT COUNT(DISTINCT `ip`) as 'c16' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '16:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '17:00:00')) as table1617,
        (SELECT COUNT(DISTINCT `ip`) as 'c17' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '17:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '18:00:00')) as table1718,
        (SELECT COUNT(DISTINCT `ip`) as 'c18' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '18:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '19:00:00')) as table1819,
        (SELECT COUNT(DISTINCT `ip`) as 'c19' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '19:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '20:00:00')) as table1920,
        (SELECT COUNT(DISTINCT `ip`) as 'c20' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '20:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '21:00:00')) as table2021,
        (SELECT COUNT(DISTINCT `ip`) as 'c21' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '21:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '22:00:00')) as table2122,
        (SELECT COUNT(DISTINCT `ip`) as 'c22' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '22:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '23:00:00')) as table2223,
        (SELECT COUNT(DISTINCT `ip`) as 'c23' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE(), '23:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE(), '23:59:59')) as table2324;";
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getViewYesterdaySQL()
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM
        (SELECT COUNT(`id`) as 'c0' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '00:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '01:00:00')) as table01,
        (SELECT COUNT(`id`) as 'c1' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '01:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '02:00:00')) as table12,
        (SELECT COUNT(`id`) as 'c2' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '02:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '03:00:00')) as table23,
        (SELECT COUNT(`id`) as 'c3' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '03:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '04:00:00')) as table34,
        (SELECT COUNT(`id`) as 'c4' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '04:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '05:00:00')) as table45,
        (SELECT COUNT(`id`) as 'c5' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '05:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '06:00:00')) as table56,
        (SELECT COUNT(`id`) as 'c6' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '06:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '07:00:00')) as table67,
        (SELECT COUNT(`id`) as 'c7' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '07:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '08:00:00')) as table78,
        (SELECT COUNT(`id`) as 'c8' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '08:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '09:00:00')) as table89,
        (SELECT COUNT(`id`) as 'c9' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '09:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '10:00:00')) as table910,
        (SELECT COUNT(`id`) as 'c10' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '10:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '11:00:00')) as table1011,
        (SELECT COUNT(`id`) as 'c11' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '11:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '12:00:00')) as table1112,
        (SELECT COUNT(`id`) as 'c12' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '12:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '13:00:00')) as table1213,
        (SELECT COUNT(`id`) as 'c13' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '13:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '14:00:00')) as table1314,
        (SELECT COUNT(`id`) as 'c14' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '14:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '15:00:00')) as table1415,
        (SELECT COUNT(`id`) as 'c15' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '15:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '16:00:00')) as table1516,
        (SELECT COUNT(`id`) as 'c16' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '16:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '17:00:00')) as table1617,
        (SELECT COUNT(`id`) as 'c17' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '17:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '18:00:00')) as table1718,
        (SELECT COUNT(`id`) as 'c18' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '18:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '19:00:00')) as table1819,
        (SELECT COUNT(`id`) as 'c19' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '19:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '20:00:00')) as table1920,
        (SELECT COUNT(`id`) as 'c20' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '20:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '21:00:00')) as table2021,
        (SELECT COUNT(`id`) as 'c21' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '21:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '22:00:00')) as table2122,
        (SELECT COUNT(`id`) as 'c22' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '22:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '23:00:00')) as table2223,
        (SELECT COUNT(`id`) as 'c23' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '23:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '23:59:59')) as table2324;";
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getUserYesterdaySQL()
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM
        (SELECT COUNT(DISTINCT `ip`) as 'c0' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '00:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '01:00:00')) as table01,
        (SELECT COUNT(DISTINCT `ip`) as 'c1' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '01:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '02:00:00')) as table12,
        (SELECT COUNT(DISTINCT `ip`) as 'c2' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '02:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '03:00:00')) as table23,
        (SELECT COUNT(DISTINCT `ip`) as 'c3' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '03:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '04:00:00')) as table34,
        (SELECT COUNT(DISTINCT `ip`) as 'c4' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '04:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '05:00:00')) as table45,
        (SELECT COUNT(DISTINCT `ip`) as 'c5' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '05:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '06:00:00')) as table56,
        (SELECT COUNT(DISTINCT `ip`) as 'c6' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '06:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '07:00:00')) as table67,
        (SELECT COUNT(DISTINCT `ip`) as 'c7' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '07:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '08:00:00')) as table78,
        (SELECT COUNT(DISTINCT `ip`) as 'c8' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '08:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '09:00:00')) as table89,
        (SELECT COUNT(DISTINCT `ip`) as 'c9' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '09:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '10:00:00')) as table910,
        (SELECT COUNT(DISTINCT `ip`) as 'c10' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '10:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '11:00:00')) as table1011,
        (SELECT COUNT(DISTINCT `ip`) as 'c11' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '11:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '12:00:00')) as table1112,
        (SELECT COUNT(DISTINCT `ip`) as 'c12' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '12:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '13:00:00')) as table1213,
        (SELECT COUNT(DISTINCT `ip`) as 'c13' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '13:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '14:00:00')) as table1314,
        (SELECT COUNT(DISTINCT `ip`) as 'c14' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '14:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '15:00:00')) as table1415,
        (SELECT COUNT(DISTINCT `ip`) as 'c15' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '15:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '16:00:00')) as table1516,
        (SELECT COUNT(DISTINCT `ip`) as 'c16' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '16:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '17:00:00')) as table1617,
        (SELECT COUNT(DISTINCT `ip`) as 'c17' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '17:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '18:00:00')) as table1718,
        (SELECT COUNT(DISTINCT `ip`) as 'c18' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '18:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '19:00:00')) as table1819,
        (SELECT COUNT(DISTINCT `ip`) as 'c19' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '19:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '20:00:00')) as table1920,
        (SELECT COUNT(DISTINCT `ip`) as 'c20' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '20:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '21:00:00')) as table2021,
        (SELECT COUNT(DISTINCT `ip`) as 'c21' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '21:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '22:00:00')) as table2122,
        (SELECT COUNT(DISTINCT `ip`) as 'c22' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '22:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '23:00:00')) as table2223,
        (SELECT COUNT(DISTINCT `ip`) as 'c23' FROM `geo__stat` WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '23:00:00') AND TIMESTAMP(`datetime`) < TIMESTAMP(CURDATE() - INTERVAL 1 DAY, '23:59:59')) as table2324;";
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getViewMonthSQL()
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM ";
        $maxDays = date('t');
        for ($i = 1; $i <= $maxDays; $i++) {
            $day = $i;

            if ($i < 10)
                $day = '0' . $day;

            $sql .= "(SELECT COUNT(`id`) as 'd$i' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-', MONTH(CURDATE()), '-$day'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-', MONTH(CURDATE()), '-$day'), '23:59:59')) as table$i,";
        }
        $sql = trim($sql, ',');
        $sql .= ";";
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getUserMonthSQL()
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM ";
        $maxDays = date('t');
        for ($i = 1; $i <= $maxDays; $i++) {
            $day = $i;

            if ($i < 10)
                $day = '0' . $day;

            $sql .= "(SELECT COUNT(DISTINCT `ip`) as 'd$i' 
                    FROM `geo__stat` 
                    WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-', MONTH(CURDATE()), '-$day'), '00:00:00') 
                      AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-', MONTH(CURDATE()), '-$day'), '23:59:59')) as table$i,";
        }
        $sql = trim($sql, ',');
        $sql .= ";";
        $result = $db->prepare($sql);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getViewYearSQL()
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM
                (SELECT COUNT(`id`) as 'm1' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-01-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-02-01'), '00:00:00')) as table1,
                (SELECT COUNT(`id`) as 'm2' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-02-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-03-01'), '00:00:00')) as table2,
                (SELECT COUNT(`id`) as 'm3' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-03-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-04-01'), '00:00:00')) as table3,
                (SELECT COUNT(`id`) as 'm4' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-04-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-05-01'), '00:00:00')) as table4,
                (SELECT COUNT(`id`) as 'm5' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-05-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-06-01'), '00:00:00')) as table5,
                (SELECT COUNT(`id`) as 'm6' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-06-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-07-01'), '00:00:00')) as table6,
                (SELECT COUNT(`id`) as 'm7' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-07-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-08-01'), '00:00:00')) as table7,
                (SELECT COUNT(`id`) as 'm8' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-08-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-09-01'), '00:00:00')) as table8,
                (SELECT COUNT(`id`) as 'm9' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-09-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-10-01'), '00:00:00')) as table9,
                (SELECT COUNT(`id`) as 'm10' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-10-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-11-01'), '00:00:00')) as table10,
                (SELECT COUNT(`id`) as 'm11' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-11-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-12-01'), '00:00:00')) as table11,
                (SELECT COUNT(`id`) as 'm12' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-12-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-12-31'), '00:00:00')) as table12;";
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getUserYearSQL()
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM
                (SELECT COUNT(DISTINCT `ip`) as 'm1' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-01-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-02-01'), '00:00:00')) as table1,
                (SELECT COUNT(DISTINCT `ip`) as 'm2' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-02-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-03-01'), '00:00:00')) as table2,
                (SELECT COUNT(DISTINCT `ip`) as 'm3' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-03-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-04-01'), '00:00:00')) as table3,
                (SELECT COUNT(DISTINCT `ip`) as 'm4' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-04-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-05-01'), '00:00:00')) as table4,
                (SELECT COUNT(DISTINCT `ip`) as 'm5' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-05-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-06-01'), '00:00:00')) as table5,
                (SELECT COUNT(DISTINCT `ip`) as 'm6' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-06-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-07-01'), '00:00:00')) as table6,
                (SELECT COUNT(DISTINCT `ip`) as 'm7' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-07-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-08-01'), '00:00:00')) as table7,
                (SELECT COUNT(DISTINCT `ip`) as 'm8' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-08-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-09-01'), '00:00:00')) as table8,
                (SELECT COUNT(DISTINCT `ip`) as 'm9' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-09-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-10-01'), '00:00:00')) as table9,
                (SELECT COUNT(DISTINCT `ip`) as 'm10' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-10-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-11-01'), '00:00:00')) as table10,
                (SELECT COUNT(DISTINCT `ip`) as 'm11' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-11-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-12-01'), '00:00:00')) as table11,
                (SELECT COUNT(DISTINCT `ip`) as 'm12' 
                FROM `geo__stat` 
                WHERE TIMESTAMP(`datetime`) > TIMESTAMP(CONCAT(YEAR(CURDATE()), '-12-01'), '00:00:00') 
                  AND TIMESTAMP(`datetime`) < TIMESTAMP(CONCAT(YEAR(CURDATE()), '-12-31'), '00:00:00')) as table12;";
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getRegionSQL()
    {
        $db = Db::getConnection();

        $sql = "SELECT `region`, COUNT(`region`) as 'count' FROM (SELECT DISTINCT `ip`, `region`
                FROM `geo__stat`, `geo__cities`
                WHERE `geo__stat`.`idCity` = `geo__cities`.`city_id` AND YEAR(`datetime`) = YEAR(CURDATE())) as tableRegion
                GROUP BY `region` ORDER BY `count` DESC;";
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}