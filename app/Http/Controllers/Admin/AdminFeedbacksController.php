<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminFeedbacksController extends Controller
{
    public function listItems()
    {
        $oObjects = Feedback::orderBy('feedbackID', 'DESC')->paginate(20);
        $oUsers = User::all()->keyBy('userID');

        return view('admin.feedbacks.list', [
            'arrObjects' => $oObjects,
            'oUsers' => $oUsers
        ]);
    }

    public function deleteItems(Request $request)
    {
        if ($request->ajax()) {

            $objectID = $request->objectID;

            $obj = Feedback::where('feedbackID', $objectID)->first();
            if (!is_null($obj)) {
                $obj->delete();
            }

            return response()->json([
                'success' => true,
                'objectID' => $objectID
            ]);
        }
    }
}
