@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Statistics for SubUser #{{ $id }}</h1>

        <form method="GET" action="{{ route('sub-users.stat', ['id' => $id]) }}" class="mb-4 row g-2 align-items-center">
            <div class="col-auto">
                <select name="period" class="form-select">
                    @foreach($periods as $option)
                        <option value="{{ $option['value'] }}"
                            {{ $period == $option['value'] ? 'selected' : '' }}>
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Show</button>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <p><strong>Period:</strong> {{ ucfirst(request('period', $period)) }}</p>

                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <thead class="table-light">
                        <tr>
                            <th>Traffic</th>
                            <th>Extra traffic</th>
                            <th>Request</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($stats['usage'] ?? [] as $point)
                            <tr>
                                <td>{{ $point['traffic'] ?? 0 }}</td>
                                <td>{{ $point['extra_traffic'] ?? 0 }}</td>
                                <td>{{ $point['request'] ?? 0 }}</td>
                                <td>
                                    {{ !empty($point['d_usage']) ? \Carbon\Carbon::parse($point['d_usage'])->format('Y-m-d H:i') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No data available for this period.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
