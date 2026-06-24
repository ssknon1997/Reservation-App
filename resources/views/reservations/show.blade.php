<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">予約詳細</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm text-gray-500">店舗名</dt>
                    <dd class="text-gray-800">{{ $reservation->shop->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">予約日時</dt>
                    <dd class="text-gray-800">{{ $reservation->reserved_at->format('Y年m月d日 H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">ステータス</dt>
                    <dd class="text-gray-800">{{ $reservation->status }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">メモ</dt>
                    <dd class="text-gray-800">{{ $reservation->note ?? 'なし' }}</dd>
                </div>
            </dl>

            <div class="flex gap-4 mt-6">
                @if($reservation->status === 'pending')
                    <a href="{{ route('reservations.edit', $reservation) }}"
                            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        編集
                    </a>
                @endif
                @if(in_array($reservation->status, ['pending', 'confirmed']))
                    <form action="{{ route('reservations.cancel', $reservation) }}" method="POST"
                            onsubmit="return confirm('キャンセルしますか？')">
                        @csrf
                        @method('PATCH')
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            キャンセル
                        </button>
                    </form>
                @else
                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST"
                        onsubmit="return confirm('削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline">削除</button>
                    </form>
                @endif
            </div>
        </div>

        <a href="{{ route('reservations.index') }}" class="block mt-4 text-blue-500 hover:underline">
            ← 一覧に戻る
        </a>
    </div>
</x-app-layout>
