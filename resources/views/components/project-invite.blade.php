<div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg space-y-3 py-6 flex flex-col">
    <div class="border-l-8 border-blue-300 text-lg">
        <h3 class="text-xl px-4 py-4">Invite a user</h3>
    </div>
    <div class="rounded mt-6 px-4">
        <form action="{{ route('invitations.store', $project) }}" method="POST">
            @csrf
            <label class="label text-sm mb-2 block" for="title">Email</label>
            <input
                type="email"
                class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                name="email"
                value="{{ old('email') }}"
                placeholder="My next awesome teammate"
                required
            >
            <button
                type="submit"
                class="bg-blue-400 text-white rounded-lg shadow hover:bg-blue-500 px-4 py-2 mt-2"
            >
                Invite
            </button>
            @error('email')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </form>
    </div>
</div>
