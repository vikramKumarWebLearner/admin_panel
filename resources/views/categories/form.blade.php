<div class="col-md-6 col-12">
    <label for="name" class="form-label required">Name</label>
    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $category->name) }}">
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-md-6 col-12">
    <label for="name" class="form-label">Slug</label>
    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('name', $category->slug) }}">
</div>
<div class="col-md-6 col-12">
    <label for="name" class="form-label">Status</label>
    <select class="form-control" id="status" name="status">
        <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
        <option value="draft" {{ old('status', $category->status) == 'draft' ? 'selected' : '' }}>Draft</option>
    </select>

</div>
<div class="col-md-6 col-12">
    <label for="name" class="form-label">Image</label>
    <input type="file" id="image" name="image" class="form-control">
</div>
<div class="col-md-12 col-12">
    <label for="name" class="form-label">Description</label>
    <textarea name="description" id="description" class="form-control">{{ old('name', $category->description) }}</textarea>
</div>
