<x-danger-button x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-group-deletion')">グループから退会する</x-danger-button>
<x-modal name="confirm-group-deletion" focusable>
    <form method="post" action="{{ route('group.leaveGroup', ['group' => $group]) }}" class="p-6">
        @csrf
        @method('delete')
        <input type="hidden" name="group_id" value={{ $group->id }} />
        <h2 class="text-lg font-medium text-gray-900">
            「{{ $group->name }}」　から退会して本当に大丈夫ですか？
        </h2>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                キャンセル
            </x-secondary-button>
            <x-danger-button class="ms-3">
                グループから退会する
            </x-danger-button>
        </div>
    </form>
</x-modal>
