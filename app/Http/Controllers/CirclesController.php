<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CirclesController extends Controller
{
    public function __construct()
    {
        $this->items_per_page = config('circles.listing.items_per_page');
    }

    public function index()
    {
        $model = \App\Circle::orderBy('id', 'desc');
        $model = $model->with(['memberships', 'users', 'user']);
        $items = $model->paginate($this->items_per_page);
        
        return view('circles.index')->with([
            'items' => $items
        ]);
    }

    public function create()
    {
        $this->authorize('create', \App\Circle::class);
        return view('circles.create');
    }

    public function store(Request $request)
    {        
        $this->authorize('create', \App\Circle::class);

        $this->validate($request, \App\Circle::validationRules());

        $user = auth()->user();

        $request->merge(['limit' => config('circle.defaults.limit')]);

        $item = $user->circles()->create($request->all());

        return redirect()->route('circles.show', $item->uuid)->with([
            'success' => sprintf('%s was created!', (string) $item)
        ]);
    }

    public function show($uuid, Request $request)
    {
        $item = \App\Circle::withUuid($uuid)->firstOrFail();
        
        $this->authorize('view', $item);

        $user = auth()->user();
        
        return view('circles.show')->with([
            'item' => $item,
            'user' => $user
        ]);
    }

    public function edit($uuid, Request $request)
    {
        $item = \App\Circle::withUuid($uuid)->firstOrFail();
        
        $this->authorize('update', $item);

        return view('circles.edit')->with([
            'item' => $item
        ]);
    }

    public function update($uuid, Request $request)
    {
        $item = \App\Circle::withUuid($uuid)->firstOrFail();
        
        $this->authorize('update', $item);

        $this->validate($request, \App\Circle::validationRules());

        $item->update($request->all());

        return redirect()->route('circles.show', $item->uuid)->with([
            'success' => sprintf('%s was updated!', (string) $item)
        ]);
    }

    public function join($uuid, Request $request)
    {
        $item = \App\Circle::withUuid($uuid)->firstOrFail();

        $user = auth()->user();

        if($item->joinable($user) == false)
        {
            return redirect()->route('circles.show', $item->uuid)->withErrors(
                sprintf('You cannot join circle %s', (string) $item)
            );
        }

        $item->joinWithDefaults($user);

        return redirect()->route('circles.membership.edit', $item->uuid)->with([
            'success' => sprintf('You have joined %s!', (string) $item)
        ]);
    }

    public function leave($uuid, Request $request)
    {
        $item = \App\Circle::withUuid($uuid)->firstOrFail();

        $user = auth()->user();

        $item->leave($user);

        return redirect()->route('circles.show', $item->uuid)->with([
            'success' => sprintf('You have left %s!', (string) $item)
        ]);
    }
}
