<?php
// app/Http/Controllers/AdminDashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Transaction;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $monthlyRevenue = Transaction::whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                                     ->sum('amount');
        $formattedMonthlyRevenue = 'Rp ' . number_format($monthlyRevenue, 0, ',', '.');

        return view('dashboard-admin', compact('totalPatients', 'formattedMonthlyRevenue'));
    }
}