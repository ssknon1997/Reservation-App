<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">予約作成</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <form action="{{ route('reservations.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">店舗</label>

                @if($shop)
                    <p class="text-gray-800 px-3 py-2 bg-gray-50 rounded">{{ $shop->name }}</p>
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                @else
                    <select name="shop_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                        <option value="">選択してください</option>
                        @foreach($shops as $s)
                            <option value="{{ $s->id }}"
                                {{ old('shop_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                @endif

                @error('shop_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">予約日時</label>
                <input type="datetime-local" name="reserved_at" value="{{ old('reserved_at') }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                @error('reserved_at')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">メモ</label>
                <textarea name="note" rows="3"
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">{{ old('note') }}</textarea>
                @error('note')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                予約する
            </button>
        </form>
    </div>
</x-app-layout>
