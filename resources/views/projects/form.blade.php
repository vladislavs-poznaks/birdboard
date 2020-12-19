<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title">Title</label>

    <div class="control">
        <input
            type="text"
            class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
            name="title"
            value="{{ $project->title ?? '' }}"
            placeholder="My next awesome project">
        required
    </div>
    @error('title')
    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="description">Description</label>

    <div class="control">
            <textarea
                name="description"
                rows="10"
                class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                placeholder="I should start learning piano."
                required
            >{{ $project->description ?? '' }}</textarea>
    </div>
    @error('description')
    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>
