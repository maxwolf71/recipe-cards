<?php

namespace Cooking;

use WP_REST_Request;
use WP_User;

class Api
{
    /**
     *  @var string
     */
    protected $baseURI;

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'initialize']);
    }

    public function initialize()
    {
        $this->baseURI = dirname($_SERVER['SCRIPT_NAME']);

        register_rest_route(
            'cooking/v1', // name of the API (endpoint)
            '/register', // route following our API
            [
                'methods' => 'post',
                'callback' => [$this, 'register']
            ]
        );

        register_rest_route(
            'cooking/v1',
            '/recipe-save',
            [
                'methods' => 'post',
                'callback' => [$this, 'recipeSave']
            ]
        );

        register_rest_route(
            'cooking/v1',
            '/upload-image',
            [
                'methods' => 'post',
                'callback' => [$this, 'uploadImage']
            ]
        );

        register_rest_route(
            'cooking/v1',
            '/comment-save',
            [
                'methods' => 'post',
                'callback' => [$this, 'commentSave']
            ]
        );
    }

    public function commentSave(WP_REST_Request $request) {
        $comment = $request->get_param('comment');
        $recipeId = $request->get_param('recipeId');

        $user = wp_get_current_user();

        if (
            in_array('chef', (array) $user->roles) ||
            in_array('contributor', (array) $user->roles) ||
            in_array('administrator', (array) $user->roles)
        ) {

            $commentSaveResult = wp_insert_comment(
                [
                'user_id' => $user->ID,
                'comment_post_ID' => $recipeId,
                'comment_content' => $comment,
                ]
            );

            if(is_int($commentSaveResult)) {
                return [
                    'success' => true,
                    'recipe-id' => $recipeId,
                    'comment' => $comment,
                    'user' => $user,
                    'comment-id' => $commentSaveResult
                ];
            } 
            else {
                return [
                    'success' => false
                ];
            }
            
        } 
        else {
            return [
                'success' => false
            ];
        }
    }

    public function uploadImage(WP_REST_Request $request)
    {
        $imageFileIndex = 'image'; // variable used to send the image (fromRecipeCreate)
        $imageData = $_FILES[$imageFileIndex]; // info about uploaded Image
        $imageSource = $imageData['tmp_name']; // path where the uploaded image is stored
        $destination = wp_upload_dir(); // where wp stores uploaded files
        $imageDestinationFolder = $destination['path']; // wp folder where image will be stored

        $imageName = sanitize_file_name(
            md5(uniqid()) . '-' . $imageData['name']
        );
        $imageDestination = $imageDestinationFolder . '/' . $imageName;

        $success = move_uploaded_file($imageSource, $imageDestination); // move uploade file to wp storage folder

        if ($success) { // if it worked
            $imageType =  wp_check_filetype($imageDestination, null);
            $attachement = array(
                'post_mime_type' => $imageType['type'],
                'post_title' => $imageName,
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachmentId = wp_insert_attachment($attachement, $imageDestination);
            if (is_int($attachmentId)) {
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $metadata = wp_generate_attachment_metadata($attachmentId, $imageDestination);
                wp_update_attachment_metadata($attachmentId, $metadata);

                return [
                    'status' => 'success',
                    'image' => [
                        'url' => $destination['url'] . '/' . $imageName,
                        'id' => $attachmentId
                    ]
                ];
            } else {
                return [
                    'status' => 'failed'
                ];
            }
        }
    }

    public function recipeSave(WP_REST_Request $request)
    {
        $title =  $request->get_param('title');
        $type =  $request->get_param('type');
        $description =  $request->get_param('description');
        $ingredients =  $request->get_param('ingredients');
        $imageId =  $request->get_param('imageId');

        $user = wp_get_current_user(); // get user who sent the request

        if (
            in_array('chef', (array) $user->roles) ||
            in_array('contributor', (array) $user->roles) ||
            in_array('administrator', (array) $user->roles)
        ) {

            $recipeCreateResult = wp_insert_post(
                [
                    'post_title' => $title,
                    'post_content' => $description,
                    'post_status' => 'publish',
                    'post_type' => 'recipe'
                ]
            );

            if($imageId) {
                set_post_thumbnail(
                    $recipeCreateResult,
                    $imageId
                );
            }

            if (is_int($recipeCreateResult)) { // recipe created
                wp_set_post_terms(
                    $recipeCreateResult,
                    [$type],
                    'recipe-type'
                );

                wp_set_post_terms(
                    $recipeCreateResult,
                    $ingredients,
                    'ingredient'
                );
            }

            return [
                'success' => true,
                'title' => $title,
                'type' => $type,
                'description' => $description,
                'ingredients' => $ingredients,
                'user' => $user,
                'recipe-id' => $recipeCreateResult
            ];
        }
        return [
            'success' => false,
        ];
    }

    public function register(WP_REST_Request $request)
    {
        $email = $request->get_param('email');
        $password = $request->get_param('password');
        $username = $request->get_param('username');

        $userCreateResult = wp_create_user(
            $username,
            $password,
            $email
        );

        if (is_int($userCreateResult)) {
            $user = new WP_User($userCreateResult);
            $user->remove_role('subscriber');
            $user->add_role('contributor');

            return [
                'success' => true,
                'userId' => $userCreateResult,
                'username' => $username,
                'email' => $email,
                'role' => 'contributor'
            ];
        } else {
            // user wasn't created because there was an error 
            return [
                'success' => false,
                'error' => $userCreateResult,
            ];
        }
    }
}
