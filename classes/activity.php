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

    public function displayVolunteerArchive($userId) {
        $result = $this->readsData('SELECT DISTINCT activity.activity_name, activity.activity_id, activity.date_planned FROM activity, users, user_activity WHERE user_activity.user_id=' . $userId . ' AND user_activity.activity_id=activity.activity_id;');
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
            return '<div class="selection-message">Geen leden in deze activiteit</div>';
        } else {
            $result = $this->readsData('SELECT users.id ,users.fname, users.lname, users.email FROM users, activity, user_activity WHERE activity.activity_id=' . $activityId . ' AND user_activity.activity_id=' . $activityId . ' AND users.id=user_activity.user_id;');
            $html   = '';

            while ($row = $result->fetch()) {
                $html .= '<div class="col-xs-12 activity-member-select">';
                $html .= '<h5>' . $row['fname'] . ' ' . $row['lname'] . '</h5>';
                $html .= '<span>' . $row['email'] . '</span>';
                $html .= '</div>';
            }

            return $html;
        }
    }

    public function displayTodos($activityId, $catId = null) {

        if ($catId !== null) {
            $activityTodos = $this->readsData('SELECT * FROM activity_todo WHERE activity_id="' . $activityId . '" AND cat_id="' . $catId . '";');
        } else {
            $activityTodos = $this->readsData('SELECT * FROM activity_todo WHERE activity_id=' . $activityId . ';');
        }

        $html = '';

        while ($row = $activityTodos->fetch()) {
            $html .= '<p>' . $row['title'] . '</p>';
        }

        return $html;
    }

    public function amountMembers($activityId) {
        $result = $this->readsData('SELECT COUNT(*) AS memberAmount FROM users, activity, user_activity WHERE activity.activity_id=' . $activityId . ' AND user_activity.activity_id=' . $activityId . ' AND users.id=user_activity.user_id;')->fetch();
        return $result['memberAmount'];
    }

    public function amountTodos($activityId) {
        $result = $this->readsData('SELECT COUNT(*) AS "amount_todos" FROM activity_todo WHERE activity_id="' . $activityId . '"')->fetch();
        return $result['amount_todos'];
    }

    public function activityDetail($column, $activityId) {
        $result = $this->readsData('SELECT * FROM activity WHERE activity_id="' . $activityId . '";')->fetch();
        return $result[$column];
    }


    /**
     * Gets the user assigned todolist and displays it on the dash
     *
     * @param $activityid
     * @param $userId
     * @return string
     */
    public function getMemberActivities($activityId, $userId, $role) {
        if ($role === 'beheerder') {
            $result = $this->readsData('SELECT DISTINCT * FROM activity_todo WHERE activity_todo.activity_id = ' . $activityId . ';');

        } else {
            $result = $this->readsData('SELECT DISTINCT * FROM activity_todo WHERE activity_todo.user_id = ' . $userId . ' AND activity_todo.activity_id = ' . $activityId . ';');
        }

        $html = '';

        while ($row = $result->fetch()) {
            $html .= '<a href="?activity_id=' . $activityId . '&todo_id=' . $row['todo_id'] . '"><div class="todo-select" data-todo-id="' . $row['todo_id'] . '" data-status-id="' . $this->getStatus($row['status_id']) . '">';
            $html .= '<h5>' . $row['title'] . '</h5>';
            $html .= '<span>' . $this->getCategory($row['cat_id']) . ' / ' . $this->getStatus($row['status_id']) . '</span>';
            $html .= '</div></a>';
        }

        return $html;
    }


    public function getDescription($todoId) {
        $status = $this->readsData('SELECT description FROM activity_todo WHERE todo_id = ' . $todoId . ';')->fetch();

        if ($status) {
            return $status['description'];
        } else {
            return 'Geen taak geselecteerd';
        }
    }

    public function getCategory($catId) {
        $status = $this->readsData('SELECT description FROM categories WHERE cat_id = ' . $catId . ';')->fetch();
        return $status['description'];
    }


    public function getStatus($statusId) {
        $status = $this->readsData('SELECT description FROM status WHERE status_id = ' . $statusId . ';')->fetch();
        return $status['description'];
    }

    public function getActivityTitle($activityId) {
        $activity = $this->readsData('SELECT * FROM activity WHERE activity_id=' . $activityId . ';')->fetch();
        return $activity['activity_name'];
    }


}
