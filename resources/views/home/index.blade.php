<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>XM Project - xm.com</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css"/>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js" > </script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
   {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js"> --}}
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
     @vite('resources/css/app.css')
     @vite('resources/js/app.js')
     <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body class="antialiased">
    <div class="relative sm:flex sm:flex-col sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-black selection:bg-red-500 selection:text-white">
       
        <div class="max-w-full mx-auto p-6 lg:p-8">
            <div class="flex justify-center">     
            <svg id="Layer_1" data-name="Layer 1" class="h-16 w-auto bg-gray-100 dark:bg-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 182 48"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:red;}</style></defs><polygon class="cls-1" points="101.81 10.63 96.93 0.03 80.22 0.03 90.49 21.23 101.81 10.63"/><path class="cls-1" d="M141.46,0H111.6L70.75,48H87L97.7,35.24,103.58,48h28.05l3.76-21.36L138.8,38.4,149,26.16ZM118.57,44.15,108.62,23,125.81,3.09Z"/><polygon class="cls-1" points="166.96 0.03 139.67 41.44 153.36 41.44 163.75 25.24 159.74 47.97 173.54 47.97 182 0.03 166.96 0.03"/><path class="cls-2" d="M21.53,1.79a35.48,35.48,0,0,0-.31,6.72c.32,3.17,2.29,4.79,4.88,5.8a5.27,5.27,0,0,0,2.94.53,3.48,3.48,0,0,0,1.1-.62A7.86,7.86,0,0,1,33.39,13a13.77,13.77,0,0,1,5.23.66A19.44,19.44,0,0,1,43,15.28a4.18,4.18,0,0,1,1.45,1.54c.6,1,.84,2.72,2.2,3a25,25,0,0,0,.13-4.44,26.92,26.92,0,0,1,.57-4.08,57.15,57.15,0,0,1,1.45-5.54c.09-.28.34-1.69.88-1.49.24.08.19.66.18,1,0,1.18-.13,2-.22,3.21A32.25,32.25,0,0,0,49.86,17a13.78,13.78,0,0,1,.48,4.13c0,.38-.23.84-.3,1.27s0,.65-.09.92a6.77,6.77,0,0,1-.79,1.41,8,8,0,0,0-.4.7c-.15.28-.41.41-.39.7,0,.45.9,1.32,1.36,1.45,2,.56,4.14.85,5.31,2a4.43,4.43,0,0,1,1.37,2.81,5.81,5.81,0,0,1-.66,2.86c-.28.63-.55,2.2-1,2.5s-.91.09-1.32.31A9.7,9.7,0,0,0,53,39.75c-.33.47-.83.77-1.19,1.22.12,1-.54,1.31-1.4,1.37-2.57,2.09-7.67.71-9.84-.71-1.08.77-2.28,1.42-2.15,3.39a14.79,14.79,0,0,0,2.76,1.49c1.47.49,3.27.23,4.22,1.1a2.39,2.39,0,0,1,.22.23H53L73.84,23.58,62.43.05H21.67C21.62.65,21.58,1.22,21.53,1.79Z"/><path class="cls-2" d="M2.38,47.61a15.42,15.42,0,0,1,5.09-3.16,18.34,18.34,0,0,0,4.09-2.11,3.28,3.28,0,0,1,1.49-.93,9.06,9.06,0,0,1,3.16.53A5.71,5.71,0,0,0,21.62,40a7.18,7.18,0,0,0,1.71-2.11,11.21,11.21,0,0,0,.26-3.82c0-2.74,1-4.67,1.06-7.2A31.9,31.9,0,0,1,24.52,23a13.31,13.31,0,0,1-4.05-2.59c-1.06-1.18-2.29-3.38-1.93-5.31A9.2,9.2,0,0,1,17,10.14a18.14,18.14,0,0,1,1.1-5.36c.46-1.56.91-3.14,1.39-4.73H10.33L0,47.84H2.18C2.24,47.77,2.31,47.68,2.38,47.61Z"/></svg>
            </div>

            <div class="mt-16">
                <div id="pageOne" class=" max-w-[450px] min-w-[400px] m-auto relative">
                    <div class="scale-100 flex w-full p-6 bg-white via-transparent  dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1] transition-all duration-[.3s] focus:outline focus:outline-2 focus:outline-red-500" style="background: #121319 !important;">
                        <form id="xmForm" action="javascript:void(0)" class="p-3 rounded w-full shadow-md">
                            @csrf
                            <div class="mb-4">
                              <label class="block text-gray-400 font-bold mb-2" for="symbol">
                                Company Symbol:
                              </label>
                              <div class="relative">
                                <select class="w-full symbolDet appearance-none px-3 py-2 border border-gray-500  focus:border-gray-300 hover:border-gray-300 outline-none rounded dark:bg-black text-white" id="symbol" name="symbol" required>
                                  <option value="">Select company symbol...</option>
                                    @foreach ($symbols as $symbol)
                                    <option data-name="{{ $symbol['Company Name'] }}" value="{{ $symbol['Symbol'] }}">{{ $symbol['Symbol'] }}</option>
                                    {{-- {{ $symbol['Company Name'] }}  --}}
                                    @endforeach
                                </select>
                                <input type="hidden" name="compSelected" id="cSelected" />
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9 11l4-4 4 4h-3v4H8v-4H5z"/></svg>
                                </div>
                              </div>
                              <span class="text-red-500 text-[13px]" id="symbol-error"></span>
                            </div>
                            <div class="mb-4">
                              <label class="block text-gray-400 font-bold mb-2" for="start-date">
                                Start Date:
                              </label>
                              <input class="w-full px-3 py-2 border border-gray-500 focus:border-gray-300 hover:border-gray-300 outline-none rounded dark:bg-black text-white datepicker" type="text" id="start-date" name="start-date" placeholder="Select Start Date" required>
                              <span class="text-red-500 text-[13px]" id="start-date-error"></span>
                            </div>
                            <div class="mb-4">
                              <label class="block text-gray-400 font-bold mb-2" for="end-date">
                                End Date:
                              </label>
                              <input class="w-full px-3 py-2 border border-gray-500 focus:border-gray-300 hover:border-gray-300 outline-none rounded dark:bg-black datepicker text-white" type="text" id="end-date" name="end-date" required placeholder="Select End Date">
                              <span class="text-red-500 text-[13px]" id="end-date-error"></span>
                            </div>
                            <div class="mb-4">
                              <label class="block text-gray-400 font-bold mb-2" for="email">
                                Email:
                              </label>
                              <input class="w-full px-3 py-2 border border-gray-500 focus:border-gray-300 hover:border-gray-300 outline-none rounded dark:bg-black text-white" type="email" id="email" name="email" required placeholder="Enter Email Address">
                              <span class="text-red-500 text-[13px]" id="email-error"></span>
                            </div>
                            <button class="bg-green-500 mt-5 hover:bg-green-700 w-full text-white duration-[.3s] font-bold py-3 transition-all px-4 rounded" id="submitForm" type="button">
                              Submit
                            </button>
                          </form>                      
                    </div>
                </div>
                <div id="pageTwo" class="hidden m-auto relative overflow-hidden">
                   
                    <div class="scale-100 w-full flex justify-center items-center flex-row space-x-4 p-6 bg-white via-transparent relative dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1] transition-all duration-[.3s] focus:outline focus:outline-2 focus:outline-red-500" style="background: #121319 !important;">
                      <div id="historical-loader" class="absolute flex items-center justify-center top-0 spinner left-0 w-full h-full z-[888] dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none" style="background: #121319 !important;">
                        <div class="loading flex items-center justify-center flex-col">
                          <h2 class="loader">Please wait, loading historical data...</h2>
                          <div>
                            <span></span>
                          <span></span>
                          <span></span>
                          <span></span>
                          <span></span>
                          <span></span>
                          <span></span>
                          </div>
                        </div>
                      </div>
                      <div class="showOnError h-[200px] px-[5%] flex items-center justify-center text-center ">
                          <h2 class="text-2xl text-red-100">No stock historical data found for <span class="selectedCompName"></span> (<span class="selStartDate"></span> - <span class="selEndDate"></span>)</h2>
                      </div>
                        <div class="hiddenOnError max-w-[50%] w-1/2 overflow-auto pb-4">
                          <h2 class="py-6 text-2xl text-white w-[90%] text-center block relative m-auto mb-6 opacity-80"><span class="selectedCompName"></span> Stock Historical Data Table <br/>(<span class="selStartDate"></span> - <span class="selEndDate"></span>)</h2>
                        <div class="stockTable hidden min-w-[50%] relative">
                           
                            <table id="stockTable" class="display border stripe">
                                <thead>
                                  <tr>
                                    <th>Date</th>
                                    <th>Open</th>
                                    <th>High</th>
                                    <th>Low</th>
                                    <th>Close</th>
                                    <th>Volume</th>
                                  </tr>
                                </thead>
                                <tbody></tbody>
                              </table>
                        </div>
                        </div>
                        <div class="hiddenOnError w-1/2 relative">
                          <div id="historical-loader-chart" class="absolute hidden items-center justify-center top-0 spinner left-0 w-full h-[400px] z-[888] dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none" style="background: #121319 !important;">
                            <div class="loading flex items-center justify-center flex-col">
                              <h2 class="loader">loading chart...</h2>
                              <div>
                                <span></span>
                              <span></span>
                              <span></span>
                              <span></span>
                              <span></span>
                              <span></span>
                              <span></span>
                              </div>
                            </div>
                          </div>
                          <h2 class="py-6 text-2xl text-white w-[90%] text-center block relative m-auto mb-6 opacity-80"><span class="selectedCompName"></span> Stock Historical Data Chart <br/>(<span class="selStartDate"></span> - <span class="selEndDate"></span>)</h2>
                            <div id="canvaCont">
                              <canvas id="myChart" height="180px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 w-full hidden backToFrm">
                      <button class="bg-red-500 mt-5 hover:bg-red-700 w-full text-white duration-[.3s] font-bold py-3 transition-all px-4 rounded" id="backForm" type="button">
                        Go Back to Form
                      </button>
                    </div>
                </div>
            </div>

          
        </div>

        <div class="flex justify-center px-8 sm:items-center sm:justify-between relative mt-6 bottom-0 py-6 w-full left-0">
          <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
              <div class="flex items-center gap-4">
                  <a href="https://devdannnny.github.io/" target="_blank" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="-mt-px mr-1 w-5 h-5 stroke-gray-400 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                      </svg>
                      Developed By Daniel Dabiri
                  </a>
              </div>
          </div>

          <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
              Built with Laravel v{{ Illuminate\Foundation\Application::VERSION }}, Tailwind css & (PHP v{{ PHP_VERSION }})
          </div>
      </div>

        
    </div>
</body>

</html>