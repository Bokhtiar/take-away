<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white border border-gray-200 rounded-xl shadow-sm p-6">
        <h1 class="text-2xl font-bold mb-2">User Login</h1>
        <p class="text-sm text-gray-500 mb-6">Login to place order and track your history.</p>

        <form method="POST" action="{{ route('user.login.submit') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-sm font-medium">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required class="mt-1 w-full h-11 px-3 rounded-lg border border-gray-300">
                @error('phone')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium">Password</label>
                <input type="password" name="password" required class="mt-1 w-full h-11 px-3 rounded-lg border border-gray-300">
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember">
                <span>Remember me</span>
            </label>

            <button type="submit" class="w-full h-11 rounded-lg bg-black text-white font-medium">Login</button>
        </form>

        <p class="mt-5 text-sm text-gray-600">
            No account?
            <a href="{{ route('user.register') }}" class="text-blue-600 hover:text-blue-800 font-medium">Register</a>
        </p>
    </div>
</body>
</html>

