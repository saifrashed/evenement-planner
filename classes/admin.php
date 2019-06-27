<?php
/**
 * User: saifeddine
 * Date: 2019-02-20
 * Time: 13:25
 */

include 'handler.php';

/**
 * The admin class handles admin control and functionality
 *
 *
 * @author   Saif Rashed <saifeddinerashed@icloud.com>
 * @version  1
 * @access   public
 */
class Admin extends Handler {

    /**
     * Returns bootstrap table of given sql query.
     *
     * @param $result
     * @return string
     */
    public function createTable($result, $type) {
        $tableHeader = true;
        $html        = '';
        $html        .= '<table class="table">';
        $id          = '';

        if ($type == 'user') {
            $id = 'id';
        } else {
            $id = 'activity_id';
        }

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if ($tableHeader) {
                $html .= '<tr>';

                foreach ($row as $key => $value) {
                    $html .= '<th>' . $key . '</th>';
                }

                $html        .= '<th colspan="3" style="text-align: center;">Actions</th>';
                $html        .= '</tr>';
                $tableHeader = !$tableHeader;
            }

            $html .= '<tr>';

            foreach ($row as $key => $value) {
                if ($key === 'activity_description') {
                    $html .= '<td>' . $this->limitSummary($value, 5) . ' ...</td>';
                } else {
                    $html .= '<td>' . $value . '</td>';
                }
            }

            $html .= '<td><a href="admin_form.php?fieldset=' . $type . '&' . $type . '_id=' . $row[$id] . '" class="btn btn-secondary" style="width: 100%;"><i class="fas fa-pencil-alt action-icons"></i> Update </a></td>';

            if ($type == 'user') {
                $html .= '<td><form action="./includes/form_handling.php" method="GET">';
                $html .= '<input type="hidden" name="operation" value="delete" />';
                $html .= '<input type="hidden" name="id" value="' . $row['activity_id'] . '" />';
                $html .= '<button type="submit" class="btn btn-danger" style="width: 100%;">';
                $html .= '<i class="fas fa-times action-icons"></i></button></form></td>';

            } else {
                $html .= '<td><form action="./includes/form_handling.php" method="GET">';
                $html .= '<input type="hidden" name="operation" value="delete_activity" />';
                $html .= '<input type="hidden" name="id" value="' . $row['activity_id'] . '" />';
                $html .= '<button type="submit" class="btn btn-danger" style="width: 100%;">';
                $html .= '<i class="fas fa-times action-icons"></i></button></form></td>';
            }

            $html .= '</tr>';
        }

        $html .= '</table>';


        return $html;
    }


    /**
     * Getters
     */

    public function amountUsers() {
        $result = $this->readsData('SELECT COUNT(*) AS "amount" FROM users;')->fetch();
        return $result;
    }

    public function amountActivities() {
        $result = $this->readsData('SELECT COUNT(*) AS "amount" FROM activity;')->fetch();
        return $result;
    }

    /**
     * Admin tables
     *
     * @return string
     */

    public function displayActivityTable() {
        $result = $this->readsData('SELECT * FROM activity;');
        return $this->createTable($result, 'activity');
    }

    public function displayUserTable() {
        $result = $this->readsData('SELECT users.id, users.fname, users.lname, users.email, gender.description AS "geslacht", role.description AS "rol" FROM users, role, gender 
                                          WHERE users.role=role.role_id AND users.gender=gender.gender_id;');
        return $this->createTable($result, 'user');
    }

    /**
     * Update functions
     */

    public function updateActivity($activityId, $title, $description, $date) {
        $result = $this->updateData('UPDATE activity SET activity_name = "' . $title . '", activity_description = "' . $description . '", date_planned="' . $date . '" WHERE activity_id=' . $activityId . ';');
    }

    /**
     * Delete functions
     */

    public function deleteActivity($activityId) {
        $result = $this->deleteData('DELETE FROM activity WHERE activity_id=' . $activityId . ';');
    }


    /**
     * Forms
     */

    public function updateActivityForm($activityId) {
        $row = $this->readsData('SELECT * FROM activity WHERE activity_id=' . $activityId . ';')->fetch();

        return <<<HTML
         <h1>Update: activiteit {$activityId}</h1>
                    <form action="./includes/form_handling.php" method="GET">
                        <input type="hidden" name="operation" value="update_activity">
                        <input type="hidden" name="id" value="{$activityId}">
                    
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" value="{$row['activity_name']}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" value="{$row['activity_description']}" rows="3">{$row['activity_description']}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Datum</label>
                            <input type="text" name="date" value="{$row['date_planned']}" class="form-control" placeholder="yyyy-mm-dd">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
HTML;
    }

    public function updateUserForm($userId) {
        $row = $this->readsData('SELECT * FROM users WHERE id=' . $userId . ';')->fetch();

        return <<<HTML
         <h1>Update: gebruiker {$userId}</h1>
                    <form action="./includes/form_handling.php" method="GET">
                        <div class="form-group">
                            <label>first name</label>
                            <input type="text" value="{$row['fname']}" class="form-control">
                              <label>Last name</label>
                            <input type="text" value="{$row['lname']}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3">{$row['activity_description']}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Datum</label>
                            <input type="text" value="{$row['date_planned']}" class="form-control" placeholder="yyyy-mm-dd">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
HTML;
    }

    /**
     * Basic functions
     */

    public function limitSummary($string, $limit) {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $limit));
    }

}
