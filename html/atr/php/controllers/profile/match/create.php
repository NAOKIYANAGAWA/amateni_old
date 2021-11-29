<?php
namespace controller\profile\match\create;

use lib\Auth;
use lib\Msg;
use Throwable;
use db\DataSource;
use model\UserModel;
use db\profile\MatchQuery;
use model\profile\MatchModel;
use model\profile\match\scoreModel;

function get()
{
    Auth::requireLogin();

    $match = MatchModel::getSessionAndFlush();
    $score = ScoreModel::getSessionAndFlush();

    if (empty($match)) {
        $match = new MatchQuery;
        $match->id = -1;
        $match->opponent_id = 0;
        $match->match_type = 0;
        $match->win_flg = 0;
    }

    if (empty($score)) {
        $score = new ScoreModel;
        $score->match_id = 0;
        $score->set_point_user = 0;
        $score->set_point_opponent = 0;
        $score->first_set_game_point_user = 0;
        $score->first_set_game_point_opponent = 0;
        $score->second_set_game_point_user = 0;
        $score->second_set_game_point_opponent = 0;
        $score->third_set_game_point_user = 0;
        $score->third_set_game_point_opponent = 0;
        $score->fourth_set_game_point_user = 0;
        $score->fourth_set_game_point_opponent = 0;
        $score->fifth_set_game_point_user = 0;
        $score->fifth_set_game_point_opponent = 0;
    }

    \view\profile\match\edit\index($match, $score, false);
}

function post()
{
    Auth::requireLogin();

    $match = new MatchModel;
    $match->id = get_param('id', null);
    $match->opponent_id = get_param('opponent_id', null);
    $match->match_type = get_param('match_type', null);
    $match->win_flg = get_param('win_flg', null);

    $score = new scoreModel;
    $score->match_id = get_param('id', null);
    $score->set_point_user = get_param('set_point_user', null);
    $score->set_point_opponent = get_param('set_point_opponent', null);
    $score->first_set_game_point_user = get_param('first_set_game_point_user', null);
    $score->first_set_game_point_opponent = get_param('first_set_game_point_opponent', null);
    $score->second_set_game_point_user = get_param('second_set_game_point_user', null);
    $score->second_set_game_point_opponent = get_param('second_set_game_point_opponent', null);
    $score->third_set_game_point_user = get_param('third_set_game_point_user', null);
    $score->third_set_game_point_opponent = get_param('third_set_game_point_opponent', null);
    $score->fourth_set_game_point_user = get_param('fourth_set_game_point_user', null);
    $score->fourth_set_game_point_opponent = get_param('fourth_set_game_point_opponent', null);
    $score->fifth_set_game_point_user = get_param('fifth_set_game_point_user', null);
    $score->fifth_set_game_point_opponent = get_param('fifth_set_game_point_opponent', null);

    try {
        $user = UserModel::getSession();

        $db = new DataSource;

        $db->begin();

        $is_success = MatchQuery::insert($match, $score, $user, $db);
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
        $is_success = false;
    }

    if ($is_success) {
        $db->commit();
        Msg::push(Msg::INFO, '試合の登録に成功しました。');
        redirect('profile/match');
    } else {
        $db->rollback();
        Msg::push(Msg::ERROR, '試合の登録に失敗しました。');
        MatchModel::setSession($match);
        ScoreModel::setSession($score);
        redirect(GO_REFERER);
    }
}
