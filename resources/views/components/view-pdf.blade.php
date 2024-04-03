@props(['name','id'])

<div>
    <a href="{{ route('upload.show', ['id' => $id]) }}" >{{ $name }}</a>
</div>
