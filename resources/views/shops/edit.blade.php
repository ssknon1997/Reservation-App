<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">店舗編集</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <form action="{{ route('shops.update', $shop) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">店舗名</label>
                <input type="text" name="name" id="name" value="{{ old('name', $shop->name) }}" placeholder="必須：店舗名を入力してください"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address', $shop->address) }}" placeholder="必須：住所を入力してください"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">店舗紹介文</label>
                <textarea name="description" id="description" rows="4" placeholder="必須：店舗紹介文を入力してください"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">{{ old('description', $shop->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                更新する
            </button>
        </form>
    </div>
</x-app-layout>
