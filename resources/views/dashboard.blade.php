{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in! here") }}


                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}



@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <!-- Left side menu -->
            <div class="w-1/4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-800">Menu</h3>
                        <div class="mt-4">
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('budgets.create') }}"
                                        class="block w-full text-left bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                        Create New Budget
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block w-full text-left bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                        Manage Budgets
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-button">
                                            Dropdown
                                            <i class="fas fa-chevron-down ml-2"></i> <!-- Icon added here -->
                                        </button>
                                        <div class="dropdown-list">
                                            <a href="#">This is Link 1</a>
                                            <a href="#">This is Link 2</a>
                                            <a href="#">This is Link 3</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <select onchange="location = this.value;"
                                        class="block w-full bg-gray-100 border border-gray-300 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none mt-4">
                                        <option value="">Budget Related</option>
                                        <option value="{{ route('search.showSearchForm') }}">Search Budget</option>
                                        <option value="{{ route('search.summary') }}">Total Budget Summary</option>
                                        {{-- <option value="{{ route('search.showSearchForm') }}" class="cursor-pointer">Search
                                            Budget</option> --}}
                                    </select>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="w-3/4 ml-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                            {{ __('Dashboard Overview') }}
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-blue-100 p-6 rounded-lg shadow">
                                <div class="flex items-center">
                                    <div class="bg-primary p-4 rounded-full text-white">
                                        <i class="far fa-user fa-2x"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-700">Total News Categories</h4>
                                        <p class="text-2xl font-bold">12</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-red-100 p-6 rounded-lg shadow">
                                <div class="flex items-center">
                                    <div class="bg-danger p-4 rounded-full text-white">
                                        <i class="fas fa-book-open fa-2x"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-700">Total News</h4>
                                        <p class="text-2xl font-bold">122</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-100 p-6 rounded-lg shadow">
                                <div class="flex items-center">
                                    <div class="bg-warning p-4 rounded-full text-white">
                                        <i class="fas fa-bullhorn fa-2x"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-700">Total Users</h4>
                                        <p class="text-2xl font-bold">45</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-100 p-6 rounded-lg shadow">
                                <div class="flex items-center">
                                    <div class="bg-success p-4 rounded-full text-white">
                                        <i class="fas fa-dollar-sign fa-2x"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-700">Total Budget</h4>
                                        <p class="text-2xl font-bold">$500,000</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-purple-100 p-6 rounded-lg shadow">
                                <div class="flex items-center">
                                    <div class="bg-purple-500 p-4 rounded-full text-white">
                                        <i class="fas fa-receipt fa-2x"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-700">Total Charges</h4>
                                        <p class="text-2xl font-bold">$120,000</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="font-semibold text-lg text-gray-800">Budget Management</h3>
                            <p class="mt-4">Use the menu on the left to create or manage your budgets.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
