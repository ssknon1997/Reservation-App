<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">予約管理</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        @if($reservations->isEmpty())
            <p class="text-gray-500">予約はまだありません</p>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">予約者</th>
                            <th class="px-4 py-3 text-left">店舗名</th>
                            <th class="px-4 py-3 text-left">予約日時</th>
                            <th class="px-4 py-3 text-left">ステータス</th>
                            <th class="px-4 py-3 text-left">操作</th>
                            <th class="px-4 py-3 text-left"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reservations as $reservation)
                            <tr>
                                <td class="px-4 py-3">{{ $reservation->user->name }}</td>
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
                                <td class="px-4 py-3">
                                    <a href="{{ route('owner.reservations.show', $reservation) }}"
                                        class="text-blue-500 hover:underline">詳細</a>
                                </td>

                                @if($reservation->status === 'pending')
                                    <td class="px-4 py-3">
                                        <form action="{{ route('owner.reservations.confirm', $reservation) }}" method="POST"
                                            onsubmit="return confirm('確定しますか？')">
                                            @csrf
                                            @method('PATCH')
                                            <button class="text-green-500 hover:underline">確定する</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
