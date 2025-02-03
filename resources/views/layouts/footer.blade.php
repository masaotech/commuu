<footer class="fixed left-0 bottom-0 w-full sm:hidden">
    <div class="h-12 flex justify-between bg-gray-100">
        @php
            $isActiveShopping = request()->routeIs('shoppingitem.index') || request()->routeIs('shoppingitem.edit');
            $isActiveHabit = request()->routeIs('habititem.index') || request()->routeIs('habititem.edit');
            $isActiveDeclutter = request()->routeIs('declutter.index');
        @endphp
        <div class="flex-grow">
            <x-footer-link :href="route('shoppingitem.index')" :active="$isActiveShopping">
                @include('icon.shopping-icon')
                <span class="ms-2">買い物リスト</span>
            </x-footer-link>
        </div>
        <div class="flex-grow" style="margin-left: 2px;">
            <x-footer-link :href="route('habititem.index')" :active="$isActiveHabit">
                @include('icon.habit-todo-icon')
                <span class="ms-2">定期To-Do</span>
            </x-footer-link>
        </div>
        <div class="flex-grow" style="margin-left: 2px;">
            <x-footer-link :href="route('declutter.index')" :active="$isActiveDeclutter">
                @include('icon.declutter-icon')
                <span class="ms-2">断捨離サポート</span>
            </x-footer-link>
        </div>
    </div>
</footer>
