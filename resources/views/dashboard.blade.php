<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between"> <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <h2>Balance : USD {{ number_format($user->balance, 2)}} </h2></div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:flex lg:justify-between bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   Fund Account
                    <form class="w-full max-w-sm" method="Post" action="{{route('callback')}}">
                        @csrf
                        <div class="flex items-center border-b border-teal-500 py-2">
                            <input class="bg-transparent w-full text-gray-700 mr-3 py-1 px-2" type="number" name="amount" placeholder="USD Amount" required>
                            <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit">
                               Fund
                            </button>
                        </div>
                    </form>
                </div>
                <div class="mt-4 p-6 bg-white border-b border-gray-200">
                   Trade with Balance
                    <form class="w-full max-w-sm" method="Post" action="{{route('trade')}}">
                        @csrf
                        <div class="flex items-center border-b border-teal-500 py-2">
                            <input id="usdt" class="bg-transparent w-full text-gray-700 mr-3 py-1 px-2" type="text" name="usdt" placeholder="USDT Wallet (BEP20)" required>
                            <button id="exampleModalCenter" class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="button">
                               Trade
                            </button>
                        </div>
                        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="showModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
                            <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                                        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                                            USDT Wallet Address: <span id="usdtInput"></span>
                                        </h5>
                                        <button type="button"
                                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body relative p-4">
                                        <p></p>
                                    </div>
                                    <div
                                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                                        <button type="button"
                                                class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
                                                data-bs-dismiss="modal" id="close">
                                            Close
                                        </button>
                                        <button type="submit"
                                                class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">
                                          Confirmed
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <div class="flex items-center justify-center">
        <h1 class="mb-4 text-xl content-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-2xl"><span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">TRADING</span> HISTORIES.</h1>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">
                   USDT Address
                </th>
                <th scope="col" class="py-3 px-6">
                    Amount
                </th>
                <th scope="col" class="py-3 px-6">
                    Status
                </th>
                <th scope="col" class="py-3 px-6">
                    Date
                </th>
                <th scope="col" class="py-3 px-6">
                    <span class="sr-only">Delete</span>
                </th>
            </tr>
            </thead>
            @if (!empty($details))
                @foreach($details as $data)
            <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{$data->usdt}}
                </th>
                <td class="py-4 px-6">
                  USD {{$data->amount}}
                </td>
                <td class="py-4 px-6">
                  {{$data->status}}
                </td>
                <td class="py-4 px-6">
                   {{$data->created_at}}
                </td>
                <form action="{{ route('destory', $data->id) }}" method="POST">
                    @csrf
                <td class="py-4 px-6 text-right">
                    <button type="submit" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                </td>
                </form>
            </tr>
            </tbody>
                @endforeach
            @endif
        </table>
    </div>

{{--    transaction--}}
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <div class="flex items-center justify-center">
            <h1 class="mb-4 text-xl content-center font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-2xl"><span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">TRANSACTION</span> HISTORIES.</h1>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">
                    Type
                </th>
                <th scope="col" class="py-3 px-6">
                    Amount
                </th>
                <th scope="col" class="py-3 px-6">
                    Status
                </th>
                <th scope="col" class="py-3 px-6">
                    Date
                </th>
                <th scope="col" class="py-3 px-6">
                    <span class="sr-only">Delete</span>
                </th>
            </tr>
            </thead>
            @if (!empty($trans))
                @foreach($trans as $tran)
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$tran->type}}
                        </th>
                        <td class="py-4 px-6">
                           USD {{$tran->amount}}
                        </td>
                        <td class="py-4 px-6">
                            {{$tran->status}}
                        </td>
                        <td class="py-4 px-6">
                            {{$tran->created_at}}
                        </td>
                        <form action="{{ route('delete', $tran->id) }}" method="POST">
                            @csrf
                            <td class="py-4 px-6 text-right">
                                <button type="submit" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                            </td>
                        </form>
                    </tr>
                    </tbody>
                @endforeach
            @endif
        </table>
    </div>
</x-app-layout>
