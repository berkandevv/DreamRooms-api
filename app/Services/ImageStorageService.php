<?php

namespace App\Services;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class ImageStorageService
{
    // Devuelve las reglas de validación de imágenes
    public function validationRules(): array
    {
        return [
            'image' => ['sometimes', 'file', 'image', 'max:5120'],
            'images' => ['sometimes', 'array', 'size:1'],
            'images.*' => ['file', 'image', 'max:5120'],
            'alt_text' => ['nullable', 'string', 'max:150'],
            'image_alt_texts' => ['sometimes', 'array', 'size:1'],
            'image_alt_texts.*' => ['nullable', 'string', 'max:150'],
        ];
    }

    // Guarda la única foto del hotel o habitación y sustituye la anterior si existe
    public function store(Hotel|RoomType $imageOwner, array $validated, string $directory): void
    {
        $image = $validated['image'] ?? ($validated['images'][0] ?? null);

        if (! $image) {
            return;
        }

        /** @var FilesystemAdapter $publicDisk */
        $publicDisk = Storage::disk('public');

        // Solo se permite una foto: se borra la anterior (fichero y registro) antes de guardar la nueva
        $publicDisk->deleteDirectory("{$directory}/{$imageOwner->id}");
        $imageOwner->images()->delete();

        $path = $image->store("{$directory}/{$imageOwner->id}", 'public');

        $imageOwner->images()->create([
            'image_url' => $publicDisk->url($path),
            'alt_text' => $validated['alt_text'] ?? ($validated['image_alt_texts'][0] ?? $imageOwner->name),
            'is_cover' => true,
            'sort_order' => 0,
        ]);
    }
}
