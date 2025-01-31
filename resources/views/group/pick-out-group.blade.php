<x-app-layout>
   <x-slot name="header">
        グループ選択
    </x-slot>

    <div class="max-w-7xl mx-auto md:px-4 lg:px-8 space-y-6">
        <div class="p-4 md:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xxl">
                <div class="overflow-x-auto rounded-lg border">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700 rounded-md">
                        <thead class="bg-gray-100 ">
                            <tr>
                                <th scope="col" class="p-2 sm:px-4 min-w-24">グループ名</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userRegisteredGroups as $item)
                                <tr class="border-t">
                                    <td>
                                        <form action="{{ route('group.changeCurrentGroup') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="group_id" value="{{ $item->group->id }}">
                                            <button type="submit"
                                                class="p-4 block w-full text-start text-sm leading-5 text-gray-700 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 transition duration-150 ease-in-out">
                                                {{ $item->group->name }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
