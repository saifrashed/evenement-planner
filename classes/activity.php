<?php
/**
 * User: saifeddine
 * Date: 2019-02-20
 * Time: 13:25
 */

include 'handler.php';

/**
 * The activity class handles the display of activities archive and has a few getters and setter to receive data from activities
 *
 *
 * @author   Saif Rashed <saifeddinerashed@icloud.com>
 * @version  1
 * @access   public
 */
class Activity extends Handler {

    public function displayArchive() {
        $result = $this->readsData('SELECT * FROM activity;');
        $html   = '';

        while ($row = $result->fetch()) {
            $html .= '<div class="activity-select" data-activity-name="' . $row['activity_name'] . '" data-activity-id="' . $row['activity_id'] . '">';
            $html .= '<h5>' . $row['activity_name'] . '</h5>';
            $html .= '<span>Datum: ' . $row['date_planned'] . ' / Leden: ' . $this->amountMembers($row['activity_id']) . '</span>';
            $html .= '</div>';
        }

        return $html;
    }

    public function displaySingle($productId) {
        $row = $this->readsData('SELECT * FROM activity WHERE activity_id=' . $productId . ';')->fetch();

        $html = '<h2>' . $row['activity_name'] . '</h2>';
        return $html;
    }

    public function amountMembers($activityid) {
        $result = $this->readsData('SELECT COUNT(*) AS memberAmount FROM users, activity, user_activity WHERE activity.activity_id=' . $activityid . ' 
                                            AND user_activity.activity_id=' . $activityid . '
                                            AND users.id=user_activity.user_id;');

        $amount = $result->fetch();

        return $amount['memberAmount'];
    }

    /**
     * Gets the user assigned todolist and displays it on the dash
     *
     * @param $activityid
     * @param $userId
     * @return string
     */
    public function getMemberActivities($activityid, $userId) {
        $result = $this->readsData('SELECT DISTINCT activity_todo.description AS "title", categories.description, status.description 
                                          FROM users, activity, activity_todo, categories, status 
                                          WHERE activity_todo.user_id="'.$userId.'" AND activity_todo.activity_id="'.$activityid.'"
                                          AND activity_todo.cat_id=categories.cat_id AND activity_todo.status_id=status.status_id;');
        $html   = '';

        while ($row = $result->fetch()) {
            $html .= '<div class="activity-select">';
            $html .= '<h5>' . $row['title'] . '</h5>';
            $html .= '</div>';
        }

        return $html;
    }

}
