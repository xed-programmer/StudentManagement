<div class="card card-primary p-4">
    <!-- form start -->
    <form action="{{ route('admin.destination.update', $destination) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <x-label for="name" :value="__('Name')" class="text-dark" />

            <x-input id="name" class="form-control" type="text" name="name" :value="$destination->name" required />
        </div>
        <!-- Building -->
        <div class="form-group">
            <x-label for="building" :value="__('Building')" />

            <select name="building" id="building" class="form-control w-50">
                @foreach ($buildings as $b)
                    <option value="{{ $b->name }}" @if ($b->id == $destination->building_id) selected @endif>
                        {{ Str::ucfirst($b->name) }}</option>
                @endforeach
            </select>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        </div>
    </form>
</div>
