<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            アカウント情報
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            名前を更新できます
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ $user->email }}"
                readonly />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autocomplete="name" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>保存</x-primary-button>
        </div>
    </form>
</section>
