<?php

namespace App\Http\Livewire\Admin\Activities;

use Livewire\Component;
use App\AffiliateEarning;
use App\AffiliateWithdraw;
use App\UserInformation;
use DateTime;

class LoginLog extends Component
{

    public $perPage = 10;
    public $shouldLoad = 10;
    public $loadMore = true;
    public $total;

    public $matchings = [];
    public $preview = false;
    public $previewInfo;


    protected $listeners = [
        'withdraw-updated' => '$refresh'
    ];

    public function mount()
    {
        $this->total = UserInformation::where('type', 'login')->get()->count();

        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->shouldLoad;


        $this->total = UserInformation::where('type','login')->get()->count();

        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }

        // $this->emit('load-more');
    }

    public function preview($id)
    {
        $this->preview = false;
         $info = UserInformation::where('id', $id)->first();

         $all = UserInformation::where('id', '!=', $id)
                    ->where('user_id', '!=', $info->user_id)
                    ->where('type', 'login')
                    ->latest()
                    ->get();

        //  dd( $all );

        //  $matched = [];

         foreach($all as $key => $match)
         {
             if(
                 $info->ip == $match->ip
                 && $info->device != $match->device
                 && $info->platform != $match->platform
                 && $info->platform_version != $match->platform_version
                 && $info->browser != $match->browser
                 && $info->browser_version != $match->browser_version
             )
             {
                $this->matchings[$key] = [
                    'id' => $match->id,
                    'user_id' => $match->user_id,
                    'email' =>$match->user->email,
                    'created_at' => $match->created_at,
                    'percent' => 10
                ];
             }
             elseif(
                 $info->ip != $match->ip
                 && $info->device == $match->device
                 && $info->platform == $match->platform
                 && $info->platform_version == $match->platform_version
                 && $info->browser == $match->browser
                 && $info->browser_version == $match->browser_version
             )
             {
                $this->matchings[$key] = [
                    'id' => $match->id,
                    'user_id' => $match->user_id,
                    'email' =>$match->user->email,
                    'created_at' => $match->created_at,
                    'percent' => 15
                ];
             }
             elseif(
                 $info->ip == $match->ip
                 && $info->device == $match->device
                 && $info->platform != $match->platform
                 && $info->platform_version != $match->platform_version
                 && $info->browser != $match->browser
                 && $info->browser_version != $match->browser_version
             )
             {
                $this->matchings[$key] = [
                    'id' => $match->id,
                    'user_id' => $match->user_id,
                    'email' =>$match->user->email,
                    'created_at' => $match->created_at,
                    'percent' => 30
                ];
             }
             elseif(
                 $info->ip == $match->ip
                 && $info->device == $match->device
                 && $info->platform == $match->platform
                 && $info->platform_version != $match->platform_version
                 && $info->browser != $match->browser
                 && $info->browser_version != $match->browser_version
             )
             {
                $this->matchings[$key] = [
                    'id' => $match->id,
                    'user_id' => $match->user_id,
                    'email' =>$match->user->email,
                    'created_at' => $match->created_at,
                    'percent' => 45
                ];
             }
             elseif(
                 $info->ip == $match->ip
                 && $info->device == $match->device
                 && $info->platform == $match->platform
                 && $info->platform_version == $match->platform_version
                 && $info->browser != $match->browser
                 && $info->browser_version != $match->browser_version
             )
             {
                $this->matchings[$key] = [
                    'id' => $match->id,
                    'user_id' => $match->user_id,
                    'email' =>$match->user->email,
                    'created_at' => $match->created_at,
                    'percent' => 60
                ];
             }
             elseif(
                 $info->ip == $match->ip
                 && $info->device == $match->device
                 && $info->platform == $match->platform
                 && $info->platform_version == $match->platform_version
                 && $info->browser != $match->browser
                 && $info->browser_version == $match->browser_version
             )
             {
                $this->matchings[$key] = [
                    'id' => $match->id,
                    'user_id' => $match->user_id,
                    'email' =>$match->user->email,
                    'created_at' => $match->created_at,
                    'percent' => 52
                ];
             }
             elseif(
                 $info->ip == $match->ip
                 && $info->device == $match->device
                 && $info->platform == $match->platform
                 && $info->platform_version == $match->platform_version
                 && $info->browser != $match->browser
                 && $info->browser_version == $match->browser_version
             )
             {
                $this->matchings[$key] = [
                    'id' => $match->id,
                    'user_id' => $match->user_id,
                    'email' =>$match->user->email,
                    'created_at' => $match->created_at,
                    'percent' => 50
                ];
             }
             elseif(
                 $info->ip == $match->ip
                 && $info->device == $match->device
                 && $info->platform == $match->platform
                 && $info->platform_version == $match->platform_version
                 && $info->browser == $match->browser
                 && $info->browser_version != $match->browser_version
             )
             {
                $this->matchings[$key] = [
                    'id' => $match->id,
                    'user_id' => $match->user_id,
                    'email' =>$match->user->email,
                    'created_at' => $match->created_at,
                    'percent' => 80
                ];
             }
             elseif(
                 $info->ip == $match->ip
                 && $info->device == $match->device
                 && $info->platform == $match->platform
                 && $info->platform_version == $match->platform_version
                 && $info->browser == $match->browser
                 && $info->browser_version == $match->browser_version
             )
             {
                $this->matchings[$key] = [
                    'id' => $match->id,
                    'user_id' => $match->user_id,
                    'email' =>$match->user->email,
                    'created_at' => $match->created_at,
                    'percent' => 100
                ];
             }

         }

         $this->previewInfo = $info;
         $this->preview = true;

    }
    public function goBack()
    {
         $this->preview = false;
    }



    public function delete($id)
    {
        // dd($id);
        $wt =  UserInformation::where('id', $id)->first();
        $wt->delete();


        $this->total = UserInformation::where('type','login')->get()->count();

        if($this->total <= $this->perPage)
        {
            $this->loadMore = false;
        }


    }

    public function render()
    {
        $data['logins'] = UserInformation::where('type','login')->latest()->paginate($this->perPage);
        return view('livewire.admin.activities.login-log', $data);
    }
}
