<?php

namespace App\Http\Controllers;

use App\Enums\PeriodEnum;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\SubUserDeleteRequest;
use App\Http\Requests\SubUserStoreRequest;
use App\Http\Requests\SubUserUpdateRequest;
use App\Services\ResellerApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SubUserController extends Controller
{
    public function __construct(protected readonly ResellerApiService $service)
    {
    }

    public function index()
    {
        $subUsers = $this->service->listSubUsers()['subusers'] ?? [];

        return view('sub_users.index', compact('subUsers'));
    }

    public function create()
    {
        return view('sub_users.create');
    }

    public function store(SubUserStoreRequest $request)
    {
        $this->service->createSubUser($request->validated());

        return redirect()->route('sub-users.index');
    }

    public function edit(int $id)
    {
        $subUser = $this->service->getSubUser($id);

        return view('sub_users.edit', compact('subUser'));
    }

    public function update(SubUserUpdateRequest $request)
    {
        $this->service->updateSubUser($request->validated());

        return redirect()->route('sub-users.index');
    }

    public function destroy(SubUserDeleteRequest $request)
    {
        $this->service->deleteSubUser($request->validated());

        return redirect()->route('sub-users.index');
    }

    public function stat(Request $request, $id)
    {
        $period = $request->query('period', PeriodEnum::DAY->value);

        $stats = $this->service->getStatistics(
            $id,
            $period
        );

        $periods = PeriodEnum::options();

        return view('sub_users.stat', compact('stats', 'periods', 'id', 'period'));
    }

    public function pay(PaymentRequest $request)
    {
        $data = $request->validated();
        $expectedSignature = ResellerApiService::generateSignature($data['subuser_id'], $data['idempotency_key']);

        if (!hash_equals($expectedSignature, $data['signature'])) {
            return redirect()->back()->with('error', 'Invalid signature');
        }

        if (Cache::has('payment_' . $data['idempotency_key'])) {
            return redirect()->back()->with('status', 'Payment already processed');
        }

        $this->service->pay($data['subuser_id'], $data['traffic']);

        Cache::put('payment_' . $data['idempotency_key'], true, now()->addHours(1));

        return redirect()->back()->with('status', 'Payment processed successfully!');
    }
}
