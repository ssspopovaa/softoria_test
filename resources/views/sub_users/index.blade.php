@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <h1 class="mb-4">{{ __('SubUsers') }}</h1>

        <a class="btn btn-primary" href="{{ route('sub-users.create') }}">{{ __('Create New') }}</a>
        <br><br>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Label') }}</th>
                    <th>{{ __('Login') }}</th>
                    <th>{{ __('Balance') }}</th>
                    <th>{{ __('Threads') }}</th>
                    <th>{{ __('Pool Type') }}</th>
                    <th>{{ __('Blocked') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($subUsers as $subUser)
                    <tr>
                        <td>{{ $subUser['id'] }}</td>
                        <td>{{ $subUser['label'] }}</td>
                        <td>{{ $subUser['login'] }}</td>
                        <td>{{ $subUser['balance'] }}</td>
                        <td>{{ $subUser['threads'] }}</td>
                        <td>{{ $subUser['pool_type'] }}</td>
                        <td>
                            @if($subUser['blocked'])
                                <span class="badge bg-danger">{{ __('Yes') }}</span>
                            @else
                                <span class="badge bg-success">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('sub-users.edit', $subUser['id']) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                            <a href="{{ route('sub-users.stat', $subUser['id']) }}" class="btn btn-sm btn-info">{{ __('Stat') }}</a>

                            <!-- Delete Form -->
                            <form action="{{ route('sub-users.destroy') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="subuser_id" value="{{ $subUser['id'] }}">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                            </form>

                            <!-- Simulate Payment Form -->
                            <form action="{{ route('sub-users.pay') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="subuser_id" value="{{ $subUser['id'] }}">
                                @php
                                    $idempotencyKey = bin2hex(random_bytes(16));
                                    $signature = App\Support\SignatureGenerator::generate(
                                        $subUser['id'],
                                        $idempotencyKey,
                                        config('services.dataimpulse.webhook_secret')
                                    );
                                @endphp
                                <input type="hidden" name="idempotency_key" value="{{ $idempotencyKey }}">
                                <input type="hidden" name="signature" value="{{ $signature }}">
                                <input type="number" name="traffic" min="1" value="1" class="form-control form-control-sm d-inline w-auto">
                                <button type="submit" class="btn btn-sm btn-success">{{ __('Pay') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">{{ __('No SubUsers found.') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
