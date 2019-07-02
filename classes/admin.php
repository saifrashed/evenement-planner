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

                if ($type === 'todo') {

                    if ($key === 'description') {
                        $html .= '<td>' . $this->limitSummary($value, 5) . ' ...</td>';
                    }

                    if ($key === 'title') {
                        $html .= '<td>' . $value . ' </td>';
                    }

                    if ($key === 'todo_id') {
                        $html .= '<td>' . $value . ' </td>';
                    }

                    if ($key === 'user_id') {
                        $html .= '<td>' . $this->getUser($value) . ' </td>';
                    }

                    if ($key === 'activity_id') {
                        $html .= '<td>' . $this->getActivityName($value) . ' </td>';
                    }

                    if ($key === 'cat_id') {
                        $html .= '<td>' . $this->getCategory($value) . ' </td>';
                    }

                    if ($key === 'status_id') {
                        $html .= '<td>' . $this->getStatus($value) . '</td>';
                    }

                } else {
                    $html .= ($key === 'activity_description' ? '<td>' . $this->limitSummary($value, 5) . ' ...</td>' : '<td>' . $value . '</td>');
                }
            }

            if ($type !== 'todo') {
                if ($type !== 'user') {
                    $html .= '<td><a href="admin_form.php?fieldset=' . $type . '&' . $type . '_id=' . $row[$id] . '" class="btn btn-secondary" style="width: 100%;"><i class="fas fa-pencil-alt action-icons"></i> Update </a></td>';
                }
            }

            $html .= '<td><form action="./includes/form_handling.php" method="GET">';
            $html .= '<input type="hidden" name="operation" value="delete_' . $type . '" />';
            $html .= '<input type="hidden" name="id" value="' . $this->correctDeleteId($type, $row) . '" />';
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

    public function getUser($userId) {
        $result = $this->readsData('SELECT fname, lname FROM users WHERE id=' . $userId . ';')->fetch();
        return $result['fname'] . ' ' . $result['lname'];
    }

    public function getActivityName($activityId) {
        $result = $this->readsData('SELECT activity_name FROM activity WHERE activity_id=' . $activityId . ';')->fetch();
        return $result['activity_name'];
    }

    public function getCategory($catId) {
        $status = $this->readsData('SELECT description FROM categories WHERE cat_id = ' . $catId . ';')->fetch();
        return $status['description'];
    }

    public function getStatus($statusId) {
        $status = $this->readsData('SELECT description FROM status WHERE status_id = ' . $statusId . ';')->fetch();
        return $status['description'];
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

    public function displayTodoTable() {
        $result = $this->readsData('SELECT * FROM activity_todo');
        return $this->createTable($result, 'todo');
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

    public function updateTodoStatus($todoId, $activityId, $statusId) {
        $result = $this->createData('UPDATE activity_todo SET status_id = "' . $statusId . '" WHERE todo_id = "' . $todoId . '"');

        header('Location: ../todos.php?activity_id=' . $activityId . '&todo_id=' . $todoId . '');

    }

    /**
     * Add methods
     */

    public function addActivity($activityName, $activityDesc, $plannedDate) {
        $currentDate = date('Y-m-d');
        $result      = $this->createData('INSERT INTO activity (activity_name, activity_description, date_planned, date_created) VALUES ("' . $activityName . '", "' . $activityDesc . '", "' . $plannedDate . '", "' . $currentDate . '");');
    }

    public function addTodo($todoName, $todoDesc, $activityId, $userId, $catId) {
        $result = $this->createData('INSERT INTO activity_todo (title, description, user_id, activity_id, cat_id, status_id) VALUES ("' . $todoName . '", "' . $todoDesc . '", "' . $activityId . '", "' . $userId . '", "' . $catId . '", "1");');
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

    public function deleteTodo($todoId) {
        $result = $this->deleteData('DELETE FROM activity_todo WHERE todo_id="' . $todoId . '";');
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
                            <label>Titel</label>
                            <input type="text" name="title" value="{$activityData['activity_name']}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Beschrijving</label>
                            <textarea class="form-control" name="description" value="{$row['activity_description']}" rows="3">{$activityData['activity_description']}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Geplande datum</label>
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

    public function addTodoForm() {

        $activities = $this->readsData('SELECT activity_id ,activity_name FROM activity');
        $users      = $this->readsData('SELECT id, fname, lname FROM users');
        $categories = $this->readsData('SELECT cat_id ,description FROM categories');

        $activitiesHtml = '';
        $usersHtml      = '';
        $categoriesHtml = '';

        while ($row = $activities->fetch()) {
            $activitiesHtml .= '<option value="' . $row['activity_id'] . '">' . $row['activity_name'] . '</option>';
        }

        while ($row = $users->fetch()) {
            $usersHtml .= '<option value="' . $row['id'] . '">' . $row['fname'] . ' ' . $row['lname'] . '</option>';
        }

        while ($row = $categories->fetch()) {
            $categoriesHtml .= '<option value="' . $row['cat_id'] . '">' . $row['description'] . '</option>';
        }

        return <<<HTML
         <h1>Voeg nieuwe taak toe</h1>
                    <form action="./includes/form_handling.php" method="GET">
                        <input type="hidden" name="operation" value="add_todo">

                        <div class="form-group">
                            <label>Taak naam</label>
                            <input type="text" name="todo_name" placeholder="Taak naam" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Taak beschrijving</label>
                            <textarea class="form-control" name="todo_desc" placeholder="Taak beschrijving"  rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Selecteer de activiteit</label>
                            <select class="form-control" name="activity_id">
                                {$activitiesHtml}
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Selecteer de gebruiker</label>
                            <select class="form-control" name="user_id">
                                {$usersHtml}
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Selecteer de categorie</label>
                            <select class="form-control" name="cat_id">
                                {$categoriesHtml}
                            </select>
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

    public function correctFieldset($tableData) {

        switch ($tableData) {
            case 'activities':
                return 'add_activity';
                break;
            case 'users':
                return 'add_user';
                break;
            case'todos':
                return 'add_todo';
                break;
            default:
                return 'add_activity';
                break;
        }

    }

    public function correctDeleteId($type, $row) {

        switch ($type) {
            case 'activity':
                return $row['activity_id'];
                break;
            case 'user':
                return $row['id'];
                break;
            case'todo':
                return $row['todo_id'];
                break;
            default:
                return 'error';
                break;
        }

    }

}
