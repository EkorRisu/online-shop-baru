@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">📂 Create New Category</h1>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm px-3 py-2"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                    Create Category
                </button>
            </form>
        </div>
    </div>
@endsection
