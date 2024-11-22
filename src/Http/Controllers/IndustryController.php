<?php

namespace Seat\HermesDj\Industry\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RecursiveTree\Seat\PricesCore\Models\PriceProviderInstance;

class IndustryController
{
    public function about(): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('seat-industry::about');
    }

    public function buildTimePriceProviderConfiguration(Request $request): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $existing = PriceProviderInstance::find($request->id);

        $id = $request->id;
        $name = $existing->name ?? $request->name ?? '';
        $reaction_multiplier = $existing->configuration['reactions'] ?? 1;
        $manufacturing_multiplier = $existing->configuration['manufacturing'] ?? 1;

        return view('seat-industry::priceprovider.buildTimeConfiguration',
            compact('id', 'name', 'reaction_multiplier', 'manufacturing_multiplier')
        );
    }

    public function buildTimePriceProviderConfigurationPost(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|string',
            'manufacturing' => 'required|integer',
            'reactions' => 'required|integer',
        ]);

        $model = PriceProviderInstance::findOrNew($request->id);
        $model->name = $request->name;
        $model->backend = 'hermesdj/seat-industry/build-time';
        $model->configuration = [
            'reactions' => (int) $request->reactions,
            'manufacturing' => (int) $request->manufacturing,
        ];
        $model->save();

        return redirect()->route('pricescore::settings')->with('success', trans('seat-industry::ai-common.price_provider_create_success'));
    }
}
