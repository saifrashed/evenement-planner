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
    public function createTable($result) {
        $tableHeader = true;
        $html        = '';
        $html        .= '<table class="table">';

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
                    $html .= '<td>' . $value . '</td>';
            }

            $html .= '<td><a href="###" class="btn btn-secondary" style="width: 100%;"><i class="fas fa-book-open action-icons"></i> Read</a></td>';
            $html .= '<td><a href="###" class="btn btn-secondary" style="width: 100%;"><i class="fas fa-pencil-alt action-icons"></i> Update</a></td>';
            $html .= '<td><a href="###" class="btn btn-secondary" style="width: 100%;"><i class="fas fa-times action-icons"></i> Delete</a></td>';
            $html .= '</tr>';
        }

        $html .= '</table>';


        return $html;
    }

    public function displayActivityTable() {
        $result = $this->readsData('SELECT * FROM activity;');
        return $this->createTable($result);
    }

    public function displayUserTable() {
        $result = $this->readsData('SELECT users.id, users.fname, users.lname, users.email, gender.description AS "geslacht", role.description AS "rol" FROM users, role, gender 
                                          WHERE users.role=role.role_id AND users.gender=gender.gender_id;');
        return $this->createTable($result);
    }



}
