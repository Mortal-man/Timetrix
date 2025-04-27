<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    // You can restrict this later with middleware if needed (e.g., only admin access)
    public function index()
    {
        $audits = Audit::with('user') // eager load user for display
        ->orderBy('created_at', 'desc')
            ->paginate(20); // Paginate for performance

        return view('audits.index', compact('audits'));
    }

    public function show($id)
    {
        $audit = Audit::with('user')->findOrFail($id);
        return view('audits.show', compact('audit'));
    }
}
