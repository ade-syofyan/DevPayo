public function cookie()
    {
        $this->load->helper('cookie');

        $name   = 'user';
        $value  = 'pradip';
        $expire = time()+1000;
        $path  = '/';
        $secure = TRUE;

        setcookie($name,$value,$expire,$path); 

        $this->load->view('welcome_message');
    }