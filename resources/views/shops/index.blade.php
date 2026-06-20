<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">店舗一覧</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            @auth
                @if(auth()->user()->isOwner())
                    <a href="{{ route('shops.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        店舗を登録する
                    </a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($shops as $shop)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ $shop->name }}</h2>
                    <p class="text-gray-600 mb-2">{{ $shop->address }}</p>
                    <p class="text-gray-500 text-sm mb-4">{{ $shop->description }}</p>
                    <a href="{{ route('shops.show', $shop) }}"
                        class="text-blue-500 hover:underline">
                        店舗詳細を見る
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $shops->links() }}
        </div>
    </div>
</x-app-layout>
