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
//            $html .= '<a href="single_activity.php?activity_id=' . $row['activity_id'] . '">';
            $html .= '<div class="activity-select" data-activity-id="' . $row['activity_id'] . '">';
            $html .= '<h5>' . $row['activity_name'] . '</h5>';
            $html .= '<span>Datum: ' . $row['date_planned'] . ' / Leden: ' . $this->amountMembers($row['activity_id']) . '</span>';
            $html .= '</div>';
//            $html .= '</a>';
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

}
