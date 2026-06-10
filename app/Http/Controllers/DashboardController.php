<?php

namespace App\Http\Controllers;

use App\Services\MiembroService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private MiembroService $miembroService
    ) {}

    public function index(): View
    {
        $miembros = $this->miembroService->listar();
        return view('dashboard.index', compact('miembros'));
    }
}
