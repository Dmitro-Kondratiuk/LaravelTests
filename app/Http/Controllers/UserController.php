<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Logic\Logger;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tinify\AccountException;
use Tinify\ClientException;
use Tinify\ConnectionException;
use Tinify\ServerException;

class UserController extends Controller
{
    public function index(Request $request) {

        return view('users.index');
    }

    public function create() {
        return view('users.create');
    }

    /**
     * @throws AccountException
     * @throws ClientException
     * @throws ServerException
     * @throws ConnectionException
     * @throws Exception
     */
    public function add(UserRequest $request) {
        $data     = $request->all();
        $avatar   = $data['avatar'];
        $fileName = $avatar->getClientOriginalName();
        $fileName = date('Y-m-d-h-i-s') . '-' . $fileName;

        try {
            \Tinify\setKey(env('TINIFY_KEY'));
            $source = \Tinify\fromFile($avatar->getRealPath());
            $source->toFile($avatar->getRealPath());
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

        $user             = new User();
        $user->first_name = $data['first_name'];
        $user->last_name  = $data['last_name'];
        $user->email      = $data['email'];
        $user->avatar     = $fileName;
        $user->save();

        Logger::writeLog('Save new user', $user->toJson());
        return response()->json('/')->cookie('success','User created!',0.05);
    }

    public function getUsers(Request $request) {

        $page = $request->query('page', 1);

        $perPage = 6;

        $users = User::skip(($page - 1) * $perPage)->take($perPage)->get();

        $totalUsers = User::count();
        $countPages = ceil($totalUsers / $perPage);

        $response = ['users' => $users, 'countPages' => $countPages];
        return response()->json($response);
    }
}
