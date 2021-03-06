<?php
$custom_price = isset($custom_price) ? $custom_price : [];
$post_type = isset($post_type) ? $post_type : 'home';
?>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('Start Date')}}</th>
            <th scope="col">{{__('End Date')}}</th>
            <th scope="col">{{__('Price')}}</th>
            @if($post_type != 'experience' )
                <th scope="col">{{__('Available')}}</th>
            @endif
            <th scope="col" width="100">{{__('Action')}}</th>
        </tr>
        </thead>
        @if (!empty($custom_price['total']))
            <tbody>
            @foreach ($custom_price['results'] as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ date('Y-m-d', $item->start_time) }}</td>
                    <td>{{ date('Y-m-d', $item->end_time) }}</td>
                    <td>{{ convert_price($item->price) }}</td>
                    <td>
                        <?php
                        $data = [
                            'priceID' => $item->ID,
                            'priceEncrypt' => hh_encrypt($item->ID),
                            'postType' => $post_type
                        ];
                        ?>
                        <input type="checkbox" id="coupon_status" name="coupon_status" data-parent="tr"
                               data-plugin="switchery" data-color="#1abc9c" class="hh-checkbox-action"
                               data-action="{{ dashboard_url('change-price-status') }}"
                               data-params="{{ base64_encode(json_encode($data)) }}"
                               value="on" @if( $item->available == 'on') checked @endif/>
                    </td>
                    <td>
                        <?php
                        if ($post_type == 'car') {
                            $post_id = $item->car_id;
                        } elseif ($post_type == 'experience') {
                            $post_id = $item->exprience_id;
                        } else {
                            $post_id = $item->home_id;
                        }
                        ?>
                        <a href="javascript: void(0)" class="btn btn-danger btn-sm delete-price"
                           data-title="{{__('Delete this item?')}}"
                           data-content="{{__('Are you sure to delete this item?')}}"
                           data-post-type="{{$post_type}}"
                           data-post-id="{{ $post_id }}"
                           data-price-id="{{ $item->ID }}">{{__('Delete')}}</a>
                    </td>
                </tr>
            @endforeach
            <tbody>
        @endif
    </table>
</div>
