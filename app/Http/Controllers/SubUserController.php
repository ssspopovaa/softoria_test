<?php

namespace App\Http\Controllers;

use App\DTO\PaymentDTO;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\SubUserStoreRequest;
use App\Http\Requests\SubUserUpdateRequest;
use App\Http\Requests\SubUserDeleteRequest;
use App\Services\SubUserService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class SubUserController extends Controller
{
    public function __construct(
        protected SubUserService $subUserService,
        protected PaymentService $paymentService
    ) {}

    public function index()
    {
        $subUsers = $this->subUserService->list();
        return view('sub_users.index', compact('subUsers'));
    }

    public function create()
    {
        return view('sub_users.create');
    }

    public function store(SubUserStoreRequest $request)
    {
        $this->subUserService->create($request->validated());
        return redirect()->route('sub-users.index');
    }

    public function edit(int $id)
    {
        $subUser = $this->subUserService->get($id);
        return view('sub_users.edit', compact('subUser'));
    }

    public function update(SubUserUpdateRequest $request)
    {
        $this->subUserService->update($request->validated());
        return redirect()->route('sub-users.index');
    }

    public function destroy(SubUserDeleteRequest $request)
    {
        $this->subUserService->delete($request->validated());
        return redirect()->route('sub-users.index');
    }

    public function stat(Request $request, int $id)
    {
        $period = $request->query('period', 'day');
        $stats  = $this->subUserService->statistics($id, $period);
        return view('sub_users.stat', compact('stats', 'id', 'period'));
    }

    public function pay(PaymentRequest $request)
    {
        $dto = new PaymentDTO(
            subUserId: $request->input('subuser_id'),
            traffic: $request->input('traffic'),
            idempotencyKey: $request->input('idempotency_key'),
            signature: $request->input('signature')
        );

        return redirect()->back()->with('status', $this->paymentService->process($dto));
    }
}
