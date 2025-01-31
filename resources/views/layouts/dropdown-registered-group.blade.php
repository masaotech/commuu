<x-slot name="userRegisteredGroups">
    <div class="space-y-1">
        @foreach ($userRegisteredGroups as $item)
            <form action="{{ route('group.changeCurrentGroup') }}" method="post">
                @csrf
                <input type="hidden" name="group_id" value="{{ $item->group->id }}">
                @php
                    $isCurrentGroup = $item->group->id == $userCurrentGroupId;
                @endphp

                <x-dropdown-nav-button :active="$isCurrentGroup">
                    {{ $item->group->name }}
                </x-dropdown-nav-button>
            </form>
        @endforeach
    </div>
</x-slot>

<x-slot name="currentGroupName">
    @foreach ($userRegisteredGroups as $item)
        @if ($item->group->id == $userCurrentGroupId)
            {{ $item->group->name }}
        @endif
    @endforeach
</x-slot>
