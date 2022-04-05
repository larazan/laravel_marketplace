<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

class UserSubscriptionController extends Controller
{
    //
    public function postSubscribe(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:attributes,email'
        ]);

        // Storage::append('emails.txt', $request->input('email'));
        $params = $request->except('_token');
        $params['status'] = 'active';

        Subscription::create($params);

        return response()->json(['success' => true]);
    }

    public function checkSubscriber(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            echo "<pre>";
            print_r($data);
            die;

            // $subscriberCount = Subscription::where('email', $data['subscriber_email'])->count();
            // if ($subscriberCount > 0) {
            //     echo "exists";
            // }
        }
    }

    public function addSubscriber(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $subscriberCount = Subscription::where('email', $data['subscriber_email'])->count();
            if ($subscriberCount > 0) {
                echo "exists";
            } else {
                // add email to table
                $newsletter = new Subscription;
                $newsletter->email = $data['subscriber_email'];
                $newsletter->status = 1;
                $newsletter->save();
                echo "saved";
            }
        }
    }
}
