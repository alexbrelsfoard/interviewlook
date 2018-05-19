<?php
/**
 * Created by PhpStorm.
 * User: Code and Silver
 * Date: 4/22/2018
 * Time: 5:23 PM
 */

namespace App\Http\Controllers;

use App\models\Look;
use Exception;

class AddPipeController extends Controller
{

    public function apiRequest($method, $url, $data, $headers)
    {

        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "GET":

                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($curl, CURLOPT_USERAGENT, $agent);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    public function importVideoData() {

        $method = 'GET';
        $url = 'https://api.addpipe.com/video/all';
        $data = '';
        $headers = array(
            'Cache-Control: no-cache',
            'content-type: application/json',
            'X-PIPE-AUTH: b92d5464d2ef0f5d8988c0784e5b23859dea8a7c8ef27cb3e060c04404d9a332'
        );

        $video_list = $this->apiRequest($method, $url, $data, $headers);
        $video_list = json_decode($video_list, true);

        foreach ($video_list['videos'] as $videos) {

            $payload = json_decode($videos['payload'], true);
            $user_id = $payload['user_id'];
            $video_id = $payload['video_id'];
            $img_url = $videos['snapshotURL'];
            $add_pipe_id = $videos['id'];

            try {
                Look::updateOrCreate(['video_id' => $video_id], [
                    'user_id' => $user_id,
                    'img_url' => $img_url,
                    'add_pipe_id' => $add_pipe_id
                ]);

            } catch(Exception $e) {

                report($e);
                return false;

            }

        }

    }
}