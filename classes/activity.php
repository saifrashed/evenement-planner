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
            $html .= '<a href="?activityId=' . $row['activity_id'] . '"><div class="activity-select" data-activity-name="' . $row['activity_name'] . '" data-activity-id="' . $row['activity_id'] . '">';
            $html .= '<h5>' . $row['activity_name'] . '</h5>';
            $html .= '<span>Datum: ' . $row['date_planned'] . ' / Leden: ' . $this->amountMembers($row['activity_id']) . '</span>';
            $html .= '</div></a>';
        }

        return $html;
    }

    public function displayMembers($activityId) {

        if ($this->amountMembers($activityId) == 0) {
            return 'Geen leden in dit activiteit';
        } else {
            $result = $this->readsData('SELECT users.id ,users.fname, users.lname, users.email FROM users, activity, user_activity WHERE activity.activity_id=' . $activityId . ' 
                                            AND user_activity.activity_id=' . $activityId . '
                                            AND users.id=user_activity.user_id;');
            $html   = '';

            while ($row = $result->fetch()) {
                $html .= '<a href="?userId=' . $row['id'] . '"><div class="col-xs-12 activity-member-select">';
                $html .= '<h5>' . $row['fname'] . '</h5>';
                $html .= '<span>' . $row['email'] . '</span>';
                $html .= '</div></a>';
            }

            return $html;
        }
    }

    public function displaySingle($productId) {
        $row = $this->readsData('SELECT * FROM activity WHERE activity_id=' . $productId . ';')->fetch();

        $html = '<h2>' . $row['activity_name'] . '</h2>';
        return $html;
    }

    public function amountMembers($activityId) {
        $result = $this->readsData('SELECT COUNT(*) AS memberAmount FROM users, activity, user_activity WHERE activity.activity_id=' . $activityId . ' 
                                            AND user_activity.activity_id=' . $activityId . '
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
                                          WHERE activity_todo.user_id="' . $userId . '" AND activity_todo.activity_id="' . $activityid . '"
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
