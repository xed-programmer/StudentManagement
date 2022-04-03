<div class="card card-primary p-4">
    <!-- form start -->
    <form action="{{ route('admin.building.update', $building) }}" method="post">
        @csrf
        <div class="form-group">
            <x-label for="name" :value="__('Name')" class="text-dark" />

            <x-input id="name" class="form-control" type="text" name="name" :value="$building->name" required />
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        </div>
    </form>
</div>
