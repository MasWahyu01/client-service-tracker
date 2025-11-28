<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <title>Login - Client Service Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center">
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h1 class="text-xl font-semibold text-slate-800 mb-1">
                Client Service Tracker
            </h1>
            <p class="text-sm text-slate-500 mb-6">
                Please sign in to continue.
            </p>

            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 text-red-700 px-3 py-2 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.perform') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-medium text-slate-700">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                                  focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700">Password</label>
                    <input type="password" name="password"
                           class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                                  focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-slate-300">
                        <span class="text-slate-600">Remember me</span>
                    </label>

                    <span class="text-slate-400 italic">
                        Demo: admin@example.com / password
                    </span>
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white
                            hover:bg-sky-700">
                    Sign in
                </button>
            </form>
        </div>
    </div>
</body>
</html>
