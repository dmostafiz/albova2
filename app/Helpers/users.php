<?php

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery\Exception;
use ReallySimpleJWT\Token;

function api_token_valid($token)
{
    $user = new \App\Models\User();

    return $user->getUserByApiToken($token);
}

function get_user_by_access_token($token)
{
    return api_token_valid($token);
}

function create_api_token($user_id)
{
    $secret = 'sec!ReT423*&';
    $expiration = time() + 3600;
    $issuer = 'localhost';

    return Token::create($user_id, $secret, $expiration, $issuer);
}

function get_activation_code($user_id)
{
    $user = new \App\Models\User();

    return $user->getActivationCode($user_id);
}

function createEmail($name = '')
{
    return $name . createPassword(4) . apply_filters('awebooking_create_email_domain', '@aweboking.org');
}

function createPassword($length = 8)
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

function get_all_roles()
{
    $user_model = new \App\Models\User();
    $users = $user_model->getAllRoles();
    if ($users) {
        $data = [];
        foreach ($users as $user) {
            $data[$user->id] = $user->name;
        }

        return $data;
    }
    return [];
}

function get_user_role($user_id, $type = '')
{
    $user_model = new \App\Models\User();
    $result = $user_model->getUserRole($user_id);
    if (!empty($type)) {
        return isset($result->$type) ? $result->$type : '';
    }
    return $result;
}

function user_can_edit_service($service_object, $user_id = null): bool
{
    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }
    if (!is_object($service_object)) {
        return false;
    }
    if (is_admin($user_id) || ((int)$user_id === (int)$service_object->author)) {
        return true;
    }
    return false;
}

function user_can_edit_post($post_object = null, $user_id = null): bool
{
    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    if (is_admin($user_id)) {
        return true;
    }

    return false;
}

function user_can_manage_post($user_id = null)
{
    if (is_null($user_id)) {
        $user_id = get_current_user_id();
    }

    if (is_admin($user_id)) {
        return true;
    }

    return false;
}


function logout_url($redirect = '')
{
    if (!$redirect) {
        $redirect = url('/');
    }
    return auth_url('logout') . '/?redirect_url=' . $redirect;
}

function is_user_logged_in()
{
    $userdata = get_current_user_data();
    return !empty($userdata) ? true : false;
}

function get_username($user_id)
{
    $user = get_user_by_id($user_id);
    if ($user) {
        if (!empty($user->first_name) || !empty($user->last_name)) {
            return $user->first_name . ' ' . $user->last_name;
        } else {
            return $user->email;
        }
    }
    return '';
}

function get_user_avatar($user_id = null, $size = [50, 50])
{
    if (is_null($user_id)) {
        $user = get_current_user_data();
    } else {
        $user = get_user_by_id($user_id);
    }
    if (!empty($user)) {
        $avatar_id = $user->avatar;
    } else {
        $avatar_id = 0;
    }
    $avatar_url = get_attachment_url($avatar_id, $size);

    return $avatar_url;
}

function get_current_user_id()
{
    $user_data = get_current_user_data();

    if ($user_data != null) {
        return $user_data->getUserId();
    } else {
        return 0;
    }
}

function is_admin($user_id = '')
{
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    $user_data = get_user_by_id($user_id);

    if ($user_data) {
        return $user_data->inRole('administrator') ? true : false;
    }
    return false;
}

function is_partner($user_id = '')
{
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    $user_data = get_user_by_id($user_id);

    if ($user_data) {
        return $user_data->inRole('partner') ? true : false;
    }
    return false;
}

function is_customer($user_id = '')
{
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    $user_data = get_user_by_id($user_id);

    if ($user_data) {
        return $user_data->inRole('customer') ? true : false;
    }
    return false;
}

function get_current_user_data()
{
    return Sentinel::getUser();
}

function get_user_by_id($user_id)
{
    $user = Sentinel::findById($user_id);
    return (is_object($user)) ? $user : false;
}

function get_user_by_email($user_email)
{
    $credentials = [
        'login' => $user_email,
    ];

    $user = Sentinel::findByCredentials($credentials);
    return (is_object($user)) ? $user : false;
}

function get_admin_user()
{
    $admin_id = get_option('user_admin');
    return get_user_by_id($admin_id);
}

function get_users_by_role($role = 'administrator', $for_option = false)
{
    $return = [];
    $users = Sentinel::getUserRepository()->get();
    if (!empty($users) && is_object($users)) {
        foreach ($users as $user) {
            if ($user->inRole($role)) {
                if ($for_option) {
                    $return[$user->getUserId()] = '(' . $user->getUserId() . ') ' . get_username($user->getUserId());
                } else {
                    $return[$user->getUserId()] = get_username($user->getUserId());
                }
            }
        }
    }

    return $return;
}

function get_users_in_role($roles = ['administrator'], $exclude = '')
{
    $return = [];
    $users = Sentinel::getUserRepository()->get();
    if (!empty($users) && is_object($users)) {
        foreach ($users as $user) {
            $user_id = $user->getUserId();
            if (in_array($user->roles[0]['slug'], $roles) && $user_id != $exclude) {
                if (empty($user->first_name) && empty($user->last_name)) {
                    $return[$user_id] = trim(get_username($user_id));
                } else {
                    $return[$user_id] = trim(get_username($user_id)) . ' (' . $user->email . ')';
                }
            }
        }
    }
    return $return;
}

function get_user_meta($user_id, $meta_key, $default = '')
{
    $user_model = new \App\Models\User();

    $result = $user_model->getUserMeta($user_id, $meta_key);
    if (!empty($result) && is_object($result)) {
        return maybe_unserialize($result->meta_value);
    } else {
        return $default;
    }
}

function update_user_meta($user_id, $meta_key, $meta_value = '')
{
    $user_model = new \App\Models\User();

    return $user_model->updateUserMeta($user_id, $meta_key, $meta_value);
}

function create_new_user($data = [])
{
    $default = [
        'email' => '',
        'password' => \Illuminate\Support\Str::random(12),
        'first_name' => '',
        'last_name' => '',
        'role' => 'customer',
    ];

    $data = wp_parse_args($data, $default);

    if (empty($data['email']) || !is_email($data['email'])) {
        return [
            'status' => 0,
            'message' => __('Invalid Email address')
        ];
    }
    if (empty($data['password']) || strlen($data['password']) < 6) {
        return [
            'status' => 0,
            'message' => __('The password has at least 6 characters')
        ];
    }

    $user = Sentinel::findByCredentials([
        'login' => $data['email']
    ]);

    if ($user) {
        return [
            'status' => 0,
            'message' => __('This user already exists')
        ];
    } else {
        try {
            $approval = get_option('account_approval', 'off');

            if ($approval == 'on') {
                $user = Sentinel::register($data);
            } else {
                $user = Sentinel::registerAndActivate($data);
            }

        } catch (Exception $e) {
            return [
                'status' => 0,
                'message' => $e->getMessage()
            ];
        }

        if (!$user) {
            return [
                'status' => 0,
                'message' => __('Can not create new user')
            ];
        } else {

            $user_model = new \App\Models\User();
            $role = $user_model->getRoleByName($data['role']);
            $user_model->updateUserRole($user->getUserId(), $role->id);
            if ($approval == 'on') {
                $user_model->updateUser($user->getUserId(), ['request' => 'request_a_customer']);
                do_action('hh_user_registered_as_customer', $user->getUserId());
            }
            do_action('hh_registered_user', $user->getUserId(), $data['password'], $approval);

            return [
                'status' => 1,
                'message' => __('Registered successfully'),
                'user' => $user,
                'password' => $data['password']
            ];
        }
    }
}


function getRefferalLink($id = null)
{
    if($id != null)
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        {
            $protocol = "https://";
        }
        else
        {
            $protocol = "http://";
        }

        return $protocol . $_SERVER['HTTP_HOST'] . '/user?ref_id=' . $id;
    }
}


function updateAffiliateRegistrationRecord($user_id, $child_id)
{
    $record = new App\AffiliateRegistration();
    $record->user_id = $user_id;
    $record->child_id = $child_id;
    $record->save();
}


function updateAffiliateEarning($child_id, $type)
{

    $child = App\Models\User::where('id', $child_id)->first();
    // $child_id = $child->id;

    if($child->parent_id != null)
    {
        $parent = App\Models\User::where('id',$child->parent_id)->first();

        if($parent)
        {

            $role = get_user_role($parent->id)->name;

            if($type == "new_experience")
            {
                if($role == 'Partner')
                {
                    $amount = 10;
                }
                elseif($role == 'Customer')
                {
                    $amount = 5;
                }

                $earning_type = "Experience created.";
            }
            elseif($type == "purchase_experience")
            {
                $earning_type = "Experience sold.";

                if($role == 'Partner')
                {
                    $amount = 30;
                }
                elseif($role == 'Customer')
                {
                    $amount = 5;
                }
            }


            $user_id = $parent->id;

            $earning = App\AffiliateEarning::where('user_id', $user_id)->first();

            if($earning)
            {
                $earning->total_earning = $earning->total_earning + $amount;
                $earning->available_payout = $earning->available_payout + $amount;
                $earning->save();
            }

            $record = new App\AffiliateEarningRecord();
            $record->user_id = $user_id;
            $record->child_id = $child_id;
            $record->amount = $amount;
            $record->earning_type = $earning_type;
            $record->save();
        }

    }
}



function get_ip_info($ip = null){

     if($ip == null)
     {
        $ip = $_SERVER["REMOTE_ADDR"];
     }

     $ip = "103.141.60.209";

    $key = '0z0q849fr9vwer';

    $api = 'https://api.ipregistry.co/'.$ip.'?key='.$key;

    $info = json_decode(file_get_contents( $api ));
    // dd($info);
    return $info;

    // $request = new \GuzzleHttp\Psr7\Request('GET', $api);
    // $promise = $client->sendAsync($request)->then(function ($response) {
    //     dd($response->getBody());
    // });

}
function get_agent_info(){
    $agent = new Agent();

    // $agent->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2');
    // $agent->setHttpHeaders($headers);

    return $agent;

}

function log_user_info($uid, $type = 'login')
{
    $ipinfo = get_ip_info();
    $agent = get_agent_info();

    // IP info
    $info = new UserInformation();
    $info->user_id = $uid;
    $info->type = $type;
    $info->ip = $ipinfo->ip;
    $info->ip_type = $ipinfo->type;
    $info->city = $ipinfo->location->city;
    $info->country = $ipinfo->location->country->name;
    $info->region = $ipinfo->location->region->name;
    $info->continent = $ipinfo->location->continent->name;
    $info->postal = $ipinfo->location->postal;
    $info->latitude = $ipinfo->location->latitude;
    $info->longitude = $ipinfo->location->longitude;
    $info->time_zone = $ipinfo->time_zone->id;
    $info->org_name = $ipinfo->connection->organization;
    $info->org_domain = $ipinfo->connection->domain;
    $info->org_route = $ipinfo->connection->route;
    $info->org_type = $ipinfo->connection->type;

    //Agent
    $platform = $agent->platform();
    $browser = $agent->browser();


    $info->device = $agent->device();
    $info->platform = $platform;
    $info->platform_version = $agent->version($platform);
    $info->browser = $browser;
    $info->browser_version = $agent->version($browser);
    $info->save();
}

function get_readable_time($time)
{
    // $time = (int) $time;
    if(is_string($time))
    {
        // $time = Carbon::date($time);
        return $time;
        // return $time>diffForHumans();
    }

    return $time->diffForHumans();
}
