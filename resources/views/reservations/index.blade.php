<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">予約一覧</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-end mb-6">
            <a href="{{ route('reservations.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                新規予約
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($reservations->isEmpty())
            <p class="text-gray-500">予約はまだありません</p>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">店舗名</th>
                            <th class="px-4 py-3 text-left">予約日時</th>
                            <th class="px-4 py-3 text-left">ステータス</th>
                            <th class="px-4 py-3 text-left">操作</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reservations as $reservation)
                            <tr>
                                <td class="px-4 py-3">{{ $reservation->shop->name }}</td>
                                <td class="px-4 py-3">{{ $reservation->reserved_at->format('Y/m/d H:i') }}</td>
                                <td class="px-4 py-3">
                                    @if($reservation->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">保留中</span>
                                    @elseif($reservation->status === 'confirmed')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">確定</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">キャンセル</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="{{ route('reservations.show', $reservation) }}"
                                        class="text-blue-500 hover:underline">詳細</a>
                                    <a href="{{ route('reservations.edit', $reservation) }}"
                                        class="text-yellow-500 hover:underline">編集</a>
                                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST"
                                        onsubmit="return confirm('キャンセルしますか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:underline">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
