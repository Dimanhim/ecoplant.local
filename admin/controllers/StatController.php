<?php

class StatController
{
    public function actionToday() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_STAT, User::getId())) {
            Admin::accessDenied();
        }

        $statViewListSQL = Stat::getViewTodaySQL();
        $statUserListSQL = Stat::getUserTodaySQL();

        require_once(ROOT . '/views/stat/today.php');
        return true;
    }
    public function actionYesterday() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_STAT, User::getId())) {
            Admin::accessDenied();
        }

        $statViewListSQL = Stat::getViewYesterdaySQL();
        $statUserListSQL = Stat::getUserYesterdaySQL();

        require_once(ROOT . '/views/stat/yesterday.php');
        return true;
    }
    public function actionMonth() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_STAT, User::getId())) {
            Admin::accessDenied();
        }

        $statViewListSQL = Stat::getViewMonthSQL();
        $statUserListSQL = Stat::getUserMonthSQL();

        require_once(ROOT . '/views/stat/month.php');
        return true;
    }
    public function actionYear() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_STAT, User::getId())) {
            Admin::accessDenied();
        }

        $statViewListSQL = Stat::getViewYearSQL();
        $statUserListSQL = Stat::getUserYearSQL();

        require_once(ROOT . '/views/stat/year.php');
        return true;
    }
    public function actionRegion() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_STAT, User::getId())) {
            Admin::accessDenied();
        }

        $regionList = array();
        $regionListSQL = Stat::getRegionSQL();
        if ($regionListSQL) {
            $i = 0;
            while ($row = $regionListSQL->fetch()) {
                $regionList[$i]['region'] = $row['region'];
                $regionList[$i]['count'] = $row['count'];

                $i++;
            }
        }

        require_once(ROOT . '/views/stat/region.php');
        return true;
    }
}