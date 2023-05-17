<?php
class Authentication
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('wp_ajax_authenticate', [$this, 'callbackAjax']);
        add_action('wp_ajax_nopriv_authenticate', [$this, 'callbackAjax']);
    }

    public function enqueueScripts()
    {
        wp_register_script('authentication', get_stylesheet_directory_uri() . '/assets/js/authentication.js', ['jquery'], get_dynamic_version());
        wp_localize_script('authentication', 'authentication_params', ['ajax_url' => admin_url('admin-ajax.php')]);
        wp_enqueue_script('authentication');
    }

    public function callbackAjax()
    {
        $data = (isset($_POST['data'])) ? $_POST['data'] : '';
        if ($data['slug'] == 'login') {
            $response = $this->login($data);
        }
        if ($data['slug'] == 'register') {
            $response = $this->register($data);
        }
        if (!empty($data['isLogout'])) {
            $response = $this->logout();
        }
        wp_send_json_success($response);
        exit();
    }

    public function login($data)
    {
        extract($data);
        if (!empty($username)) {
            $user = wp_authenticate($username, $password);
        }
        if (!empty($email)) {
            $user = get_user_by('email', $email);
        };
        $condition = $user && wp_check_password($password, $user->data->user_pass, $user->ID) ? true : false;
        $this->response($condition, $user->ID, $user->last_name);
    }

    public function register($data)
    {
        extract($data);
        $user_login = sanitize_text_field($data['username']);
        $user_email = sanitize_email($data['email']);
        $user_id    = register_new_user($user_login, $user_email);
        $this->updateUser($user_id, $data);
        $condition = !is_wp_error($user) ? true : false;
        $this->response($condition, $user_id, $last_name);
    }

    public function updateUser($user_id, $data)
    {
        extract($data);
        $user_data = [];
        $user_data['ID']         = $user_id;
        $user_data['first_name'] = $first_name;
        $user_data['last_name']  = $last_name;
        wp_update_user($user_data);
        wp_set_password($password, $user_id);
    }

    public function logout()
    {
        wp_clear_auth_cookie();
        return "You're logged out";
    }

    public function response($condition, $user_id, $user_name)
    {
        $condition == true ? wp_set_auth_cookie($user_id) : '';
        return $condition == true ? "Welcome $user_name." : "Sorry you should check your information and try again, please!";
    }
}
$authentication = new Authentication();
