@extends('layouts.app')

@section('content')
    <h1>{{ __('Create Sub User') }}</h1>

    <form action="{{ route('sub-users.store') }}" method="POST">
        @csrf
        <label>{{ __('Label') }}</label>
        <input type="text" name="label" required>

        <label>{{ __('Threads') }}</label>
        <input type="number" name="threads" min="0" max="2000" step="1">

        <button type="submit">{{ __('Create') }}</button>
    </form>
@endsection
