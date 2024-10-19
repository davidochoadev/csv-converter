<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedbackUser;

class DashboardController extends Controller
{
    public function index()
    {
        $feedbackUsers = FeedbackUser::all()->paginate(10);
        return view('dashboard', compact('feedbackUsers'));
    }
}
