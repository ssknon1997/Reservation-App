<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">予約編集</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <form action="{{ route('reservations.update', $reservation) }}" method="POST"
                class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">店舗</label>
                <p class="text-gray-800 px-3 py-2 bg-gray-50 rounded">{{ $reservation->shop->name }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">予約日時</label>
                <input type="datetime-local" name="reserved_at"
                        value="{{ old('reserved_at', $reservation->reserved_at->format('Y-m-d\TH:i')) }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                @error('reserved_at')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">メモ</label>
                <textarea name="note" rows="3"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">{{ old('note', $reservation->note) }}</textarea>
                @error('note')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">
                更新する
            </button>
        </form>
    </div>
</x-app-layout>
