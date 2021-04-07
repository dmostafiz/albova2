<?php

namespace App\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController extends Controller
{

    public function _index(Request $request)
    {
        $folder = $this->getFolder();
        $user_id = get_current_user_id();
        $default_access_token = get_user_meta($user_id, 'access_token');
        if (empty($default_access_token)) {
            $default_access_token = create_api_token(get_current_user_id());
            update_user_meta($user_id, 'access_token', $default_access_token);
        }

        return view("dashboard.screens.{$folder}.api", ['bodyClass' => 'hh-dashboard']);
    }

    public function _resetApiKey(Request $request)
    {
        $access_key = create_api_token(get_current_user_id());

        update_user_meta(get_current_user_id(), 'access_token', $access_key);

        return $this->sendJson([
            'status' => 1,
            'message' => __('Created API key successfully'),
            'access_key' => $access_key
        ]);
    }

}
