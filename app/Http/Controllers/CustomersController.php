<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return new CustomerCollection(Customer::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request): JsonResource
    {
        return new CustomerResource(
            Customer::create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResource
    {
        return new CustomerResource(Customer::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id): JsonResource
    {
        Customer::where('id', $id)->update($request->validated());

        return new CustomerResource(Customer::find($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResource
    {
        Customer::destroy($id);

        return new CustomerResource([]);
    }
}
