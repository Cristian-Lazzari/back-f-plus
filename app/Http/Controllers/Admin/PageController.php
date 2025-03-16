<?php



namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Date;
use App\Models\Post;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Consumer;
use App\Models\Ingredient;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    public function admin() {
        $consumers = Consumer::all();
        $users = User::with('consumers')->get();

        $statusCounts = [
            'Essentials' => Consumer::where('status', 1)->count(),
            'Grow Up' => Consumer::where('status', 2)->count(),
            'Boost Up' => Consumer::where('status', 3)->count(),
            'Prova Gratis' => Consumer::where('status', '>', 3)->count(),
        ];

        // Passiamo i dati alla vista

        return view('admin.dashboard', compact('consumers', 'statusCounts', 'users'));
    }


}

