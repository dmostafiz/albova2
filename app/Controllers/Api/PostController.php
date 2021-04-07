<?php

namespace App\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\TermRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(Request $request, Post $post)
    {
        $post = new Post();

        $rules = [
            'search' => 'string',
            'term_slug' => 'string',
            'term_ids' => 'array',
            'term_relation' => 'in:and,or',
            'page' => 'integer|min:1',
            'number' => 'integer|min:1',
            'status' => 'array',
            'order_by' => 'in:post_id,post_title,post_slug,created_at',
            'order' => 'in:asc,desc',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendJson([
                'status' => 0,
                'message' => $validator->errors()
            ]);
        }
        $data = parse_request($request, array_keys($rules));

        $posts = $post->getAllPosts($data);
        if (is_array($posts)) {
            return $this->sendJson([
                'status' => 1,
                'total' => $posts['total'],
                'results' => $posts['results']
            ]);
        }
        return $this->sendJson([
            'status' => 0,
            'message' => __('Can not get data')
        ]);
    }

    public function store(Request $request)
    {
        $post = new Post();

        $rules = [
            'post_title' => 'required|string',
            'post_slug' => 'required|string',
            'post_content' => 'string',
            'thumbnail_id' => 'integer',
            'author' => 'required|integer|min:0',
            'status' => 'in:publish,draft,trash,revision',
            'created_at' => 'numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendJson([
                'status' => 0,
                'message' => $validator->errors()
            ]);
        }

        $meta_rules = [
            'categories' => 'array',
            'tags' => 'array',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendJson([
                'status' => 0,
                'message' => $validator->errors()
            ]);
        }

        $data = parse_request($request, array_keys($rules));

        $new_post = $post->createPost($data);
        $post_object = get_post($new_post, 'post');
        if ($new_post && $post_object) {

            $data = parse_request($request, array_keys($meta_rules));

            $termRelation = new TermRelation();

            /* Category update */
            $categories = $data['categories'];
            if (is_array($categories)) {
                $termRelation->deleteRelationByServiceID($new_post, 'post-category');
                if (!empty($categories)) {
                    foreach ($categories as $termID) {
                        $termRelation->createRelation($termID, $new_post, 'post');
                    }
                }
            }

            /* Tag update */
            $tags = $data['tags'];
            if (is_array($tags)) {
                $termRelation->deleteRelationByServiceID($new_post, 'post-tag');
                if (!empty($tags)) {
                    foreach ($tags as $termID) {
                        $termRelation->createRelation($termID, $new_post, 'post');
                    }
                }
            }

            return $this->sendJson([
                'status' => 1,
                'post' => $post_object,
                'message' => __('Created post successfully')
            ]);

        } else {
            return $this->sendJson([
                'status' => 0,
                'message' => __('Can not create post')
            ]);
        }

    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
