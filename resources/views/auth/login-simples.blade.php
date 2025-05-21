@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">
    <div class="w-full max-w-md p-6 bg-white dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-lg transition">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/LogoUni.png') }}" alt="Logo" class="h-16 w-auto">
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 dark:text-gray-200 mb-6">
            Bem-vindo de volta
        </h2>

        <form>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 dark:text-gray-300">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 dark:text-gray-300">Senha</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">
                Entrar
            </button>
        </form>
    </div>
</div>
@endsection