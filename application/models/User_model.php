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
	private $login;
	private $nick;
	private $password;
	private $role;
	private $avatar;

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
		}
	}

	public function save()
	{
		if ($this->login != null && $this->nick != null && $this->password != null)
		{
			$data = array(
				'Login' => $this->login,
				'Nick' => $this->nick,
				'Password' => $this->hash_password($this->password),
				'RoleId' => 2,
				'Avatar' => null
			);
			$this->db->insert('users', $data);
		}

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
	public function getLogin()
	{
		return $this->login;
	}

	/**
	 * @param mixed $login
	 */
	public function setLogin($login)
	{
		$this->login = $login;
	}

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

	public function checkLoginAndPassword($login, $password)
	{
		$this->db->select('Password');
		$this->db->from('Users');
		$this->db->where('Login', $login);
		$hash = $this->db->get()->row('Password');
		return $this->verify_password_hash($password, $hash);
	}

	public function checkUniqueLoginAndNick()
	{
		$this->db->where('Login', $this->login);
		$user = $this->db->get('users')->result_array();
		if(!empty($user))
		{
			return $this->login;
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
		$this->login = $user[0]['Login'];
		$this->nick = $user[0]['Nick'];
		$this->password = $user[0]['Password'];
		$this->avatar = $user[0]['Avatar'];
		$this->load->model('Role_model');
		$this->role = new Role_model($user[0]['RoleId']);
	}
}
