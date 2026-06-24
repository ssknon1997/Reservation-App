<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">店舗詳細</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $shop->name }}</h1>
            <p class="text-gray-600 mb-2">{{ $shop->address }}</p>
            <p class="text-gray-700 mb-6">{{ $shop->description }}</p>

            <div class="flex gap-4">
                @auth
                    @if(auth()->user()->isUser())
                        <a href="{{ route('reservations.create', ['shop_id' => $shop->id]) }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            予約する
                        </a>
                    @endif

                    @can('update', $shop)
                        <a href="{{ route('shops.edit', $shop) }}"
                            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                            編集する
                        </a>

                        <form action="{{ route('shops.destroy', $shop) }}" method="POST"
                                onsubmit="return confirm('削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                削除する
                            </button>
                        </form>

                    @endcan
                @endauth
            </div>
        </div>


        <a href="{{ route('shops.index') }}" class="block mt-4 text-blue-500 hover:underline">
            ← 一覧へ戻る
        </a>
    </div>
</x-app-layout>
