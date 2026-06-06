<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ServiceController extends Controller
{
    // Lista los servicios del panel de administración
    public function index(Request $request): View
    {
        $search = $request->string('q')->toString();
        $scope = $request->string('scope', 'all')->toString();
        $status = $request->string('status', 'all')->toString();
        $category = $request->string('category', 'all')->toString();

        $services = Service::query()
            ->withCount(['hotels', 'roomTypes'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('icon', 'like', "%{$search}%");
                });
            })
            ->when($scope !== 'all', fn ($query) => $query->where('scope', $scope))
            ->when($status !== 'all', fn ($query) => $query->where('is_active', $status === 'active'))
            ->when($category !== 'all', fn ($query) => $query->where('category', $category))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.services.index', [
            'services' => $services,
            'search' => $search,
            'scope' => $scope,
            'status' => $status,
            'category' => $category,
            'scopes' => $this->scopes(),
            'categories' => $this->categories(),
        ]);
    }

    // Muestra el formulario de edición de un servicio
    public function edit(Service $service): View
    {
        return view('admin.services.edit', [
            'service' => $service,
            'scopes' => $this->scopes(),
            'categories' => $this->categories(),
        ]);
    }

    // Muestra el formulario de creación de un servicio
    public function create(): View
    {
        return view('admin.services.create', [
            'service' => new Service([
                'scope' => 'both',
                'is_active' => true,
            ]),
            'scopes' => $this->scopes(),
            'categories' => $this->categories(),
        ]);
    }

    // Guarda un servicio nuevo
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedServiceData($request);

        $service = Service::create($validated);

        return redirect()
            ->route('admin.services.edit', $service)
            ->with('status', 'service-created');
    }

    // Actualiza los datos de un servicio
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->validatedServiceData($request, $service);

        $service->update($validated);

        return redirect()
            ->route('admin.services.edit', $service)
            ->with('status', 'service-updated');
    }

    // Valida y prepara los datos de un servicio antes de guardarlo
    private function validatedServiceData(Request $request, ?Service $service = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('services', 'name')->ignore($service?->id)],
            'slug' => ['nullable', 'string', 'max:120'],
            'icon' => ['nullable', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:50'],
            'scope' => ['required', Rule::in($this->scopes())],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = filled($validated['slug'] ?? null)
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        if (Service::where('slug', $validated['slug'])->when($service, fn ($query) => $query->whereKeyNot($service->id))->exists()) {
            throw ValidationException::withMessages([
                'slug' => 'The slug has already been taken.',
            ]);
        }

        return $validated;
    }

    // Devuelve los ámbitos permitidos para un servicio
    private function scopes(): array
    {
        return ['hotel', 'room_type', 'both'];
    }

    // Devuelve las categorías existentes de servicios
    private function categories()
    {
        return Service::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }
}
