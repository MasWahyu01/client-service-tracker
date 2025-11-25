<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        protected ServiceService $serviceService
    ) {}

    public function index(Request $request)
    {
        $services = $this->serviceService->paginateServices($request->all(), 10);

        return view('services.index', compact('services'));
    }

    public function create(Request $request)
    {
        $clientId = $request->get('client_id');

        return view('services.create', compact('clientId'));
    }

    public function store(StoreServiceRequest $request)
    {
        $service = $this->serviceService->createService($request->validated());

        return redirect()
            ->route('clients.show', $service->client_id)
            ->with('success', 'Service added successfully.');
    }
}
