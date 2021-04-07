@include('dashboard.components.header')
<div id="wrapper">
    @include('dashboard.components.top-bar')
    @include('dashboard.components.nav')
    <div class="content-page">
        <div class="content mt-2">
            {{--Start Content--}}
            @include('dashboard.components.breadcrumb', ['heading' => __('APIs')])
            <div id="api-settings">
                <div class="card-box">
                    <div class="header-area d-flex align-items-center">
                        <h4 class="header-title mb-0">{{__('Access Token')}}</h4>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <?php
                            $access_token = get_user_meta(get_current_user_id(), 'access_token');
                            ?>
                            <form action="{{dashboard_url('create-api')}}" class="form-action form-sm relative mt-3">
                                <div class="access-token-preview">
                                    <div id="access-token-preview-render" class="render" onclick="selectText(this.id)">{{$access_token}}</div>
                                    <div class="actions">
                                        <a href="javascript: void(0)" class="copied" data-toggle="popover" data-placement="top" data-content="{{__('Copy')}}" data-trigger="hover"><i class="fe-copy"></i></a>
                                        <a href="{{dashboard_url('reset-api-key')}}" class="reset" data-toggle="popover" data-placement="top" data-content="{{__('New Key')}}" data-trigger="hover"><i class="fe-refresh-ccw "></i></a>
                                    </div>
                                </div>
                                <input type="hidden" readonly name="access_token" value="{{$access_token}}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{--End content--}}
            @include('dashboard.components.footer-content')
        </div>
    </div>
</div>
@include('dashboard.components.footer')
