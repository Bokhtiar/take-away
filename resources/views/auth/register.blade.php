<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white border border-gray-200 rounded-xl shadow-sm p-6">
        <h1 class="text-2xl font-bold mb-2">Create Account</h1>
        <p class="text-sm text-gray-500 mb-6">Register as user for ordering.</p>

        <form method="POST" action="{{ route('user.register.submit') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-sm font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 w-full h-11 px-3 rounded-lg border border-gray-300">
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required class="mt-1 w-full h-11 px-3 rounded-lg border border-gray-300">
                @error('phone')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Email (Optional)</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full h-11 px-3 rounded-lg border border-gray-300">
                @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Password</label>
                <input type="password" name="password" required class="mt-1 w-full h-11 px-3 rounded-lg border border-gray-300">
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="mt-1 w-full h-11 px-3 rounded-lg border border-gray-300">
            </div>

            <button type="submit" class="w-full h-11 rounded-lg bg-black text-white font-medium">Register</button>
        </form>

        <p class="mt-5 text-sm text-gray-600">
            Already have account?
            <a href="{{ route('user.login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login</a>
        </p>
    </div>
</body>
</html>

