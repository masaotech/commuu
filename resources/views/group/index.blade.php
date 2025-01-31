<x-app-layout>
    @include('layouts.dropdown-registered-group')

    <x-slot name="header">
        グループ管理
    </x-slot>

    <div class="max-w-7xl mx-auto md:px-4 lg:px-8 space-y-6">
        <div class="p-4 md:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xxl">

                <div class="overflow-x-auto rounded-lg border">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 rounded-md shadow-sm">
                        <thead class="text-sm text-gray-700 uppercase bg-gray-100 ">
                            <tr>
                                <th scope="col" class="px-2 py-3 pl-5">グループ名</th>
                                <th scope="col" class="px-2 py-3 min-w-16">権限種別</th>
                                <th scope="col" class="px-2 py-3 min-w-20"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupUsers as $groupUser)
                                <tr class="bg-white border-t ">
                                    <td class="px-2 py-4 pl-5">{{ $groupUser->group->name }}</td>
                                    <td class="px-2 py-4">
                                        {{ $groupUser->userRole->name }}</td>
                                    <td class="px-2 py-4">
                                        <a href="{{ route('group.edit', ['group' => $groupUser->group_id]) }}"
                                            class="inline-flex items-center justify-center rounded-md border-transparent bg-gray-500 font-medium px-4 py-2 mx-3 text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900">
                                            設定
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('group.create') }}"
                        class="inline-flex items-center justify-center rounded-md border-transparent bg-gray-500 text-sm font-medium px-4 py-2 mx-3 text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900">
                        新規登録
                    </a>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
