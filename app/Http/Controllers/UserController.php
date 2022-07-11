<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;

// models
use App\Models\User;

class UserController extends Controller
{
    public function attempt(Request $request) {
        try {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
                return response()->json([
                    'success' => true,
                    'message' => 'User authenticated',
                    'data' => []
                ]);
            }
            throw new \Exception("Incorrect username and password");
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function authSetings() {
        return view('pages.auth_settings')->with([
            'user' => Auth::user()->load('role')
        ]);
    }

    public function saveFaceRecognition(Request $request) {
        try {
            $images = [];
            $logged_user = Auth::user();

            $directory = 'public/images/'.$logged_user->email;

            if(!Storage::exists($directory)){
                Storage::makeDirectory($directory);
            }

            $files = glob(storage_path('app/'.$directory.'/*.png'));

            foreach ($files as $key => $value) {
                unlink($value);
            }
            
            foreach ($request['faces'] as $key => $photo) {
                //get the base-64 from data
                $base64_str = substr($photo, strpos($photo, ",")+1);

                //decode base64 string
                $image = base64_decode($base64_str);

                $uuid = Str::uuid();

                $filename = strtoupper($logged_user->first_name).' '.strtoupper($logged_user->first_name)."_$uuid.".'png';

                Storage::put($directory.'/'.$filename, $image);

                $images[] = [
                    'uuid' => $uuid,
                    'user_id' => $logged_user->id
                ];
            }

            $logged_user->images()->createMany($images);

            return response()->json([
                'success' => true,
                'message' => "Face processed, you can now use the method",
                'data' => []
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }
}
