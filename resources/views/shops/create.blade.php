<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">店舗一覧</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <form action="{{ route('shops.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">店舗名</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="必須：店舗名を入力してください"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="必須：住所を入力してください"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">店舗紹介文</label>
                <textarea name="description" id="description" rows="4" placeholder="必須：店舗紹介文を入力してください"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                登録する
            </button>
        </form>
    </div>
</x-app-layout>
