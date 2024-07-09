<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Logic\Helper\UsersHelper;
use App\Logic\Logger;
use App\Models\Positions;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tinify\AccountException;
use Tinify\ClientException;
use Tinify\ConnectionException;
use Tinify\ServerException;

class UserController extends Controller
{
    const PER_PAGE = 6;

    public function index() {

        return view('users.index');
    }

    public function create() {
        $positions = Positions::all();
        return view('users.create',compact('positions'));
    }

    /**
     * @throws AccountException
     * @throws ClientException
     * @throws ServerException
     * @throws ConnectionException
     * @throws Exception
     */
    public function add(UserRequest $request): JsonResponse {
        $data     = $request->all();
        $photo    = $data['photo'];
        $fileName = $photo->getClientOriginalName();
        $fileName = date('Y-m-d-h-i-s') . '-' . $fileName;

        try {
            \Tinify\setKey(env('TINIFY_KEY'));
            $source = \Tinify\fromFile($photo->getRealPath());
            $source->toFile($photo->getRealPath());
            $resized = $source->resize([
                "method" => "cover",
                "width"  => 70,
                "height" => 70,
            ]);

            $directory = 'images';


            $resizedFilePath = storage_path( $directory . '/' . $fileName);
            $resized->toFile($resizedFilePath);
        }
        catch (\Tinify\AccountException $e) {
            Logger::writeLog('The error message is: ', $e->getMessage());
            throw new \Tinify\AccountException("The error message is: " . $e->getMessage());
        }
        catch (\Tinify\ClientException $e) {
            Logger::writeLog('The error message is: ', $e->getMessage());
            throw new \Tinify\ClientException("The error message is: " . $e->getMessage());
        }
        catch (\Tinify\ServerException $e) {
            Logger::writeLog('The error message is: ', $e->getMessage());
            // Temporary issue with the Tinify API.
            throw new \Tinify\ServerException("The error message is: " . $e->getMessage());
        }
        catch (\Tinify\ConnectionException $e) {
            Logger::writeLog('The error message is: ', $e->getMessage());
            // A network connection error occurred.
            throw new \Tinify\ConnectionException("The error message is: " . $e->getMessage());
        }
        catch (Exception $e) {
            Logger::writeLog('The error message is: ', $e->getMessage());
            // Something else went wrong, unrelated to the Tinify API.
            throw new Exception("The error message is: " . $e->getMessage());
        }

        $user              = new User();
        $user->name        = $data['name'];
        $user->phone       = $data['phone'];
        $user->email       = $data['email'];
        $user->position_id = $data['position_id'];

        $client = new Client();
        $url = 'https://api.imgbb.com/1/upload';

        $apiKey = config('app.api_image_key');
        $imageFilePath = $resized->toBuffer();

        try {
            $response = $client->post($url, [
                'multipart' => [
                    [
                        'name'     => 'key',
                        'contents' => $apiKey,
                    ],
                    [
                        'name'     => 'image',
                        'contents' => $imageFilePath,
                        'filename' => $photo->getClientOriginalName(),
                    ],
                ],
            ]);


            $responseBody = json_decode($response->getBody(), true);
            $user->photo =  $responseBody['data']['image']['url'];

        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        $user->save();

        Logger::writeLog('Save new user', $user->toJson());
        return response()->json('/')->cookie('success','User created!',0.05);
    }

    public function getUsers(Request $request): JsonResponse {

        $page       = $request->query('page', 1);
        $response   = UsersHelper::getUsersTable($page, self::PER_PAGE);
        $response['positions'] = Positions::all();
        return response()->json($response);
    }
    public function getPositionsUsers(Request $request): JsonResponse {

        $position_id = (int)$request->query('position_id');
        $page        = (int)$request->query('page', 1);
        $response    = UsersHelper::getUsersTable($page, self::PER_PAGE, $position_id);

        return response()->json($response);
    }
    public function show($id) {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
}
