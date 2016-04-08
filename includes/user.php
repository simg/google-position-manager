<?

class user
{
	public $user_id;
	public $email_address;
	public $is_authenticated;
	
	public function user($user_id, $email_address, $is_authenticated)
	{
		$this->user_id = $user_id;
		$this->email_address = $email_address;
		$this->is_authenticated = $is_authenticated;
	}
}

?>
