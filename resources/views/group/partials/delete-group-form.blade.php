<header>
    <h2 class="text-lg font-medium text-gray-900">
        グループを削除
    </h2>
    <p class="mt-1 text-sm text-gray-600">
        グループを削除すると、グループに関連するデータとファイルも完全に削除されます。<br>
        グループを削除する前に必要なデータがあれば事前に取得をお願いします。
    </p>
</header>
<x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-group-deletion')"
    class="mt-2">グループを削除</x-danger-button>
<x-modal name="confirm-group-deletion" focusable>
    <form method="post" action="{{ route('group.destroy', ['group' => $group]) }}" class="p-6">
        @csrf
        @method('delete')
        <input type="hidden" name="group_id" value={{ $group->id }} />
        <input type="hidden" name="group_name" value={{ $group->name }} />
        <h2 class="text-lg font-medium text-gray-900">
            グループを削除して本当に大丈夫ですか？
        </h2>
        <p class="mt-1 text-sm text-red-500"> グループを削除すると、グループに関連するデータも完全に削除されます。 </p>
        <p class="mt-1 text-sm text-gray-600"> ※ユーザーは削除されません </p>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                キャンセル
            </x-secondary-button>
            <x-danger-button class="ms-3">
                グループを削除
            </x-danger-button>
        </div>
    </form>
</x-modal>
