<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">予約詳細（オーナー）</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm text-gray-500">予約者</dt>
                    <dd class="text-gray-800">{{ $reservation->user->name }}</dd>
                </div>
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
                <div class="flex gap-4 mt-6">
                    @if($reservation->status === 'pending')
                        <form action="{{ route('owner.reservations.confirm', $reservation) }}" method="POST"
                            onsubmit="return confirm('予約を確定しますか？')">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                予約を確定する
                            </button>
                        </form>
                    @endif
                </div>
            </dl>
        </div>

        <a href="{{ route('owner.reservations.index') }}" class="block mt-4 text-blue-500 hover:underline">
            ← 予約一覧に戻る
        </a>
    </div>
</x-app-layout>
