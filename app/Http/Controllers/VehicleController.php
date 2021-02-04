<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVehicleRequest;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Services\VehicleService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function create()
    {
        $brands = brand::all();
        return view('vehicles/createCar', ['brands' => $brands]);
    }

    public function store(CreateVehicleRequest $request)
    {
        $vehicle = $this->vehicleService->saveVehicle($request->all());

        return redirect()->route('vehicles.create');
    }

    public function listing ()
    {
        $vehicles = Vehicle::with('brand')->get();
        return view('vehicles/listingVehicles',['vehicles' =>$vehicles]);
    }
}