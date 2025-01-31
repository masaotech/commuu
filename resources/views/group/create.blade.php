<x-app-layout>
    <x-slot name="header">
        グループ新規登録
    </x-slot>

    <div class="max-w-7xl mx-auto md:px-4 lg:px-8 space-y-6">
        <div class="p-4 md:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">

                <header>
                    <p class="mt-1 text-sm text-gray-600">
                        新規グループを登録します
                    </p>
                </header>

                <form method="post" action="{{ route('group.store') }}" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="name" value="グループ名" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required
                            autofocus />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>登録</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
