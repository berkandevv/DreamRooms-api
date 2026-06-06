{{-- Galería de fotos en miniatura para el panel de administración --}}
<div x-data>
    <x-input-label :value="$title" />

    @if ($images->isEmpty())
        <div class="mt-1 text-sm text-slate-500">No photos</div>
    @else
        <div class="mt-2 flex flex-wrap gap-3">
            @foreach ($images as $image)
                <button
                    type="button"
                    data-url="{{ $image->image_url }}"
                    data-alt="{{ $image->alt_text }}"
                    x-on:click="$dispatch('open-lightbox', { url: $el.dataset.url, alt: $el.dataset.alt })"
                    class="relative block cursor-pointer"
                >
                    <img
                        src="{{ $image->image_url }}"
                        alt="{{ $image->alt_text }}"
                        class="h-28 w-40 rounded-md border border-gray-200 object-cover transition hover:opacity-90"
                    >
                    @if ($image->is_cover)
                        <span class="absolute left-1 top-1 rounded bg-sky-900/80 px-1.5 py-0.5 text-[10px] font-semibold text-white">
                            Cover
                        </span>
                    @endif
                </button>
            @endforeach
        </div>
    @endif
</div>
