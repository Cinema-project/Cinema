<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 12.11.2017
 * Time: 17:07
 */
class User_model extends CI_Model
{
	private $id;
	private $email;
	private $nick;
	private $password;
	private $role;
	private $avatar;
    private $favorites = array();

	/**
	 * User constructor.
	 */
	public function __construct($id = null)
	{
		if ($id != null)
		{
			$sql = "SELECT * FROM users WHERE UserId = ?";
			$user = $this->db->query($sql, $id)->result_array()[0];
			if(!empty($user))
			{
				$this->setUser($user);
			}
			$sql = "SELECT MovieId FROM favorites WHERE AccountId = ?";
            $moviesId = $this->db->query($sql, $id)->result_array();
            foreach ($moviesId as $id) {
                $this->favorites[] = new Tmdbmovie_model($id);
            }
		}
	}

	public function save()
	{
		if ($this->email != null && $this->nick != null && $this->password != null)
		{
			$data = array(
				'Email' => $this->email,
				'Nick' => $this->nick,
				'Password' => $this->hash_password($this->password),
				'RoleId' => 2,
				'Avatar' => null
			);
			$this->db->insert('users', $data);
		}

	}

    public function insertIntoFavorites($user, $movie){
        $data = array('AccountID' => $user,
            'MovieId' => $movie);
        $this->db->insert('favorites', $data);
    }

    public function getFavoritesById($userId){
        if ($userId != null)
        {
            $this->db->select('MovieId');
            $this->db->from('favorites');
            $this->db->where('AccountId', $userId);
            return $this->db->get()->result();
        }
    }

    public function removeFromFavorites($userId = null, $movieId = null){
        if ($userId != null && $movieId != null)
        {
            $this->db->where('AccountId', $userId);
            $this->db->where('MovieId', $movieId);
            $this->db->delete('favorites');
        }
    }

    /**
     * @return array
     */
    public function getFavorites()
    {
        return $this->favorites;
    }
	/**
	 * @return mixed
	 */

	public function getId()
	{
		return $this->id;
	}

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

	/**
	 * @return mixed
	 */

	/**
	 * @return mixed
	 */
	public function getNick()
	{
		return $this->nick;
	}

	/**
	 * @param mixed $nick
	 */
	public function setNick($nick)
	{
		$this->nick = $nick;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @return mixed
	 */
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * @param mixed $role
	 */
	public function setRole($role)
	{
		$this->role = $role;
	}

	/**
	 * @return mixed
	 */
	public function getAvatar()
	{
		return $this->avatar;
	}

	/**
	 * @param mixed $avatar
	 */
	public function setAvatar($avatar)
	{
		$this->avatar = $avatar;
	}

	public function checkLoginAndPassword($email, $password)
	{
		$this->db->select('Password');
		$this->db->from('users');
		$this->db->where('Email', $email);
		$hash = $this->db->get()->row('Password');
		return $this->verify_password_hash($password, $hash);
	}

	public function checkUniqueLoginAndNick()
	{
		$this->db->where('Email', $this->email);
		$user = $this->db->get('users')->result_array();
		if(!empty($user))
		{
			return $this->email;
		}
		$this->db->where('Nick', $this->nick);
		$user = $this->db->get('users')->result_array();
		if(!empty($user))
		{
			return $this->nick;
		}
		else
		{
			return null;
		}
	}

	/**
	 * hash_password function.
	 *
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password){
		return password_hash($password, PASSWORD_DEFAULT);
	}

	/**
	 * verify_password_hash function.
	 *
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		return password_verify($password, $hash);
	}

	private function setUser($user)
	{
		$this->id = $user[0]['UserId'];
		$this->email = $user[0]['Email'];
		$this->nick = $user[0]['Nick'];
		$this->password = $user[0]['Password'];
		$this->avatar = $user[0]['Avatar'];
		$this->load->model('Role_model');
		$this->role = new Role_model($user[0]['RoleId']);
	}

	public function getUserId($email){
        $this->db->select('UserId');
        $this->db->from('users');
        $this->db->where('Email', $email);
        $querry = $this->db->get()->result()[0]->UserId;
        return $querry;
  }
    public function getUserNick($email){
        $this->db->select('Nick');
        $this->db->from('users');
        $this->db->where('Email', $email);
        $querry = $this->db->get()->result()[0]->Nick;
        return $querry;
    }

    public function getUserRoleById($userId){
        $this->db->select('RoleId');
        $this->db->from('users');
        $this->db->where('UserId', $userId);
        $querry = $this->db->get()->result()[0]->RoleId;
        return $querry;
    }
}
