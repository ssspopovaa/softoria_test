@extends('layouts.app')

@section('content')
    <h1>Edit Sub User</h1>

    <form action="{{ route('sub-users.update') }}" method="POST">
        @csrf
        <input type="hidden" name="subuser_id" value="{{ $subUser['id'] }}">
        <label>Label</label>
        <input type="text" name="label" value="{{ $subUser['label'] }}" required>
        <label>Threads</label>
        <input type="number" name="threads" value="{{ $subUser['threads'] }}">
        <button type="submit">Update</button>
    </form>
@endsection
