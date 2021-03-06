<?php

namespace App\Http\Controllers\Admin\Tables;

use App\Contact;
use App\trPerizinanApotik;
use App\trPerizinanDepo;
use App\trPerizinanHama;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class MemFeedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $c_apotik = trPerizinanApotik::whereraw('created_at = curdate()')->count();
        $c_air = trPerizinanDepo::whereraw('created_at = curdate()')->count();
        $c_hama = trPerizinanHama::whereraw('created_at = curdate()')->count();
        $feedback = Contact::whereraw('created_at = curdate()')->count();
        $feedback_t = Contact::whereraw('created_at = curdate()')->get();
        $member = User::whereraw('created_at = curdate()')->count();
        $notif = $c_apotik + $c_air + $c_hama + $feedback + $member;

        return view('admin.table_memfeed', compact('c_apotik', 'c_air', 'c_hama', 'feedback', 'feedback_t', 'member', 'notif'));
    }

    public function banned(User $id)
    {
        $id->delete();
        Session::flash('ban', 'Successfully, banned!');
        return back();
    }

    public function restore($id)
    {
        User::withTrashed()->find($id)->restore();
        Session::flash('res', 'Successfully, restored!');
        return back();
    }
}
