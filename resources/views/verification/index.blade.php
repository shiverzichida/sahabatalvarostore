@extends('layouts.app')

@section('title', 'Verifikasi Produk - Sahabat Alvaro Store')

@section('content')
<div class="bg-gray-100 py-12 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="bg-primary-blue py-6 px-8">
                <h1 class="text-2xl font-bold text-white text-center">Verifikasi Keaslian Produk</h1>
            </div>
            
            <div class="p-8">
                <p class="text-gray-600 mb-8 text-center">Masukkan kode unik yang tertera pada kemasan produk Sahabat Alvaro untuk memastikan keaslian produk Anda.</p>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ session('warning') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('verification.check') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Kode Verifikasi</label>
                        <input type="text" name="code" id="code" required class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: ALV-123456">
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-white bg-primary-blue hover:bg-blue-700 font-bold">
                            VERIFIKASI SEKARANG
                        </button>
                    </div>
                </form>

                <div class="mt-12 border-t border-gray-100 pt-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 text-center">Panduan Verifikasi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                        <div>
                            <div class="bg-blue-50 rounded-full h-10 w-10 flex items-center justify-center mx-auto mb-2 text-primary-blue font-bold">1</div>
                            <p class="text-sm text-gray-600">Cari kode QR atau kode serial pada kemasan.</p>
                        </div>
                        <div>
                            <div class="bg-blue-50 rounded-full h-10 w-10 flex items-center justify-center mx-auto mb-2 text-primary-blue font-bold">2</div>
                            <p class="text-sm text-gray-600">Masukkan kode pada formulir di atas.</p>
                        </div>
                        <div>
                            <div class="bg-blue-50 rounded-full h-10 w-10 flex items-center justify-center mx-auto mb-2 text-primary-blue font-bold">3</div>
                            <p class="text-sm text-gray-600">Dapatkan konfirmasi status keaslian produk.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
