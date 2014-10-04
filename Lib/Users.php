<?php
/**
 * The class which administers all users in the system.
 *
 * The class which provides the administrators to login and change passwords.
 *
 * @author     Midori Kocak <mtkocak@mtkocak.net>
 */

namespace Midori\Cms;

use \PDO;

/**
 * Class Users
 * @package Midori\Cms
 */
class Users extends Assets
{


    /**
     * Administrator user name
     *
     * @var string
     */
    public $username;

    /**
     * Administrator e-mail
     *
     * @var string
     */
    public $email;

    /**
     * Administrator password
     *
     * @var string
     */
    private $password;

    /**
     * If the system has no users make it public, if it does let it render the admin theme.
     *
     * @param string $username Administrator user name
     * @param string $password Administrator password
     * @param string $password2 Administrator password control value
     * @param string $email Administrator e-mail
     * @return bool if added return true, if not return false
     */
    public function add($username = null, $email = null, $password = null, $password2 = null)
    {
        $users = $this->index();
        // The method which checks if we're logged in and if there exists any users in the system.
        if (!$this->checkLogin()) {
            return false;
        }

        if ($password != $password2) {
            return false;
        }

        // 3 variables must not be empty
        if ($username != null && $email != null && $password != null) {
            // Let's first prepare our database query.


            // insert
            $insert = $this->db->insert('users')
                        ->set(array(
                            "username" => $username,
                            "password" => md5($password),
                            "email" => $email,
                        ));

            if ($insert) {
                // If the database action is successful, let's change the variables belonging to the class object
                $this->id = $this->db->lastId();
                $this->username = $username;
                $this->password = $password;
                $this->email = $email;

                return true;
            } else {
                return false;
            }
        } else {
            return array('render' => true, 'template' => 'admin');
        }
    }

    /**
     * The method which edits a single user data and sends to the profile page. Must not be rendered
     *
     * @param int $id Unique index of the user
     * @return array if it renders properly return array data, if not return false
     */
    public function view($id)
    {

        // The method which checks if we're logged in and if there's any users in the system.
        if (!$this->checkLogin()) {
            return false;
        }
        // If an query is sent, the class object has been written.
        if ($id == $this->id) {
            return array("id" => $this->id, "username" => $this->username, "email" => $this->email, "password" => $this->password,);
        } else {
            // From here we understand that the data isn't pulled yet. Let's start pulling the data

            $query = $this->db->select('users')
                        ->where('id', $id)
                        ->run();

            if ($query) {
                $user = $query[0];

                $this->id = $user['id'];
                $this->username = $user['username'];
                $this->password = $user['password'];

                $result = array('template' => 'admin', 'user' => $user, 'render' => true);
                return $result;
            }
        }

        // If both actions fail, return false.
        return false;
    }

    /**
     * The method which lists all users.
     *
     * @return bool if it lists return true, if not return false
     */
    public function show()
    {

        // The method which checks if we're logged in and if any user exists in the system.
        if (!$this->checkLogin()) {
            return false;
        }
        $query = $this->db->select('users')
                    ->run();

        if ($query) {
            // With the fetchAll method we've pulled all values to the array.
            $result = array('render' => true, 'template' => 'admin', 'users' => $query);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * The method which lists users. We used this method for pulling a list
     * This method isn't rendered like the view method.
     *
     * @return bool if it lists return true, if not return false
     */
    public function index()
    {
        return $this->show();
    }


    /**
     * Edits the user. With the given id and information it edits and updates the
     * information in the system. This page should be also considered the user profile page.
     * It should pull and render prepared data from the view method.
     *
     * @param int $id Unique index of category
     * @param string $username Administrator user name
     * @param string $password Administrator password
     * @param string $password2 Administrator password control value
     * @param string $email Administrator e-mail
     * @return bool if it's edited return true, if not return false
     */
    public function edit($id = null, $username = null, $password = null, $password2 = null, $email = null)
    {
        // The method which checks if we're logged in and if any users exists in the system.
        if (!$this->checkLogin()) {
            return false;
        }

        if ($password != $password2) {
            return false;
        }

        if ($id != null && $username != null && $password != null && $email != null) {

            $update = $this->db->update('user')
                        ->where('id', $id)
                        ->set(array(
                            "username" => $username,
                            "password" => md5($password),
                            "email" => $email
                        ));

            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            $oldData = $this->view($id);
            return array('template' => 'admin', 'render' => true, 'user' => $oldData['user']);
        }
    }


    /**
     * The method which loggs in the user
     *
     * @param $username
     * @param $password
     * @return array
     */
    public function login($username = null, $password = null)
    {
        if (!$this->checkLogin()) {
            // From here we understand that the data hasn't logged in yet

            $query = $this->db->select('users')
                        ->where('username', $username)
                        ->where('password', md5($password))
                        ->run();

            if ($query) {
                $user = $query[0];
                // If the user name or password is wrong
                if (!$user) {
                    return array('template' => 'public', 'render' => true, 'message' => 'Hatalı kullanıcı adı veya parola.');
                }

                $this->id = $user['id'];
                $this->$username = $user['username'];
                $this->$password = $user['password'];

                // We complete the session stuff.

                $_SESSION['username'] = $user['username'];
                $_SESSION['id'] = $user['id'];

                return array('template' => 'admin', 'render' => false, 'message' => 'Oturum açıldı', 'user' => $user);
            }
        } else {
            return array('template' => 'admin', 'render' => false, 'message' => 'Zaten oturum açıldı!');
        }
        return false;
    }


    /**
     * The method which loggs out the user from the system.
     *
     */
    public function logout()
    {
        unset($_SESSION['username']);
        return array('template' => 'public', 'render' => false, 'message' => 'Sistemden çıktınız');
    }

    /**
     * The method which deletes the user, deletes the data.
     * This is not reversable.
     *
     * @param int $id Unique index of category
     * @return bool if it's deleted return true, if not return false
     */
    public function delete($id)
    {
        if (!$this->checkLogin()) {
            return false;
        }

        $query = $this->db->delete('users')
                    ->where('id', $id)
                    ->done();

        return array('template' => 'admin', 'render' => false);
    }

}

?>
