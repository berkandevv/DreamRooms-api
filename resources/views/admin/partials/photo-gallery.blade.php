{{-- Galería de fotos en miniatura para el panel de administración --}}
<div>
    <x-input-label :value="$title" />

    @if ($images->isEmpty())
        <div class="mt-1 text-sm text-slate-500">No photos</div>
    @else
        <div class="mt-2 flex flex-wrap gap-3">
            @foreach ($images as $image)
                <a href="{{ $image->image_url }}" target="_blank" rel="noopener" class="relative block">
                    <img
                        src="{{ $image->image_url }}"
                        alt="{{ $image->alt_text }}"
                        class="h-28 w-40 rounded-md border border-gray-200 object-cover"
                    >
                    @if ($image->is_cover)
                        <span class="absolute left-1 top-1 rounded bg-sky-900/80 px-1.5 py-0.5 text-[10px] font-semibold text-white">
                            Cover
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
