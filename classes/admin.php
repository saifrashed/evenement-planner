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
        $html        = '<table class="table">';
        $id          = ($type == 'user' ? 'id' : 'activity_id');

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
                $html .= ($key === 'activity_description' ? '<td>' . $this->limitSummary($value, 5) . ' ...</td>' : '<td>' . $value . '</td>');
            }

            $html .= '<td><a href="admin_form.php?fieldset=' . $type . '&' . $type . '_id=' . $row[$id] . '" class="btn btn-secondary" style="width: 100%;"><i class="fas fa-pencil-alt action-icons"></i> Update </a></td>';

            $html .= '<td><form action="./includes/form_handling.php" method="GET">';
            $html .= '<input type="hidden" name="operation" value="delete_' . $type . '" />';
            $html .= '<input type="hidden" name="id" value="' . ($type == 'user' ? $row['id'] : $row['activity_id']) . '" />';
            $html .= '<button type="submit" class="btn btn-danger" style="width: 100%;">';
            $html .= '<i class="fas fa-times action-icons"></i></button></form></td>';


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
     */

    public function displayActivityTable() {
        $result = $this->readsData('SELECT * FROM activity;');
        return $this->createTable($result, 'activity');
    }

    public function displayUserTable() {
        $result = $this->readsData('SELECT users.id, users.fname, users.lname, users.email, gender.description AS "geslacht", role.description AS "rol" FROM users, role, gender WHERE users.role=role.role_id AND users.gender=gender.gender_id;');
        return $this->createTable($result, 'user');
    }

    /**
     * Update methods
     */

    public function updateActivity($activityId, $title, $description, $date, $deleteUsers = [], $addUsers = []) {

        echo var_dump($deleteUsers);
        echo var_dump($addUsers);

        if ($addUsers !== null) {
            foreach ($addUsers as $userId) {
                $this->updateData('INSERT INTO user_activity (user_id, activity_id) VALUES (' . $userId . ',' . $activityId . ')');
            }
        }

        if ($deleteUsers !== null) {
            foreach ($deleteUsers as $userId) {
                $this->updateData('DELETE FROM user_activity WHERE user_id=' . $userId . ' AND activity_id=' . $activityId . ';');
            }
        }


        $result = $this->updateData('UPDATE activity SET activity_name = "' . $title . '", activity_description = "' . $description . '", date_planned="' . $date . '" WHERE activity_id=' . $activityId . ';');
    }

    /**
     * Add methods
     */

    public function addActivity($activityName, $activityDesc, $plannedDate) {
        $currentDate = date('Y-m-d');
        $result = $this->createData('INSERT INTO activity (activity_name, activity_description, date_planned, date_created) VALUES ("'.$activityName.'", "'.$activityDesc.'", "'.$plannedDate.'", "'.$currentDate.'");');
    }

    /**
     * Delete methods
     */

    public function deleteActivity($activityId) {
        $result = $this->deleteData('DELETE FROM activity WHERE activity_id=' . $activityId . ';');
    }

    public function deleteUser($userId) {
        $result = $this->deleteData('DELETE FROM users WHERE id="' . $userId . '";');
    }


    /**
     * Forms
     */

    public function displayActivityForm($activityId) {
        $activityData   = $this->readsData('SELECT * FROM activity WHERE activity_id=' . $activityId . ';')->fetch();
        $activeUsers    = $this->readsData('SELECT users.id ,users.fname, users.lname, users.email FROM users, activity, user_activity WHERE activity.activity_id=' . $activityId . ' AND user_activity.activity_id=' . $activityId . ' AND users.id=user_activity.user_id;');
        $nonActiveUsers = $this->readsData('SELECT DISTINCT users.id ,users.fname, users.lname, users.email FROM users, activity, user_activity');

        $deleteUsersSelection = '';
        $addUsersSelection    = '';

        while ($row = $activeUsers->fetch()) {
            $deleteUsersSelection .= '<option value="' . $row['id'] . '">' . $row['fname'] . ' ' . $row['lname'] . '</option>';
        }

        while ($row = $nonActiveUsers->fetch()) {
            $addUsersSelection .= '<option value="' . $row['id'] . '">' . $row['fname'] . ' ' . $row['lname'] . '</option>';
        }

        return <<<HTML
         <h1>Update: activiteit {$activityId}</h1>
                    <form action="./includes/form_handling.php" method="GET">
                        <input type="hidden" name="operation" value="update_activity">
                        <input type="hidden" name="id" value="{$activityId}">
                    
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" value="{$activityData['activity_name']}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" value="{$row['activity_description']}" rows="3">{$activityData['activity_description']}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Datum</label>
                            <input type="text" name="date" value="{$activityData['date_planned']}" class="form-control" placeholder="yyyy-mm-dd">
                        </div>
                              
                        <div class="form-group">
                            <label>Voeg gebruiker toe aan activiteit</label>
                            <select multiple class="form-control" name="add-users[]">
                              {$addUsersSelection}
                            </select>
                          </div>
                          
                          <div class="form-group">
                            <label>Verwijder gebruiker van activiteit</label>
                            <select multiple class="form-control" name="delete-users[]">
                              {$deleteUsersSelection}
                            </select>
                          </div>
                          
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
HTML;
    }

    public function displayUserForm($userId) {
        $user = $this->readsData('SELECT * FROM users WHERE id=' . $userId . ';')->fetch();


        return <<<HTML
         <h1>Update: {$user['fname']} {$user['lname']}</h1>
                    <form action="./includes/form_handling.php" method="GET">
                        <input type="hidden" name="id" value="{$userId}">
                          <div class="form-group">
                            <label>Voeg toe aan activiteiten</label>
                            <select multiple class="form-control">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                            </select>
                          </div>
                        
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
HTML;
    }

    /**
     * Add forms
     */

    public function addActivityForm() {


        return <<<HTML
         <h1>Voeg nieuwe activiteit toe</h1>
                    <form action="./includes/form_handling.php" method="GET">
                        <input type="hidden" name="operation" value="add_activity">

                        <div class="form-group">
                            <label>Activiteit naam</label>
                            <input type="text" name="activity_name" placeholder="Activity name" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Activiteit beschrijving</label>
                            <textarea class="form-control" name="activity_desc" placeholder="Activity description"  rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Datum activiteit</label>
                            <input type="text" name="planned_date"  class="form-control" placeholder="yyyy-mm-dd">
                        </div>

                        <button type="submit" class="btn btn-primary">Voeg toe</button>
                    </form>
HTML;
    }

    public function addUserForm() {
        return <<<HTML
         <h1>Voeg nieuwe gebruiker toe</h1>
                    <form action='includes/registration.php' method='POST' class="register-form">
                        <input type="hidden" name="operation" value="add_user">

                        <div class="form-group">
                            <label>Voornaam</label>
                            <input class="form-control" type="text" name="fname" placeholder="First name" maxlength="50"/>
                        </div>
                        
                        <div class="form-group">
                            <label>Achternaam</label>
                            <input class="form-control" type="text" name='lname' placeholder="Last name" maxlength="50"/>
                        </div>
                        
                        <div class="form-group">
                            <label>Wachtwoord</label>
                            <input class="form-control" type="password" name='password' placeholder="password" maxlength="50"/>
                        </div>
                        
                        <div class="form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="email" name='email' placeholder="Email address" maxlength="50"/>
                        </div>
                        
                        <div class="form-group">
                            <label> <input type="radio" name="gender" value="male"> Man</label>
                            <label> <input type="radio" name="gender" value="female"> Vrouw</label>
                        </div>
                              
                        
                        <button type="submit" class="btn btn-primary">Voeg toe</button>
                    </form>
HTML;
    }

    /**
     * Basic methods
     */

    public function limitSummary($string, $limit) {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $limit));
    }

}
