<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        // Example response
        return response()->json([
            'users' => 10,
            'content_sections' => 5,
            'announcements' => 3,
        ]);
    }
}
